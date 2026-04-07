@php
    $cartCount = 0;
    if (Session::has($user->username . "_cart")) {
        $cart = Session::get($user->username . "_cart");
        if (is_array($cart)) {
            foreach ($cart as $item) {
                $cartCount += (int)$item['qty'];
            }
        }
    }
@endphp

<header class="sticky-top bg-white shadow-sm">
    <div class="container-fluid py-2" style="background-color: #0f5156;">
        <div class="row align-items-center">
            <!-- Left: Icons (Notification & Search) -->
            <div class="col-4 d-flex align-items-center">
                <a href="{{ route('user.front.cart', getParam()) }}" class="text-white position-relative me-3">
                    <i class="fas fa-shopping-cart fa-lg"></i>
                    @if($cartCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="font-size: 0.6rem;">
                        {{ $cartCount }}
                    </span>
                    @endif
                </a>
                <a href="javascript:void(0)" class="text-white" onclick="toggleSearchModal(true)">
                    <i class="fas fa-search fa-lg"></i>
                </a>
            </div>

            <!-- Center: Logo -->
            <div class="col-4 text-center">
                <a class="navbar-brand fw-bold text-white d-block" href="{{ route('user.front.index', getParam()) }}"
                    style="font-size: 1.5rem;">
                    <i class="fas fa-utensils me-2"></i> {{ $userBs->website_title }}
                </a>
            </div>

            <!-- Right: Language & Menu -->
            <div class="col-4 d-flex justify-content-end align-items-center">
    
                <a href="{{ route('user.front.change.language', [getParam(), 'ar']) }}" class="text-white fw-bold me-3 text-decoration-none">AR</a>
          
                <a href="{{ route('user.front.change.language', [getParam(), 'en']) }}" class="text-white fw-bold me-3 text-decoration-none">EN</a>

                <a href="javascript:void(0)" class="text-white menu-trigger" onclick="toggleSidebar(true)">
                    <i class="fas fa-bars fa-lg"></i>
                </a>
            </div>
        </div>
    </div>
</header>

<!-- ... (Search Modal section remains same) ... -->

<!-- Right Sidebar (Mobile Menu) -->
<div id="sideDrawer" class="side-drawer">
    <div class="drawer-header p-3 d-flex justify-content-between align-items-center">
        <button type="button" class="btn-close" onclick="toggleSidebar(false)" style="font-size: 1.2rem;"></button>
        <h5 class="m-0 fw-bold">{{ __('Menu') }}</h5>
    </div>
    
    <div class="drawer-body p-3">
        <div class="menu-list">
            <!-- Cart -->
            <a href="{{ route('user.front.cart', getParam()) }}" class="menu-item-card shadow-sm d-flex align-items-center justify-content-between">
                <i class="fas fa-arrow-left text-muted"></i>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end">
                        <span class="fw-bold d-block">{{ __('Cart') }}</span>
                        @if($cartCount > 0)
                            <small class="text-success fw-bold">{{ $cartCount }} {{ __('Items') }}</small>
                        @endif
                    </div>
                    <div class="menu-item-icon cart-bg position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem; padding: 0.35em 0.6em;">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </div>
                </div>
            </a>

            <!-- Change Branch -->
            <a href="javascript:void(0)" onclick="openBranchModal()" class="menu-item-card shadow-sm d-flex align-items-center justify-content-between">
                <i class="fas fa-arrow-left text-muted"></i>
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold">{{ __('Change Branch') }}</span>
                    <div class="menu-item-icon store-bg">
                        <i class="fas fa-store"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="drawerOverlay" class="drawer-overlay" onclick="toggleSidebar(false)"></div>

<style>
    /* Search Modal Styles */
    .search-modal {
        position: fixed;
        top: -100%;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 600px;
        background: white;
        z-index: 2100;
        transition: top 0.4s ease-in-out;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .search-modal.active {
        top: 0;
    }

    .live-search-results {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: white;
        border-radius: 15px;
        margin-top: 10px;
        max-height: 400px;
        overflow-y: auto;
        z-index: 10;
        border: 1px solid #eee;
    }

    .search-result-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        text-decoration: none;
        color: #333;
        transition: background 0.2s;
        border-bottom: 1px solid #f8f9fa;
    }

    .search-result-item:hover {
        background: #f8f9fa;
        color: inherit;
    }

    .search-result-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
        margin-right: 15px;
    }

    .search-result-info {
        flex: 1;
    }

    .search-result-title {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 2px;
        display: block;
    }

    .search-result-price {
        color: #0f5156;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .no-results-msg { padding: 20px; color: #999; }

    /* Sidebar Drawer Styles */
    .side-drawer {
        position: fixed;
        top: 0;
        right: -100%;
        width: 80%;
        max-width: 350px;
        height: 100%;
        background: #f8f9fa;
        z-index: 2000;
        transition: right 0.4s ease-in-out;
        box-shadow: -5px 0 15px rgba(0,0,0,0.1);
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        display: flex;
        flex-direction: column;
    }

    .side-drawer.active {
        right: 0;
    }

    .drawer-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        z-index: 1500;
        display: none;
        backdrop-filter: blur(2px);
    }

    .drawer-overlay.active {
        display: block;
    }

    /* Menu Card Styles */
    .menu-item-card {
        background: white;
        padding: 15px 20px;
        border-radius: 15px;
        margin-bottom: 12px;
        text-decoration: none;
        color: #333;
        transition: transform 0.2s;
        border: 1px solid #f0f0f0;
    }

    .menu-item-card:active {
        transform: scale(0.98);
    }

    .menu-item-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .heart-bg { background-color: #fef2f2; color: #ef4444; }
    .cart-bg { background-color: #f0fdf4; color: #22c55e; }
    .store-bg { background-color: #eff6ff; color: #3b82f6; }

    .gap-3 { gap: 1rem; }
    .decoration-none { text-decoration: none; }
</style>

<script>
    let searchTimeout = null;

    function toggleSearchModal(show) {
        if (show) {
            document.getElementById('searchModal').classList.add('active');
            document.getElementById('searchOverlay').classList.add('active');
            setTimeout(() => document.getElementById('globalSearchInput').focus(), 400);
        } else {
            document.getElementById('searchModal').classList.remove('active');
            document.getElementById('searchOverlay').classList.remove('active');
            hideSearchResults();
        }
    }

    function hideSearchResults() {
        document.getElementById('liveSearchResults').classList.add('d-none');
    }

    function executeSearch() {
        const query = document.getElementById('globalSearchInput').value;
        if (query.trim() === '') {
            toastr["warning"]("Please enter something to search!");
            return;
        }
        const searchUrl = "{{ route('user.front.items', [getParam()]) }}?search=" + encodeURIComponent(query);
        window.location.href = searchUrl;
    }

    // Live Search Logic
    document.getElementById('globalSearchInput')?.addEventListener('input', function (e) {
        const query = e.target.value.trim();
        const resultsContainer = document.getElementById('liveSearchResults');
        const resultsList = resultsContainer.querySelector('.results-list');

        clearTimeout(searchTimeout);

        if (query.length < 2) {
            hideSearchResults();
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch("{{ route('user.front.ajax.search', getParam()) }}?term=" + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    resultsList.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const html = `
                                <a href="${item.details_url}" class="search-result-item">
                                    <img src="${item.image_url}" class="search-result-img" alt="${item.title}">
                                    <div class="search-result-info">
                                        <span class="search-result-title">${item.title}</span>
                                        <span class="search-result-price">${item.current_price}</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted small"></i>
                                </a>
                            `;
                            resultsList.insertAdjacentHTML('beforeend', html);
                        });
                        resultsContainer.classList.remove('d-none');
                    } else {
                        resultsList.innerHTML = '<div class="no-results-msg text-center">{{ __("No products found") }}</div>';
                        resultsContainer.classList.remove('d-none');
                    }
                })
                .catch(err => console.error('Search error:', err));
        }, 300); // 300ms debounce
    });

    // Handle Enter Key for Search
    document.getElementById('globalSearchInput')?.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            executeSearch();
        }
    });

    function toggleSidebar(show) {
        if (show) {
            document.getElementById('sideDrawer').classList.add('active');
            document.getElementById('drawerOverlay').classList.add('active');
            document.body.style.overflow = 'hidden'; 
        } else {
            document.getElementById('sideDrawer').classList.remove('active');
            document.getElementById('drawerOverlay').classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }

    function openBranchModal() {
        toggleSidebar(false);
        toastr["info"]("Branch selection coming soon!");
    }

    $(document).ready(function() {
        $(document).on('change', '.languageChange', function() {
            const that = $(this);
            const url = that.find('option:selected').attr('data-href');
            document.location.href = url;
        })
    });
</script>
