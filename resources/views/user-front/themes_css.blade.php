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
@if ($activeTheme == 'fastfood' || !request()->routeIs('user.front.index'))
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
@endif
@if ($activeTheme == 'fastfood' && $rtl == 1)
    <link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css') }}">
@endif
@if ($rtl == 1)
    <link rel="stylesheet" href="{{ asset('assets/front/css/rtl.css') }}">
@endif

@if ($activeTheme == 'fastfood' && ($userBs->is_tawkto == 1 || $userBs->is_whatsapp == 1))
    <style>
        .go-top-area .go-top.active {
            right: auto;
            left: 20px;
        }
    </style>
@endif
