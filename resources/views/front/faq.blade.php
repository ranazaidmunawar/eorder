@extends('front.layout')

@section('pagename')
    - {{__('FAQs')}}
@endsection

@section('meta-description', !empty($seo) ? $seo->faqs_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->faqs_meta_keywords : '')

@section('breadcrumb-title')
    {{__('FAQ')}}
@endsection
@section('breadcrumb-link')
    {{__('FAQ')}}
@endsection

@section('content')

   
    <div id="faq" class="faq-area pt-120 pb-90">
        <div class="container">
            <div class="accordion" id="faqAccordion">
                <div class="row">
                    <div class="col-lg-6 has-time-line" data-aos="fade-right">
                        <div class="row">
                            @for ($i=0; $i < ceil(count($faqs)/2); $i++)
                                <div class="col-12">
                                    <div class="accordion-item">
                                        <h6 class="accordion-header" id="heading{{$faqs[$i]->id}}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{$faqs[$i]->id}}" aria-expanded="true"
                                                    aria-controls="collapse{{$faqs[$i]->id}}">
                                                {{$faqs[$i]->question}}
                                            </button>
                                        </h6>
                                        <div id="collapse{{$faqs[$i]->id}}"
                                             class="accordion-collapse collapse {{$i == 0 ? 'show':''}}"
                                             aria-labelledby="heading{{$faqs[$i]->id}}" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <p>{{$faqs[$i]->answer}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="row">
                            @for ($i=ceil(count($faqs)/2); $i < count($faqs); $i++)
                                <div class="col-12">
                                    <div class="accordion-item">
                                        <h6 class="accordion-header" id="heading{{$faqs[$i]->id}}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{$faqs[$i]->id}}" aria-expanded="true"
                                                    aria-controls="collapse{{$faqs[$i]->id}}">
                                                {{$faqs[$i]->question}}
                                            </button>
                                        </h6>
                                        <div id="collapse{{$faqs[$i]->id}}"
                                             class="accordion-collapse collapse {{$i == 0 ? 'show':''}}"
                                             aria-labelledby="heading{{$faqs[$i]->id}}" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <p>{{$faqs[$i]->answer}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
@endsection
