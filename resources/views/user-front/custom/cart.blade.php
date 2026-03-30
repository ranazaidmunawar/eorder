@extends('layouts.master')
@section('title', 'Shopping cart')

@section('content')
<div class="container py-3 cart-page-container" style="padding-bottom: 130px;">
    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <h4 class="fw-bold mb-0 mx-auto">Shopping cart</h4>
        <a href="{{ route('home') }}" class="btn btn-sm btn-light rounded-circle position-absolute end-0 me-3"
            style="width: 32px; height: 32px;"><i class="fas fa-times"></i></a>
    </div>

    <!-- Coupon Banner -->
    <div class="coupon-banner p-3 mb-4 d-flex align-items-center justify-content-center gap-2 cursor-pointer" onclick="openCouponModal()">
        <i class="fas fa-ticket-alt"></i>
        <span>Use the discount coupon </span>
    </div>

    <!-- Cart List -->
    <div id="cart-list" class="mb-4">
        <!-- JS will populate this -->
    </div>
</div>

<!-- Coupon Modal -->
<div id="coupon-overlay" class="coupon-overlay" onclick="closeCouponModal(event)">
    <div class="coupon-popup">
        <button class="coupon-close" onclick="closeCouponModal()"><i class="fas fa-times"></i></button>
        <div class="text-center mb-3">
            <img src="https://armani.nemo.ps/wp-content/themes/noqta-menu-theme/assets/svgs/coupon.gif" style="max-width: 180px;">
        </div>
        <p class="text-center fw-bold mb-3" style="font-size:1.1rem;">Enter the code </p>
        <form onsubmit="applyCoupon(event)">
            <input type="text" id="coupon-input" class="coupon-input" placeholder="Coupon code " autocomplete="off">
            <button type="submit" class="coupon-apply-btn">Apply discount </button>
        </form>
        <div id="coupon-msg" class="mt-3 text-center fw-bold" style="display:none;"></div>
    </div>
</div>

<!-- Sticky Bottom Action -->
<div class="sticky-action-bar">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="fs-5 fw-bold text-dark" id="cart-total-display">0.00</span>
        <span class="text-muted small">:Total</span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('home') }}" class="btn btn-outline-primary flex-grow-1 py-3 rounded-pill fw-bold"
            style="border-width: 2px;">Add another product</a>
        <a href="{{ route('checkout') }}" class="btn btn-primary flex-grow-1 py-3 rounded-pill fw-bold">The next</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#sticky-cart').hide(); // Hide global sticky cart
        renderCartPage();
    });

    function openCouponModal() {
        document.getElementById('coupon-overlay').classList.add('active');
        document.getElementById('coupon-input').focus();
    }

    function closeCouponModal(event) {
        if (!event || event.target === document.getElementById('coupon-overlay') || !event.target.closest) {
            document.getElementById('coupon-overlay').classList.remove('active');
            document.getElementById('coupon-msg').style.display = 'none';
        }
    }

    function applyCoupon(e) {
        e.preventDefault();
        const code = document.getElementById('coupon-input').value.trim();
        const msg = document.getElementById('coupon-msg');
        msg.style.display = 'block';
        if (!code) {
            msg.style.color = '#ef4444';
            msg.textContent = 'Please enter a coupon code.';
            return;
        }
        // Placeholder: always show invalid for now
        msg.style.color = '#ef4444';
        msg.textContent = 'Invalid coupon code.';
    }


    function renderCartPage() {
        const cartList = $('#cart-list');
        cartList.empty();

        if (cart.length === 0) {
            cartList.html('<div class="text-center text-muted py-5"><i class="fas fa-shopping-basket fa-3x mb-3 text-secondary opacity-25"></i><p>Your cart is empty</p></div>');
            $('#cart-total-display').text('0.00');
            return;
        }

        let total = 0;
        cart.forEach((item, index) => {
            total += item.price * item.qty;
            cartList.append(`
                <div class="cart-item-card mb-3 d-flex align-items-center gap-3 p-3">
                    <div class="d-flex align-items-center gap-3 flex-shrink-0">
                         <!-- Delete Icon -->
                         <button class="btn btn-link text-muted p-0" onclick="removeCartItem(${index})">
                            <i class="far fa-trash-alt"></i> delete
                        </button>
                        
                        <!-- Quantity Stepper -->
                        <div class="qty-stepper">
                            <button class="qty-btn" onclick="updateCartItem(${index}, 1)"><i class="fas fa-plus"></i></button>
                            <input type="text" class="qty-input" value="${item.qty}" readonly>
                            <button class="qty-btn" onclick="updateCartItem(${index}, -1)"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="text-end flex-grow-1">
                        <h6 class="fw-bold mb-1">${item.name}</h6>
                        <small class="text-muted d-block mb-1">:Additions</small>
                        <span class="fw-bold text-primary">${parseFloat(item.price).toFixed(2)} ₪</span>
                    </div>

                    <div class="cart-item-img-wrap flex-shrink-0">
                        <img src="${item.image || ''}" class="cart-item-img" alt="${item.name}" onerror="this.parentElement.style.background='#f3f4f6'">
                    </div>
                </div>
            `);
        });

        // Currency symbol assumption from reference, adjusted to default if needed or strictly follow ref.
        // Ref shows '₪'.
        $('#cart-total-display').text('₪ ' + total.toFixed(2));
    }

    function updateCartItem(index, change) {
        cart[index].qty += change;
        if (cart[index].qty < 1) cart[index].qty = 1;
        saveCart();
        renderCartPage();
    }

    function removeCartItem(index) {
        cart.splice(index, 1);
        saveCart();
        renderCartPage();
    }
</script>
@endsection