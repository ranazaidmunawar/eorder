@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Home'] ?? __('Home') }}
@endsection
@section('style')
    @includeIf('user-front.sushi.include.sushi_css')
@endsection
<style>
.toast-success, .toast-error, .toast-warning, .toast-info {
    background: #0f5156 !important;
    background-image: none !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}
.toast-success::before, .toast-error::before, .toast-warning::before, .toast-info::before {
    display: none !important;
}
</style>

@section('content')
    <!-- Home-area start-->
    <!--===Start Hero Section====--->
    @includeIf('user-front.sushi.heroSeaction')
    <!---===End Hero Section ==-->

  <!-- Start menu Section -->
    @if ($userBs->menu_section == 1)
        @includeIf('user-front.sushi.categoryProductSection')
    @endif
    <!-- End menu Section -->
  
 
@endsection

@section('script')
    @includeIf('user-front.sushi.include.sushi_js')
@endsection
