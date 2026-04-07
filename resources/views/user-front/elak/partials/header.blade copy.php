@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp
<header class="header-area header-2" data-aos="fade-down">
    <!-- Start mobile menu -->
    <div class="mobile-menu">
        <div class="container">
            <div class="mobile-menu-wrapper"></div>
        </div>
    </div>
    <!-- End mobile menu -->

    <div class="main-responsive-nav">
        <div class="container">
            <!-- Mobile Logo -->
            <div class="logo">
                <a href="{{ route('user.front.index', getParam()) }}" target="_self" title="Superv">
                    <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_LOGO, $userBs->logo, $userBs) }}"
                        alt="Logo">
                </a>
            </div>
            <!-- Menu toggle button -->
            <button class="menu-toggler" type="button">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    <div class="main-navbar">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('user.front.index', getParam()) }}" target="_self"
                    title="Superv">
                    <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_LOGO, $userBs->logo, $userBs) }}"
                        alt="Logo">
                </a>
                <!-- Navigation items -->
                <div class="collapse navbar-collapse">
                    <ul id="mainMenu" class="navbar-nav mobile-item mx-auto">
                        @php
                            $links = json_decode($userMenus, true);
                            //   dd($links);
                        @endphp

                        @foreach ($links as $link)
                            @php
                                $href = getUserHref($link, $userCurrentLang->id);
                            @endphp
                            <!---Level 1 links whick doesn't have dropdown--->
                            @if (!array_key_exists('children', $link))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ $href }}">{{ $link['text'] }}</a>
                                </li>
                            @else
                                <!-- Level 1 Link which have dropdown Menu-->

                                <li class="nav-item">
                                    <a href="#" class="nav-link toggle">{{ $link['text'] }} <i
                                            class="fal fa-plus"></i></a>
                                    <ul class="menu-dropdown">
                                        @foreach ($link['children'] as $level2)
                                            @php
                                                $l2Href = getUserHref($level2, $userCurrentLang->id);
                                            @endphp

                                            <li class="nav-item">

                                                <a class="nav-link  @if (array_key_exists('children', $level2)) toggle @endif  @if (url() == $l2Href) active @endif"
                                                    href="{{ $l2Href }}">{{ $level2['text'] }} @if (array_key_exists('children', $level2))
                                                        <i class="fal fa-plus"></i>
                                                    @endif </a>
                                                @php
                                                    if (array_key_exists('children', $level2)) {
                                                        create_other_theme_menu($level2);
                                                    }
                                                @endphp
                                            </li>
                                        @endforeach

                                    </ul>
                                </li>
                            @endif
                        @endforeach


                    </ul>
                </div>

                <div class="more-option mobile-item">
                    @if (!empty($userCurrentLang))

                        <div class="item">
                            <div class="language">
                                <select class="languageChange text-capitalize">
                                    @foreach ($allLanguageInfos as $key => $lang)
                                        {{ $lang->code }}
                                        <option
                                            value="{{ route('user.front.change.language', [getParam(), $lang->code]) }}"
                                            data-href="{{ route('user.front.change.language', [getParam(), $lang->code]) }}"
                                            {{ $lang->code == $userCurrentLang->code ? 'selected' : '' }}>
                                            {{ convertUtf8($lang->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    @endif

                    @auth
                        <div class="item">
                            <a href="{{ route('user.client.dashboard', getParam()) }}" class="btn-icon" target="_self"
                                aria-label="User" {{ $keywords['Dashboard'] ?? __('Dashboard') }}>
                                <i class="fal fa-user-circle"></i>
                            </a>
                        </div>
                    @else
                        <div class="item">
                            <a href="{{ route('user.client.login', getParam()) }}" class="btn-icon" target="_self"
                                aria-label="User" title="{{ $keywords['Login'] ?? __('Login') }}">
                                <i class="fal fa-sign-in"></i>
                            </a>
                        </div>

                    @endauth


                    <div class="item cart cartQuantity" id="cartQuantity">
                        <a href="{{ route('user.front.cart', getParam()) }}" class="btn-icon pe-2" target="_self"
                            aria-label="User" title="User">
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
                            <span class="badge rounded-pill bg-primary cart-quantity">{{ $itemsCount }}</span>
                        </a>
                    </div>
                    @if ($userBs->website_call_waiter == 1)
                        <div class="item">
                            <a data-toggle="modal" data-target="#callWaiterModal" class="btn-icon" target="_self"
                                title="{{ __('Call Waiter') }}" data-tooltip="tooltip" data-bs-placement="top"
                                data-bs-original-title="{{ __('Call Waiter') }}">
                                <i class="fal fa-bell"></i>
                            </a>
                        </div>
                    @endif

                    @if ($userBs->is_quote)
                        <div class="item">
                            <a href="{{ route('user.front.reservation', getParam()) }}"
                                class="btn btn-md btn-primary rounded-pill"
                                title="{{ $keywords['Reservation'] ?? __('Reservation') }}"
                                target="_self">{{ $keywords['Reservation'] ?? __('Reservation') }}</a>
                        </div>
                    @endif
                </div>
            </nav>
        </div>
    </div>
</header>
<script>
    $(document).ready(function() {
        $(document).on('change', '.languageChange', function() {
            const that = $(this);
            const url = that.find('option:selected').attr('data-href');
            document.location.href = url;

        })
    });
</script>
