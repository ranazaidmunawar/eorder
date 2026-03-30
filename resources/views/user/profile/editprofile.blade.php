@php use App\Constants\Constant;use App\Http\Helpers\Uploader; @endphp
@extends('user.layout')

@section('pagename')
    - {{__('Edit Profile')}}
@endsection

@section('content')
    <div class="page-header">
        <h4 class="page-title">Profile</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Profile Settings</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Profile</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Update Profile</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">

                            <form action="{{route('user.update.profile')}}" method="post" role="form"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="form-group">
                                        <div class="col-12 mb-2">
                                            <label for="image"><strong>Profile Image</strong></label>
                                        </div>
                                        <div class="col-md-12 showImage mb-3">
                                            @if(Auth::guard('web')->user()->image)
                                            <img
                                                src="{{Uploader::getImageUrl(Constant::WEBSITE_TENANT_USER_IMAGE,Auth::guard('web')->user()->image,$userBs)}}"
                                                alt="..." class="img-thumbnail" width="150">
                                            @else 
                                             <img
                                                src="{{asset('assets/admin/img/noimage.jpg')}}"
                                                alt="..." class="img-thumbnail" width="150">
                                            @endif    
                                            <input type="file" name="profile_image" id="image" class="form-control image">
                                        </div>
                                        @if ($errors->has('profile_image'))
                                            <p class="text-danger mb-0">{{$errors->first('profile_image')}}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Username *</label>
                                        </div>
                                        <div class="col-md-12">
                                            <input class="form-control input-lg" name="username"
                                                   value="{{$user->username}}" placeholder="Your Username" type="text">
                                            @if ($errors->has('username'))
                                                <p class="text-danger mb-0">{{$errors->first('username')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Email *</label>
                                        </div>
                                        <div class="col-md-12">
                                            <input class="form-control input-lg" name="email" value="{{$user->email}}"
                                                   placeholder="Your Email" type="text">
                                            @if ($errors->has('email'))
                                                <p class="text-danger mb-0">{{$errors->first('email')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Restaurant Name *</label>
                                        </div>
                                        <div class="col-md-12">
                                            <input class="form-control input-lg" name="restaurant_name"
                                                   value="{{$user->restaurant_name}}" placeholder="Your First Name"
                                                   type="text">
                                            @if ($errors->has('restaurant_name'))
                                                <p class="text-danger mb-0">{{$errors->first('restaurant_name')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Address *</label>
                                        </div>
                                        <div class="col-md-12">
                                            <input class="form-control input-lg" name="address"
                                                   value="{{$user->address}}" placeholder="Your Last Name"
                                                   type="text">
                                            @if ($errors->has('address'))
                                                <p class="text-danger mb-0">{{$errors->first('address')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-success">Submit</button>
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

@endsection
