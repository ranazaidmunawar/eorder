@extends('front.layout')

@section('pagename')
    - {{$page->name}}
@endsection

@section('meta-description', !empty($page) ? $page->meta_keywords : '')
@section('meta-keywords', !empty($page) ? $page->meta_description : '')

@section('breadcrumb-title')
    {{$page->title}}
@endsection
@section('breadcrumb-link')
    {{$page->name}}
@endsection

@section('content')
  
    <section class="terms-condition-area pt-120 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 m-auto">
                    <div class="item-single mb-30" data-aos="fade-up">
                        {!! replaceBaseUrl($page->body) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
   
@endsection
