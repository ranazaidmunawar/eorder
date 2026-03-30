
<script src="{{asset('assets/admin/js/plugin/webfont/webfont.min.js')}}"></script>
<script>
  "use strict";
  WebFont.load({
    google: {"families":["Lato:300,400,700,900"]},
    custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{asset('assets/admin/css/fonts.min.css')}}']},
    active: function() {
      sessionStorage.fonts = true;
    }
  });
</script>


<link rel="stylesheet" href="{{asset('assets/admin/css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/fontawesome-iconpicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/dropzone.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/jquery.dm-uploader.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-datepicker.min.css')}}">
{{-- <link rel="stylesheet" href="{{ asset('assets/front/css/plugin.min.css') }}"> --}}
<link rel="stylesheet" href="{{asset('assets/front/css/jquery-ui.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/jquery.timepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/mdtimepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/atlantis.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/custom.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/tenant/css/version-header.css')}}"> --}}
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }
    input:checked + .slider {
        background-color: #17d909;
    }
    input:focus + .slider {
        box-shadow: 0 0 1px #17d909;
    }
    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }
    .slider.round:before {
        border-radius: 50%;
    }
</style>

@if(request()->cookie('user-theme') == 'dark')
    <link rel="stylesheet" href="{{asset('assets/admin/css/dark.css')}}">
@endif

@yield('styles')
