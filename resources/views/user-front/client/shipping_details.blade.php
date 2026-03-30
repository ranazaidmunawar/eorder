@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')
    {{$keywords['Shipping Details'] ?? __('Shipping Details') }}
@endsection
@section('content')
    
  <section class="page-title-area d-flex align-items-center"
    style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{ $keywords['Shipping Details'] ?? __('Shipping Details') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="{{route('user.client.dashboard',getParam())}}"><i
                                            class="flaticon-home"></i>{{$keywords['Dashboard'] ?? __('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $keywords['Shipping Details'] ?? __('Shipping Details') }}</li>
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
                                        <h4>{{ $keywords['Edit Shipping Details'] ?? __('Edit Shipping Details') }}</h4>
                                    </div>
                                    <div class="edit-info-area">
                                        <form action="{{ route('user.client.shipping.update', getParam()) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                        placeholder="{{ $keywords['Shipping First Name'] ?? __('Shipping First Name') }}"
                                                        name="shipping_fname" value="{{ $customer->shipping_fname }}">
                                                    @error('shipping_fname')
                                                        <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                        placeholder="{{ $keywords['Shipping Last Name'] ?? __('Shipping Last Name') }}"
                                                        name="shipping_lname" value="{{ $customer->shipping_lname }}">
                                                    @error('shipping_lname')
                                                        <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <input type="email" class="form_control"
                                                        placeholder="{{ $keywords['Shipping Email'] ?? __('Shipping Email') }}"
                                                        name="shipping_email" value="{{ $customer->shipping_email }}">
                                                    @error('shipping_email')
                                                        <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">

                                                    <div class="input-group mb-3">
                                                        <input type="hidden" name="shipping_country_code"
                                                            value="{{ !empty($customer->shipping_country_code) ? $customer->shipping_country_code : null }}">
                                                        <div class="input-group-prepend">
                                                            <button
                                                                class="btn btn-outline-secondary dropdown-toggle shipping_country_code"
                                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">{{!empty($customer->shipping_country_code) ? $customer->shipping_country_code : $keywords['Select'] ?? __('Select')}}</button>
                                                            <div class="dropdown-menu country-codes"
                                                                id="shipping_country_code">
                                                                @foreach ($ccodes as $ccode)
                                                                    <a class="dropdown-item"
                                                                        data-shipping_country_code="{{ $ccode['code'] }}"
                                                                        href="#">{{ $ccode['name'] }}
                                                                        ({{ $ccode['code'] }})</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <input type="text" name="shipping_number" class="form-control"
                                                            placeholder="{{ $keywords['Shipping Phone'] ?? __('Shipping Phone') }}"
                                                            value="{{ $customer->shipping_number }}">
                                                    </div>
                                                    @error('shipping_country_code')
                                                        <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                    @error('shipping_number')
                                                        <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                        placeholder="{{ $keywords['Shipping City'] ?? __('Shipping City') }}"
                                                        name="shipping_city" value="{{ $customer->shipping_city }}">
                                                    @error('shipping_city')
                                                        <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                        placeholder="{{ $keywords['Shipping State'] ?? __('Shipping State') }}"
                                                        name="shipping_state" value="{{ $customer->shipping_state }}">
                                                    @error('shipping_state')
                                                        <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                        placeholder="{{ $keywords['Shipping Country'] ?? __('Shipping Country') }}"
                                                        name="shipping_country" value="{{ $customer->shipping_country }}">
                                                    @error('shipping_country')
                                                        <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>


                                                <div class="col-lg-12">
                                                    <textarea name="shipping_address" class="form_control"
                                                        placeholder="{{ $keywords['Shipping Address'] ?? __('Shipping Address') }}">
                                                              {{ $customer->shipping_address }}
                                                    </textarea>
                                                    @error('shipping_address')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-button">
                                                        <button type="submit"
                                                            class="btn form-btn">{{ $keywords['Submit'] ?? __('Submit') }}</button>
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
