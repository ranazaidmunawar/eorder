@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp

@php
    $cart = session()->get(getUser()->username . '_cart');
    $cartCount = 0;
    if($cart) {
        foreach($cart as $item) {
            $cartCount += $item['qty'];
        }
    }
    $total = cartTotal();
@endphp

@if($cartCount > 0 && !request()->routeIs('user.product.front.checkout') && !request()->routeIs('user.front.product.checkout'))
<a href="{{ route('user.front.cart', getParam()) }}" id="sticky-cart" class="bottom-cart-bar decoration-none">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div class="d-flex flex-column text-start">
            <span class="view-cart-text">View Cart</span>
            <span class="cart-total-price">
                @if($userBe->base_currency_symbol_position == 'left')
                    {{ $userBe->base_currency_symbol }} <span class="cart-total">{{ number_format($total, 2) }}</span>
                @else
                    <span class="cart-total">{{ number_format($total, 2) }}</span> {{ $userBe->base_currency_symbol }}
                @endif
            </span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="cart-icon-container position-relative">
                <span class="cart-badge-count cart-count">{{ $cartCount }}</span>
                <i class="fas fa-shopping-basket fa-lg"></i>
            </div>
            <i class="fas fa-chevron-right text-white opacity-50"></i>
        </div>
    </div>
</a>
@endif


