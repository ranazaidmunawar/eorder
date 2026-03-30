@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

@extends('user-front.layout')
@section('pageHeading')
 {{ $keywords['Success'] ?? __('Success') }}
@endsection
@section('content')


     <section class="page-title-area d-flex align-items-center lazy"
             data-bg="{{$userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB,$userBs->breadcrumb,$userBs) : asset('assets/restaurant/images/breadcrum.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{$keywords['Success'] ?? __("Success")}}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.front.index',getParam())}}"><i
                                            class="flaticon-home"></i>{{$keywords['Home'] ?? __('Home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$keywords['Success'] ?? __("Success")}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="checkout-message">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="checkout-success">
                        <div class="icon text-success"><i class="far fa-check-circle"></i></div>
                        <h2>{{$keywords['Success'] ?? __('Success')}}!</h2>
                        @if (!empty($order->token_no))
                            <p class="mb-0">{{$keywords['Token No'] ?? __('Token No')}}:
                                <strong class="text-danger">
                                    {{$order->token_no}}
                                </strong>
                            </p>
                        @endif
                        <p class="mb-0">{{$keywords['Order Number'] ?? __('Order Number')}}: <strong
                                class="text-danger">#{{$orderNum ?? ''}}</strong></p>
                        <p class="mb-0">{{$keywords['We have sent you a mail with an invoice'] ?? __('We have sent you a mail with an invoice.')}}</p>
                        <p class="mt-3">{{$keywords['Thank you '] ?? __('Thank you')}}</p>
                        <a class="main-btn main-btn-2 mt-4"
                           href="{{route('user.front.index',getParam())}}">{{$keywords['Return_to_Website'] ?? __('Return to Website')}}</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
