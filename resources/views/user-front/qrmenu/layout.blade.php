@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Table;
    use Illuminate\Support\Facades\Auth;
    
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{ $userCurrentLang->rtl == 1 ? 'rtl' : ''}}" >

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">
    <title>@yield('page-heading') {{ $userBs->website_title !== null ? '|' . ' ' : '' }} {{ $userBs->website_title }}</title>


    <link rel="shortcut icon" href="{{ Uploader::getImageUrl(Constant::WEBSITE_FAVICON, $userBs->favicon, $userBs) }}"
        type="image/png">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/front/css/qr-plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/qr-menu.css') }}">

    <link rel="stylesheet"
        href="{{ asset('assets/front/css/qr-styles.php?color=' . str_replace('#', '', $userBs->base_color)) }}">
    @if ($userCurrentLang->rtl == 1)
        <link rel="stylesheet" href="{{ asset('assets/front/css/qr-rtl.css') }}">
    @endif

    <script src="{{asset('assets/front/js/jquery.min.js')}}"></script>
    @if ($userBs->is_recaptcha == 1)
        <script type="text/javascript">
            var onloadCallback = function() {
                grecaptcha.render('g-recaptcha', {
                    'sitekey': '{{ $userBs->google_recaptcha_site_key }}'
                });
            };
        </script>
    @endif
    <script type="text/javascript">
        const userChangeLanguageUrl = "{{ route('user.front.change.language', [getParam(), ':lang', 'qr']) }}";
    </script>
</head>

<body class="qr-menu">

    <div class="header">
        <div class="container">
            <div class="row no-gutters align-items-center">
                <div class="col-3">
                    <div class="logo-wrapper">
                        @if ($userBs?->logo)
                            <a href="{{ route('user.front.qrmenu', getParam()) }}">
                                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_LOGO, $userBs->logo, $userBs) }}"
                                    alt="Logo">
                            </a>
                        @else
                            <a class="navbar-brand" href="{{ route('user.front.qrmenu', getParam()) }}">
                                <img src="{{ asset('assets/restaurant/images/logo.png') }}" alt="Logo">
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-9 d-flex justify-content-end">
                    <form id="langForm" action="" class='mr-2'>
                        <select class="form-control form-control-md"
                            onchange="document.getElementById('langForm')
                            .setAttribute('action',userChangeLanguageUrl.replace(':lang',this.value));
                            document.getElementById('langForm').submit()">
                            @foreach ($allLanguageInfos as $lang)
                                <option value="{{ $lang->code }}"
                                    {{ $userCurrentLang->code == $lang->code ? 'selected' : '' }}>
                                    {{ $lang->name }}
                                </option>
                            @endforeach
                        </select>

                    </form>

                    <div class="dropdown">
                        <button class="btn base-btn text-white dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            @if (in_array('Call Waiter', $packagePermissions) && $userBs->qr_call_waiter == 1)
                                <a href="#" class="dropdown-item" data-toggle="modal"
                                    data-target="#callWaiterModal">{{ $keywords['Call Waiter'] ?? __('Call Waiter') }}
                                </a>
                            @endif
                            @if (Auth::guard('client')->check())
                                <a class="dropdown-item"
                                    href="{{ route('user.client.dashboard', getParam()) }}">{{ $keywords['Dashboard'] ?? __('Dashboard') }}
                                </a>

                                <a class="dropdown-item"
                                    href="{{ route('user.front.qrmenu.logout', getParam()) }}">{{ $keywords['Logout'] ?? __('Logout') }}
                                </a>
                            @else
                                <a class="dropdown-item"
                                    href="{{ route('user.front.qrmenu.login', getParam()) }}">{{ $keywords['Login'] ?? __('Login') }}
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="qr-breadcrumb lazy"
        style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="qr-breadcrumb-details">
                <h2>{{ $userBs->website_title }}</h2>
                <small>{{ $keywords['Working Hours'] ?? __('Working Hours') }}: {{ $userBs->office_time }}</small>
            </div>
            <h4 class="qr-page-heading">
                @yield('page-heading')
            </h4>
        </div>
    </div>

    @yield('content')

    <div class="request-loader">
        <img src="{{ asset('assets/admin/img/loader.gif') }}" alt="">
    </div>

    @if (!empty($packagePermissions) && in_array('Online Order', $packagePermissions))

        <div class="cart-icon">
            <div id="cartQuantity">
                <img src="{{ asset('assets/front/img/static/cart-icon.png') }}" alt="Cart Icon">
                <span class="cart-count">{{ $itemsCount }}</span>
            </div>
        </div>

    @endif

    @includeIf('user-front.qrmenu.partials.qr-cart-sidebar')

    <div class="modal fade" id="callWaiterModal" tabindex="-1" role="dialog" aria-labelledby="callWaiterModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {{ $keywords['Call Waiter'] ?? __('Call Waiter') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                        $tables = Table::query()
                            ->where('status', 1)
                            ->where('user_id', $user->id)
                            ->get();
                    @endphp
                    <form id="callWaiterForm" action="{{ route('user.front.call.waiter', getParam()) }}"
                        method="GET">
                        <select class="form-control" name="table" required>
                            <option value="" disabled selected>
                                {{ $keywords['Select a Table'] ?? __('Select a Table') }}</option>
                            @foreach ($tables as $table)
                                <option value="{{ $table->table_no }}">{{ $keywords['Table'] ?? __('Table') }}
                                    - {{ $table->table_no }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="callWaiterForm" class="btn base-btn text-white">
                        {{ $keywords['Call Waiter'] ?? __('Call Waiter') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const mainurl = "{{ url('/') }}";
        const userCheckoutUrl = "{{ route('user.front.add.cart', [getParam(), ':id']) }}";
        const position = "{{ $userBe->base_currency_symbol_position }}";
        const sessionLang = '{{ $userCurrentLang->code }}';
        const userCurrentLang = '{{ $userCurrentLang->code }}';
        const symbol = "{{ $userBe->base_currency_symbol }}";
        const textPosition = "{{ $userBe->base_currency_text_position }}";
        const currText = "{{ $userBe->base_currency_text }}";
        const select = "{{ $keywords['Select'] ?? __('Select') }}";
        var demo_mode = "{{ env('DEMO_MODE') }}";
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="{{ asset('assets/tenant/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/qr-plugins.js') }}"></script>

    <script>
    var datepickerpath = "{{ asset('assets/tenant/js/i18n/'.$userCurrentLang->datepicker_name.'-' . $userCurrentLang->code . '.js') }}";
    </script>

    <script>
        var qrQtyChangeRoute = "{{ route('user.front.qr.qtyChange', getParam()) }}";
        var qrRemoveRoute = "{{ route('user.front.qr.remove', getParam()) }}";
    </script>

    <script src="{{ asset('assets/restaurant/js/custom.js') }}"></script>

    <script src="{{ asset('assets/front/js/qr-cart.js') }}"></script>

    @if (session()->has('success'))
        <script>
            "use strict";
            toastr["success"]("{{ __(session('success')) }}");
        </script>
    @endif

    @if (session()->has('warning'))
        <script>
            "use strict";
            toastr["warning"]("{{ __(session('warning')) }}");
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            "use strict";
            toastr["error"]("{{ __(session('error')) }}");
        </script>
    @endif

    @yield('script')
</body>

</html>
