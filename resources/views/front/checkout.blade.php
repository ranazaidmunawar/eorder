@php use Illuminate\Support\Carbon; @endphp
@extends('front.layout')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/front/css/checkout.css') }}">
@endsection

@section('pagename')
  - {{ __('Checkout') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->checkout_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->checkout_meta_keywords : '')

@section('breadcrumb-title')
  {{ __('Checkout') }}
@endsection
@section('breadcrumb-link')
  {{ __('Checkout') }}
@endsection


@section('content')

  <section class="checkout-area ptb-90">
    <div class="container">
      <form
        onsubmit="document.getElementById('confirmBtn').innerHTML='Processing...';document.getElementById('confirmBtn').disabled=true;"
        action="{{ route('front.membership.checkout') }}" method="POST" enctype="multipart/form-data" id="my-checkout-form">
        <div class="row">
          <div class="col-lg-8 ">
            <div class="billing_form form-block">
              <div class="title mb-30">
                <h3>{{ __('Billing Details') }}</h3>
              </div>
              @csrf
              <div class="row">
                <input type="hidden" name="username" value="{{ $username }}">
                <input type="hidden" name="password" value="{{ $password }}">
                <input type="hidden" name="package_type" value="{{ $status }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="package_id" value="{{ $id }}">
                <input type="hidden" name="trial_days" id="trial_days" value="{{ $package->trial_days }}">
                <input type="hidden" name="start_date" value="{{ Carbon::today()->format('d-m-Y') }}">
                @if ($status === 'trial')
                  <input type="hidden" name="expire_date"
                    value="{{ Carbon::today()->addDay($package->trial_days)->format('d-m-Y') }}">
                @else
                  @if ($package->term === 'month')
                    <input type="hidden" name="expire_date" value="{{ Carbon::today()->addMonth()->format('d-m-Y') }}">
                  @elseif($package->term === 'lifetime')
                    <input type="hidden" name="expire_date" value="{{ Carbon::maxValue()->format('d-m-Y') }}">
                  @else
                    <input type="hidden" name="expire_date" value="{{ Carbon::today()->addYear()->format('d-m-Y') }}">
                  @endif
                @endif
                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="first_name">{{ __('First Name') }}*</label>
                    <input id="first_name" type="text" class="form-control" name="first_name"
                      placeholder="{{ __('First Name') }}" value="{{ old('first_name') }}" required>
                    @if ($errors->has('first_name'))
                      <span class="error">
                        <strong>{{ $errors->first('first_name') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="last_name">{{ __('Last Name') }}*</label>
                    <input id="last_name" type="text" class="form-control" name="last_name"
                      placeholder="{{ __('Last Name') }}" value="{{ old('last_name') }}" required>
                    @if ($errors->has('last_name'))
                      <span class="error">
                        <strong>{{ $errors->first('last_name') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="phone">{{ __('Phone Number') }}*</label>
                    <input id="phone" type="text" class="form-control" name="phone"
                      placeholder="{{ __('Phone Number') }}" value="{{ old('phone') }}" required>
                    @if ($errors->has('phone'))
                      <span class="error">
                        <strong>{{ $errors->first('phone') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="email">{{ __('Email Address') }}*</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email }}"
                      disabled>
                    @if ($errors->has('email'))
                      <span class="error">
                        <strong>{{ $errors->first('email') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group mb-30">
                    <label for="address">{{ __('Street Address') }}</label>
                    <input id="address" type="text" class="form-control" name="address"
                      placeholder="{{ __('Street Address') }}" value="{{ old('address') }}">
                    @if ($errors->has('address'))
                      <span class="error">
                        <strong>{{ $errors->first('address') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="city">{{ __('City') }}</label>
                    <input id="city" type="text" class="form-control" name="city"
                      placeholder="{{ __('City') }}" value="{{ old('city') }}">
                    @if ($errors->has('city'))
                      <span class="error">
                        <strong>{{ $errors->first('city') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="district">{{ __('State') }}</label>
                    <input id="district" type="text" class="form-control" name="district"
                      placeholder="{{ __('State') }}" value="{{ old('district') }}">
                    @if ($errors->has('district'))
                      <span class="error">
                        <strong>{{ $errors->first('district') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group mb-30">
                    <label for="country">{{ __('Country') }}*</label>
                    <input id="country" type="text" class="form-control" name="country"
                      placeholder="{{ __('Country') }}" value="{{ old('country') }}" required>
                    @if ($errors->has('country'))
                      <span class="error">
                        <strong>{{ $errors->first('country') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="order_wrap_box mb-40">
              <div id="couponReload">
                <input type="hidden" name="price"
                  value="{{ $status == 'trial' ? 0 : $package->price - $cAmount }}">
                <div class="order-summery form-block mb-30 mt-30">

                  <div class="title">
                    <h3>{{ __('Package Summary') }}</h3>
                  </div>
                  <div class="order-list-info">
                    <ul class="summery-list">
                      <li>{{ __('Package') }} <span>{{ __("$package->title") }}
                          ({{ __(ucfirst($package->term)) }}) </span></li>
                      <li>{{ __('Start Date') }}
                        <span>{{ \Carbon\Carbon::today()->format('d-m-Y') }}</span>
                      </li>
                      @if ($status === 'trial')
                        <li>
                          {{ __('Expiry Date') }}
                          <span>
                            {{ \Carbon\Carbon::today()->addDay($package->trial_days)->format('d-m-Y') }}
                          </span>
                        </li>
                      @else
                        <li>
                          {{ __('Expiry Date') }}
                          <span>
                            @if ($package->term === 'month')
                              {{ \Carbon\Carbon::today()->addMonth()->format('d-m-Y') }}
                            @elseif($package->term === 'lifetime')
                              {{ __('Lifetime') }}
                            @else
                              {{ \Carbon\Carbon::today()->addYear()->format('d-m-Y') }}
                            @endif
                          </span>
                        </li>
                      @endif
                      @if (session()->has('coupon'))
                        <li>
                          <span>{{ __('Package Price') }}</span>
                          <span class="price">
                            @if ($status === 'trial')
                              {{ __('Free') }} ({{ $package->trial_days . ' days' }})
                            @elseif($package->price == 0)
                              {{ __('Free') }}
                            @else
                              {{ format_price($package->price) }}
                            @endif
                          </span>
                        </li>
                        <li>
                          <span>{{ __('Discount') }}</span>
                          <span class="price text-success">
                            - {{ format_price($cAmount) }}
                          </span>
                        </li>
                      @endif
                      <li class="border-0">
                        <span>{{ __('Total') }}</span>
                        <span class="price">
                          @if ($status === 'trial')
                            {{ __('Free') }} ({{ $package->trial_days }}
                            {{ __('days') }})
                          @elseif($package->price == 0)
                            {{ __('Free') }}
                          @else
                            {{ format_price($package->price - $cAmount) }}
                          @endif
                        </span>
                      </li>
                    </ul>
                  </div>
                </div>

                @if ($package->price > 0 && $status != 'trial')
                  @if (!session()->has('coupon'))
                    <div class="row">
                      <div class="col-12">
                        <div class="input-group mb-3 align-items-lg-stretch">
                          <input type="text" class="form-control" name="coupon"
                            placeholder="{{ __('Enter Coupon Code Here') }}">
                          <div class="input-group-append">
                            <span class="btn primary-btn no-animation rounded-1 h-100 coupon-apply"
                              id="basic-addon2">{{ __('Apply') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  @else
                    <div class="alert alert-success">
                      {{ __('Coupon already applied') }}
                    </div>
                  @endif
                @endif

                @if ($package->price - $cAmount <= 0 || $status == 'trial')
                @else
                  <div class="order-payment form-block">
                    <div class="title">
                      <h3>{{ __('Payment Method') }}</h3>
                    </div>
                    <div class="form-group mb-30">
                      <select name="payment_method" id="payment-gateway" class="olima_select">
                        <option value="" selected disabled>{{ __('Choose an option') }}
                        </option>
                        @foreach ($payment_methods as $payment_method)
                          <option value="{{ $payment_method->name }}"
                            {{ old('payment_method') == $payment_method->name ? 'selected' : '' }}>
                            {{ $payment_method->name }}
                          </option>
                        @endforeach
                      </select>
                      @if ($errors->has('payment_method'))
                        <span class="method-error">
                          <strong>{{ $errors->first('payment_method') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                @endif
              </div>

              <div class="iyzico-element {{ old('payment_method') == 'Iyzico' ? '' : 'd-none' }}">
                <input type="text" name="identity_number" class="form-control mt-2 mb-2"
                  placeholder="{{ __('Identity Number') }}" value="{{ old('identity_number') }}">
                @error('identity_number')
                  <p class="text-danger text-left">{{ $message }}</p>
                @enderror

                <input type="text" name="zip_code" class="form-control" placeholder="{{ __('Zip Code') }}"
                  value="{{ old('zip_code') }}">
                @error('zip_code')
                  <p class="text-danger text-left">{{ $message }}</p>
                @enderror
              </div>

              <div class="row d-none py-3" id="tab-stripe">
                <div class="col-lg-12">
                  <div class="form-group mb-3">
                    <div id="stripe-element" class="mb-2 ">

                    </div>
                  </div>
                  <p class="text-danger" id="stripe-errors"></p>
                </div>
              </div>

              <div class="row d-none py-3" id="tab-anet">
                <div class="col-lg-6">
                  <div class="form-group mb-3">
                    <input class="form-control" type="text" id="anetCardNumber" placeholder="Card Number"
                      disabled />
                  </div>
                </div>
                <div class="col-lg-6 mb-3">
                  <div class="form-group">
                    <input class="form-control" type="text" id="anetExpMonth" placeholder="Expire Month"
                      disabled />
                  </div>
                </div>
                <div class="col-lg-6 ">
                  <div class="form-group">
                    <input class="form-control" type="text" id="anetExpYear" placeholder="Expire Year" disabled />
                  </div>
                </div>
                <div class="col-lg-6 ">
                  <div class="form-group">
                    <input class="form-control" type="text" id="anetCardCode" placeholder="Card Code" disabled />
                  </div>
                </div>
                <input type="hidden" name="opaqueDataValue" id="opaqueDataValue" disabled />
                <input type="hidden" name="opaqueDataDescriptor" id="opaqueDataDescriptor" disabled />
                <ul id="anetErrors"></ul>
              </div>

              <div>
                <div id="instructions"></div>
                <input type="hidden" name="is_receipt" value="0" id="is_receipt">
                @if ($errors->has('receipt'))
                  <span class="error">
                    <strong>{{ $errors->first('receipt') }}</strong>
                  </span>
                @endif
              </div>


              <div class="text-center mt-4">
                <button form="my-checkout-form" id="confirmBtn" class="btn primary-btn w-100"
                  type="submit">{{ __('Confirm') }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>

@endsection

@section('scripts')
  <script>
    var couponRoute = "{{ route('front.membership.coupon') }}";
    var stripe_key = "{{ $stripe_key ?? '' }}";
    var packageId = {{ $package->id }};
    var ogateways = @php echo json_encode($offline) @endphp;
    var oinstructions = "{{ route('front.payment.instructions') }}";
  </script>
  <script src="{{ asset('assets/front/js/checkout.js') }}"></script>


  @php
    $anet = App\Models\PaymentGateway::find(20);
    $anerInfo = $anet->convertAutoData();
    $anetTest = $anerInfo['sandbox_check'] ?? false;

    if ($anetTest == 1) {
        $anetSrc = 'https://jstest.authorize.net/v1/Accept.js';
    } else {
        $anetSrc = 'https://js.authorize.net/v1/Accept.js';
    }
  @endphp
  <script>
    var clientKey = "{{ $anerInfo['public_key'] ?? '' }}";
    var loginId = "{{ $anerInfo['login_id'] ?? '' }}";
  </script>
  @if (!empty($stripe_key))
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('assets/front/js/stripe.js') }}"></script>
  @endif
  <script type="text/javascript" src="{{ $anetSrc }}" charset="utf-8"></script>
  <script src="{{ asset('assets/front/js/anet.js') }}"></script>

@endsection
