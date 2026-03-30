@extends('user.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{__('Mail Information')}}</h4>
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
        <a href="#">{{__('Settings')}}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{__('Mail Information')}}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <form action="{{route('user.mail.info.update')}}" method="post">
          @csrf
          <div class="card-header">
            <div class="card-title">{{__('Mail Information')}}</div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-8 offset-lg-2">
                  <div class="form-group">
                    <label for="email">{{__('Reply To')}} **</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{$info->email ?? Auth::guard('web')->user()->email}}" placeholder="{{__('Enter Email Address')}}">
                    @if ($errors->has('email'))
                      <p class="text-danger mb-0">{{$errors->first('email')}}</p>
                    @endif
                  </div>
                  <div class="form-group">
                      <label for="from-name">{{__('From Name')}} **</label>
                      <input id="from-name" type="text" class="form-control" name="from_name" value="{{$info->from_name ?? Auth::guard('web')->user()->username}}" placeholder="{{__('Enter From name')}}">
                      @if ($errors->has('from_name'))
                          <p class="text-danger mb-0">{{$errors->first('from_name')}}</p>
                      @endif
                  </div>
                  <div class="form-group">
                      <label for="from-name">{{__('Recipient  Email')}} **</label>
                      <input id="from-name" type="text" class="form-control" name="from_mail" value="{{$infoBe->from_mail ?? ''}}" placeholder="{{__('Enter From Email')}}">
                      @if ($errors->has('from_mail'))
                          <p class="text-danger mb-0">{{$errors->first('from_mail')}}</p>
                      @endif
                      <p class="text-warning">This mail address will receive mails from contact form & reservation form</p>
                  </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-center">
            <button type="submit" class="btn btn-success">
              {{__('save')}}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
