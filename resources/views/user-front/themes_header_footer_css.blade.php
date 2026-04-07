@if (count($langs) == 0)
    <style media="screen">
        .support-bar-area ul.social-links li:last-child {
            margin-right: 0px;
        }

        .support-bar-area ul.social-links::after {
            display: none;
        }
    </style>
@endif

@if ($userBs->feature_section == 0)
    <style media="screen">
        .hero-txt {
            padding-bottom: 160px;
        }
    </style>
@endif


{{-- -- Bakery Theme Header & Footer css --}}
@if ($activeTheme == 'bakery')

    @if (!request()->routeIs('user.front.index'))
        @include('user-front.bakery.include.bakery_header_footer_css')
    @endif
@endif
{{-- -- End Bakery theme Header & Footer css --}}


{{-- --Start Pizza theme Header & Footer css --}}
@if ($activeTheme == 'pizza')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.pizza.include.pizza_header_footer_css')
    @endif

@endif

{{-- -- End Pizz theme Header & Footer css --}}
@if ($activeTheme == 'elack')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.elack.include.elack_header_footer_css')
    @endif
@endif


{{-- Start coffee theme css --}}
@if ($activeTheme == 'coffee')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.coffee.include.coffee_header_footer_css')
    @endif

@endif
{{-- End coffee theme css --}}


{{-- -- Start Medicine theme css --}}
@if ($activeTheme == 'medicine')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.medicine.include.medicine_header_footer_css')
    @endif

@endif
{{-- --End Medicine theme css --}}

{{-- -- Start Grocery theme css --}}
@if ($activeTheme == 'grocery')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.grocery.include.grocery_header_footer_css')
    @endif

@endif
{{-- --End Medicine theme css --}}

{{-- -- Start beverage theme css --}}
@if ($activeTheme == 'beverage')
    @if (!request()->routeIs('user.front.index'))
        @include('user-front.beverage.include.beverage_header_footer_css')
    @endif
@endif
{{-- --End Medicine theme css --}}
@if ($activeTheme == 'seabbq' || $activeTheme == 'desifoodie' || $activeTheme == 'desices')
    @if (!request()->routeIs('user.front.index'))
        <link rel="stylesheet" href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/vendor/all.min.css">
        <link rel="stylesheet"
            href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/vendor/nice-select.css">
        <link rel="stylesheet" href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/inner-common.css">

        @if ($activeTheme == 'seabbq')
            <link rel="stylesheet"
                href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/header/header-10.css">
            <link rel="stylesheet"
                href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/footer/footer-10.css">
            @if ($rtl == 1)
                <link rel="stylesheet"
                    href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/homepage/rtl-style-10.css">
            @endif
        @endif
        @if ($activeTheme == 'desifoodie')
            <link rel="stylesheet"
                href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/header/header-11.css">
            <link rel="stylesheet"
                href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/footer/footer-11.css">
            @if ($rtl == 1)
                <link rel="stylesheet"
                    href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/homepage/rtl-style-11.css">
            @endif
        @endif
        @if ($activeTheme == 'desices')
            <link rel="stylesheet"
                href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/header/header-12.css">
            <link rel="stylesheet"
                href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/footer/footer-12.css">
            @if ($rtl == 1)
                <link rel="stylesheet"
                    href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/homepage/rtl-style-12.css">
            @endif
        @endif
    @endif
@endif
<!-- Swiper CSS -->
<link rel="stylesheet" href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/swiper-bundle.min.css" />
