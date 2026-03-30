@extends('front.layout')

@section('meta-description', !empty($seo) ? $seo->contact_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->contact_meta_keywords : '')

@section('pagename')
    - {{ __('Contact') }}
@endsection
@section('breadcrumb-title')
    {{ __('Contact') }}
@endsection
@section('breadcrumb-link')
    {{ __('Contact') }}
@endsection

@section('content')
    <section class="contact-area pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row justify-content-center">
                        @php
                            $phones = explode(',', $be->contact_numbers);
                            $mails = explode(',', $be->contact_mails);
                            $addresses = explode(PHP_EOL, $be->contact_addresses);
                        @endphp
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-30 blue" data-aos="fade-up" data-aos-delay="100">
                                <div class="icon">
                                    <i class="fal fa-phone-plus"></i>
                                </div>
                                <div class="card-text">
                                    @foreach ($phones as $phone)
                                        <p><a href="tel:{{ $phone }}">{{ $phone }}</a></p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-30 green" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon">
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="card-text">
                                    @foreach ($mails as $mail)
                                        <p><a href="mailTo:{{ $mail }}">{{ $mail }}</a></p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-50 orange" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon">
                                    <i class="fal fa-map-marker-alt"></i>
                                </div>
                                <div class="card-text">
                                    @foreach ($addresses as $address)
                                        <p>{{ $address }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-8 mb-30" data-aos="fade-up" data-aos-delay="100">
                            <form id="contactForm" action="{{ route('front.admin.contact.message') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-30">
                                            <input type="text" name="name" class="form-control" id="name"
                                                required data-error="Enter your name"
                                                placeholder="{{ __('Full Name') }} *" />
                                            @if ($errors->has('name'))
                                                <div class="help-block with-errors text-danger">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-30">
                                            <input type="email" name="email" class="form-control" id="email"
                                                required data-error="Enter your email"
                                                placeholder="{{ __('Email Address') }}*" />
                                            @if ($errors->has('email'))
                                                <div class="help-block with-errors text-danger">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-30">
                                            <input type="text" name="subject" class="form-control" id="subject"
                                                required data-error="Enter your subject"
                                                placeholder="{{ __('Subject') }}*" />
                                            @if ($errors->has('subject'))
                                                <div class="help-block with-errors text-danger">{{ $errors->first('subject') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-30">
                                            <textarea name="message" id="message" class="form-control" cols="30" rows="8" required
                                                data-error="Please enter your message" placeholder="{{ __('Message') }}... *"></textarea>
                                            @if ($errors->has('message'))
                                                <div class="help-block with-errors text-danger">{{ $errors->first('message') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group mb-30">
                                        @if ($bs->is_recaptcha == 1)
                                            <div class="d-block mb-4">
                                                {!! NoCaptcha::renderJs() !!}
                                                {!! NoCaptcha::display() !!}
                                                @if ($errors->has('g-recaptcha-response'))
                                                    @php
                                                        $errmsg = $errors->first('g-recaptcha-response');
                                                    @endphp
                                                    <p class="text-danger mb-0 mt-2">{{ __("$errmsg") }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <button type="submit" class="btn primary-btn primary-btn-5"
                                            title="Send message">{{ __('Send Message') }}</button>
                                        <div id="msgSubmit"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

    </section>

@endsection
