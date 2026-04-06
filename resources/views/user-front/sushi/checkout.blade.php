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
    body { background-color: #f8fbfb; }
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
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .checkout-toggle-item.active {
        background: #fff;
        color: var(--color-primary);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    /* Inputs */
    .input-with-icon {
        position: relative;
        margin-bottom: 12px;
    }
    .input-with-icon .form-control, .input-with-icon select {
        padding-right: 50px;
        padding-left: 20px;
        border-radius: 18px;
        height: 60px;
        border: 1px solid #f0f0f0;
        background-color: #fff !important;
        font-size: 0.95rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.01);
        font-weight: 600;
    }
    .input-with-icon .input-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-primary);
        font-size: 1.1rem;
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
    
    /* Boxed Sections */
    .content-box {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.01);
        margin-bottom: 25px;
    }

    /* Order Details Summary */
    .order-details-box {
        background: #fff;
        border-radius: 20px;
        padding: 22px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.02);
        margin-bottom: 25px;
    }
    .order-details-title { text-align: right; font-weight: 800; font-size: 1rem; margin-bottom: 15px; color: #333; }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.95rem;
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
    .total-label { font-size: 1.25rem; font-weight: 800; color: var(--color-primary); }
    .total-value { font-size: 1.6rem; font-weight: 900; color: var(--color-primary); }

    /* Payment Buttons */
    .payment-method-row {
        display: flex;
        gap: 12px;
        margin-bottom: 25px;
    }
    .payment-btn {
        flex: 1;
        background: #fff;
        border: 1.5px solid #f0f0f0;
        border-radius: 18px;
        padding: 15px 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        min-height: 85px;
    }
    .payment-btn.active {
        border-color: var(--color-primary);
        background: #f1f9f9;
        box-shadow: 0 8px 20px rgba(var(--color-primary-rgb), 0.08);
    }
    .payment-btn .btn-text { font-weight: 800; font-size: 0.85rem; color: var(--color-primary); text-align: center; margin-top: 8px; }
    .payment-btn .payment-icons { display: flex; gap: 5px; margin-bottom: 2px; }
    .payment-btn .payment-icons img { height: 18px; }

    /* Section Headers */
    .section-header { text-align: right; font-weight: 800; font-size: 0.9rem; color: #333; margin-bottom: 15px; }

    /* Product Summary */
    .product-summary-box {
        background: #fff;
        border-radius: 20px;
        padding: 15px;
        margin-bottom: 30px;
    }
    .product-summary-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f8f9fa;
    }
    .product-summary-item:last-child { border-bottom: none; }
    .product-summary-item img { width: 45px; height: 45px; border-radius: 10px; object-fit: cover; }
    .product-info h6 { margin: 0; font-weight: 800; font-size: 0.8rem; }
    .product-info span { font-size: 0.7rem; color: #888; font-weight: 600; }

    /* Sticky Action Bar */
    .sticky-action-bar-container {
        position: fixed;
        bottom: 20px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        z-index: 1000;
        padding: 0 15px;
    }
    .sticky-card {
        background: #fff;
        padding: 10px;
        border-radius: 25px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.15);
    }
    .btn-submit {
        background-color: var(--color-primary);
        color: #fff;
        width: 100%;
        border: none;
        border-radius: 20px;
        padding: 16px;
        font-weight: 800;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Notes Textarea */
    .order-notes-textarea {
        border-radius: 18px;
        border: 1px solid #f0f0f0;
        padding: 15px 20px;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.01);
        min-height: 120px;
        resize: none;
        background-color: #fff;
    }
    
    /* Coupon */
    .coupon-box {
        background: #fff;
        border-radius: 18px;
        padding: 8px;
        display: flex;
        gap: 10px;
        border: 1px solid #f0f0f0;
        margin-bottom: 25px;
    }
    .coupon-box input { border: none; flex-grow: 1; padding: 0 15px; font-weight: 600; outline: none; font-size: 0.85rem; }
    .btn-apply {
        background: var(--color-primary);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 8px 20px;
        font-weight: 700;
        font-size: 0.8rem;
    }
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
                @php
                    $label = $sm->name;
                    if ($sm->name == 'On Table') $label = 'Eat at the restaurant';
                    elseif ($sm->name == 'Pick Up') $label = 'Receive it yourself';
                    elseif ($sm->name == 'Home Delivery') $label = 'Delivery';
                @endphp
                <div class="checkout-toggle-item serving-method-toggle {{ $loop->first ? 'active' : '' }}" 
                     onclick="selectServingMethod('{{ $sm->value }}', this)">
                    <input type="radio" name="serving_method" value="{{ $sm->value }}" class="d-none" 
                           {{ $loop->first ? 'checked' : '' }}>
                    <span>{{ $keywords[str_replace(' ', '_', $label)] ?? __($label) }}</span>
                </div>
            @endforeach
        </div>

        <!-- Contact Information Fields -->
        <h6 class="section-header">Contact information</h6>
        <div class="content-box">
            <div id="dynamic-fields">
                <!-- <div id="on_table_fields" class="serving-fields" style="display:none;">
                    <div class="input-with-icon">
                        <input type="text" name="table_number" class="form-control" placeholder="Table number *" value="{{ session('table') }}">
                        <span class="input-icon"><i class="fas fa-utensils"></i></span>
                    </div>
                    <div class="input-with-icon">
                        <input type="text" name="waiter_name" class="form-control" placeholder="Waiter name">
                        <span class="input-icon"><i class="fas fa-user-tie"></i></span>
                    </div>
                </div> -->

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
                        <input type="text" name="shipping_address" class="form-control" placeholder="Enter the address *" value="{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->shipping_address : '' }}">
                        <span class="input-icon"><i class="fas fa-home"></i></span>
                    </div>
                </div>

                <div class="input-with-icon">
                    <input type="text" name="billing_fname" class="form-control" placeholder="Enter the name *" value="{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->firstname : '' }}" required>
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                </div>

                <div class="row g-2 mb-2">
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
                            <input type="tel" name="billing_number" class="form-control" placeholder="Enter mobile number *" value="{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->phone : '' }}" required>
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

                <textarea name="order_notes" class="form-control order-notes-textarea mt-3" rows="2" placeholder="Additional notes for the order"></textarea>
            </div>
        </div>


        <!-- Order Summary (Products) -->
        <!-- <h6 class="section-header">Items summary</h6>
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
        </div> -->

        <!-- Coupon -->
        <!-- <div class="coupon-box shadow-sm">
            <input type="text" id="coupon_code" placeholder="Enter coupon code">
            <button type="button" class="btn-apply" onclick="applyCoupon()">Apply</button>
        </div> -->

        <!-- Order Details (Calculations) -->
        <h6 class="section-header">Order details</h6>
        <div class="order-details-box">
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
                <span class="label">Delivery cost</span>
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

        <!-- Payment Method -->
        @php
            $firstOffline = $ogateways->first();
            $firstOnline = null;
            $onlineList = ['paypal', 'stripe', 'paystack', 'flutterwave', 'razorpay', 'instamojo', 'paytm', 'mollie', 'mercadopago', 'anet', 'yoco', 'xendit', 'perfect_money', 'midtrans', 'myfatoorah', 'toyyibpay', 'paytabs', 'iyzico', 'phonepe'];
            $onlineGateways = ['paypal', 'stripe', 'paystack', 'flutterwave', 'razorpay', 'instamojo', 'paytm', 'mollie', 'mercadopago', 'anet', 'yoco', 'xendit', 'perfect_money', 'midtrans', 'myfatoorah', 'toyyibpay', 'paytabs', 'phonepe'];
            foreach($onlineGateways as $gw) {
                if(isset($$gw) && $$gw->status == 1) {
                    $firstOnline = $gw;
                    break;
                }
            }
        @endphp

        <h6 class="section-header">payment method</h6>
        <div class="payment-method-row">
            @if($firstOffline)
            <div class="payment-btn {{ $firstOffline ? 'active' : '' }} p-category-toggle" onclick="selectPayment('cash')">
                <div class="btn-text">Cash on delivery</div>
            </div>
            @endif

            @if($firstOnline)
            <div class="payment-btn p-category-toggle" onclick="selectPayment('card')">
                <div class="payment-icons">
                    <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa">
                    <img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="Mastercard">
                </div>
                <div class="btn-text">Card payment</div>
            </div>
            @endif
        </div>


        <div id="payment-gateways-container" style="display:none;">
            <!-- Hidden gateway lists for selection logic -->
            <div id="online-list" class="d-none">
                @foreach($onlineList as $key)
                    @if(isset($$key) && $$key->status == 1)
                        <div class="gateway-hidden-item" data-id="{{ $key }}" data-type="online" onclick="selectGateway('{{ $key }}', 'online', this)"></div>
                    @endif
                @endforeach
            </div>
            <div id="offline-list" class="d-none">
                @foreach($ogateways as $og)
                    <div class="gateway-hidden-item" data-id="{{ $og->id }}" data-type="offline" onclick="selectGateway('{{ $og->id }}', 'offline', this)"></div>
                @endforeach
            </div>
        </div>


        <input type="hidden" name="payment_method" id="paymentInput" value="{{ $firstOffline ? 'cash' : 'card' }}">
        <input type="hidden" name="gateway" id="gateway_internal" value="{{ $firstOffline ? $firstOffline->id : ($firstOnline ?? '') }}">


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

    function selectPayment(type) {
        $('.p-category-toggle').removeClass('active');
        // Find the button by its click event argument
        $(`.p-category-toggle[onclick*="'${type}'"]`).addClass('active');
        
        let id = "";
        if (type === 'card') {
            id = "{{ $firstOnline }}";
            $('#paymentInput').val('card');
        } else {
            id = "{{ $firstOffline->id ?? '' }}";
            $('#paymentInput').val('cash');
        }
        $('#gateway_internal').val(id);

        let action = "";
        if (type === 'card') {
            let routeMap = {
                'paypal': "{{ route('product.paypal.submit', getParam()) }}",
                'stripe': "{{ route('product.stripe.submit', getParam()) }}",
                'paystack': "{{ route('product.paystack.submit', getParam()) }}",
                'flutterwave': "{{ route('product.flutterwave.submit', getParam()) }}",
                'razorpay': "{{ route('product.razorpay.submit', getParam()) }}",
                'instamojo': "{{ route('product.instamojo.submit', getParam()) }}",
                'paytm': "{{ route('product.paytm.submit', getParam()) }}",
                'mollie': "{{ route('product.mollie.submit', getParam()) }}",
                'mercadopago': "{{ route('product.mercadopago.submit', getParam()) }}",
                'anet': "{{ route('product.anet.submit', getParam()) }}",
                'phonepe': "{{ route('product.phonepe.submit', getParam()) }}",
            };
            action = routeMap[id] || "";
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
        // Initialize serving method
        selectServingMethod($('.serving-method-toggle.active input').val(), $('.serving-method-toggle.active'));
        $(document).on('change', '#postal_code', calcFinal);
        
        // Initialize payment category from the active button (Card or Cash)
        let defaultType = "{{ $firstOffline ? 'cash' : 'card' }}";
        selectPayment(defaultType);
    });


</script>
@endsection
