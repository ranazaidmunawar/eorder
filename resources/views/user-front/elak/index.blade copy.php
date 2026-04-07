@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Home'] ?? __('Home') }}
@endsection
@section('style')
    @include('user-front.elak.include.elak_css')
@endsection

@section('content')
    <!-- Home-area start-->
    <!--===Start Hero Section====--->
    @includeIf('user-front.elak.heroSeaction')
    <!---===End Hero Section ==-->

    <!---Start Feature  Section--->
    @if ($userBs->feature_section == 1)
        @includeIf('user-front.elak.featureSection')
    @endif
    <!---end Feature Section-->

    <!---Start Intro Section--->
    @if ($userBs->intro_section == 1)
        @includeIf('user-front.elak.introSection')
    @endif
    <!---end Intro Section-->

    <!-- Start menu Section -->
    @if ($userBs->menu_section == 1)
        @includeIf('user-front.elak.categoryProductSection')
    @endif
    <!-- End menu Section -->

    <!--===Start spaecial section --==-->
    @if ($userBs->special_section == 1)
        @includeIf('user-front.elak.specialSection')
    @endif
    <!--===End spaecial section --==-->

    @if ($userBs->testimonial_section == 1)
        @includeIf('user-front.elak.testimoialSection')
    @endif

    <!---Start Blog Section-->
    @if ($userBs->news_section == 1)
        @includeIf('user-front.elak.blogSection')
    @endif
@endsection

@section('script')
    @include('user-front.elak.include.elak_js')
@endsection
