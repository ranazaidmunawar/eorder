@php
 use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;
    use App\Models\User\ProductReview;

@endphp



<!-- Categories -->
<nav class="category-scroller sticky-top bg-white py-3 shadow-sm" style="top: 0; z-index: 1020;">
    <a href="#" class="category-pill active" data-filter="all">
        <i class="fas fa-th-large"></i> All
    </a>
  @foreach ($categories as $keys => $category)
    <a href="#cat-{{ $category->id }}" class="category-pill" data-filter=".cat-{{ $category->id }}">
        <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $category->image, $userBs) }}" alt="{{ convertUtf8($category->name) }}"> {{ convertUtf8($category->name) }}
    </a>
    @endforeach
</nav>

<!-- Products -->
<div class="row mt-3 mx-1">
    @foreach($categories as $category)
    <div id="cat-{{ $category->id }}" class="col-12 mb-2 cat-section cat-{{ $category->id }}">
        <h5 class="fw-bold mb-3 px-2 border-start border-4 border-primary ps-2">{{ $category->name }}</h5>
        <div class="row">
            @foreach($category->products as $productInfo)
            @php
                $product = $productInfo->product;
            @endphp
            @if(!empty($product) && $product->status == 1)
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="product-card" onclick="openProductModal({{ $productInfo->toJson() }})">
                    <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}" class="product-image" alt="{{ $productInfo->title }}">
                    <div class="product-details">
                        <h6 class="product-title">{{ $productInfo->title }}</h6>
                        <p class="product-desc">{{ $productInfo->summary ?? $productInfo->description }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="product-price">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ number_format($product->current_price, 2) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</span>
                            <button class="add-btn shadow-sm">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>


<!-- Product Details Modal (Bottom Sheet Style) -->
<div class="modal fade bottom-sheet" id="productModal" tabindex="-1" aria-hidden="true"
    style="padding-left: 0 !important;">
    <div class="modal-dialog">
        <div class="modal-content overflow-hidden border-0 bg-white">

            <!-- Hero Image Section -->
            <div class="modal-product-hero">
                <button type="button" class="modal-close-btn" data-dismiss="modal" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
                <button type="button" class="modal-fav-btn">
                    <i class="far fa-heart"></i>
                </button>
                <img id="modalImg" src="" class="modal-product-img" alt="Product Image">
                <div
                    class="position-absolute bottom-0 start-0 w-100 h-25 bg-gradient-to-t from-black to-transparent opacity-50">
                </div>
                <!-- Optional: Line indicator for swipe (visual only) -->
                <div class="position-absolute top-0 start-50 translate-middle-x mt-2"
                    style="width: 40px; height: 4px; background: rgba(255,255,255,0.5); border-radius: 2px;"></div>
            </div>

            <div class="modal-additions-section">
                <!-- Title & Desc -->
                <div class="mb-4">
                    <h4 id="modalTitle" class="fw-bold mb-2 fs-4 text-end"></h4>
                    <p id="modalDesc" class="text-muted small text-end"></p>
                </div>

                <hr class="opacity-10 my-3">

                <!-- Additions -->
                <div class="mb-5 text-end">
                    <h6 class="fw-bold mb-3">Additions</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2">
                        <span class="addition-pill">( ₪ 4.00+ ) Kibbeh</span>
                        <span class="addition-pill">( ₪ 4.00+ ) cheese</span>
                        <span class="addition-pill">( ₪ 4.00+ ) Zinger</span>
                        <span class="addition-pill">( ₪ 2.00+ ) Onion rings</span>
                    </div>
                </div>
            </div>

            <!-- Sticky Footer for Modal -->
            <div class="modal-sticky-footer">
                <button class="modal-add-btn shadow-sm" onclick="addToCart()">
                    <span id="modalTotalBtn" class="fs-6">24.00</span>
                    <span>Add to cart</span>
                </button>

                <div class="modal-qty-control shadow-sm">
                    <button class="modal-qty-btn" onclick="updateQty(1)"><i class="fas fa-plus"></i></button>
                    <input type="text" id="qtyInput" class="modal-qty-val" value="1" readonly>
                    <button class="modal-qty-btn" onclick="updateQty(-1)"><i class="fas fa-minus"></i></button>
                </div>
            </div>

        </div>
    </div>
</div>



   <!-- Product-area start -->
   <section class="product-area product-2 pt-100 pb-75">
       <div class="container">
           <div class="row">
               <div class="col-12">
                   <div class="tab-content" data-aos="fade-up">
                       <!-- @foreach ($categories as $keys => $category)
                           <div class="tab-pane slide {{ $keys == 0 ? 'show active' : '' }}" id="{{ $category->slug }}">
                               <div class="tabs-navigation text-center mb-50">
                                   <ul class="nav nav-tabs" data-hover="fancyHover">
                                       @foreach ($category->subcategories()->where('is_feature', 1)->get() as $subkeys => $subcat)
                                           <li class="nav-item {{ $subkeys == 0 ? 'active' : '' }}">
                                               <button
                                                   class="nav-link hover-effect {{ $subkeys == 0 ? 'active' : '' }} btn-md rounded-pill"
                                                   data-bs-toggle="tab" data-bs-target="#sub_{{ $subcat->id }}"
                                                   type="button">{{ convertUtf8($subcat->name) }}
                                               </button>
                                           </li>
                                       @endforeach

                                   </ul>
                               </div>
                               <div class="tab-content">
                                   @foreach ($category->subcategories()->where('is_feature', 1)->get() as $subkeys => $subcat)
                                       <div class="tab-pane slide {{ $subkeys == 0 ? 'show active' : '' }}"
                                           id="sub_{{ $subcat->id }}">
                                           <div class="row">
                                               @php
                                                   $featureActiveProducts = Product::query()
                                                       ->join('product_informations', 'product_informations.product_id', 'products.id')
                                                       ->where('product_informations.category_id', $category->id)
                                                       ->where('product_informations.subcategory_id', $subcat->id)
                                                       ->where('products.is_feature', 1)
                                                       ->where('products.user_id', $user->id)
                                                       ->where('products.status', 1)
                                                       ->get();
                                               @endphp

                                               @foreach ($featureActiveProducts as $product)
                                                   <div class="col-md-6 col-lg-4 col-xl-3 item">
                                                       <div class="product radius-md text-center p-30 mb-25">
                                                           <figure class="product-img mb-20 mx-auto">
                                                               <a href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"
                                                                   target="_self"
                                                                   title="{{ convertUtf8($product->title) }}"
                                                                   class="lazy-container ratio ratio-1-1 bg-none">
                                                                   <img class="lazyload"
                                                                       data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}"
                                                                       alt="Image">
                                                               </a>
                                                               <div class="hover-show">
                                                                @if (in_array('Online Order', $packagePermissions))
                                                                   <a href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"
                                                                       class="cart-link btn btn-md btn-outline rounded-pill"
                                                                       title="{{ $keywords['Add to Cart'] ??  __('Add to Cart') }}" target="_self"
                                                                       data-product="{{ $product }}"
                                                                       data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Add to Cart'] ??  __('Add to Cart')  }}</a>
                                                                       @else
                                                                       @if (!empty(json_decode($product->addons, true)) || !empty(json_decode($product->variations, true)))
                                                                        <a href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"
                                                                       class="cart-link btn btn-md btn-outline rounded-pill"
                                                                       title="{{ $keywords['Extras'] ??  __('Extras') }}" target="_self"
                                                                       data-product="{{ $product }}"
                                                                       data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Extras'] ??  __('Extras')  }}</a>
                                                                       @endif
                                                                       @endif
                                                               </div>
                                                           </figure>
                                                           <div class="product-details">
                                                               <h4 class="product-title lc-1 mb-1"><a
                                                                       href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"
                                                                       target="_self"
                                                                       title="{{ convertUtf8($product->title) }}">{{ convertUtf8($product->title) }}</a>
                                                               </h4>
                                                               <div class="ratings justify-content-center mb-10">
                                                                   <div class="rate">
                                                                       <div class="rating-icon"
                                                                           style="width:{{ $product->rating ? $product->rating * 20 : 0 }}% !important">
                                                                       </div>
                                                                   </div>
                                                                   <span
                                                                       class="ratings-total">({{ $product->rating }})</span>
                                                               </div>
                                                               <div class="product-price">
                                                                   <span class="h6 font-lg new-price color-primary"
                                                                       dir="ltr">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</span>
                                                                   @if ($product->previous_price)
                                                                       <span class="prev-price font-sm" dir="ltr">
                                                                           {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</span>
                                                                   @endif
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                               @endforeach

                                           </div>
                                       </div>
                                   @endforeach
                               </div>
                               <div class="cta-btn text-center mt-15 mb-25">
                                   <a href="{{ route('user.front.items', [getParam(), 'category_id' => $category->id]) }}"
                                       class="btn btn-lg btn-primary rounded-pill" title="{{ $keywords['View All Items'] ??  __('View All Items') }}"
                                       target="_self">{{ $keywords['View All Items'] ??  __('View All Items') }}</a>
                               </div>
                           </div>
                       @endforeach -->
                   </div>
               </div>
           </div>
       </div>
   </section>
   <!-- Product-area end -->

<script>
    let currentProductBasePrice = 0;
    let selectedAddonsTotal = 0;
    let currentQty = 1;
    let currencySymbol = "{{ $userBe->base_currency_symbol }}";
    let currencyPos = "{{ $userBe->base_currency_symbol_position }}";

    function openProductModal(product) {
        console.log("Opening Modal for:", product);
        
        // Handle stringified JSON if needed
        if (typeof product === 'string') {
            product = JSON.parse(product);
        }

        // Get main product data (since we joined in the model or access via relation)
        const baseProduct = product.product || product; 
        
        currentProductBasePrice = parseFloat(baseProduct.current_price || 0);
        selectedAddonsTotal = 0;
        currentQty = 1;

        // Update UI
        document.getElementById('modalTitle').innerText = product.title || product.name;
        document.getElementById('modalDesc').innerText = product.summary || product.description || '';
        
        // Set Image URL
        const imgUrl = "{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, ':img', $userBs) }}".replace(':img', baseProduct.feature_image);
        document.getElementById('modalImg').src = imgUrl;

        // Reset Qty
        document.getElementById('qtyInput').value = currentQty;

        // Reset Fav Heart
        const favIcon = document.querySelector('.modal-fav-btn i');
        favIcon.className = 'far fa-heart';
        favIcon.classList.remove('text-danger');

        // Render Additions (Addons)
        const additionsContainer = document.querySelector('.modal-additions-section .d-flex');
        additionsContainer.innerHTML = '';
        
        if (baseProduct.addons) {
            try {
                const addons = JSON.parse(baseProduct.addons);
                for (const [name, price] of Object.entries(addons)) {
                    const pill = document.createElement('span');
                    pill.className = 'addition-pill';
                    pill.innerHTML = `( ${currencyPos == 'left' ? currencySymbol : ''}${price}${currencyPos == 'right' ? currencySymbol : ''}+ ) ${name}`;
                    pill.onclick = function() {
                        this.classList.toggle('active');
                        if (this.classList.contains('active')) {
                            selectedAddonsTotal += parseFloat(price);
                        } else {
                            selectedAddonsTotal -= parseFloat(price);
                        }
                        calculateTotal();
                    };
                    additionsContainer.appendChild(pill);
                }
            } catch (e) {
                console.error("Error parsing addons:", e);
            }
        }

        calculateTotal();

        // Show Modal
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            var myModal = new bootstrap.Modal(document.getElementById('productModal'));
            myModal.show();
        } else {
            // Fallback for jQuery / Bootstrap 4
            $('#productModal').modal('show');
        }
    }

    // Manual Close Fix
    document.querySelector('.modal-close-btn').addEventListener('click', function() {
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            var modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
            if (modal) modal.hide();
        }
        $('#productModal').modal('hide');
    });

    // Favorite Toggle Logic
    document.querySelector('.modal-fav-btn').addEventListener('click', function() {
        const icon = this.querySelector('i');
        icon.classList.toggle('far');
        icon.classList.toggle('fas');
        icon.classList.toggle('text-danger');
        
        if (icon.classList.contains('fas')) {
            toastr["success"]("Added to favorites!");
        }
    });

    function updateQty(delta) {
        currentQty += delta;
        if (currentQty < 1) currentQty = 1;
        document.getElementById('qtyInput').value = currentQty;
        calculateTotal();
    }

    function calculateTotal() {
        const total = (currentProductBasePrice + selectedAddonsTotal) * currentQty;
        const formattedTotal = (currencyPos == 'left' ? currencySymbol : '') + total.toFixed(2) + (currencyPos == 'right' ? currencySymbol : '');
        document.getElementById('modalTotalBtn').innerText = formattedTotal;
    }

    function addToCart() {
        // Logic to send data to backend or cart logic
        toastr["success"]("Added to cart!");
        var myModalEl = document.getElementById('productModal');
        var modal = bootstrap.Modal.getInstance(myModalEl);
        modal.hide();
    }
</script>
