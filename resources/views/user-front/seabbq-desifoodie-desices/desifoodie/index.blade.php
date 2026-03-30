@extends('user-front.seabbq-desifoodie-desices.layout')
@section('pageHeading')
    {{ $keywords['Home'] ?? __('Home') }}
@endsection
@section('style')
    @include('user-front.seabbq-desifoodie-desices.desifoodie.include.css')
@endsection
@section('content')
    @include('user-front.seabbq-desifoodie-desices.desifoodie.heroSeaction')
    @if ($userBs->featured_category_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desifoodie.featured-category')
    @endif

    @if ($userBs->intro_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desifoodie.introSection')
    @endif

    @if ($userBs->special_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desifoodie.specialItem')
    @endif

    @if ($userBs->banner_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desifoodie.banner')
    @endif

    @if ($userBs->menu_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desifoodie.featured-item')
    @endif

    @if ($userBs->affordable_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desifoodie.offer-items')
    @endif

    @if ($userBs->testimonial_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desifoodie.testimonial')
    @endif

    @if ($userBs->news_section == 1)
        @include('user-front.seabbq-desifoodie-desices.desifoodie.blog')
    @endif
@endsection
@section('script')
    @include('user-front.seabbq-desifoodie-desices.desifoodie.include.script')
@endsection
