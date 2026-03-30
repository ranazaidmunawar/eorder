@php
    use App\Constants\Constant;use App\Http\Helpers\UserPermissionHelper;
@endphp
@extends('user.layout')
@section('content')
    <div class="page-header">
        <h4 class="page-title">{{__('User Details')}}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{route('user.dashboard')}}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Users</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{__('User Details')}}</a>
            </li>
        </ul>

        <a href="{{route('user.registered_clients')}}" class="btn-md btn btn-primary ml-auto">{{__('Back')}}</a>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center p-4">
                    <img
                        src="{{!empty($user->image) ? asset(Constant::WEBSITE_TENANT_USER_IMAGE.'/'.$user->image) : asset('assets/user/img/user.jpg')}}"
                        alt="" width="200">
                </div>
            </div>
        </div>
        <div class="col-md-9">
            @if (session()->has('membership_warning'))
                <div class="alert alert-warning text-dark">
                    {{session()->get('membership_warning')}}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('User Details')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('Username:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            {{$user->username ?? '-'}}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('First Name:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            {{$user->first_name ?? '-'}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('Last Name:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            {{$user->last_name ?? '-'}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('Company Name:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            {{$user->company_name ?? '-'}}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('Email:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            {{$user->email ?? '-'}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('Number:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            {{$user->phone ?? '-'}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('City:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            {{$user->city ?? '-'}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('State:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            {{$user->state ?? '-'}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('Country:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            {{$user->country}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('Address:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            {{$user->address}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('Email Status:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            @if ($user->email_verified == 1)
                                <span class="badge badge-success">{{__('Verified')}}</span>
                            @elseif ($user->email_verified == 0)
                                <span class="badge badge-danger">{{__('Not Verified')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{__('Account Status:')}}</strong>
                        </div>
                        <div class="col-lg-6">
                            @if ($user->status == 1)
                                <span class="badge badge-success">{{__('Active')}}</span>
                            @elseif ($user->status == 0)
                                <span class="badge badge-danger">{{__('Banned')}}</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
