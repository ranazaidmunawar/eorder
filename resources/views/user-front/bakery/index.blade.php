@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Home'] ?? __('Home') }}
@endsection
@section('style')
    @include('user-front.bakery.include.bakery_css')
@endsection
@section('content')
    <!--===Start Hero Section====--->
    @includeIf('user-front.bakery.heroSeaction')
    <!---===End Hero Section ==-->

    <!---Start Intro Section--->
    @if ($userBs->intro_section == 1)
        @includeIf('user-front.bakery.introSection')
    @endif
    <!---end Intro Section-->

    <!---Start Feature  Section--->
    @if ($userBs->feature_section == 1)
        @includeIf('user-front.bakery.featureSection')
    @endif
    <!---end Feature Section-->

    <!-- Start menu Section -->
    @if ($userBs->menu_section == 1)
        @includeIf('user-front.bakery.categoryProductSection')
    @endif
    <!-- End menu Section -->

    <!--===Start spaecial section --==-->
    @if ($userBs->special_section == 1)
        @includeIf('user-front.bakery.specialSection')
    @endif
    <!--===End spaecial section === ---->

    <!---Start Testimonial Section ---->
    @if ($userBs->testimonial_section == 1)
        @includeIf('user-front.bakery.testimoialSection')
    @endif
    <!---End Testimonial Section --==-->


    <!---Start Blog Section-->
    @if ($userBs->news_section == 1)
        @includeIf('user-front.bakery.blogSection')
    @endif
    <!-- end Blog Section -->
@endsection
@section('script')
    @include('user-front.bakery.include.bakery_js')
@endsection
