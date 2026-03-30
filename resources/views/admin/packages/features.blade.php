@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{__('Package Features')}}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{__('Packages Management')}}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{__('Package Features')}}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{__('Package Features')}}</div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-8 offset-lg-2">
              <form id="permissionsForm" class="" action="{{route('admin.package.features')}}" method="post">
                @csrf
                <div class="alert alert-warning">
                  {{__('Only these selected features will be visible in frontend Pricing Section')}}
                </div>
                <div class="form-group">
                    <label class="form-label">{{__('Package Features')}}</label>
                    <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Custom Domain" class="selectgroup-input" @if(is_array($features) && in_array('Custom Domain', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Custom Domain')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Subdomain" class="selectgroup-input" @if(is_array($features) && in_array('Subdomain', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Subdomain')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="POS" class="selectgroup-input" @if(is_array($features) && in_array('POS', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('POS')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Coupon" class="selectgroup-input" @if(is_array($features) && in_array('Coupon', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Coupon')}}</span>
                        </label>
          
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Live Orders" class="selectgroup-input" @if(is_array($features) && in_array('Live Orders', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Live Order')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Whatsapp Order & Notification" class="selectgroup-input" @if(is_array($features) && in_array('Whatsapp Order & Notification', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Whatsapp Order & Notification')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="QR Menu" class="selectgroup-input" @if(is_array($features) && in_array('QR Menu', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('QR Menu')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Table Reservation" class="selectgroup-input" @if(is_array($features) && in_array('Table Reservation', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Table Reservation')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Table QR Builder" class="selectgroup-input" @if(is_array($features) && in_array('Table QR Builder', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Table QR Builder')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Call Waiter" class="selectgroup-input" @if(is_array($features) && in_array('Call Waiter', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Call Waiter')}}</span>
                        </label>
                       
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Staffs" class="selectgroup-input" @if(is_array($features) && in_array('Staffs', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Staffs')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Blog" class="selectgroup-input" @if(is_array($features) && in_array('Blog', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Blog')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Custom Page" class="selectgroup-input" @if(is_array($features) && in_array('Custom Page', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Custom Page')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Online Order" class="selectgroup-input" @if(is_array($features) && in_array('Online Order', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Online Order')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="On Table" class="selectgroup-input" @if(is_array($features) && in_array('On Table', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('On Table')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Pick Up" class="selectgroup-input" @if(is_array($features) && in_array('Pick Up', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Pick Up')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Home Delivery" class="selectgroup-input" @if(is_array($features) && in_array('Home Delivery', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Home Delivery')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="Postal Code Based Delivery Charge" class="selectgroup-input" @if(is_array($features) && in_array('Postal Code Based Delivery Charge', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('Postal Code Based Delivery Charge')}}</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="features[]" value="PWA Installability" class="selectgroup-input" @if(is_array($features) && in_array('PWA Installability', $features)) checked @endif>
                            <span class="selectgroup-button">{{__('PWA Installability')}}</span>
                        </label>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="permissionBtn" class="btn btn-success">{{__('Update')}}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
