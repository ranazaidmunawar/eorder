@extends('user.layout')

@section('content')
<div class="page-header">
   <h4 class="page-title">Plugins</h4>
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
         <a href="#">Plugins</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-lg-12">
         <div class="row">
            @if(!empty($features) && in_array('Live Orders',$features) || in_array('Call Waiter',$features))
            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card-title">Pusher Setup</div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <form action="{{route('user.pusher.update')}}" method="POST" id="pusherForm">
                        @csrf
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label>Pusher App ID</label>
                                 <input class="form-control" name="pusher_app_id" value="{{$userBe->pusher_app_id}}">
                                 @if ($errors->has('pusher_app_id'))
                                 <p class="mb-0 text-danger">{{$errors->first('pusher_app_id')}}</p>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label>Pusher App key</label>
                                 <input class="form-control" name="pusher_app_key" value="{{$userBe->pusher_app_key}}">
                                 @if ($errors->has('pusher_app_key'))
                                 <p class="mb-0 text-danger">{{$errors->first('pusher_app_key')}}</p>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label>Pusher App Secret</label>
                                 <input class="form-control" name="pusher_app_secret" value="{{$userBe->pusher_app_secret}}">
                                 @if ($errors->has('pusher_app_secret'))
                                 <p class="mb-0 text-danger">{{$errors->first('pusher_app_secret')}}</p>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label>Pusher App Cluster</label>
                                 <input class="form-control" name="pusher_app_cluster" value="{{$userBe->pusher_app_cluster}}">
                                 @if ($errors->has('pusher_app_cluster'))
                                 <p class="text-danger">{{$errors->first('pusher_app_cluster')}}</p>
                                 @endif
                                 <p class="text-warning mb-0">Pusher credentials needed for Realtime notification after <strong class="text-warning">new order & call waiter</strong> in your Dashboard  with sound</p>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="card-footer text-center">
                     <button type="submit" form="pusherForm" class="btn btn-success">Update</button>
                  </div>
               </div>
            </div>
            @else
            @endif

           @if(!empty($features) && in_array('Online Order',$features))
            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card-title">Facebook Login</div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <form action="{{route('user.fblogin.update')}}" id="fbLoginForm" method="POST">
                        @csrf
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label>Status</label>
                                 <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                    <input type="radio" name="is_facebook_login" value="1" class="selectgroup-input" {{$userBe->is_facebook_login == 1 ? 'checked' : ''}}>
                                    <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item">
                                    <input type="radio" name="is_facebook_login" value="0" class="selectgroup-input" {{$userBe->is_facebook_login == 0 ? 'checked' : ''}}>
                                    <span class="selectgroup-button">Deactive</span>
                                    </label>
                                 </div>
                                 @if ($errors->has('is_facebook_login'))
                                 <p class="mb-0 text-danger">{{$errors->first('is_facebook_login')}}</p>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label>Facebook App ID</label>
                                 <input class="form-control" name="facebook_app_id" value="{{$userBe->facebook_app_id}}">
                                 @if ($errors->has('facebook_app_id'))
                                 <p class="text-danger">{{$errors->first('facebook_app_id')}}</p>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label>Facebook App Secret</label>
                                 <input class="form-control" name="facebook_app_secret" value="{{$userBe->facebook_app_secret}}">
                                 @if ($errors->has('facebook_app_secret'))
                                 <p class="text-danger">{{$errors->first('facebook_app_secret')}}</p>
                                 @endif
                                 <p class="text-warning mb-0">Facebook App ID & App Secret are required for Facebook Login.</p>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="card-footer text-center">
                     <button class="btn btn-success" type="submit" form="fbLoginForm">Update</button>
                  </div>
               </div>
            </div>

            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card-title">Google Login</div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <form action="{{route('user.googlelogin.update')}}" method="POST" id="googleLoginForm">
                        @csrf
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label>Status</label>
                                 <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                    <input type="radio" name="is_google_login" value="1" class="selectgroup-input" {{$userBe->is_google_login == 1 ? 'checked' : ''}}>
                                    <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item">
                                    <input type="radio" name="is_google_login" value="0" class="selectgroup-input" {{$userBe->is_google_login == 0 ? 'checked' : ''}}>
                                    <span class="selectgroup-button">Deactive</span>
                                    </label>
                                 </div>
                                 @if ($errors->has('is_google_login'))
                                 <p class="mb-0 text-danger">{{$errors->first('is_google_login')}}</p>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label>Google Client ID</label>
                                 <input class="form-control" name="google_client_id" value="{{$userBe->google_client_id}}">
                                 @if ($errors->has('google_client_id'))
                                 <p class="text-danger">{{$errors->first('google_client_id')}}</p>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label>Google Client Secret</label>
                                 <input class="form-control" name="google_client_secret" value="{{$userBe->google_client_secret}}">
                                 @if ($errors->has('google_client_secret'))
                                 <p class="text-danger">{{$errors->first('google_client_secret')}}</p>
                                 @endif
                                 <p class="text-warning mb-0">Google Client ID & Client Secret are required for Google Login.</p>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="card-footer text-center">
                     <button type="submit" class="btn btn-success" form="googleLoginForm">Update</button>
                  </div>
               </div>
            </div>
            @endif
            @if(!empty($features) && in_array('Whatsapp Order & Notification',$features) )
            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card-title">Twilio Credentials</div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <form action="{{route('user.twilio.update')}}" id="twilioForm" method="POST">
                        @csrf
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="form-group">
                              <div class="form-group">
                                 <label>Account SID</label>
                                 <input class="form-control" name="twilio_sid" value="{{$abex->twilio_sid ?? null}}">
                                 @if ($errors->has('twilio_sid'))
                                 <p class="text-danger">{{$errors->first('twilio_sid')}}</p>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label>Auth token</label>
                                 <input class="form-control" name="twilio_token" value="{{$abex->twilio_token ?? null}}">
                                 @if ($errors->has('twilio_token'))
                                 <p class="text-danger">{{$errors->first('twilio_token')}}</p>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label>Phone Number (with country code)</label>
                                 <input class="form-control" name="twilio_phone_number" value="{{$abex->twilio_phone_number ?? null}}">
                                 @if ($errors->has('twilio_phone_number'))
                                 <p class="text-danger">{{$errors->first('twilio_phone_number')}}</p>
                                 @endif
                                 <p class="text-warning mb-0">Twilio credentials will be used to send whatsapp notification of orders</p>
                                 <p class="text-warning mb-0">You have to enable whatsapp notification from <a href="{{ route('user.order.settings') }}" target="_blank">Order Management > Settings</a> </p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>

               <div class="card-footer text-center">
                  <button type="submit" form="twilioForm" class="btn btn-success">Update</button>
               </div>
            </div>
         </div>

            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header">
                     <div class="card-title">WhatsApp Chat Button</div>
                  </div>
                  <div class="card-body">
                     <form action="{{route('user.whatsapp.update')}}" method="POST" id="waForm">
                        @csrf
                        <div class="form-group">
                           <label>Status</label>
                           <div class="selectgroup w-100">
                              <label class="selectgroup-item">
                              <input type="radio" name="is_whatsapp" value="1" class="selectgroup-input" {{$userBs->is_whatsapp == 1 ? 'checked' : ''}}>
                              <span class="selectgroup-button">Active</span>
                              </label>
                              <label class="selectgroup-item">
                              <input type="radio" name="is_whatsapp" value="0" class="selectgroup-input" {{$userBs->is_whatsapp == 0 ? 'checked' : ''}}>
                              <span class="selectgroup-button">Deactive</span>
                              </label>
                           </div>
                           <p class="text-warning mb-0">If you enable WhatsApp, then Tawk.to must be disabled.</p>
                        </div>
                        <div class="form-group">
                           <label>WhatsApp Number</label>
                           <input class="form-control" type="text" name="whatsapp_number" value="{{$userBs->whatsapp_number}}">
                           <p class="text-warning mb-0">Enter Phone number with Country Code</p>
                        </div>
                        <div class="form-group">
                           <label>WhatsApp Header Title</label>
                           <input class="form-control" type="text" name="whatsapp_header_title" value="{{$userBs->whatsapp_header_title}}">
                           @if ($errors->has('whatsapp_header_title'))
                           <p class="mb-0 text-danger">{{$errors->first('whatsapp_header_title')}}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>WhatsApp Popup Message</label>
                           <textarea class="form-control" name="whatsapp_popup_message" rows="2">{{$userBs->whatsapp_popup_message}}</textarea>
                           @if ($errors->has('whatsapp_popup_message'))
                           <p class="mb-0 text-danger">{{$errors->first('whatsapp_popup_message')}}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Popup</label>
                           <div class="selectgroup w-100">
                              <label class="selectgroup-item">
                              <input type="radio" name="whatsapp_popup" value="1" class="selectgroup-input" {{$userBs->whatsapp_popup == 1 ? 'checked' : ''}}>
                              <span class="selectgroup-button">Active</span>
                              </label>
                              <label class="selectgroup-item">
                              <input type="radio" name="whatsapp_popup" value="0" class="selectgroup-input" {{$userBs->whatsapp_popup == 0 ? 'checked' : ''}}>
                              <span class="selectgroup-button">Deactive</span>
                              </label>
                           </div>
                           @if ($errors->has('whatsapp_popup'))
                           <p class="mb-0 text-danger">{{$errors->first('whatsapp_popup')}}</p>
                           @endif
                        </div>
                     </form>
                  </div>
                  <div class="card-footer text-center">
                     <button type="submit" class="btn btn-success" form="waForm">Update</button>
                  </div>
               </div>
            </div>
             @endif
            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card-title">Tawk.to</div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <form action="{{route('user.tawk.update')}}" id="tawkForm" method="POST">
                        @csrf
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label>Tawk.to Status</label>
                                 <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                    <input type="radio" name="is_tawkto" value="1" class="selectgroup-input" {{$userBs->is_tawkto == 1 ? 'checked' : ''}}>
                                    <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item">
                                    <input type="radio" name="is_tawkto" value="0" class="selectgroup-input" {{$userBs->is_tawkto == 0 ? 'checked' : ''}}>
                                    <span class="selectgroup-button">Deactive</span>
                                    </label>
                                 </div>
                                 <p class="mb-0 text-warning">If you enable Tawk.to, then WhatsApp must be disabled.</p>
                                 @if ($errors->has('is_tawkto'))
                                 <p class="mb-0 text-danger">{{$errors->first('is_tawkto')}}</p>
                                 @endif
                              </div>
                            
                               <div class="form-group">
                         <label>{{__('Tawk.to Direct Chat Link')}}</label>
                         <input class="form-control" name="tawkto_direct_chat_link" value="{{$userBs->tawkto_direct_chat_link}}">
                         @if ($errors->has('tawkto_direct_chat_link'))
                         <p class="mb-0 text-danger">{{$errors->first('tawkto_direct_chat_link')}}</p>
                         @endif
                      </div>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="card-footer text-center">
                     <button class="btn btn-success" form="tawkForm" type="submit">Update</button>
                  </div>
               </div>
            </div>
            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card-title">Disqus</div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <form action="{{route('user.disqus.update')}}" id="disqusForm" method="POST">
                        @csrf
                        <div class="row">
                           <div class="col-lg-12">
                               <div class="form-group">
                         <label>{{__('Disqus Status')}}</label>
                         <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                            <input type="radio" name="is_disqus" value="1" class="selectgroup-input" {{$userBs->is_disqus == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">{{__('Active')}}</span>
                            </label>
                            <label class="selectgroup-item">
                            <input type="radio" name="is_disqus" value="0" class="selectgroup-input" {{$userBs->is_disqus == 0 ? 'checked' : ''}}>
                            <span class="selectgroup-button">{{__('Deactive')}}</span>
                            </label>
                         </div>
                         @if ($errors->has('is_disqus'))
                         <p class="mb-0 text-danger">{{$errors->first('is_disqus')}}</p>
                         @endif
                      </div>
                  
                      <div class="form-group">
                         <label>{{__('Disqus Shortname')}}</label>
                         <input class="form-control" name="disqus_shortname" value="{{$userBs->disqus_shortname}}">
                         @if ($errors->has('disqus_shortname'))
                         <p class="mb-0 text-danger">{{$errors->first('disqus_shortname')}}</p>
                         @endif
                      </div>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="card-footer text-center">
                     <button class="btn btn-success" type="submit" form="disqusForm">Update</button>
                  </div>
               </div>
            </div>
            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card-title">Google Analytics</div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <form action="{{route('user.ga.update')}}" method="POST" id="gaForm">
                        @csrf
                       <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('Google Analytics Status') }}</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_analytics" value="1"
                                                class="selectgroup-input"
                                                {{ isset($userBs) && $userBs->is_analytics == 1 ? 'checked' : '' }}>
                                            <span class="selectgroup-button">{{ __('Active') }}</span>
                                        </label>

                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_analytics" value="0"
                                                class="selectgroup-input"
                                                {{ !isset($userBs) || $userBs->is_analytics != 1 ? 'checked' : '' }}>
                                            <span class="selectgroup-button">{{ __('Deactive') }}</span>
                                        </label>
                                    </div>

                                    @if ($errors->has('is_analytics'))
                                        <p class="mt-1 mb-0 text-danger">{{ $errors->first('is_analytics') }}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Measurement ID') }} </label>
                                    <input type="text" class="form-control" name="measurement_id"
                                        value="{{ isset($userBs) && $userBs->measurement_id ? $userBs->measurement_id : null }}">
                                    @if ($errors->has('measurement_id'))
                                        <p class="mt-1 mb-0 text-danger">{{ $errors->first('measurement_id') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                     </form>
                  </div>
                  <div class="card-footer text-center">
                     <button class="btn btn-success" type="submit" form="gaForm">Update</button>
                  </div>
               </div>
            </div>
         
            
            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card-title">Google Recaptcha</div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <form action="{{route('user.recaptcha.update')}}" id="grForm" method="POST">
                        @csrf
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label>Google Recaptcha Status</label>
                                 <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                    <input type="radio" name="is_recaptcha" value="1" class="selectgroup-input" {{$userBs->is_recaptcha == 1 ? 'checked' : ''}}>
                                    <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item">
                                    <input type="radio" name="is_recaptcha" value="0" class="selectgroup-input" {{$userBs->is_recaptcha == 0 ? 'checked' : ''}}>
                                    <span class="selectgroup-button">Deactive</span>
                                    </label>
                                 </div>
                                 @if ($errors->has('is_recaptcha'))
                                 <p class="mb-0 text-danger">{{$errors->first('is_recaptcha')}}</p>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label>Google Recaptcha Site key</label>
                                 <input class="form-control" name="google_recaptcha_site_key" value="{{$userBs->google_recaptcha_site_key}}">
                                 @if ($errors->has('google_recaptcha_site_key'))
                                 <p class="mb-0 text-danger">{{$errors->first('google_recaptcha_site_key')}}</p>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label>Google Recaptcha Secret key</label>
                                 <input class="form-control" name="google_recaptcha_secret_key" value="{{$userBs->google_recaptcha_secret_key}}">
                                 @if ($errors->has('google_recaptcha_secret_key'))
                                 <p class="mb-0 text-danger">{{$errors->first('google_recaptcha_secret_key')}}</p>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="card-footer text-center">
                     <button class="btn btn-success" type="submit" form="grForm">Update</button>
                  </div>
               </div>
            </div>
            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card-title">Facebook Pexel</div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <form action="{{route('user.pixel.update')}}" id="pixelForm" method="POST">
                        @csrf
                       <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('Facebook Pixel Status') }}</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_facebook_pixel" value="1"
                                                class="selectgroup-input"
                                                {{ isset($userBe) && $userBe->is_facebook_pixel == 1 ? 'checked' : '' }}>
                                            <span class="selectgroup-button">{{ __('Active') }}</span>
                                        </label>

                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_facebook_pixel" value="0"
                                                class="selectgroup-input"
                                                {{ !isset($userBe) || $userBe->is_facebook_pixel != 1 ? 'checked' : '' }}>
                                            <span class="selectgroup-button">{{ __('Deactive') }}</span>
                                        </label>
                                    </div>
                                    <p id="erris_facebook_pixel" class="mb-0 text-danger em"></p>
                                    <p class="text text-warning">
                                        <strong>Hint:</strong> <a class="text-primary" href="https://prnt.sc/5u1ZP6YjAw5O"
                                            target="_blank">Click Here</a> to see where to get the Facebook Pixel ID
                                    </p>
                                    @if ($errors->has('is_facebook_pixel'))
                                        <p class="text-danger">{{ $errors->first('is_facebook_pixel') }}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Facebook Pixel ID') }}</label>
                                    <input type="text" class="form-control" name="pixel_id"
                                        value="{{ isset($userBe) ? $userBe->pixel_id : null }}">
                                    <p id="errpixel_id" class="mb-0 text-danger em"></p>
                                    @if ($errors->has('pixel_id'))
                                        <p class="text-danger">{{ $errors->first('pixel_id') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                     </form>
                  </div>
                  <div class="card-footer text-center">
                     <button type="submit" class="btn btn-success" form="pixelForm">Update</button>
                  </div>
               </div>
            </div>
         </div>
   </div>

</div>
@endsection
