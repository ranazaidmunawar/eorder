     @if ($activeTheme == 'seabbq')
         <a data-product="{{ $product }}" href="javascript:void(0)"
             data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}"
             class="add-to-cart cart-link">
             <i class="far fa-shopping-bag"></i>
             {{ $keywords['Add_to_Cart'] ?? 'Add to Cart' }}
         </a>
     @elseif ($activeTheme == 'desifoodie' || $activeTheme == 'desices')
         <a data-product="{{ $product }}" href="javascript:void(0)"
             data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}"
             class="add-to-cart cart-link">
             <span><i class="far fa-shopping-bag"></i> {{ $keywords['Add_to_Cart'] ?? 'Add to Cart' }}</span>
             <span><i class="far fa-shopping-bag"></i> {{ $keywords['Add_to_Cart'] ?? 'Add to Cart' }}</span>
         </a>
     @else
         <a data-product="{{ $product }}"
             data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}"
             class="add-to-cart cart-link"><i class="far fa-shopping-bag"></i>
             {{ $keywords['Add_to_Cart'] ?? 'Add to Cart' }}</a>
     @endif
