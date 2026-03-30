@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
<html lang="en">
<head>
    <title>{{$userBs->website_title}} - Maintenance Mode</title>

    <link rel="shortcut icon" href="{{Uploader::getImageUrl(Constant::WEBSITE_FAVICON,$userBs->favicon,$userBs)}}" type="image/x-icon">
  
    <link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/503.css')}}">
</head>
<body>
<div class="container">
    <div class="content">
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <div class="maintain-img-wrapper">
                    <img src="{{Uploader::getImageUrl(Constant::WEBSITE_MAINTENANCE,$userBs->maintenance_img,$userBs)}}"
                        alt="">
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 offset-lg-3">
                <h3 class="maintain-txt">
                    {!! replaceBaseUrl($userBs->maintenance_text) !!}
                </h3>
            </div>
        </div>
    </div>
</div>
</body>
</html>
