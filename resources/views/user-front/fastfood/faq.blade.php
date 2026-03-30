@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

@extends("user-front.layout")
@section('pageHeading')
{{ $keywords['FAQ'] ?? __('FAQ') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->faqs_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->faqs_meta_description : '')
@section('content')

  @include('user-front.breadcrum',['title' => $upageHeading?->faq_page_title])

    <div class="faq-section">
        @if($faqs->count() > 0)
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="accordion" id="accordionExample1">
                        @for ($i=0; $i < ceil(count($faqs)/2); $i++)
                            <div class="card">
                                <div class="card-header" id="heading{{$faqs[$i]->id}}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapse{{$faqs[$i]->id}}"
                                                aria-expanded="false" aria-controls="collapse{{$faqs[$i]->id}}">
                                            {{convertUtf8($faqs[$i]->question)}}
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse{{$faqs[$i]->id}}" class="collapse"
                                     aria-labelledby="heading{{$faqs[$i]->id}}" data-parent="#accordionExample1">
                                    <div class="card-body">
                                        {{convertUtf8($faqs[$i]->answer)}}
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion" id="accordionExample2">
                        @for ($i=ceil(count($faqs)/2); $i < count($faqs); $i++)
                            <div class="card">
                                <div class="card-header" id="heading{{$faqs[$i]->id}}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapse{{$faqs[$i]->id}}"
                                                aria-expanded="false" aria-controls="collapse{{$faqs[$i]->id}}">
                                            {{convertUtf8($faqs[$i]->question)}}
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse{{$faqs[$i]->id}}" class="collapse"
                                     aria-labelledby="heading{{$faqs[$i]->id}}" data-parent="#accordionExample2">
                                    <div class="card-body">
                                        {{convertUtf8($faqs[$i]->answer)}}
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center text-center bg-light py-5">
                    <h3>{{ $keywords['NO_FAQ_FOUND!'] ?? __('NO FAQ FOUND!') }}</h3>
                </div>
            </div>
        </div>
        @endif
    </div>

@endsection
