    @php
        use App\Constants\Constant;
        use App\Http\Helpers\Uploader;
        use Illuminate\Support\Facades\Auth;

    @endphp
    <!--========= Start Header =========-->
    <header class="header-area">
        <div class="header-top">
            <div class="container">
                <div class="header-top-left">
                    <span class="">{{ @$userBe->top_header_support_text }}</span>
                    <a
                        href="mailto:{{ @$userBe->top_header_support_email }}">{{ @$userBe->top_header_support_email }}</a>
                </div>
                <div class="header-top-center">
                    <span>{{ @$userBe->top_header_middle_text }}</span>
                </div>
                <div class="header-top-right">
                    @if (!empty($userCurrentLang))
                        <div class="language">
                            <i class="fa-solid fa-globe"></i>
                            <select class="niceselect nice-select languageChange">
                                @foreach ($allLanguageInfos as $key => $lang)
                                    <option value="{{ route('user.front.change.language', [getParam(), $lang->code]) }}"
                                        {{ $lang->code == $userCurrentLang->code ? 'selected' : '' }}
                                        data-href="{{ route('user.front.change.language', [getParam(), $lang->code]) }}">
                                        {{ convertUtf8($lang->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if (request()->routeIs('user.front.index'))
                        <div class="dropdown user-btn">
                            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-light fa-user-circle"></i>@auth
                                    {{ $keywords['Dashboard'] ?? __('Dashboard') }}
                                @else
                                {{ $keywords['Login'] ?? __('Login') }} @endauth
                            </button>
                            <ul class="dropdown-menu">
                                @auth
                                    <li><a class="dropdown-item"
                                            href="{{ route('user.client.dashboard', getParam()) }}">{{ $keywords['Dashboard'] ?? __('Dashboard') }}</a>
                                    </li>
                                @else
                                    <li><a class="dropdown-item"
                                            href="{{ route('user.client.login', getParam()) }}">{{ $keywords['Login'] ?? __('Login') }}</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('user.client.register', getParam()) }}">
                                            {{ $keywords['Sign_Up'] ?? __('Sign Up') }}</a></li>
                                @endauth
                            </ul>
                        </div>
                    @else
                        <div class="dropdown user-btn">
                            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fa-light fa-user-circle"></i>
                                @if (Auth::guard('client')->check())
                                    {{ $keywords['Dashboard'] ?? __('Dashboard') }}
                                @else
                                    {{ $keywords['Login'] ?? __('Login') }}
                                @endif
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @if (Auth::guard('client')->check())
                                    <a class="dropdown-item" href="{{ route('user.client.dashboard', getParam()) }}">
                                        {{ $keywords['Dashboard'] ?? __('Dashboard') }}
                                    </a>
                                @else
                                    <a class="dropdown-item" href="{{ route('user.client.login', getParam()) }}">
                                        {{ $keywords['Login'] ?? __('Login') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('user.client.register', getParam()) }}">
                                        {{ $keywords['Sign_Up'] ?? __('Sign Up') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-xl hover-menu">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('user.front.index', getParam()) }}" target="_self">
                    <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_LOGO, $userBs->logo, $userBs) }}"
                        alt="Brand Logo">
                </a>
                <button class="menu-toggler d-block d-xl-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#mobilemenu-offcanvas" aria-controls="mobilemenu-offcanvas">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="collapse navbar-collapse" id="main_nav">
                    <!-- Header menu -->
                    <ul id="mainMenu" class="navbar-nav justify-content-center ms-auto">
                        @php $links = json_decode($userMenus, true); @endphp

                        @foreach ($links as $link)
                            @php
                                $href = getUserHref($link, $userCurrentLang->id);
                            @endphp
                            @if (!array_key_exists('children', $link))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ $href }}">{{ $link['text'] }}</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#"
                                        data-bs-toggle="dropdown">{{ $link['text'] }}</a>
                                    <ul class="dropdown-menu shadow">
                                        @foreach ($link['children'] as $level2)
                                            @php
                                                $l2Href = getUserHref($level2, $userCurrentLang->id);
                                            @endphp
                                            <li>
                                                <a class="dropdown-item @if (array_key_exists('children', $level2)) toggle @endif  @if (url() == $l2Href) active @endif"
                                                    href="{{ $l2Href }}">
                                                    {{ $level2['text'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <!-- navbar-right -->
                    <div class="navbar-right ms-auto">
                        <div class="item cart cartQuantity" id="cartQuantity">
                            <a href="{{ route('user.front.cart', getParam()) }}" class="btn-icon"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Shopping Cart">
                                <i class="fal fa-shopping-bag"></i>
                                @php
                                    $itemsCount = 0;
                                    $cart = session()->get(getUser()->username . '_cart');
                                    if (!empty($cart)) {
                                        foreach ($cart as $p) {
                                            $itemsCount += $p['qty'];
                                        }
                                    }
                                @endphp
                                <span class="cart-quantity">{{ $itemsCount }}</span>
                            </a>
                        </div>
                        @if ($userBs->website_call_waiter == 1)
                            @if (request()->routeIs('user.front.index'))
                                <div class="item">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#callWaiterModal"
                                        class="btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Call Waiter">
                                        <i class="fal fa-bell"></i>
                                    </a>
                                </div>
                            @else
                                <div class="item">
                                    <a href="#" data-toggle="modal" data-target="#callWaiterModal"
                                        class="btn-icon" data-toggle="tooltip" data-placement="top" title="Call Waiter">
                                        <i class="fal fa-bell"></i>
                                    </a>
                                </div>
                            @endif
                        @endif
                        @if ($userBs->is_quote)
                            <div class="item reservation-btn">
                                <a href="{{ route('user.front.reservation', getParam()) }}"
                                    class="btn thm-btn radius-30">{{ $keywords['Reservation'] ?? __('Reservation') }}</a>
                            </div>
                        @endif
                    </div>
                </div> <!-- navbar-collapse.// -->
            </div> <!-- container.// -->
        </nav>
    </header>
    <!--========= End Header ==========-->

    <!-- Start Mobile-menu -->
    <div class="offcanvas desices-mobilemenu mobilemenuoffcanvas offcanvas-start" data-bs-scroll="true"
        data-bs-backdrop="true" tabindex="-1" id="mobilemenu-offcanvas">
        <div class="offcanvas-header align-items-center justify-content-between px-20 pt-20">
            <a class="navbar-brand" href="index.html">
                <img width="150" class="lazyload blur-up"
                    src="{{ Uploader::getImageUrl(Constant::WEBSITE_LOGO, $userBs->logo, $userBs) }}" alt="logo">
            </a>
            <a href="#" class="menu-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-light fa-xmark"></i>
            </a>
        </div>
        <div class="offcanvas-body">
            <!-- mobile-menu clone -->
            <nav id="mobileMenu" class="mobile-menu mb-40">

            </nav>
            <!-- menu-action-item-wrapper -->
            <div class="menu-action-item-wrapper">
                <div class="group-buttons">
                    @if (!empty($userCurrentLang))
                        <div class="language">
                            <i class="fa-solid fa-globe"></i>
                            <select class="niceselect nice-select languageChange">
                                @foreach ($allLanguageInfos as $key => $lang)
                                    <option
                                        value="{{ route('user.front.change.language', [getParam(), $lang->code]) }}"
                                        {{ $lang->code == $userCurrentLang->code ? 'selected' : '' }}
                                        data-href="{{ route('user.front.change.language', [getParam(), $lang->code]) }}">
                                        {{ convertUtf8($lang->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="dropdown user-btn">
                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-light fa-user-circle"></i>
                            @auth
                                {{ $keywords['Dashboard'] ?? __('Dashboard') }}
                            @else
                                {{ $keywords['Login'] ?? __('Login') }}
                            @endauth
                        </button>
                        <ul class="dropdown-menu">
                            @auth
                                <li><a class="dropdown-item"
                                        href="{{ route('user.client.dashboard', getParam()) }}">{{ $keywords['Dashboard'] ?? __('Dashboard') }}</a>
                                </li>
                            @else
                                <li><a class="dropdown-item"
                                        href="{{ route('user.client.login', getParam()) }}">{{ $keywords['Login'] ?? __('Login') }}</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('user.client.register', getParam()) }}">
                                        {{ $keywords['Sign_Up'] ?? __('Sign Up') }}</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>

                <div class="navbar-right">
                    <div class="item">
                        <a href="{{ route('user.front.cart', getParam()) }}" class="btn-icon" target="_self"
                            aria-label="User" title="Cart">
                            <i class="fal fa-shopping-bag"></i>
                            @php
                                $itemsCount = 0;
                                $cart = session()->get(getUser()->username . '_cart');
                                if (!empty($cart)) {
                                    foreach ($cart as $p) {
                                        $itemsCount += $p['qty'];
                                    }
                                }
                            @endphp
                            <span class="cart-quantity">{{ $itemsCount }}</span>
                        </a>
                    </div>
                    @if ($userBs->website_call_waiter == 1)
                        @if (request()->routeIs('user.front.index'))
                            <div class="item">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#callWaiterModal"
                                    class="btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Call Waiter">
                                    <i class="fal fa-bell"></i>
                                </a>
                            </div>
                        @else
                            <div class="item">
                                <a href="#" data-toggle="modal" data-target="#callWaiterModal"
                                    class="btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Call Waiter">
                                    <i class="fal fa-bell"></i>
                                </a>
                            </div>
                        @endif
                    @endif
                    @if ($userBs->is_quote)
                        <div class="item reservation-btn">
                            <a href="{{ route('user.front.reservation', getParam()) }}"
                                class="btn thm-btn radius-30">{{ $keywords['Reservation'] ?? __('Reservation') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Mobile-menu -->
