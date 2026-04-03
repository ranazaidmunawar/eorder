@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
@endphp

@extends('user-front.layout')

@section('pageHeading')
    {{ $keywords['Checkout'] ?? __('Checkout') }}
@endsection

@section('meta-keywords', !empty($userSeo) ? $userSeo->checkout_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->checkout_meta_description : '')

@section('content')
<style>
    :root {
        --color-primary: #044b4a;
        --color-primary-rgb: 4, 75, 74;
    }
    body { background-color: #fcfcfc; }
    .cart-page-container {
        padding-bottom: 200px;
        max-width: 550px;
        margin: 0 auto;
    }
    /* Toggle */
    .checkout-toggle-group {
        display: flex;
        background: #f1f3f5;
        border-radius: 50px;
        padding: 5px;
        gap: 5px;
        margin-bottom: 25px;
    }
    .checkout-toggle-item {
        padding: 14px 10px;
        border-radius: 50px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 700;
        color: #888;
        font-size: 0.75rem;
        flex: 1;
    }
    .checkout-toggle-item.active {
        background: #fff;
        color: var(--color-primary);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    /* Inputs */
    .input-with-icon {
        position: relative;
        margin-bottom: 20px;
    }
    .input-with-icon .form-control, .input-with-icon select {
        padding-right: 50px;
        padding-left: 20px;
        border-radius: 18px;
        height: 65px;
        border: 1px solid #eee;
        background-color: #fff !important;
        font-size: 0.95rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .input-with-icon .input-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-primary);
        font-size: 1.2rem;
    }
    .floating-label {
        position: absolute;
        top: 8px;
        right: 50px;
        font-size: 0.65rem;
        color: var(--color-primary);
        font-weight: 800;
        z-index: 10;
    }
    /* Summary Card */
    .summary-card {
        background: #fff;
        border-radius: 25px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        margin-top: 30px;
        margin-bottom: 20px;
    }
    .summary-title { text-align: right; font-weight: 800; font-size: 0.85rem; margin-bottom: 15px; }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.9rem;
    }
    .summary-row .label { color: #888; font-weight: 600; }
    .summary-row .value { color: #333; font-weight: 800; }
    .total-row {
        border-top: 1.5px solid #f8f9fa;
        padding-top: 20px;
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .total-label { font-size: 1.1rem; font-weight: 800; color: var(--color-primary); }
    .total-value { font-size: 1.4rem; font-weight: 900; color: var(--color-primary); }

    /* Payment List (Radios) */
    .pay-via-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 15px;
        margin-bottom: 30px;
    }
    .gateway-item {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 20px;
        padding: 18px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    .gateway-item.active {
        border-color: var(--color-primary);
        background: #f1f9f9;
    }
    .gateway-name { font-weight: 700; color: #333; font-size: 0.95rem; }
    .radio-circle {
        width: 22px;
        height: 22px;
        border: 2px solid #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    .gateway-item.active .radio-circle {
        border-color: var(--color-primary);
    }
    .radio-inner {
        width: 10px;
        height: 10px;
        background: var(--color-primary);
        border-radius: 50%;
        display: none;
    }
    .gateway-item.active .radio-inner { display: block; }

    /* Coupon */
    .coupon-box {
        background: #fff;
        border-radius: 20px;
        padding: 10px;
        display: flex;
        gap: 10px;
        border: 1px solid #eee;
        margin-bottom: 25px;
    }
    .coupon-box input { border: none; flex-grow: 1; padding: 0 15px; font-weight: 600; outline: none; }
    .btn-apply {
        background: var(--color-primary);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 10px 25px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    /* Product Summary */
    .product-summary-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #f8f9fa;
    }
    .product-summary-item img { width: 50px; height: 50px; border-radius: 10px; object-fit: cover; }
    .product-info h6 { margin: 0; font-weight: 800; font-size: 0.85rem; }
    .product-info span { font-size: 0.75rem; color: #888; font-weight: 600; }

    /* Sticky Bottom Bar */
    .sticky-action-bar-container {
        position: fixed;
        bottom: 20px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        z-index: 1000;
        padding: 0 20px;
    }
    .sticky-card {
        background: #fff;
        padding: 15px;
        border-radius: 25px;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.1);
    }
    .btn-submit {
        background-color: var(--color-primary);
        color: #fff;
        width: 100%;
        border: none;
        border-radius: 20px;
        padding: 18px;
        font-weight: 800;
        font-size: 1.1rem;
    }
    .section-header { text-align: right; font-weight: 800; font-size: 0.85rem; color: #333; margin-bottom: 12px; }
</style>

<div class="container py-7 cart-page-container">
    <!-- Header -->
    <div class="position-relative mb-4 text-center pt-5">
        <h4 class="fw-bold mb-0">Complete the order</h4>
        <a href="{{ route('user.front.cart', getParam()) }}" class="d-flex align-items-center justify-content-center position-absolute"
           style="width: 38px; height: 38px; border-radius: 50%; background: var(--color-primary); top: 50%; right: 0; transform: translateY(-50%);">
            <i class="fas fa-chevron-right text-white"></i>
        </a>
    </div>

    <form method="POST" id="payment" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="ordered_from" value="website">

        <!-- Serving Methods -->
        <h6 class="section-header">Serving method</h6>
        <div class="checkout-toggle-group">
            @foreach ($smethods as $sm)
                <div class="checkout-toggle-item serving-method-toggle {{ $loop->first ? 'active' : '' }}" 
                     onclick="selectServingMethod('{{ $sm->value }}', this)">
                    <input type="radio" name="serving_method" value="{{ $sm->value }}" class="d-none" 
                           {{ $loop->first ? 'checked' : '' }}>
                    <span>{{ $keywords[str_replace(' ', '_', $sm->name)] ?? __($sm->name) }}</span>
                </div>
            @endforeach
        </div>

        <!-- Information Fields -->
        <h6 class="section-header">Order details</h6>
        <div id="dynamic-fields">
            <div id="on_table_fields" class="serving-fields" style="display:none;">
                <div class="input-with-icon">
                    <input type="text" name="table_number" class="form-control" placeholder="Table number *" value="{{ session('table') }}">
                    <span class="input-icon"><i class="fas fa-utensils"></i></span>
                </div>
                <div class="input-with-icon">
                    <input type="text" name="waiter_name" class="form-control" placeholder="Waiter name">
                    <span class="input-icon"><i class="fas fa-user-tie"></i></span>
                </div>
            </div>

            <div id="home_delivery_fields" class="serving-fields" style="display:none;">
                @if ($userBs->postal_code == 1 && !empty($pfeatures) && in_array('Postal Code Based Delivery Charge',$pfeatures))
                <div class="input-with-icon">
                    <span class="floating-label">Select region *</span>
                    <select name="postal_code" id="postal_code" class="form-control">
                        <option value="" disabled selected>Select region</option>
                        @foreach ($postcodes as $pc)
                            <option value="{{ $pc->id }}" data="{{ !empty($pc->free_delivery_amount) && (cartTotal() >= $pc->free_delivery_amount) ? 0 : $pc->charge }}">
                                {{ $pc->title }}
                            </option>
                        @endforeach
                    </select>
                    <span class="input-icon"><i class="fas fa-map-marker-alt"></i></span>
                </div>
                @endif
                <div class="input-with-icon">
                    <input type="text" name="shipping_address" class="form-control" placeholder="Delivery address *" value="{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->shipping_address : '' }}">
                    <span class="input-icon"><i class="fas fa-home"></i></span>
                </div>
            </div>

            <div class="input-with-icon">
                <input type="text" name="billing_fname" class="form-control" placeholder="Your name *" value="{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->firstname : '' }}" required>
                <span class="input-icon"><i class="far fa-user"></i></span>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-4">
                    <div class="input-with-icon mb-0">
                        <select name="billing_country_code" class="form-control px-2" style="font-size: 0.8rem;">
                            @foreach ($ccodes as $cc)
                                <option value="{{ $cc['code'] }}" {{ $cc['code'] == '+972' ? 'selected' : '' }}>{{ $cc['code'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-8">
                    <div class="input-with-icon mb-0">
                        <input type="tel" name="billing_number" class="form-control" placeholder="Mobile number *" value="{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->phone : '' }}" required>
                        <span class="input-icon"><i class="fas fa-mobile-alt"></i></span>
                    </div>
                </div>
            </div>

            @guest
            <div class="input-with-icon">
                <input type="email" name="billing_email" class="form-control" placeholder="Email address *" required>
                <span class="input-icon"><i class="far fa-envelope"></i></span>
            </div>
            @else
            <input type="hidden" name="billing_email" value="{{ Auth::guard('client')->user()->email }}">
            @endguest

            <textarea name="order_notes" class="form-control mb-4" rows="3" placeholder="Order notes (optional)"></textarea>
        </div>

        <!-- Order Summary (Products) -->
        <h6 class="section-header">Items summary</h6>
        <div class="summary-card py-2">
            @if(!empty($cart))
                @foreach($cart as $id => $item)
                    @php $product = Product::findOrFail($id); @endphp
                    <div class="product-summary-item">
                        <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $item['photo'], $userBs) }}" alt="">
                        <div class="product-info flex-grow-1">
                            <h6>{{ $item['name'] }}</h6>
                            <span>Qty: {{ $item['qty'] }}</span>
                        </div>
                        <div class="product-price fw-bold text-dark font-sm">
                            {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ $item['total'] }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Coupon -->
        <div class="coupon-box shadow-sm">
            <input type="text" id="coupon_code" placeholder="Enter coupon code">
            <button type="button" class="btn-apply" onclick="applyCoupon()">Apply</button>
        </div>

        <!-- Calculations Card -->
        <div class="summary-card">
            <div class="summary-row">
                <span class="value">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}<span id="subtotal-val">{{ cartTotal() }}</span>{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</span>
                <span class="label">Subtotal</span>
            </div>
            @if($userBe->tax > 0)
            <div class="summary-row">
                <span class="value">+ {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}<span id="tax-val">0</span>{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</span>
                <span class="label">Tax ({{ $userBe->tax }}%)</span>
            </div>
            @endif
            <div id="shipping-row" class="summary-row" style="display:none;">
                <span class="value">+ {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}<span id="shipping-val">0</span>{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</span>
                <span class="label">Delivery charge</span>
            </div>
            <div id="discount-row" class="summary-row text-success" style="display:none;">
                <span class="value">- {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}<span id="discount-val">0</span>{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</span>
                <span class="label">Discount</span>
            </div>
            <div class="total-row">
                <div class="total-value">
                    {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                    <span id="final-total-val">{{ cartTotal() }}</span>
                    {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                </div>
                <div class="total-label">Total</div>
            </div>
        </div>

        <!-- Payment Multi-Level Selector -->
        <h6 class="section-header">Payment category</h6>
        <div class="checkout-toggle-group">
            <div class="checkout-toggle-item p-category-toggle active" onclick="togglePaymentGroup('online', this)">Card Payment</div>
            <div class="checkout-toggle-item p-category-toggle" onclick="togglePaymentGroup('offline', this)">Cash on Delivery</div>
        </div>

        <div id="payment-gateways-container" class="mb-10">
            <h6 class="section-header text-muted">Pay Via</h6>
            
            <!-- Online Gateways -->
            <div id="online-list" class="pay-via-list mb-5">
                @php 
                    $onlineNames = [
                        'paypal' => 'PayPal', 'stripe' => 'Credit/Debit Card', 'paystack' => 'Paystack', 
                        'flutterwave' => 'Flutterwave', 'razorpay' => 'Razorpay', 'instamojo' => 'Instamojo',
                        'paytm' => 'PayTM', 'mollie' => 'Mollie', 'mercadopago' => 'MercadoPago',
                        'anet' => 'Authorize.Net', 'yoco' => 'Yoco', 'xendit' => 'Xendit'
                    ];
                @endphp
                @foreach($onlineNames as $key => $name)
                    @if(isset($$key) && $$key->status == 1)
                        <div class="gateway-item" onclick="selectGateway('{{ $key }}', 'online', this)">
                            <div class="gateway-name">{{ $name }}</div>
                            <div class="radio-circle"><div class="radio-inner"></div></div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Offline Gateways -->
            <div id="offline-list" class="pay-via-list" style="display:none;">
                @foreach($ogateways as $og)
                    <div class="gateway-item" onclick="selectGateway('{{ $og->id }}', 'offline', this)">
                        <div class="gateway-name">{{ $og->name }}</div>
                        <div class="radio-circle"><div class="radio-inner"></div></div>
                    </div>
                @endforeach
            </div>
        </div>

        <input type="hidden" name="payment_method" id="payment_gateway_input">
        <input type="hidden" name="gateway" id="gateway_internal">
    </form>
</div>

<div class="sticky-action-bar-container">
    <div class="sticky-card shadow-lg">
        <button type="submit" form="payment" class="btn-submit">Place Order</button>
    </div>
</div>

@endsection

@section('script')
<script>
    var cartSubtotal = parseFloat("{{ cartTotal() }}") || 0;
    var taxPercentage = parseFloat("{{ $userBe->tax }}") || 0;
    var currentDiscount = 0;
    var currentShipping = 0;

    function selectServingMethod(value, el) {
        $('.serving-method-toggle').removeClass('active');
        $(el).addClass('active');
        $(el).find('input').prop('checked', true);

        $('.serving-fields').hide();
        if (value === 'home_delivery') {
            $('#home_delivery_fields').show();
            $('#shipping-row').show();
        } else if (value === 'on_table') {
            $('#on_table_fields').show();
            $('#shipping-row').hide();
        } else {
            $('#shipping-row').hide();
        }
        calcFinal();
    }

    function togglePaymentGroup(type, el) {
        $('.p-category-toggle').removeClass('active');
        $(el).addClass('active');
        $('.pay-via-list').hide();
        $(`#${type}-list`).show();
        $(`#${type}-list .gateway-item`).first().trigger('click');
    }

    function selectGateway(id, type, el) {
        $('.gateway-item').removeClass('active');
        $(el).addClass('active');
        
        $('#payment_gateway_input').val(type === 'online' ? id : 'offline'+id);
        $('#gateway_internal').val(id);

        let action = "";
        if (type === 'online') {
            if (id === 'paypal') action = "{{ route('product.paypal.submit', getParam()) }}";
            else if (id === 'stripe') action = "{{ route('product.stripe.submit', getParam()) }}";
            else {
                 let routeMap = {
                    'paystack': "{{ route('product.paystack.submit', getParam()) }}",
                    'flutterwave': "{{ route('product.flutterwave.submit', getParam()) }}",
                    'razorpay': "{{ route('product.razorpay.submit', getParam()) }}",
                    'instamojo': "{{ route('product.instamojo.submit', getParam()) }}",
                    'paytm': "{{ route('product.paytm.submit', getParam()) }}",
                    'mollie': "{{ route('product.mollie.submit', getParam()) }}",
                    'mercadopago': "{{ route('product.mercadopago.submit', getParam()) }}",
                    'anet': "{{ route('product.anet.submit', getParam()) }}",
                 };
                 action = routeMap[id] || "";
            }
        } else {
            action = "{{ route('product.offline.submit', [getParam(), ':id']) }}".replace(':id', id);
        }
        $('#payment').attr('action', action);
    }

    function applyCoupon() {
        let code = $('#coupon_code').val();
        if(!code) return;
        
        $.post("{{ route('user.front.coupon', getParam()) }}", { coupon: code, _token: "{{ csrf_token() }}" }, function(res) {
            if(res.status === 'success') {
                currentDiscount = parseFloat(res.amount);
                $('#discount-val').text(currentDiscount.toFixed(2));
                $('#discount-row').show();
                calcFinal();
                toastr.success(res.message || "Coupon applied!");
            } else {
                toastr.error(res.message || "Invalid coupon");
            }
        });
    }

    function calcFinal() {
        if ($('.serving-method-toggle.active input').val() === 'home_delivery') {
            let selectedPC = $('#postal_code option:selected');
            currentShipping = (selectedPC.length && selectedPC.attr('data')) ? parseFloat(selectedPC.attr('data')) : 0;
        } else {
            currentShipping = 0;
        }

        let taxAmount = (cartSubtotal - currentDiscount) * (taxPercentage / 100);
        if(taxAmount < 0) taxAmount = 0;

        $('#tax-val').text(taxAmount.toFixed(2));
        $('#shipping-val').text(currentShipping.toFixed(2));
        
        let final = cartSubtotal + taxAmount + currentShipping - currentDiscount;
        $('#final-total-val').text(final.toFixed(2));
    }

    $(document).ready(function() {
        selectServingMethod($('.serving-method-toggle.active input').val(), $('.serving-method-toggle.active'));
        $(document).on('change', '#postal_code', calcFinal);
        
        // Default to Offline for easier testing if available
        if($('.p-category-toggle').length > 1) {
            togglePaymentGroup('offline', $('.p-category-toggle').last());
        } else {
            togglePaymentGroup('online', $('.p-category-toggle').first());
        }
    });
</script>
@endsection
