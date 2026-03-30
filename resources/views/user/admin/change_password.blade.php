@extends('user.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Password</h4>
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
        <a href="#">Staff Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Password</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form id="ajaxForm" action="{{route('user.admin.change.submit')}}" method="post" role="form">
          <div class="card-header">
            <div class="card-title">Update Password</div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                 @csrf
                 <div class="form-body">
                  
                    <div class="form-group">
                       <label>New Password *</label>
                       <div class="">
                          <input class="form-control" name="password" placeholder="New Password" type="password" value="{{ old('password') }}">
                           <p id="errpassword" class="em text-danger"></p>
                       </div>
                    </div>
                    <div class="form-group">
                       <label>Confirm Password *</label>
                       <div class="">
                          <input class="form-control" name="password_confirmation" placeholder="New Password Again" type="password" value="{{ old('password_confirmation') }}">
                       </div>
                       <p id="errpassword_confirmation" class="em text-danger"></p>
                    </div>
                 </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
               <div class="col-md-12 text-center">
                  <button type="button" id="submitBtn" class="btn btn-success">Submit</button>
               </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
