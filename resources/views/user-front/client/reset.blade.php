@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')
 {{ $keywords['Reset'] ?? __('Reset') }}
@endsection
@section('content')

  <section class="page-title-area d-flex align-items-center"
    style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{$keywords['Reset Password'] ?? __('Reset Password')}}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.client.dashboard',getParam())}}"><i
                                            class="flaticon-home"></i>{{$keywords['Dashboard'] ?? __('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$keywords['Reset Password'] ?? __('Reset Password')}}</li>
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
                                        <h4>{{$keywords['Reset Password'] ?? __('Reset Password')}}</h4>
                                    </div>
                                    <div class="edit-info-area">
                                        <form action="{{route('user.client.reset.submit',getParam())}}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="password" class="form_control"
                                                           placeholder="{{$keywords['Current Password'] ?? __('Current Password')}}"
                                                           name="current_password">
                                                    @error('current_password')
                                                    <p class="text-danger">{{$message}}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="password" class="form_control"
                                                           placeholder="{{$keywords['New Password'] ?? __('New Password')}}" name="new_password">
                                                    @error('new_password')
                                                    <p class="text-danger">{{$message}}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="password" class="form_control"
                                                           placeholder="{{$keywords['Re-Type Password'] ?? __('Re-Type Password')}}"
                                                           name="confirmation_password">
                                                    @error('confirmation_password')
                                                    <p class="text-danger">{{$message}}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-button">
                                                        <button class="btn form-btn">{{$keywords['Submit'] ?? __('Submit')}}</button>
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
