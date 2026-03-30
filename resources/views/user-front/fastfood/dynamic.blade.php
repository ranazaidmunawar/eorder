@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

@extends('user-front.layout')
@section('pageHeading')
    {{ convertUtf8($page->title) }}
@endsection
@section('pagename')
    - {{ convertUtf8($page->title) }}
@endsection

@section('meta-keywords', "$page->meta_keywords")
@section('meta-description', "$page->meta_description")

@section('content')
   
     <section class="page-title-area d-flex align-items-center"
    style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{ convertUtf8($page->title) }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.front.index', getParam()) }}"><i
                                            class="flaticon-home"></i>{{ $keywords['Home'] ?? __('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ convertUtf8($page->title) }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="experience-area-3 pt-100 pb-90">
        <div class="container">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="tinymce-content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>
 
@endsection
