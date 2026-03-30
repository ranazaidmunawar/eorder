@extends('user-front.seabbq-desifoodie-desices.layout')
@section('pageHeading')
    {{ $keywords['Home'] ?? __('Home') }}
@endsection
@section('style')
    @include('user-front.seabbq-desifoodie-desices.seabbq.include.css')
@endsection
@section('content')
    @include('user-front.seabbq-desifoodie-desices.seabbq.heroSeaction')

    @if ($userBs->intro_section == 1)
        @include('user-front.seabbq-desifoodie-desices.seabbq.introSection')
    @endif

    @if ($userBs->special_section == 1)
        @include('user-front.seabbq-desifoodie-desices.seabbq.specialItem')
    @endif

    @if ($userBs->banner_section == 1)
        @include('user-front.seabbq-desifoodie-desices.seabbq.banner')
    @endif

    @if ($userBs->menu_section == 1)
        @include('user-front.seabbq-desifoodie-desices.seabbq.featured-item')
    @endif

    @if ($userBs->affordable_section == 1)
        @include('user-front.seabbq-desifoodie-desices.seabbq.offer-items')
    @endif

    @if ($userBs->testimonial_section == 1)
        @include('user-front.seabbq-desifoodie-desices.seabbq.testimonial')
    @endif

    @if ($userBs->news_section == 1)
        @include('user-front.seabbq-desifoodie-desices.seabbq.blog')
    @endif
@endsection
@section('script')
    @include('user-front.seabbq-desifoodie-desices.seabbq.include.script')
@endsection
