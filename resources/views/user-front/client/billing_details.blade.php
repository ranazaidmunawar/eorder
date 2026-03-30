@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')
 {{ $keywords['Billing Details'] ?? __('Billing Details') }}
@endsection
@section('content')
   <section class="page-title-area d-flex align-items-center"
    style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{$keywords['Billing Details'] ?? __('Billing Details')}}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="{{route('user.client.dashboard',getParam())}}"><i
                                            class="flaticon-home"></i>{{$keywords['Dashboard'] ?? __('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">{{$keywords['Billing Details'] ?? __('Billing Details')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
 
    <section class="user-dashbord">
        <div class="container">
            <div class="row">
                @include('user-front.client.inc.site_bar')
                <div class="col-lg-9">
                    <div class="row mb-5">
                        <div class="col-lg-12">
                            <div class="user-profile-details">
                                <div class="account-info">
                                    <div class="title">
                                        <h4>{{$keywords['Edit Billing Details'] ?? __('Edit Billing Details')}}</h4>
                                    </div>
                                    <div class="edit-info-area">
                                        <form action="{{route('user.client.billing.update',getParam())}}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['Billing First Name'] ?? __('Billing First Name')}}"
                                                           name="billing_fname" value="{{$customer->billing_fname}}">
                                                    @error('billing_fname')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['Billing Last Name'] ?? __('Billing Last Name')}}"
                                                           name="billing_lname" value="{{$customer->billing_lname}}">
                                                    @error('billing_lname')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <input type="email" class="form_control"
                                                           placeholder="{{$keywords['Billing Email'] ?? __('Billing Email')}}"
                                                           name="billing_email" value="{{$customer->billing_email}}">
                                                    @error('billing_email')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <input type="hidden" name="billing_country_code"
                                                               value="{{!empty($customer->billing_country_code) ? $customer->billing_country_code : null}}">
                                                          <div class="input-group-prepend">
                                                            <button
                                                                class="btn btn-outline-secondary dropdown-toggle billing_country_code"
                                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">{{!empty($customer->billing_country_code) ? $customer->billing_country_code : $keywords['Select'] ?? __('Select')}}</button>
                                                            <div class="dropdown-menu country-codes"
                                                                id="billing_country_code">
                                                                @foreach ($ccodes as $ccode)
                                                                    <a class="dropdown-item"
                                                                        data-billing_country_code="{{ $ccode['code'] }}"
                                                                        href="#">{{ $ccode['name'] }}
                                                                        ({{ $ccode['code'] }})</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <input type="text" name="billing_number" class="form-control"
                                                               placeholder="{{$keywords['Billing Phone'] ?? __('Billing Phone')}}"
                                                               value="{{$customer->billing_number}}">
                                                    </div>
                                                    @error('billing_country_code')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                    @error('billing_number')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['Billing City'] ?? __('Billing City')}}"
                                                           name="billing_city" value="{{$customer->billing_city}}">
                                                    @error('billing_city')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['Billing State'] ?? __('Billing State')}}"
                                                           name="billing_state" value="{{$customer->billing_state}}">
                                                    @error('billing_state')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['Billing Country'] ?? __('Billing Country')}}"
                                                           name="billing_country"
                                                           value="{{$customer->billing_country}}">
                                                    @error('billing_country')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <textarea name="billing_address" class="form_control"
                                                              placeholder="{{$keywords['Billing Address'] ?? __('Billing Address')}}">{{$customer->billing_address}}</textarea>
                                                    @error('billing_address')
                                                    <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-button">
                                                        <button type="submit"
                                                                class="btn form-btn">
                                                            {{$keywords['Submit'] ?? __('Submit')}}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

