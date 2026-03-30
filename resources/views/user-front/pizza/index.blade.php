@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Home'] ?? __('Home') }}
@endsection
@section('style')
    @include('user-front.pizza.include.pizza_css')
@endsection

@section('content')
    <!-- Home-area start-->
    <!--===Start Hero Section====--->
    @includeIf('user-front.pizza.heroSeaction')
    <!---===End Hero Section ==-->

    <!---Start Feature  Section--->
    @if ($userBs->feature_section == 1)
        @includeIf('user-front.pizza.featureSection')
    @endif
    <!---end Feature Section-->

    <!---Start Intro Section--->
    @if ($userBs->intro_section == 1)
        @includeIf('user-front.pizza.introSection')
    @endif
    <!---end Intro Section-->

    <!-- Start menu Section -->
    @if ($userBs->menu_section == 1)
        @includeIf('user-front.pizza.categoryProductSection')
    @endif
    <!-- End menu Section -->

    <!--===Start spaecial section --==-->
    @if ($userBs->special_section == 1)
        @includeIf('user-front.pizza.specialSection')
    @endif
    <!--===End spaecial section --==-->

    @if ($userBs->testimonial_section == 1)
        @includeIf('user-front.pizza.testimoialSection')
    @endif

    <!---Start Blog Section-->
    @if ($userBs->news_section == 1)
        @includeIf('user-front.pizza.blogSection')
    @endif
@endsection

@section('script')
    @include('user-front.pizza.include.pizza_js')
@endsection
