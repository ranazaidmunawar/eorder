@extends('user-front.qrmenu.layout')

@section('page-heading')
    {{$keywords["Success"] ?? __('Success')}}
@endsection

@section('content')
<div class="content">
 
    <section class="hidden-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 p-4 bg-light">
                    <div class="checkout-success">
                        <div class="icon text-success"><i class="far fa-check-circle"></i></div>
                        <h2>{{$keywords["Success"] ?? __('Success')}}!</h2>
                        @if (!empty($order->token_no))
                        <p class="mb-0">{{$keywords["Token No"] ?? __('Token No')}}:
                            <strong class="text-danger">
                                {{$order->token_no}}
                            </strong>
                        </p>
                        @endif
                        <p class="mb-0">{{$keywords["Order Number"] ?? __('Order Number')}}: <strong class="text-danger">#{{$orderNum ?? ''}}</strong></p>
                        <p class="mb-0">{{$keywords["We have sent you a mail with an invoice."] ?? __('We have sent you a mail with an invoice.')}}</p>
                        <p class="mt-3">{{$keywords["Thank you."] ??__('Thank you.')}}</p>
                        <a class="main-btn main-btn-2 mt-4" href="{{route('user.front.qrmenu',getParam())}}">{{$keywords["Return to Menu"] ?? __('Return to Menu')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection

