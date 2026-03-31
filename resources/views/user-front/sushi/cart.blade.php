@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
@endphp

@extends('user-front.layout')

@section('pageHeading')
    {{ $keywords['Cart'] ?? __('Cart') }}
@endsection

@section('style')
    @includeIf('user-front.sushi.include.sushi_css')
    <style>
        :root {
            --sushi-primary: #0f5156;
            --sushi-bg: #f4f7f6;
        }
        .toast-message {
    background: #0f5156 !important;
}

        body { background-color: var(--sushi-bg); }

        .cart-page-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .coupon-banner {
            background: #e6f2f1;
            border: 1px dashed var(--sushi-primary);
            border-radius: 12px;
            color: var(--sushi-primary);
            font-weight: 600;
            transition: all 0.2s;
        }
        .coupon-banner:hover { background: #d7ecea; }

        .cart-item-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }

        .cart-item-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 12px;
        }

        .qty-stepper {
            display: flex;
            align-items: center;
            background: #f0f2f5;
            border-radius: 10px;
            padding: 2px;
        }
        .qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            border: none;
            background: white;
            color: var(--sushi-primary);
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .qty-input {
            width: 30px;
            border: none;
            background: transparent;
            text-align: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .sticky-action-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: white;
            padding: 20px;
            border-top-left-radius: 25px;
            border-top-right-radius: 25px;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1);
            z-index: 1050;
        }

        .btn-primary { background-color: var(--sushi-primary); border-color: var(--sushi-primary); }
        .btn-outline-primary { color: var(--sushi-primary); border-color: var(--sushi-primary); }
        .btn-outline-primary:hover { background-color: var(--sushi-primary); color: white; }

        /* Coupon Modal */
        .coupon-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }
        .coupon-overlay.active { display: flex; }
        .coupon-popup {
            background: white;
            width: 90%;
            max-width: 400px;
            padding: 30px;
            border-radius: 20px;
            position: relative;
            animation: slideUp 0.3s ease-out;
        }
        @keyframes slideUp { from { transform: translateY(50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        
        .coupon-close { position: absolute; top: 15px; right: 15px; border: none; background: none; font-size: 1.2rem; color: #999; }
        .coupon-input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; margin-bottom: 15px; text-align: center; }
        .coupon-apply-btn { width: 100%; padding: 12px; background: var(--sushi-primary); color: white; border: none; border-radius: 10px; font-weight: 700; }

        .text-primary { color: var(--sushi-primary) !important; }
    </style>
@endsection

@section('content')
<div class="container py-3 cart-page-container" style="padding-bottom: 150px;">
    <!-- Header -->
    <div class="d-flex align-items-center mb-4 position-relative">
        <h4 class="fw-bold mb-0 mx-auto">{{ __('Shopping cart') }}</h4>
        <a href="{{ route('user.front.index', getParam()) }}" class="btn btn-sm btn-light rounded-circle position-absolute end-0"
            style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-times"></i>
        </a>
    </div>

    <!-- Coupon Banner -->
    <div class="coupon-banner p-3 mb-4 d-flex align-items-center justify-content-center gap-2 cursor-pointer" onclick="openCouponModal()">
        <i class="fas fa-ticket-alt"></i>
        <span>{{ __('Use the discount coupon') }}</span>
    </div>

    <!-- Cart List -->
    <div id="cart-list" class="mb-4">
        @php $totalPrice = 0; @endphp
        @if ($cart != null && count($cart) > 0)
            @foreach ($cart as $key => $item)
                @php $totalPrice += (float)$item['total']; @endphp
                <div class="cart-item-card mb-3 d-flex align-items-center gap-3 p-3">
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                         <!-- Delete Icon -->
                         <button class="btn btn-link text-muted p-0 text-decoration-none small" onclick="removeCartItem('{{ $key }}')">
                            <i class="far fa-trash-alt"></i> {{ __('delete') }}
                        </button>
                        
                        <!-- Quantity Stepper -->
                        <div class="qty-stepper">
                            <button class="qty-btn" onclick="updateCartQty('{{ $key }}', 1)"><i class="fas fa-plus"></i></button>
                            <input type="text" class="qty-input" value="{{ $item['qty'] }}" readonly>
                            <button class="qty-btn" onclick="updateCartQty('{{ $key }}', -1)"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="text-end flex-grow-1 pe-2">
                        <h6 class="fw-bold mb-1">{{ $item['name'] }}</h6>
                        @if(!empty($item['variations']) || !empty($item['addons']))
                            <small class="text-muted d-block mb-1">:{{ __('Additions') }}</small>
                            <div class="small text-muted mb-1">
                                @if(!empty($item['variations']))
                                    @foreach ($item['variations'] as $vKey => $variation)
                                        <span>{{ str_replace('_', ' ', $vKey) }}: {{ $variation['name'] }}</span>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                        <span class="fw-bold text-primary">{{ number_format($item['total'], 2) }} {{ $userBe->base_currency_symbol }}</span>
                    </div>

                    <div class="flex-shrink-0">
                        <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $item['photo'], $userBs) }}" 
                             class="cart-item-img" alt="{{ $item['name'] }}" onerror="this.src='{{ asset('assets/front/img/default.png') }}'">
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center text-muted py-5 mt-5">
                <i class="fas fa-shopping-basket fa-3x mb-3 text-secondary opacity-25"></i>
                <p class="fs-5">{{ __('Your cart is empty') }}</p>
            </div>
        @endif
    </div>
