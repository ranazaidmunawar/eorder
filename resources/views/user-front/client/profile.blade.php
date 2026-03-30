@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

@extends('user-front.layout')
@section('pageHeading')
 {{$keywords['Profile'] ??  __('Profile') }}
@endsection
@section('content')

  <section class="page-title-area d-flex align-items-center"
    style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{$keywords['Edit Profile'] ?? __('Edit Profile')}}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="{{route('user.client.dashboard',getParam())}}"><i
                                            class="flaticon-home"></i>{{$keywords['Dashboard'] ?? __('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">{{$keywords['Edit Profile'] ?? __('Edit Profile')}}</li>
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
                                        <h4>{{$keywords['Edit Profile'] ?? __('Edit Profile')}}</h4>
                                    </div>
                                    <div class="edit-info-area">
                                        <form action="{{route('user.client.profile.update',getParam())}}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="upload-img">
                                                @if (strpos($customer->photo, 'facebook') || strpos($customer->photo, 'google'))
                                                    <div class="img-box">
                                                        <img class="showimage"
                                                             src="{{$customer->photo ??  asset('assets/front/img/user/profile.jpg')}}"
                                                             alt="user-image">
                                                    </div>
                                                @else
                                                    <div class="img-box">
                                                        <img class="showimage"
                                                             src="{{$customer->photo ? Uploader::getImageUrl(Constant::WEBSITE_CUSTOMER_IMAGE,$customer->photo,$userBs) : asset('assets/front/img/user/profile.jpg')}}"
                                                             alt="user-image">
                                                    </div>
                                                @endif
                                                <div class="file-upload-area">
                                                    <div class="upload-file">
                                                        <input type="file" name="photo" class="upload image">
                                                        <span>{{$keywords['Upload'] ?? __('Upload')}}</span>
                                                    </div>
                                                    @error('photo')
                                                    <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['First Name'] ?? __('First Name')}}"
                                                           name="fname" value="{{$customer->fname}}">
                                                    @error('fname')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['Last Name'] ?? __('Last Name')}}"
                                                           name="lname" value="{{$customer->lname}}">
                                                    @error('lname')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="email" class="form_control"
                                                           placeholder="{{$keywords['Email'] ?? __('Email')}}"
                                                           name="email" disabled value="{{$customer->email}}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['Username'] ?? __('Username')}}"
                                                           name="username" value="{{$customer->username}}">
                                                    @error('username')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['Phone'] ?? __('Phone')}}"
                                                           name="number" value="{{$customer->number}}">
                                                    @error('number')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['City'] ?? __('City')}}" name="city"
                                                           value="{{$customer->city}}">
                                                    @error('city')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['State'] ?? __('State')}}"
                                                           name="state" value="{{$customer->state}}">
                                                    @error('state')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control"
                                                           placeholder="{{$keywords['Country'] ?? __('Country')}}"
                                                           name="country" value="{{$customer->country}}">
                                                    @error('country')
                                                    <p class="text-danger mb-2">{{ $message }}</p>
                                                    @enderror
                                                </div>


                                                <div class="col-lg-12">
                                                    <textarea name="address" class="form_control"
                                                              placeholder="{{$keywords['Address'] ?? __('Address')}}">{{$customer->address}}</textarea>
                                                    @error('address')
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
