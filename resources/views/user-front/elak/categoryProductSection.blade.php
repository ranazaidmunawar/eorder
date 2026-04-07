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

                <!-- Variations (Dynamic) -->
                <div id="variationsContainer" class="mb-4 text-end">
                    <!-- Dynamic Variations will be injected here -->
                </div>

                <!-- Additions (Addons) -->
                <div id="addonsContainer" class="mb-5 text-end">
                    <h6 class="fw-bold mb-3">{{ $keywords['Addons'] ?? __('Addons') }}</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2">
                        <!-- Dynamic Addons will be injected here -->
                    </div>
                </div>
            </div>

            <!-- Sticky Footer for Modal -->
            <div class="modal-sticky-footer">
                <button id="elakAddToCartBtn" class="modal-add-btn shadow-sm" onclick="elakAddToCart()">
                    <span id="modalTotalBtn" class="fs-6">0.00</span>
                    <span id="addToCartText">{{ $keywords['Add to Cart'] ?? __('Add to Cart') }}</span>
                </button>

                <div class="modal-qty-control shadow-sm">
                    <button class="modal-qty-btn" onclick="elakUpdateQty(1)"><i class="fas fa-plus"></i></button>
                    <input type="text" id="qtyInput" class="modal-qty-val" value="1" readonly>
                    <button class="modal-qty-btn" onclick="elakUpdateQty(-1)"><i class="fas fa-minus"></i></button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    let currentProduct = null;
    let currentProductBasePrice = 0;
    let selectedAddonsTotal = 0;
    let selectedVariationsTotal = 0;
    let currentQty = 1;
    let selectedVariations = {};
    let selectedAddons = [];
    let currencySymbol = "{{ $userBe->base_currency_symbol }}";
    let currencyPos = "{{ $userBe->base_currency_symbol_position }}";

    function openProductModal(product) {
        if (typeof product === 'string') {
            product = JSON.parse(product);
        }
        currentProduct = product.product || product; 
        
        currentProductBasePrice = parseFloat(currentProduct.current_price || 0);
        selectedAddonsTotal = 0;
        selectedVariationsTotal = 0;
        currentQty = 1;
        selectedVariations = {};
        selectedAddons = [];

        // Update UI
        document.getElementById('modalTitle').innerText = product.title || product.name;
        document.getElementById('modalDesc').innerText = product.summary || product.description || '';
        
        const imgUrl = "{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, ':img', $userBs) }}".replace(':img', currentProduct.feature_image);
        document.getElementById('modalImg').src = imgUrl;
        document.getElementById('qtyInput').value = currentQty;

        // Render Variations
        const varContainer = document.getElementById('variationsContainer');
        varContainer.innerHTML = '';
        if (currentProduct.variations) {
            try {
                const variations = JSON.parse(currentProduct.variations);
                for (const [vName, vOptions] of Object.entries(variations)) {
                    const section = document.createElement('div');
                    section.className = 'mb-3';
                    section.innerHTML = `<h6 class="fw-bold mb-2">${vName.replace(/_/g, ' ')}</h6>`;
                    
                    const optionsDiv = document.createElement('div');
                    optionsDiv.className = 'd-flex flex-wrap justify-content-end gap-2';
                    
                    vOptions.forEach(opt => {
                        const pill = document.createElement('span');
                        pill.className = 'addition-pill';
                        pill.innerHTML = `${opt.name} (${currencyPos == 'left' ? currencySymbol : ''}${opt.price}${currencyPos == 'right' ? currencySymbol : ''})`;
                        pill.onclick = function() {
                            // Clear previous selection for this variation
                            optionsDiv.querySelectorAll('.addition-pill').forEach(p => p.classList.remove('active'));
                            this.classList.add('active');
                            
                            selectedVariations[vName] = { name: opt.name, price: opt.price };
                            elakCalculateVariationTotal();
                        };
                        optionsDiv.appendChild(pill);
                    });
                    section.appendChild(optionsDiv);
                    varContainer.appendChild(section);
                }
            } catch (e) { console.error("Variations error:", e); }
        }

        // Render Addons
        const additionsContainer = document.querySelector('#addonsContainer .d-flex');
        additionsContainer.innerHTML = '';
        if (currentProduct.addons) {
            try {
                const addons = JSON.parse(currentProduct.addons);
                addons.forEach(addon => {
                    const pill = document.createElement('span');
                    pill.className = 'addition-pill';
                    pill.innerHTML = `${addon.name} (+${currencyPos == 'left' ? currencySymbol : ''}${addon.price}${currencyPos == 'right' ? currencySymbol : ''})`;
                    pill.onclick = function() {
                        this.classList.toggle('active');
                        const price = parseFloat(addon.price);
                        if (this.classList.contains('active')) {
                            selectedAddons.push({name: addon.name, price: addon.price});
                            selectedAddonsTotal += price;
                        } else {
                            selectedAddons = selectedAddons.filter(a => a.name !== addon.name);
                            selectedAddonsTotal -= price;
                        }
                        elakCalculateTotal();
                    };
                    additionsContainer.appendChild(pill);
                });
            } catch (e) { console.error("Addons error:", e); }
        }

        elakCalculateTotal();
        
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            new bootstrap.Modal(document.getElementById('productModal')).show();
        } else {
            $('#productModal').modal('show');
        }
    }

    function elakCalculateVariationTotal() {
        selectedVariationsTotal = 0;
        for (const v in selectedVariations) {
            selectedVariationsTotal += parseFloat(selectedVariations[v].price);
        }
        elakCalculateTotal();
    }

    function elakUpdateQty(delta) {
        currentQty += delta;
        if (currentQty < 1) currentQty = 1;
        document.getElementById('qtyInput').value = currentQty;
        elakCalculateTotal();
    }

    function elakCalculateTotal() {
        const total = (currentProductBasePrice + selectedAddonsTotal + selectedVariationsTotal) * currentQty;
        const formattedTotal = (currencyPos == 'left' ? currencySymbol : '') + total.toFixed(2) + (currencyPos == 'right' ? currencySymbol : '');
        document.getElementById('modalTotalBtn').innerText = formattedTotal;
    }

    function elakAddToCart() {
        if (!currentProduct) return;

        const btn = document.getElementById('elakAddToCartBtn');
        const btnText = document.getElementById('addToCartText');
        const originalText = btnText.innerText;

        // Validation for variations (ensure all are selected)
        if (currentProduct.variations) {
            const variations = JSON.parse(currentProduct.variations);
            for (const vName in variations) {
                if (!selectedVariations[vName]) {
                    toastr["warning"]("Please select " + vName.replace(/_/g, ' '));
                    return;
                }
            }
        }

        const total = (currentProductBasePrice + selectedAddonsTotal + selectedVariationsTotal) * currentQty;
        const variationsStr = JSON.stringify(selectedVariations);
        const addonsStr = JSON.stringify(selectedAddons);
        
        // Construct the multi-parameter ID
        const cartKey = `${currentProduct.id},,,${currentQty},,,${total},,,${variationsStr},,,${addonsStr}`;
        const url = "{{ route('user.front.add.cart', [getParam(), ':id']) }}".replace(':id', cartKey);

        if (btn) {
            btn.disabled = true;
            btnText.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    toastr["error"](data.error);
                    if (btn) {
                        btn.disabled = false;
                        btnText.innerText = originalText;
                    }
                } else {
                    toastr["success"](data.message);
                    
                    // Hide Modal Safely
                    try {
                        const modalEl = document.getElementById('productModal');
                        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                            if (modal) modal.hide();
                        } else {
                            $('#productModal').modal('hide');
                        }
                    } catch (err) {
                        console.error("Modal hiding error:", err);
                    }
                    
                    // Refresh cart count
                    location.reload(); 
                }
            })
            .catch(err => {
                console.error("Cart error:", err);
                toastr["error"]("Failed to add to cart");
                if (btn) {
                    btn.disabled = false;
                    btnText.innerText = originalText;
                }
            });
    }
</script>
