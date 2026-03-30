@php
    use App\Http\Helpers\Uploader;
    use App\Constants\Constant;
@endphp
<!doctype html>
<html lang="en" >

<head>
 
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <title>Offline | {{ $userBs->website_title }}</title>


    <link rel="shortcut icon" href="{{ Uploader::getImageUrl(Constant::WEBSITE_FAVICON,$userBs->favicon,$userBs) }}" type="image/png">


    <link rel="stylesheet" href="{{ asset('assets/front/css/plugin.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/front/css/default.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/front/css/styles.php?color=' . str_replace('#', '', $userBs->base_color)) }}">
    @if ($rtl == 1)
        <link rel="stylesheet" href="{{ asset('assets/front/css/rtl.css') }}">
    @endif


    <script src="{{ asset('assets/front/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/vendor/jquery.3.2.1.min.js') }}"></script>

    <link rel="manifest" href="{{('manifest.json')}}">
</head>

<body>

      <div class="error-container">
         <div>
            <div class="offline text-center">
               <img src="{{ asset('assets/front/img/static/offline.png') }}" alt="">
            </div>
            <div class="error-txt">
               <h2>{{$keywords["Sorry, you're offline."] ?? __("Sorry, you're offline.")}}...</h2>
            </div>
         </div>
      </div>
    

</body>

</html>
