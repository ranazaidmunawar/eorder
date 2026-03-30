@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Home'] ?? __('Home') }}
@endsection
@section('style')
    @include('user-front.medicine.include.medicine_css')
@endsection
@section('content')
    <!--===Start Hero Section====--->
    @includeIf('user-front.medicine.heroSeaction')
    <!---===End Hero Section ==-->
    <!---Start Feature  Section--->
    @if ($userBs->feature_section == 1)
        @includeIf('user-front.medicine.featureSection')
    @endif
    <!---end Feature Section-->
    <!---Start Intro Section--->
    @if ($userBs->intro_section == 1)
        @includeIf('user-front.medicine.introSection')
    @endif
    <!---end Intro Section-->


    <!-- Start menu Section -->
    @if ($userBs->menu_section == 1)
        @includeIf('user-front.medicine.categoryProductSection')
    @endif
    <!-- End menu Section -->


    <!--===Start spaecial section --==-->
    @if ($userBs->special_section == 1)
        @includeIf('user-front.medicine.specialSection')
    @endif
    <!--===End spaecial section === ---->

    <!---Start Testimonial Section ---->
    @if ($userBs->testimonial_section == 1)
        @includeIf('user-front.medicine.testimoialSection')
    @endif
    <!---End Testimonial Section --==-->
@endsection
@section('script')
    @include('user-front.medicine.include.medicine_js')
@endsection
