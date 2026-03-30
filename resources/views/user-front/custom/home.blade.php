@extends('layouts.master')

@section('content')

<!-- Main Slider -->
<div id="mainSlider" class="carousel slide main-slider" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="0" class="active" aria-current="true"
            aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/slider/slide1.webp') }}" class="d-block w-100" alt="Special Offer 1">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/slider/slide2.webp') }}" class="d-block w-100" alt="Special Offer 2">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Categories -->
<nav class="category-scroller sticky-top bg-white py-3 shadow-sm" style="top: 0; z-index: 1020;">
    <a href="#" class="category-pill active" data-filter="all">
        <i class="fas fa-th-large"></i> All
    </a>
    @foreach($categories as $category)
    <a href="#cat-{{ $category->id }}" class="category-pill" data-filter=".cat-{{ $category->id }}">
        <img src="{{ $category->image }}" alt="{{ $category->name }}"> {{ $category->name }}
    </a>
    @endforeach
</nav>

<!-- Products -->
<div class="row mt-3">
    @foreach($categories as $category)
    <div id="cat-{{ $category->id }}" class="col-12 mb-2 cat-section cat-{{ $category->id }}">
        <h5 class="fw-bold mb-3 px-2 border-start border-4 border-primary ps-2">{{ $category->name }}</h5>
        <div class="row">
            @foreach($category->products as $product)
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="product-card" onclick="openProductModal({{ $product->toJson() }})">
                    <img src="{{ $product->image }}" class="product-image" alt="{{ $product->name }}">
                    <div class="product-details">
                        <h6 class="product-title">{{ $product->name }}</h6>
                        <p class="product-desc">{{ $product->description }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="product-price">{{ number_format($product->price, 2) }} USD</span>
                            <button class="add-btn shadow-sm">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

@endsection

@section('modals')
<!-- Product Details Modal (Bottom Sheet Style) -->
<div class="modal fade bottom-sheet" id="productModal" tabindex="-1" aria-hidden="true"
    style="padding-left: 0 !important;">
    <div class="modal-dialog">
        <div class="modal-content overflow-hidden border-0 bg-white">

            <!-- Hero Image Section -->
            <div class="modal-product-hero">
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal">
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
@endsection