@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')
  {{$keywords['Contact'] ??  __('Contact') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->contact_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->contact_meta_description : '')
@section('content')


    @include('user-front.breadcrum',['title' => $upageHeading?->contact_page_title])


    <section class="contact-area pt-60 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-form pt-75">
                        <h4 class="comment-title">{{convertUtf8($contact->contact_form_title)}}</h4>
                        <form action="{{route('user.front.sendmail',getParam())}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="single-form">
                                        <label>{{$keywords["Your_Name"] ?? __('Your Name') }} *</label>
                                        <input name="name" type="text">
                                        @error('name')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-form">
                                        <label>{{$keywords["Email_Address"] ?? __('Email Address')}} *</label>
                                        <input name="email" type="email">
                                        @error('email')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single-form">
                                        <label>{{$keywords["Subject"] ?? __('Subject')}} *</label>
                                        <input name="subject" type="text">
                                        @error('subject')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">

                                    <div class="single-form">
                                        <label>{{$keywords["Write_a_message"] ?? __('Write a message')}} *</label>
                                        <textarea name="message"></textarea>
                                        @error('message')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>

                                @if ($userBs->is_recaptcha == 1)
                                    <div class="col-lg-12">
                                        <div id="g-recaptcha" class="g-recaptcha d-inline-block"></div>
                                        @if ($errors->has('g-recaptcha-response'))
                                            @php
                                                $errmsg = $errors->first('g-recaptcha-response');
                                            @endphp
                                            <p class="text-danger mb-0">{{__("$errmsg")}}</p>
                                        @endif
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <div class="single-form">
                                        <button type="submit">{{$keywords["Submit_Now"] ?? __('Submit Now')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p class="form-message"></p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 offset-lg-1">
                    <div class="contact-area-info">
                        <div class="title-area">
                            <h4 class="title">{{convertUtf8($contact->contact_info_title)}}</h4>
                            <p>{{convertUtf8($contact->contact_text)}}</p>
                        </div>
                        <div class="contact-info-list">
                            @if (!empty($userBs->contact_address))
                                <div class="item mt-30">
                                    <i class="flaticon-placeholder"></i>
                                    @php
                                        $addresses = explode(PHP_EOL, $userBs->contact_address);
                                    @endphp
                                    <ul>
                                        @foreach ($addresses as $address)
                                            <li class="d-block mb-0"> {{convertUtf8($address)}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (!empty($userBs->contact_mails))

                                <div class="item mt-30">
                                    <i class="flaticon-mail"></i>
                                    <ul>
                                        @php
                                            $mails = explode(',', $userBs->contact_mails);
                                        @endphp
                                        @foreach ($mails as $mail)
                                            <li class="d-block mb-0">{{$mail}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (!empty($userBs->contact_number))
                                <div class="item mt-30">
                                    <i class="flaticon-smartphone"></i>
                                    <ul>
                                        @php
                                            $phones = explode(',', $userBs->contact_number);
                                        @endphp
                                        @foreach ($phones as $phone)
                                            <li class="d-block mb-0">{{$phone}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
