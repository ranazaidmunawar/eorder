@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Table;
    use App\Models\User\Ulink;
    use Illuminate\Support\Facades\Auth;
    $oldThemes = ['fastfood', 'bakery', 'pizza', 'coffee', 'medicine', 'grocery', 'beverage'];
    $newThemes = ['seabbq', 'desifoodie', 'desices'];
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{ $userCurrentLang->rtl == 1 ? 'rtl' : '' }}">

<head>
    @if ($userBs->is_analytics == 1)
        <script async src="//www.googletagmanager.com/gtag/js?id={{ $userBs->measurement_id }}"></script>
        <script>
            "use strict";
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '{{ $userBs->measurement_id }}');
        </script>
    @endif

    <meta charset="utf-8">
    @if (is_array($packagePermissions) && in_array('PWA Installability', $packagePermissions))
        <link rel="manifest" crossorigin="use-credentials" href="{{ request()->root() . '/assets/pwa/manifest.json' }}" />
    @endif
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


    @if ($userBs->is_recaptcha == 1)
        <script type="text/javascript">
            var onloadCallback = function() {
                if ($("#g-recaptcha").length > 0) {
                    grecaptcha.render('g-recaptcha', {
                        'sitekey': '{{ $userBs->google_recaptcha_site_key }}'
                    });
                }
            };
        </script>
    @endif
    @include('user-front.partials.dynamic-css')
    <!--plugin css start -->
    @includeIf('user-front.plugin_css')
    <!--plugin css end -->

    <!--fastfood theme css start-->
    @includeIf('user-front.themes_css')
    <!--fastfood theme css end-->

    @yield('style')

    <!-- Theme wise Header & Footer css start-->
    @include('user-front.themes_header_footer_css')
    <!-- Theme wise Header & Footer css end-->

    @includeIf('user-front.plugin_js')

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
            --bs-primary-rgb: {{ hexToRgba($primaryColor) }};
            --color-primary: {{ $primaryColor }};
            --color-primary-rgb: {{ hexToRgba($primaryColor) }}
        }
    </style>
    @if ($activeTheme == 'desices')
        <link rel="stylesheet" href="{{ asset('assets/restaurant/seabbq-desifoodie-desices') }}/css/theme-12-common.css">
    @endif
</head>


<body class="{{ $activeTheme == 'bakery' ? 'theme-dark' : '' }} theme-{{ $userBs->theme }}">
    @if (in_array($userBs->theme, $newThemes))
        <div class="pages">
    @endif

    <!------- preloader start -->
    @if ($userBs->preloader_status == 1)
        <div id="preloader">
            <div class="loader revolve">
                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRELOADER, $userBs->preloader, $userBs) }}"
                    alt="">
            </div>
        </div>
    @endif
    <div class="request-loader">
        <img src="{{ asset('assets/admin/img/loader.gif') }}" alt="">
    </div>
    <!------- preloader end -->


    <!-- theme wise header start-->
    @include('user-front.themes_header')
    <!-- theme wise header end-->

    @yield('content')

    <!-- theme wise footer start-->
    @include('user-front.themes_footer')
    <!-- theme wise footer end-->

    @includeIf('user-front.partials.popups')

    <!-- variation modal start-->
    @include('user-front.partials.variation-modal')
    <!-- variation modal end-->


    <!-- go-top start-->
    @if ($activeTheme == 'fastfood')
        <div class="go-top-area">
            <div class="go-top-wrap">
                <div class="go-top-btn-wrap">
                    <div class="go-top go-top-btn">
                        <i class="fa fa-angle-double-up"></i>
                        <i class="fa fa-angle-double-up"></i>
                    </div>
                </div>
            </div>
        </div>
    @elseif(in_array($userBs->theme, $newThemes))
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
    @else
        <!-- <div class="go-top"><i class="fal fa-angle-up"></i></div> -->
    @endif
    <!-- go-top end-->

    <!-- whatsapp button start-->
    {{-- <div id="WAButton"></div> --}}
    <!-- whatsapp button end-->

    <!-- cookie alert start-->
    @if ($userBe->cookie_alert_status == 1)
        <div class="cookie">
            @include('cookie-consent::index')
        </div>
    @endif
    <!-- cookie alert end-->

    <!-- call waiter modal start-->
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
                        $tables = Table::query()->where('status', 1)->where('user_id', $user->id)->get();
                    @endphp
                    <form id="callWaiterForm" action="{{ route('user.front.call.waiter', getParam()) }}"
                        method="GET">
                        <select class="form-control" name="table" required>
                            <option value="" disabled selected>
                                {{ $keywords['Select a Table'] ?? __('Select a Table') }}
                            </option>
                            @foreach ($tables as $table)
                                <option value="{{ $table->table_no }}">{{ $keywords['Table'] ?? __('Table') }} -
                                    {{ $table->table_no }}
                                </option>
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
    <!-- call waiter modal end-->

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
    @include('user-front.themes_js')


    <!-- Theme wise Header & Footer js start-->
    @include('user-front.themes_header_footer_js')
    <!-- Theme wise Header & Footer js end-->


    @if ($userCurrentLang?->datepicker_name)
        <script>
            var datepickerpath =
                "{{ asset('assets/tenant/js/i18n/' . $userCurrentLang->datepicker_name . '-' . $userCurrentLang->code . '.js') }}";
            $(function() {

                $.getScript(datepickerpath)
                    .done(function() {

                        $("input.datepicker").datepicker({
                            minDate: 0,
                            dayNames: $.datepicker.regional[currentLang].dayNames,
                            monthNames: $.datepicker.regional[currentLang].monthNames,

                        });
                    })
                    .fail(function() {

                    });

            });
        </script>
    @endif

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

    @if ($userBs->is_facebook_pixel == 1)
        <!-- Meta Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $userBs->pixel_id }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $userBs->pixel_id }}&ev=PageView&noscript=1" /></noscript>
        <!-- End Meta Pixel Code -->
    @endif

    {{-- whatsapp init code --}}
    {{-- @if ($userBs->is_whatsapp == 1)
        <script type="text/javascript">
            "use strict";
            var whatsapp_popup = {{ $userBs->whatsapp_popup }};
            var whatsappImg = "{{ asset('assets/front/img/whatsapp.svg') }}";
            $(function() {
                $('#WAButton').floatingWhatsApp({
                    phone: "{{ $userBs->whatsapp_number }}", //WhatsApp Business phone number
                    headerTitle: "{{ $userBs->whatsapp_header_title }}", //Popup Title
                    popupMessage: `{!! !empty($userBs->whatsapp_popup_message) ? nl2br($userBs->whatsapp_popup_message) : '' !!}`, //Popup Message
                    showPopup: whatsapp_popup == 1 ? true : false, //Enables popup display
                    buttonImage: '<img src="' + whatsappImg + '" />', //Button Image
                    position: "left" //Position: left | right

                });
            });
        </script>
    @endif --}}

    @if ($userBs->is_tawkto == 1)
        <!--Start of Tawk.to Script-->
        @php
            $directLink = str_replace('tawk.to', 'embed.tawk.to', $userBs->tawkto_direct_chat_link);
            $directLink = str_replace('chat/', '', $directLink);
        @endphp
        <script type="text/javascript">
            "use strict";
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = '{{ $directLink }}';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>

        <!--End of Tawk.to Script-->
    @endif

    @if (in_array($userBs->theme, $newThemes))
        </div>
    @endif

</body>

</html>
