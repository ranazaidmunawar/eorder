{{-- - bakery theme js --}}
@if ($activeTheme == 'bakery')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.bakery.include.bakery_header_footer_js')
    @endif
@endif
{{-- - End bakery Theme js  - --}}

@if ($activeTheme == 'pizza')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.pizza.include.pizza_header_footer_js')
    @endif
@endif

@if ($activeTheme == 'elak')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.elak.include.elak_header_footer_js')
    @endif
@endif

@if ($activeTheme == 'coffee')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.coffee.include.coffee_header_footer_js')
    @endif
@endif

@if ($activeTheme == 'medicine')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.medicine.include.medicine_header_footer_js')
    @endif
@endif

@if ($activeTheme == 'grocery')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.grocery.include.grocery_header_footer_js')
    @endif
@endif

@if ($activeTheme == 'beverage')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.beverage.include.beverage_header_footer_js')
    @endif
@endif
@if ($activeTheme == 'seabbq' || $activeTheme == 'desifoodie' || $activeTheme == 'desices')
    @if (!request()->routeIs('user.front.index'))
        <script src="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/js/vendor/jquery.nice-select.min.js"></script>
        <script src="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/js/vendor/lazyimage/lazy.image.js"></script>
        <script src="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/js/vendor/lazyimage/lazysizes.min.js"></script>
        <script src="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/js/vendor/back-to-top.js"></script>
        <script src="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/js/vendor/svg-injector.min.js"></script>
        <script src="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/js/vendor/header-menu.js"></script>
        <script src="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/js/inner-common.js"></script>
    @endif
@endif
<!-- Swiper JS -->
<script src="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/js/swiper-bundle.min.js"></script>
