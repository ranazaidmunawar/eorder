@extends('user.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Edit Email Template</h4>
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
        <a href="#">Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Email Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Email Template</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Email Template</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('user.email.templates')}}">
            <span class="btn-label">
              <i class="fas fa-backward"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6">
                <table class="table table-striped mb-5">
                    <thead>
                      <tr>
                        <th  scope="col">BB Code</th>
                        <th  scope="col">Meaning</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td>
                            {customer_name}
                          </td>
                          <th scope="row">
                            Customer Name
                          </th>
                        </tr>
                        @if ($template->mail_type == 'reset_password')
                            <tr>
                                <td>
                                    {password_reset_link}
                                </td>
                                <th scope="row">
                                    Password Reset Link
                                </th>
                            </tr>
                        @endif
                        @if ($template->mail_type == 'email_verification' || $template->mail_type == 'verify_email')
                        <tr>
                            <td>
                              {verification_link}
                            </td>
                            <th scope="row">
                              Verification Link
                            </th>
                        </tr>
                        @endif

                        @if ($template->mail_type == 'order_received' ||
                             $template->mail_type == 'order_pickedup_pick_up' ||
                             $template->mail_type == 'order_preparing' ||
                             $template->mail_type == 'order_served' ||
                             $template->mail_type == 'order_ready_to_serve' ||
                             $template->mail_type == 'order_ready_to_pickup' ||
                             $template->mail_type == 'order_ready_to_pickup_pick_up' ||
                             $template->mail_type == 'order_pickup' ||
                             $template->mail_type == 'order_delivered' ||
                             $template->mail_type == 'order_cancelled' ||
                             $template->mail_type == 'food_checkout'
                             )

                        <tr>
                          <td>
                            {order_number}
                          </td>
                          <th scope="row">
                            Order Number
                          </th>
                        </tr>
                          <tr>
                          <td>
                            {text}
                          </td>
                          <th scope="row">
                            Text
                          </th>
                        </tr>
                        <tr>
                          <td>
                            {order_link}
                          </td>
                          <th scope="row">
                            Order Link
                          </th>
                        </tr>

                        @endif
                        <tr>
                          <td>
                            {website_title}
                          </td>
                          <th scope="row">
                            Website Title
                          </th>
                        </tr>
                    </tbody>
                </table>

             
            </div>
            <div class="col-lg-6">
               <form id="ajaxForm" action="{{route('user.email.templateUpdate', $template->id)}}" method="post" enctype="multipart/form-data">
                @csrf

                @php
                    if ($template->mail_type == 'order_pickedup_pick_up') {
                        $etype = "Order Picked up (For 'Pick up')";
                    } elseif ($template->mail_type == 'order_pickedup') {
                        $etype = "Order Picked up (For 'Home Delivery')";
                    } elseif ($template->mail_type == 'order_ready_to_pickup_pick_up') {
                        $etype = "Order Ready to Pick up (For 'Pick up')";
                    } elseif ($template->mail_type == 'order_ready_to_pickup') {
                        $etype = "Order Ready to Pick up (For 'Home Delivery')";
                    } else {
                        $etype = str_replace("_", " ", $template->mail_type);
                    }
                @endphp

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                           <label for="">Email Type **</label>
                           <input type="text" class="form-control" name="mail_type" placeholder="Email Type" value="{{$etype}}" readonly>
                           <p id="errmail_type" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                           <label for="">Email Subject **</label>
                           <input type="text" class="form-control" name="mail_subject"  placeholder="Email Subject" value="{{$template->mail_subject}}">
                           <p id="errmail_subject" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                   <div class="col-lg-12">
                      <div class="form-group">
                         <label for="">Email Body **</label>
                         <textarea class="form-control summernote" name="mail_body" placeholder="Enter description" id="mail_body" data-height="300">{{$template->mail_body}}</textarea>
                         <p id="errmail_body" class="mb-0 text-danger em"></p>
                      </div>
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
                <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection
