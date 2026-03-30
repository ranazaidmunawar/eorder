<!DOCTYPE html>
<html lang="en" dir="{{ $userCurrentLang->rtl == 1 ? 'rtl' : '' }}">

<head>
    @php
        use App\Constants\Constant;
        use App\Http\Helpers\Uploader;
        use App\Models\User\Table;
        use App\Models\User\Ulink;
        use Illuminate\Support\Facades\Auth;
    @endphp
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('pageHeading') {{ $userBs->website_title !== null ? '|' . ' ' : '' }} {{ $userBs->website_title }}</title>

    <link rel="shortcut icon"
        href="{{ $userBs->favicon ? Uploader::getImageUrl(Constant::WEBSITE_FAVICON, $userBs->favicon, $userBs) : '' }}"
        type="image/png">

    @yield('style')
    <link rel="stylesheet" href="{{ asset('assets/front/css/whatsapp.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/restaurant/seabbq-desifoodie-desices/css/plugin_css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    @php
        $primaryColor = $userBs->base_color;
        // if, primary color value does not contain '#', then add '#' before color value
        if (isset($primaryColor) && checkColorCode($primaryColor) == 0) {
            $primaryColor = '#' . $primaryColor;
        }
    @endphp

    <style>
        :root {
            --bs-primary: {{ $primaryColor }};
            --bs-primary-rgb: {{ hexToRgba($primaryColor) }}
        }
    </style>

</head>

<body>
    <div class="pages">

        <!-- Start preloader  -->
        <div class="preloader">
            <div class="preloader-content">
                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRELOADER, $userBs->preloader, $userBs) }}"
                    alt="looder">
            </div>
        </div>
        <!-- End preloader  -->
        <div class="request-loader">
            <img src="{{ asset('assets/admin/img/loader.gif') }}" alt="">
        </div>


        @if ($activeTheme == 'seabbq')
            @include('user-front.seabbq-desifoodie-desices.seabbq.partials.header')
        @endif
        @if ($activeTheme == 'desifoodie')
            @include('user-front.seabbq-desifoodie-desices.desifoodie.partials.header')
        @endif
        @if ($activeTheme == 'desices')
            @include('user-front.seabbq-desifoodie-desices.desices.partials.header')
        @endif
        @yield('content')

        <!--whatsapp button-->
        <div id="WAButton"></div>

        <!-- cookie alert -->
        @if ($userBe->cookie_alert_status == 1)
            <div class="cookie">
                @include('cookie-consent::index')
            </div>
        @endif

        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
        @if ($activeTheme == 'seabbq')
            @include('user-front.seabbq-desifoodie-desices.seabbq.partials.footer')
        @endif
        @if ($activeTheme == 'desifoodie')
            @include('user-front.seabbq-desifoodie-desices.desifoodie.partials.footer')
        @endif
        @if ($activeTheme == 'desices')
            @include('user-front.seabbq-desifoodie-desices.desices.partials.footer')
        @endif

        @include('user-front.partials.variation-modal')
        @include('user-front.seabbq-desifoodie-desices.call-waiter-modal')
    </div>

    <script>
        "use strict";
        const mainurl = "{{ url('/') }}";
        let userCheckoutUrl = "{{ route('user.front.add.cart', [getParam(), ':id']) }}";
        const lat = '{{ $userBs->latitude }}';
        const sessionLang = '{{ session()->get('user_lang') }}';
        const currentLang = '{{ $userCurrentLang->code }}';
        const lng = '{{ $userBs->longitude }}';
        const rtl = {{ $rtl }};
        const position = "{{ $userBe->base_currency_symbol_position }}";
        const symbol = "{{ $userBe->base_currency_symbol }}";
        const textPosition = "{{ $userBe->base_currency_text_position }}";
        const currText = "{{ $userBe->base_currency_text }}";
        const vap_pub_key = "{{ $userBex->VAPID_PUBLIC_KEY }}";
        const pathName = "{{ getParam() }}";
        var pusherAppKey = "{{ $userBe->pusher_app_key ?? '' }}";
        var pusherCluster = "{{ $userBe->pusher_app_cluster ?? '' }}";
        var demo_mode = "{{ env('DEMO_MODE') }}";

        const offlineImg = "{{ public_path('/assets/front/img/offline.png') }}";
        let select = "{{ $keywords['Select'] ?? __('Select') }}";
    </script>

    @yield('script')
    <script src="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/js/vendor/toastr.min.js"></script>
    <script src="{{ asset('assets/front/js/cart.js') }}"></script>
    <script src="{{ asset('assets/front/js/whatsapp.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pusher.js') }}"></script>

    <!-- Toastr Script -->
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

    @include('user-front.seabbq-desifoodie-desices.plugins')
</body>

</html>
