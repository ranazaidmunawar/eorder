<header class="sticky-top bg-white shadow-sm">
    <div class="container-fluid py-2" style="background-color: var(--primary-color);">
        <div class="row align-items-center">
            <!-- Left: Icons (Notification & Search) -->
            <div class="col-4 d-flex align-items-center">
                <a href="#" class="text-white me-3 position-relative">
                    <i class="fas fa-bell fa-lg"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="font-size: 0.5rem;">
                        1
                    </span>
                </a>
                <a href="#" class="text-white">
                    <i class="fas fa-search fa-lg"></i>
                </a>
            </div>

            <!-- Center: Logo -->
            <div class="col-4 text-center">
                <a class="navbar-brand fw-bold text-white d-block" href="{{ route('home') }}"
                    style="font-size: 1.5rem;">
                    <i class="fas fa-utensils me-2"></i> RestoApp
                </a>
                <a href="#" class="text-white-50 text-decoration-none" style="font-size: 0.8rem;">{{
                    __('view_my_requests') }}</a>
            </div>

            <!-- Right: Language & Menu -->
            <div class="col-4 d-flex justify-content-end align-items-center">
                @if(app()->getLocale() == 'en')
                <a href="{{ route('lang.switch', 'ar') }}" class="text-white fw-bold me-3 text-decoration-none">AR</a>
                @else
                <a href="{{ route('lang.switch', 'en') }}" class="text-white fw-bold me-3 text-decoration-none">EN</a>
                @endif

                <a href="#" class="text-white">
                    <i class="fas fa-bars fa-lg"></i>
                </a>
            </div>
        </div>
    </div>
</header>