@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Home'] ?? __('Home') }}
@endsection
@section('style')
    @include('user-front.grocery.include.grocery_css')
@endsection
@section('content')
    <!--===Start Hero Section====--->
    @includeIf('user-front.grocery.heroSeaction')
    <!---===End Hero Section ==-->


    <!---Start Feature  Section--->
    @if ($userBs->feature_section == 1)
        @includeIf('user-front.grocery.featureSection')
    @endif
    <!---end Feature Section-->


    <!---Start Intro Section--->
    @if ($userBs->intro_section == 1)
        @includeIf('user-front.grocery.introSection')
    @endif
    <!---end Intro Section-->



    <!-- Start menu Section -->
    @if ($userBs->menu_section == 1)
        @includeIf('user-front.grocery.categoryProductSection')
    @endif
    <!-- End menu Section -->


    <!--===Start spaecial section --==-->
    @if ($userBs->special_section == 1)
        @includeIf('user-front.grocery.specialSection')
    @endif
    <!--===End spaecial section === ---->

    <!---Start Testimonial Section ---->
    @if ($userBs->testimonial_section == 1)
        @includeIf('user-front.grocery.testimoialSection')
    @endif
    <!---End Testimonial Section --==-->


    <!---Start Blog Section-->
    @if ($userBs->news_section == 1)
        @includeIf('user-front.grocery.blogSection')
    @endif
    <!-- end Blog Section -->
@endsection
@section('script')
    @include('user-front.grocery.include.grocery_js')
@endsection
