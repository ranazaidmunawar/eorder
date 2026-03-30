@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Reservation'] ?? __('Reservation') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->reservation_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->reservation_meta_description : '')
@section('content')

    @include('user-front.breadcrum', ['title' => $upageHeading?->reservation_page_title])

    <section class="reservation-2-area reservation-3-area book-reservation">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-bg pt-130 pb-120">
                        <div class="reservation-tree">
                            <img class="lazy"
                                data-src="{{ $userBe->table_section_img ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->table_section_img, $userBs) : asset('assets/user/img/pata.png') }}"
                                alt="">
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="section-title text-center">
                                    <span>{{ convertUtf8($userBe->table_section_title) }}
                                        <img class="lazy" data-src="{{ asset('assets/front/img/title-icon.png') }}"
                                            alt=""></span>
                                    <h3 class="title">{{ convertUtf8($userBe->table_section_subtitle) }}</h3>
                                </div>
                                <form action="{{ route('user.front.table.book', getParam()) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="input-box mt-20">
                                                <label>{{ $keywords['Full Name'] ?? __('Full Name') }}
                                                    <span>**</span></label>
                                                <input type="text"
                                                    placeholder="{{ $keywords['Full Name'] ?? __('Full Name') }}"
                                                    name="name" value="{{ old('name') }}">
                                                @error('name')
                                                    <p class="text-danger">{{ convertUtf8($message) }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-box mt-20">
                                                <label>{{ $keywords['Email_Address'] ?? __('Email Address') }}
                                                    <span>**</span></label>
                                                <input type="text"
                                                    placeholder="{{ $keywords['Email_Address'] ?? __('Email Address') }}"
                                                    name="email" value="{{ old('email') }}">
                                                @error('email')
                                                    <p class="text-danger">{{ convertUtf8($message) }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        @foreach ($inputs as $input)
                                            <div
                                                class="{{ $input->type == 4 || $input->type == 3 ? 'col-lg-12' : 'col-lg-6' }}">
                                                <div class="input-box mt-20">
                                                    @if ($input->type == 1)
                                                        <label>{{ convertUtf8($input->label) }} @if ($input->required == 1)
                                                                <span>**</span>
                                                            @endif
                                                        </label>
                                                        <input name="{{ $input->name }}" type="text"
                                                            value="{{ old("$input->name") }}"
                                                            placeholder="{{ convertUtf8($input->placeholder) }}">
                                                    @endif

                                                    @if ($input->type == 2)
                                                        <label>{{ convertUtf8($input->label) }} @if ($input->required == 1)
                                                                <span>**</span>
                                                            @endif
                                                        </label>
                                                        <select class="form-control" name="{{ $input->name }}">
                                                            <option value="" selected disabled>
                                                                {{ convertUtf8($input->placeholder) }}
                                                            </option>
                                                            @foreach ($input->reservation_input_options as $option)
                                                                <option value="{{ convertUtf8($option->name) }}"
                                                                    {{ old("$input->name") == convertUtf8($option->name) ? 'selected' : '' }}>
                                                                    {{ convertUtf8($option->name) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @endif

                                                    @if ($input->type == 3)
                                                        <label>{{ convertUtf8($input->label) }} @if ($input->required == 1)
                                                                <span>**</span>
                                                            @endif
                                                        </label> <br>
                                                        @foreach ($input->reservation_input_options as $option)
                                                            <div
                                                                class="custom-control custom-checkbox custom-control-inline">
                                                                <input type="checkbox"
                                                                    id="customCheckboxInline{{ $option->id }}"
                                                                    name="{{ $input->name }}[]"
                                                                    class="custom-control-input"
                                                                    value="{{ convertUtf8($option->name) }}"
                                                                    {{ is_array(old("$input->name")) && in_array(convertUtf8($option->name), old("$input->name")) ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="customCheckboxInline{{ $option->id }}">{{ convertUtf8($option->name) }}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                    @if ($input->type == 4)
                                                        <label>{{ convertUtf8($input->label) }} @if ($input->required == 1)
                                                                <span>**</span>
                                                            @endif
                                                        </label>
                                                        <textarea name="{{ $input->name }}" id="" cols="5" rows="3"
                                                            placeholder="{{ convertUtf8($input->placeholder) }}">{{ old("$input->name") }}</textarea>
                                                    @endif

                                                    @if ($input->type == 5)
                                                        <label>{{ convertUtf8($input->label) }} @if ($input->required == 1)
                                                                <span>**</span>
                                                            @endif
                                                        </label>
                                                        <input class="datepicker" name="{{ $input->name }}" type="text"
                                                            value="{{ old("$input->name") }}"
                                                            placeholder="{{ convertUtf8($input->placeholder) }}"
                                                            autocomplete="off">
                                                    @endif

                                                    @if ($input->type == 6)
                                                        <label>{{ convertUtf8($input->label) }} @if ($input->required == 1)
                                                                <span>**</span>
                                                            @endif
                                                        </label>
                                                        <input class="timepicker" name="{{ $input->name }}" type="text"
                                                            value="{{ old("$input->name") }}"
                                                            placeholder="{{ convertUtf8($input->placeholder) }}"
                                                            autocomplete="off">
                                                    @endif

                                                    @if ($input->type == 7)
                                                        <label>{{ convertUtf8($input->label) }} @if ($input->required == 1)
                                                                <span>**</span>
                                                            @endif
                                                        </label>
                                                        <input name="{{ $input->name }}" type="number"
                                                            value="{{ old("$input->name") }}"
                                                            placeholder="{{ convertUtf8($input->placeholder) }}"
                                                            autocomplete="off">
                                                    @endif

                                                    @if ($errors->has("$input->name"))
                                                        <p class="text-danger mb-0">{{ $errors->first("$input->name") }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach


                                        @if ($userBs->is_recaptcha == 1)
                                            <div class="col-lg-12 mt-20 text-center">
                                                <div id="g-recaptcha" class="g-recaptcha d-inline-block"></div>
                                                @if ($errors->has('g-recaptcha-response'))
                                                    @php
                                                        $errmsg = $errors->first('g-recaptcha-response');
                                                    @endphp
                                                    <p class="text-danger mb-0">{{ __("$errmsg") }}</p>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="col-lg-12">
                                            <div class="book-btn text-center mt-20">
                                                <button class="main-btn main-btn-2"
                                                    type="submit">{{ $keywords['Book Table'] ?? __('Book Table') }}
                                                </button>
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
    </section>
@endsection
