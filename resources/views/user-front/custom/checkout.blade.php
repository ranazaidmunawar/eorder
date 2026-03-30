@extends('layouts.master')
@section('title', 'Complete the order')

@section('content')
<div class="container py-3 cart-page-container" style="padding-bottom: 300px;">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-center position-relative mb-4">
        <h4 class="fw-bold mb-0">Complete the order</h4>
        <a href="{{ route('cart.index') }}" class="btn btn-sm btn-primary rounded-circle position-absolute end-0"
            style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i
                class="fas fa-chevron-right"></i></a>
    </div>

    <form action="{{ route('order.store') }}" method="POST" id="checkoutForm">
        @csrf
        <input type="hidden" name="cart_data" id="cartData">

        <!-- Contact Information -->
        <h6 class="fw-bold mb-3 text-end">Contact information</h6>

        <!-- Delivery Type Toggle -->
        <div class="checkout-toggle-group mb-4" id="deliveryToggle">
            <div class="checkout-toggle-item flex-grow-1" onclick="selectDeliveryType('eat_in', this)">
                <input type="radio" name="delivery_type" value="eat_in" class="d-none">
                <span>Eat at the restaurant</span>
            </div>
            <div class="checkout-toggle-item flex-grow-1" onclick="selectDeliveryType('pickup', this)">
                <input type="radio" name="delivery_type" value="pickup" class="d-none">
                <span>Receive it yourself</span>
            </div>
            <div class="checkout-toggle-item flex-grow-1 active" onclick="selectDeliveryType('delivery', this)">
                <input type="radio" name="delivery_type" value="delivery" class="d-none" checked>
                <span>Delivery</span>
            </div>
        </div>

        <!-- Delivery-only fields -->
        <div id="delivery-fields">
            <!-- Region Select -->
            <div class="input-with-icon mb-3">
                <label class="small text-primary position-absolute top-0 end-0 mt-1 me-3"
                    style="font-size: 0.7rem; z-index: 10;">Select region</label>
                <select name="region" class="form-control bg-white" style="appearance: none; padding-top: 20px;">
                    <option value="Qaffin">Qaffin</option>
                </select>
                <span class="input-icon"><i class="fas fa-map-marker-alt"></i></span>
                <i class="fas fa-chevron-down position-absolute start-0 top-50 translate-middle-y ms-3 text-muted"></i>
            </div>

            <!-- Address -->
            <div class="input-with-icon mb-3">
                <input type="text" name="address" class="form-control bg-white" placeholder="Enter the address">
                <span class="input-icon"><i class="fas fa-home"></i></span>
            </div>
        </div>

        <!-- Name -->
        <div class="input-with-icon mb-3">
            <input type="text" name="name" class="form-control bg-white" placeholder="Enter the name" required>
            <span class="input-icon"><i class="far fa-user"></i></span>
        </div>

        <!-- Phone -->
        <div class="input-with-icon mb-4">
            <input type="tel" name="phone" class="form-control bg-white" placeholder="Enter mobile number" required>
            <span class="input-icon"><i class="fas fa-mobile-alt"></i></span>
        </div>

        <!-- Notes -->
        <textarea name="notes" class="form-control bg-white mb-4 rounded-4 p-3" rows="3"
            placeholder="Additional notes for the order"></textarea>

        <!-- Order Details -->
        <div class="card border-0 shadow-sm p-3 rounded-4 mb-4">
            <h6 class="fw-bold mb-3 text-end">Order details</h6>
            <div class="d-flex justify-content-between mb-2">
                <span class="fw-bold">₪ <span class="cart-subtotal">0.00</span></span>
                <span class="text-muted">Subtotal</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-bold">₪ 19.00</span>
                <span class="text-muted">Delivery cost</span>
            </div>

            <hr class="my-2">

            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold text-primary mb-0">₪ <span id="checkout-total">0.00</span></h4>
                <span class="fw-bold fs-5 text-primary">Total</span>
            </div>
        </div>

        <!-- Payment Method -->
        <h6 class="fw-bold mb-3 text-end">payment method</h6>
        <div class="row g-2 mb-4">
            <div class="col-6">
                <div class="payment-option d-flex align-items-center justify-content-center gap-2"
                    onclick="selectPayment('card')">
                    <i class="fab fa-cc-mastercard text-danger fs-4"></i>
                    <i class="fab fa-cc-visa text-primary fs-4"></i>
                    <span class="small text-muted">Card payment</span>
                </div>
            </div>
            <div class="col-6">
                <div class="payment-option active d-flex align-items-center justify-content-center"
                    onclick="selectPayment('cash')">
                    <span class="small fw-bold text-primary">Cash on delivery</span>
                </div>
            </div>
        </div>
        <input type="hidden" name="payment_method" id="paymentInput" value="cash">

        <!-- Payment Info -->
        <div id="payment-info" class="bg-light p-3 rounded-3 text-end text-muted small mb-5">
            Cash on delivery
        </div>
    </form>
</div>

<!-- Sticky Submit Button -->
<div class="sticky-action-bar">
    <button type="button" class="btn btn-primary w-100 py-3 rounded-3 fw-bold fs-5"
        onclick="$('#checkoutForm').submit()">Submit the request</button>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#sticky-cart').hide();
        if (cart.length === 0) window.location.href = "{{ route('home') }}";

        updateCheckoutUI();
        $('#cartData').val(JSON.stringify(cart));

        // Set initial state: delivery is pre-selected, so show delivery fields
        document.getElementById('delivery-fields').style.display = 'block';
    });

    function updateCheckoutUI() {
        let total = 0;
        cart.forEach(item => total += item.price * item.qty);

        $('.cart-subtotal').text(total.toFixed(2));
        $('.cart-total').text(total.toFixed(2)); // Placeholder for discount logic

        // Assuming fixed delivery of 19 for ref match, or keep existing logic
        let delivery = 19.00;
        $('#checkout-total').text((total + delivery).toFixed(2));
    }

    function selectDeliveryType(type, el) {
        document.querySelectorAll('.checkout-toggle-item').forEach(item => item.classList.remove('active'));
        el.classList.add('active');
        el.querySelector('input[type=radio]').checked = true;

        // Show/hide delivery-only fields
        const deliveryFields = document.getElementById('delivery-fields');
        if (type === 'delivery') {
            deliveryFields.style.display = 'block';
        } else {
            deliveryFields.style.display = 'none';
        }
    }

    function selectPayment(type) {
        $('.payment-option').removeClass('active');
        if (type === 'cash') {
            $('.payment-option').eq(1).addClass('active');
            document.getElementById('payment-info').textContent = 'Cash on delivery';
        } else {
            $('.payment-option').eq(0).addClass('active');
            document.getElementById('payment-info').textContent = 'Pay safely';
        }
        $('#paymentInput').val(type);
    }
</script>
@endsection