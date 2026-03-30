<!DOCTYPE html>
<html lang="en" @if ($rtl == 1) dir="rtl" @endif>

<head>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="@yield('meta-description')">
  <meta name="keywords" content="@yield('meta-keywords')">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  @yield('og-meta')

  <title>{{ $bs->website_title }} @yield('pagename')</title>
  <link rel="shortcut icon" href="{{ asset('assets/front/img/' . $bs->favicon) }}" type="image/png">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Rubik:wght@400;500;600&display=swap">

  <link rel="stylesheet" href="{{ asset('assets/restaurant/css/bootstrap.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/restaurant/fonts/fontawesome/css/all.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/restaurant/css/font-gigo.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/restaurant/css/toastr.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/restaurant/css/magnific-popup.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/restaurant/css/swiper-bundle.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/restaurant/css/aos.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/restaurant/css/nice-select.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/restaurant/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/tinymce-content.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/front/css/whatsapp.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/restaurant/css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/front/css/cookie-alert.css') }}">
  @if ($rtl == 1)
    <link rel="stylesheet" href="{{ asset('assets/restaurant/css/rtl.css') }}">
  @endif

  @yield('styles')

  @if ($bs->is_whatsapp == 0 && $bs->is_tawkto == 0)
    <style>
      .go-top {
        left: auto;
        right: 30px;
      }
    </style>
  @endif

  <style>
    :root {
      --color-primary: #{{ $bs->base_color }};
      --color-primary-shade: #{{ $bs->base_color2 }};
      --bg-light: #{{ $bs->base_color2 }}14;
    }
  </style>
</head>

<body>


  @if ($bs->preloader_status == 1)
    <div id="preLoader">
      <div class="loader">
        <img src="{{ $bs->preloader ? asset('assets/front/img/' . $bs->preloader) : '' }}" alt="">
      </div>
    </div>
  @endif

  @includeIf('front.partials.header')

  @if (!request()->routeIs('front.index'))
    <div class="page-title-area bg-img"
      style="background-image: url('{{ $bs->breadcrumb ? asset('assets/front/img/' . $bs->breadcrumb) : '' }}');">
      <div class="container">
        <div class="content text-center" data-aos="fade-up">
          <h2>@yield('breadcrumb-title')</h2>
          <ul class="list-unstyled">
            <li class="d-inline"><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
            <li class="d-inline">/</li>
            <li class="d-inline active">@yield('breadcrumb-link')</li>
          </ul>
        </div>
      </div>
    </div>
  @endif

  @yield('content')


  @includeIf('front.partials.footer')

  <a href="#" class="go-top"><i class="fal fa-angle-double-up"></i></a>


  @includeIf('front.partials.popups')

  <div class="cursor"></div>

  <div id="WAButton"></div>

  <script>
    var demo_mode = "{{ env('DEMO_MODE') }}";
  </script>

  <script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>

  <script src="{{ asset('assets/front/js/popper.min.js') }}"></script>

  <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>

  <script src="{{ asset('assets/front/js/jquery.nice-select.min.js') }}"></script>

  <script src="{{ asset('assets/front/js/jquery.magnific-popup.min.js') }}"></script>

  <script src="{{ asset('assets/front/js/swiper-bundle.min.js') }}"></script>

  <script src="{{ asset('assets/front/js/lazysizes.min.js') }}"></script>

  <script src="{{ asset('assets/front/js/aos.min.js') }}"></script>

  <script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>

  <script src="{{ asset('assets/front/js/whatsapp.min.js') }}"></script>

  <script src="{{ asset('assets/front/js/script.js') }}"></script>

  <script>
    var showmore = "{{ __('Show More') }}"
    var showless = "{{ __('Show Less') }}"
  </script>


  @if ($rtl == 1)
    <script>
      var showmore = "{{ __('Show More') }}"
      var showless = "{{ __('Show Less') }}"
    </script>
    <link rel="stylesheet" href="{{ asset('assets/front/js/rtl-script.js') }}">
  @endif

  <script>
    "use strict";
    var rtl = {{ $rtl }};
  </script>

  @yield('scripts')

  @yield('vuescripts')


  @if (session()->has('success'))
    <script>
      "use strict";
      toastr['success']("{{ __(session('success')) }}");
    </script>
  @endif

  @if (session()->has('error'))
    <script>
      "use strict";
      toastr['error']("{{ __(session('error')) }}");
    </script>
  @endif

  @if (session()->has('warning'))
    <script>
      "use strict";
      toastr['warning']("{{ __(session('warning')) }}");
    </script>
  @endif
  <script>
    "use strict";

    function handleSelect(elm) {
      window.location.href = "{{ route('changeLanguage', '') }}" + "/" + elm.value;
    }
  </script>


  {{-- whatsapp init code --}}
  @if ($bs->is_whatsapp == 1)
    <script type="text/javascript">
      "use strict";
      var whatsapp_popup = {{ $bs->whatsapp_popup }};
      var whatsappImg = "{{ asset('assets/front/img/whatsapp.svg') }}";
      $(function() {
        $('#WAButton').floatingWhatsApp({
          phone: "{{ $bs->whatsapp_number }}", //WhatsApp Business phone number
          headerTitle: "{{ $bs->whatsapp_header_title }}", //Popup Title
          popupMessage: `{!! !empty($bs->whatsapp_popup_message) ? nl2br($bs->whatsapp_popup_message) : '' !!}`, //Popup Message
          showPopup: whatsapp_popup == 1 ? true : false, //Enables popup display
          buttonImage: '<img src="' + whatsappImg + '" />', //Button Image
          position: "right" //Position: left | right

        });
      });
    </script>
  @endif


  @if ($bs->is_tawkto == 1)
    @php
      $directLink = str_replace('tawk.to', 'embed.tawk.to', $bs->tawkto_chat_link);
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
  @endif

  @if ($be->cookie_alert_status == 1)
    <div class="cookie">
      @include('cookie-consent::index')
    </div>
  @endif
</body>

</html>