</div>

<!-- Coupon Modal -->
<div id="coupon-overlay" class="coupon-overlay" onclick="closeCouponModal(event)">
    <div class="coupon-popup" onclick="event.stopPropagation()">
        <button class="coupon-close" onclick="closeCouponModal()"><i class="fas fa-times"></i></button>
        <div class="text-center mb-3">
            <img src="https://armani.nemo.ps/wp-content/themes/noqta-menu-theme/assets/svgs/coupon.gif" style="max-width: 150px;">
        </div>
        <p class="text-center fw-bold mb-3" style="font-size:1.1rem;">{{ __('Enter the code') }}</p>
        <form onsubmit="applyCoupon(event)">
            <input type="text" id="coupon-input" class="coupon-input" placeholder="{{ __('Coupon code') }}" autocomplete="off">
            <button type="submit" class="coupon-apply-btn">{{ __('Apply discount') }}</button>
        </form>
        <div id="coupon-msg" class="mt-3 text-center fw-bold" style="display:none;"></div>
    </div>
</div>

<!-- Sticky Bottom Action -->
<div class="sticky-action-bar">
    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
        <span class="fs-4 fw-bold text-primary" id="cart-total-display">
            {{ $userBe->base_currency_symbol }} {{ number_format($totalPrice, 2) }}
        </span>
        <span class="text-muted fw-bold">:{{ __('Total') }}</span>
    </div>
    <div class="d-flex gap-3">
        <a href="{{ route('user.front.index', getParam()) }}" class="btn btn-outline-primary flex-grow-1 py-3 rounded-pill fw-bold"
            style="border-width: 2px;">{{ __('Add another product') }}</a>
        <a href="{{ route('user.product.front.checkout', getParam()) }}" class="btn btn-primary flex-grow-1 py-3 rounded-pill fw-bold">
            {{ __('The next') }}
        </a>
    </div>
</div>
@endsection

@section('script')
    @includeIf('user-front.sushi.include.sushi_js')
    <script>
        function openCouponModal() {
            document.getElementById('coupon-overlay').classList.add('active');
            document.getElementById('coupon-input').focus();
        }

        function closeCouponModal() {
            document.getElementById('coupon-overlay').classList.remove('active');
            document.getElementById('coupon-msg').style.display = 'none';
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
            msg.style.color = '#ef4444';
            msg.textContent = 'Invalid coupon code.';
        }

        function updateCartQty(key, delta) {
            let url = delta > 0 
                ? "{{ route('user.front.cart.item.add.quantity', [getParam(), ':key']) }}" 
                : "{{ route('user.front.cart.item.less.quantity', [getParam(), ':key']) }}";
            
            url = url.replace(':key', key);

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if(data.message) {
                        location.reload();
                    } else if(data.error) {
                        toastr.error(data.error);
                    }
                });
        }

        function removeCartItem(key) {
            if(confirm('{{ __("Are you sure you want to remove this item?") }}')) {
                let url = "{{ route('user.front.cart.item.remove', [getParam(), ':key']) }}".replace(':key', key);
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        if(data.message) {
                            toastr.success(data.message);
                            location.reload();
                        }
                    });
            }
        }
    </script>
@endsection