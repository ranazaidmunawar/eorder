@php
    use App\Models\Package;
@endphp
@extends('front.layout')

@section('pagename')
    - {{ __('Templates') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->pricing_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->pricing_meta_keywords : '')

@section('breadcrumb-title')
    {{ __('Templates') }}
@endsection
@section('breadcrumb-link')
    {{ __('Templates') }}
@endsection

@section('content')

    @if ($bs->template_section == 1)
        <section class="template-area pt-120 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row justify-content-center">

                            @foreach ($templates as $template)
                                <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-delay="50">
                                    <div class="card text-center mb-30">
                                        <div class="card-image">
                                            <a href="{{ detailsUrl($template) }}" class="lazy-container" target="_blank">
                                                <img class="lazyload lazy-image"
                                                    data-src="{{ asset('assets/front/img/template-previews/' . $template->template_img) }}"
                                                    alt="Demo Image" />
                                            </a>
                                        </div>
                                        <h4 class="py-3 theme-name">{{ $template->theme_name }}</h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
