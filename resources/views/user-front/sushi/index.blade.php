@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Home'] ?? __('Home') }}
@endsection
@section('style')
    @includeIf('user-front.sushi.include.sushi_css')
@endsection

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
