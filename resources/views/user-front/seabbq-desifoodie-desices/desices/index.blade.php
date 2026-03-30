@extends('user-front.seabbq-desifoodie-desices.layout')
@section('pageHeading')
    {{ $keywords['Home'] ?? __('Home') }}
@endsection
@section('style')
    @include('user-front.seabbq-desifoodie-desices.desices.include.css')
@endsection
@section('content')
    @include('user-front.seabbq-desifoodie-desices.desices.heroSeaction')
    @if ($userBs->featured_category_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desices.featured-category')
    @endif

    @if ($userBs->intro_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desices.introSection')
    @endif

    @if ($userBs->special_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desices.specialItem')
    @endif

    @if ($userBs->banner_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desices.banner')
    @endif

    @if ($userBs->menu_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desices.featured-item')
    @endif

    @if ($userBs->affordable_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desices.offer-items')
    @endif

    @if ($userBs->testimonial_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desices.testimonial')
    @endif

    @if ($userBs->news_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desices.blog')
    @endif
@endsection
@section('script')
    @include('user-front.seabbq-desifoodie-desices.desices.include.script')
@endsection
