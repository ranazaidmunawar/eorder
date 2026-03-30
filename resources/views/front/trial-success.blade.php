@extends('front.layout')

@section('pagename')
    - {{__('Success')}}
@endsection
@section('breadcrumb-title')
    {{__('Success')}}
@endsection
@section('breadcrumb-link')
    {{__('Success')}}
@endsection

@section('content')
<div class="container ptb-120">
    <div class="row align-items-center gx-xl-5">
        <div class="col-md-6 mx-auto">
            <div class="payment-img mb-30">
                <img src="{{asset('assets/front/images/success.svg')}}" alt="Success Illustration">
            </div>
        </div>
        <div class="col-md-6 mx-auto" id="mt">
            <div class="payment mb-30">
                <div class="content">
                    <h2 class="mb-4">{{__('trial_success')}}</h2>
                    <p class="paragraph-text mb-4">
                        {{__('trial_success_msg')}}
                    </p>
                    <a href="{{route('front.index')}}" class="btn primary-btn">{{__('Go To Home')}}</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
