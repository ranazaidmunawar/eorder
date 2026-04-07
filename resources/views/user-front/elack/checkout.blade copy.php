@extends('user-front.layout')

@section('pageHeading')
    {{ $keywords['Checkout'] ?? __('Checkout') }}
@endsection

@section('style')
<style>
    :root {
        --sushi-primary: #1a4d46;
        --sushi-accent: #ffa726;
        --sushi-bg: #f8f9fa;
        --sushi-card: #ffffff;
        --sushi-text: #2d3436;
    }

    body {
        background-color: var(--sushi-bg);
        color: var(--sushi-text);
        padding-bottom: 120px; /* Space for sticky footer */
    }

    /* Branded Header */
    .resto-app-header {
        background: var(--sushi-primary);
        color: #fff;
        padding: 15px 0;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    .resto-app-header .logo {
        font-size: 1.5rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .resto-app-header .view-requests {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        display: block;
        margin-top: 4px;
    }

    /* Page Header */
    .checkout-page-header {
        padding: 20px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .checkout-page-header .back-btn {
        position: absolute;
        right: 20px;
        background: var(--sushi-primary);
        color: #fff;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(26,77,70,0.2);
    }
    .checkout-page-header h2 {
        font-weight: 800;
        font-size: 1.4rem;
        margin: 0;
    }

    /* Tabs */
    .service-tabs-wrapper {
        background: #eee;
        border-radius: 50px;
        display: flex;
        padding: 4px;
        margin-bottom: 25px;
    }
    .service-tab {
        flex: 1;
        padding: 12px;
        border-radius: 50px;
        text-align: center;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: 0.3s;
        color: #666;
    }
    .service-tab.active {
        background: #fff;
        color: var(--sushi-primary);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    /* Card styling */
    .checkout-card {
        background: var(--sushi-card);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }
    .card-title {
        font-weight: 800;
        font-size: 1rem;
        margin-bottom: 20px;
        display: flex;
        justify-content: flex-end;
    }

    /* Form Fields */
    .sushi-input-group {
        position: relative;
        margin-bottom: 15px;
    }
    .sushi-input {
        width: 100%;
        padding: 18px 20px;
        padding-right: 50px;
        border-radius: 12px;
        border: 1px solid #eee;
        background: #fafafa;
        font-size: 0.95rem;
    }
    .sushi-input:focus {
        background: #fff;
        border-color: var(--sushi-primary);
        outline: none;
    }
    .input-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 1.2rem;
    }

    /* Region Selector */
    .region-select-wrap {
        position: relative;
        margin-bottom: 15px;
    }
    .region-select {
        width: 100%;
        padding: 18px 20px;
        padding-right: 50px;
        border-radius: 12px;
        border: 1px solid #eee;
        background: #fafafa;
        appearance: none;
        font-size: 0.95rem;
    }
    .region-select:focus {
        border-color: var(--sushi-primary);
        outline: none;
    }
    .region-label {
        position: absolute;
        top: 8px;
        right: 50px;
        font-size: 0.7rem;
        color: #888;
        font-weight: 600;
    }

    /* Order Details */
    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-weight: 500;
    }
    .detail-row.total {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--sushi-primary);
    }
    .detail-row .label { color: #666; }
    .detail-row.total .label { color: var(--sushi-primary); }

    /* Payment Methods */
    .payment-options {
        display: flex;
        gap: 15px;
        margin-top: 15px;
    }
    .payment-box {
        flex: 1;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: 0.2s;
        background: #fafafa;
        position: relative;
    }
    .payment-box.active {
        border-color: var(--sushi-primary);
        background: #eaffee;
    }
    .payment-box input {
        display: none;
    }
    .payment-box img {
        height: 24px;
        margin-bottom: 8px;
        object-fit: contain;
    }
    .payment-box span {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: #444;
    }

    /* Sticky Footer */
    .sticky-footer {
        position: fixed;
        bottom: 20px;
        left: 20px;
        right: 20px;
        z-index: 1000;
    }
    .submit-btn {
        background: var(--sushi-primary);
        color: #fff;
        width: 100%;
        padding: 20px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 1.1rem;
        border: none;
        box-shadow: 0 10px 25px rgba(26,77,70,0.3);
    }

    /* RTL Support */
    body.rtl {
        direction: rtl;
        text-align: right;
    }
    body.rtl .input-icon {
        right: auto;
        left: 20px;
    }
    body.rtl .sushi-input {
        padding-right: 20px;
        padding-left: 50px;
    }
    body.rtl .checkout-page-header .back-btn {
        right: auto;
        left: 20px;
    }
</style>
@endsection

@section('content')
<div class="resto-app-header">
    <div class="container">
        <div class="logo">
            <i class="fas fa-utensils"></i> RestoApp
        </div>
        <a href="#" class="view-requests">View my requests</a>
    </div>
</div>

<div class="container py-2">
    <div class="checkout-page-header">
        <h2>{{ $keywords['Complete the order'] ?? __('Complete the order') }}</h2>
        <a href="{{ route('user.front.cart', getParam()) }}" class="back-btn">
            <i class="fas fa-chevron-left"></i>
        </a>
    </div>

    <form action="{{ route('product.offline.submit', [getParam(), 'gatewayid' => 0]) }}" method="POST" id="payment">
        @csrf
        <input type="hidden" name="ordered_from" value="website">
        <input type="hidden" name="serving_method" id="serving_method_input" value="home_delivery">

        <!-- Service Tabs -->
        <div class="service-tabs-wrapper">
            <div class="service-tab" data-target="on_table">{{ $keywords['Eat_at_the_restaurant'] ?? __('Eat at the restaurant') }}</div>
            <div class="service-tab" data-target="pick_up">{{ $keywords['Receive_it_yourself'] ?? __('Receive it yourself') }}</div>
            <div class="service-tab active" data-target="home_delivery">{{ $keywords['Delivery'] ?? __('Delivery') }}</div>
        </div>

        <div class="checkout-card">
            <div class="card-title">{{ $keywords['Contact_information'] ?? __('Contact information') }}</div>
            
            <!-- Delivery Specific Fields -->
            <div id="delivery_fields">
                <div class="region-select-wrap">
                    <span class="region-label">Select region</span>
                    <select name="shipping_charge" class="region-select" id="shipping_charge_select">
                        <option value="0" data-charge="0">-- {{ $keywords['Select_Region'] ?? __('Select Region') }} --</option>
                        @foreach ($scharges as $charge)
                            <option value="{{ $charge->id }}" data-charge="{{ $charge->charge }}">{{ $charge->title }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-map-marker-alt input-icon"></i>
                </div>

                <div class="sushi-input-group">
                    <input type="text" name="shipping_address" class="sushi-input" placeholder="Enter the address">
                    <i class="fas fa-home input-icon"></i>
                </div>
            </div>

            <div class="sushi-input-group">
                <input type="text" name="shipping_fname" class="sushi-input" placeholder="Enter the name" required>
                <i class="fas fa-user input-icon"></i>
            </div>

            <div class="sushi-input-group">
                <input type="text" name="shipping_number" class="sushi-input" placeholder="Enter mobile number" required>
                <i class="fas fa-mobile-alt input-icon"></i>
            </div>

            <div class="sushi-input-group">
                <textarea name="order_notes" class="sushi-input" placeholder="Additional notes for the order" style="height: 100px;"></textarea>
            </div>
        </div>

        <div class="checkout-card">
            <div class="card-title">{{ $keywords['Order_details'] ?? __('Order details') }}</div>
            
            <div class="detail-row">
                <span class="label">{{ $keywords['Subtotal'] ?? __('Subtotal') }}</span>
                <span class="value" id="summary_subtotal">
                    {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                    {{ cartTotal() }}
                    {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                </span>
            </div>

            <div class="detail-row" id="delivery_cost_row">
                <span class="label">{{ $keywords['Delivery_cost'] ?? __('Delivery cost') }}</span>
                <span class="value" id="summary_delivery">
                    {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                    0
                    {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                </span>
            </div>

            <div class="detail-row total">
                <span class="label">{{ $keywords['Total'] ?? __('Total') }}</span>
                <span class="value" id="summary_total">
                    {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                    {{ cartTotal() }}
                    {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                </span>
            </div>
        </div>

        <div class="card-title" style="margin-top:20px;">{{ $keywords['payment_method'] ?? __('payment method') }}</div>
        <div class="payment-options">
            <!-- Offline / Cash on Delivery -->
            <div class="payment-box active" data-type="offline" data-id="0">
                <img src="https://armani.nemo.ps/wp-content/themes/noqta-menu-theme/assets/svgs/cash.svg" alt="COD">
                <span>{{ $keywords['Cash_on_delivery'] ?? __('Cash on delivery') }}</span>
                <input type="radio" name="payment_method" value="Cash on Delivery" checked>
            </div>

            <!-- Card Payments (Simplified for UI) -->
            <div class="payment-box" data-type="stripe">
                <img src="https://armani.nemo.ps/wp-content/themes/noqta-menu-theme/assets/svgs/cards.svg" alt="Card">
                <span>{{ $keywords['Card_payment'] ?? __('Card payment') }}</span>
                <input type="radio" name="payment_method" value="Stripe">
            </div>
        </div>
        
        <p class="text-center mt-3 text-muted small" id="payment_desc">{{ $keywords['Cash_on_delivery'] ?? __('Cash on delivery') }}</p>

        <div class="sticky-footer">
            <button type="submit" class="submit-btn" id="submit_order_btn">
                {{ $keywords['Submit_the_request'] ?? __('Submit the request') }}
            </button>
        </div>
    </form>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Tab switching
        $('.service-tab').click(function() {
            $('.service-tab').removeClass('active');
            $(this).addClass('active');
            
            const target = $(this).data('target');
            $('#serving_method_input').val(target);
            
            if (target === 'home_delivery') {
                $('#delivery_fields').slideDown();
                $('#delivery_cost_row').show();
            } else {
                $('#delivery_fields').slideUp();
                $('#delivery_cost_row').hide();
                resetDeliveryCharge();
            }
            updateTotal();
        });

        // Region / Shipping charge change
        $('#shipping_charge_select').change(function() {
            updateTotal();
        });

        function resetDeliveryCharge() {
            $('#shipping_charge_select').val('0');
        }

        function updateTotal() {
            const subtotal = parseFloat("{{ cartTotal() }}");
            let shipping = 0;
            
            if ($('#serving_method_input').val() === 'home_delivery') {
                shipping = parseFloat($('#shipping_charge_select option:selected').data('charge') || 0);
            }
            
            const total = subtotal + shipping;
            const symbol = "{{ $userBe->base_currency_symbol }}";
            const pos = "{{ $userBe->base_currency_symbol_position }}";

            const formattedShipping = pos === 'left' ? symbol + shipping : shipping + symbol;
            const formattedTotal = pos === 'left' ? symbol + total.toFixed(2) : total.toFixed(2) + symbol;

            $('#summary_delivery').text(formattedShipping);
            $('#summary_total').text(formattedTotal);
        }

        // Payment Method selection
        $('.payment-box').click(function() {
            $('.payment-box').removeClass('active');
            $(this).addClass('active');
            $(this).find('input').prop('checked', true);
            $('#payment_desc').text($(this).find('span').text());

            const type = $(this).data('type');
            if (type === 'stripe') {
                $('#payment').attr('action', "{{ route('product.stripe.submit', getParam()) }}");
            } else {
                $('#payment').attr('action', "{{ route('product.offline.submit', [getParam(), 'gatewayid' => 0]) }}");
            }
        });

        // Form submission
        $('#payment').submit(function(e) {
            // Simplified validation
            const fname = $('input[name="shipping_fname"]').val();
            const number = $('input[name="shipping_number"]').val();
            
            if (!fname || !number) {
                alert("Please fill all required fields");
                return false;
            }
            
            return true;
        });
    });
</script>
@endsection
