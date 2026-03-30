<div class="cart-total" id="orderTotal">
  <div class="shop-title-box">
    <h3>{{ $keywords['Order_Total'] ?? __('Order Total') }}</h3>
  </div>

  <div id="cartTotal">
    @php
      $dataTax = tax();
      $dataTax = json_decode($dataTax, true);
      $subtoal = cartTotal() - $discount;
    @endphp

    <ul class="cart-total-table">
      <li>
        <span class="col-title">{{ $keywords['Cart_Total'] ?? __('Cart Total') }}</span>
        <span>

          {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
          <span data="{{ cartTotal() }}" class="subtotal">{{ cartTotal() }}</span>
          {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}

        </span>
      </li>
      <li>
        <span class="col-title">{{ $keywords['Discount'] ?? __('Discount') }}</span>
        <span>
          <i class="fas fa-minus"></i>
          {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
          <span data="{{ $discount }}">{{ $discount }}</span>
          {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}

        </span>

      </li>
      <li>
        <span class="col-title">{{ $keywords['Cart_Subtotal'] ?? __('Cart Subtotal') }}</span>
        <span>

          {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
          <span data="{{ cartTotal() - $discount }}" class="subtotal" id="subtotal">{{ $subtoal }}</span>
          {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}


        </span>
      </li>
      <li>

        <span class="col-title">{{ $keywords['Tax'] ?? __('Tax') }}</span>
        <span>
          <i class="fas fa-plus"></i>
          {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
          <span data-tax="{{ $dataTax['tax'] }}" id="tax">{{ $dataTax['tax'] }}</span>
          {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}

        </span>
      </li>
      <li>
        <span class="col-title">{{ $keywords['Shipping_Charge'] ?? __('Shipping Charge') }}</span>
        <span>
          <i class="fas fa-plus"></i>
          {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
          <span data="0" class="shipping">0</span>
          {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
        </span>
      </li>
      <li>
        <span class="col-title">{{ $keywords['Total'] ?? __('Total') }}</span>
        <span>
          {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
          <span data="" class="grandTotal">
          </span>

          {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
        </span>
      </li>
    </ul>
  </div>
  @if (!empty($packagePermissions) && in_array('Coupon', $packagePermissions))
    <div class="coupon">
      <h4 class="mb-3">{{ $keywords['Coupon'] ?? __('Coupon') }}</h4>
      <div class="form-group d-flex">
        <input type="text" class="form-control" name="coupon" value="">
        <button class="btn btn-primary base-btn" type="button"
          onclick="applyCoupon();">{{ $keywords['Apply'] ?? __('Apply') }}</button>
      </div>
    </div>
  @endif

  <div class="payment-options">
    <h4 class="mb-4">{{ $keywords['Pay_Via'] ?? __('Pay Via') }}</h4>
    @includeIf('user-front.product.payment-gateways')
    @error('gateway')
      <p class="text-danger mb-0">{{ convertUtf8($message) }}</p>
    @enderror
    <div class="placeorder-button mt-4">
      <button class="main-btn w-100" type="button" form="payment" id="placeOrderBtn">
        <span class="btn-title">
          {{ $keywords['Place_Order'] ?? __('Place Order') }}
        </span>
      </button>
    </div>
  </div>

</div>
