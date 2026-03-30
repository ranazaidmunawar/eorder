@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
@endphp

@extends('user.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ __('Add Blog') }}</h4>
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
                <a href="#">{{ __('Blog Management') }}</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Blog') }}</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Add Blog') }}</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">{{ __('Add Blog') }}</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block"
                       href="{{ route('user.blog_management.blogs', ['language' => $defaultLang->code]) }}">
            <span class="btn-label">
              <i class="fas fa-backward"></i>
            </span>
                        {{ __('Back') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="alert alert-danger pb-1 dis-none" id="blogErrors">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <ul></ul>
                            </div>

                            <form id="blogForm" action="{{ route('user.blog_management.store_blog') }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group px-0">
                                            <div class="mb-2">
                                                <label for="image"><strong>{{ __('Image') . '*' }}</strong></label>
                                            </div>
                                            <div class="showImage mb-3">
                                                <img
                                                    src="{{ asset('assets/admin/img/noimage.jpg')}}"
                                                    alt="..."
                                                    class="img-thumbnail" width="200">
                                            </div>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>
                                        <p class="text-warning mb-0">{{__('Upload 370 X 280 image for best quality')}}</p>
                                    </div>
                                </div>

                                <div class="form-group px-0">
                                    <label>{{ __('Serial Number') . '*' }}</label>
                                    <input class="form-control" type="number" name="serial_number"
                                           placeholder="Enter Serial Number">
                                    <p class="text-warning mt-2 mb-0">
                                        <small>{{ __('The higher the serial number is, the later the blog will be shown.') }}</small>
                                    </p>
                                </div>

                                <div class="accordion accordion-secondary mt-3" id="accordion">
                                    @foreach ($userLangs as $language)
                                        <div class="card">
                                            <div class="card-header {{ $language->is_default == 1 ? '' : 'collapsed' }}" id="heading{{ $language->id }}" data-toggle="collapse"
                                                data-target="#collapse{{ $language->id }}"
                                                aria-expanded="{{ $language->is_default == 1 ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $language->id }}">
                                                <div class="span-title">
                                                    {{ $language->name . __(' Language') }}
                                                    {{ $language->is_default == 1 ? '(Default)' : '' }}
                                                </div>
                                                <div class="span-mode"></div>
                                            </div>

                                            <div id="collapse{{ $language->id }}"
                                                 class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                                                 aria-labelledby="heading{{ $language->id }}" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                <label>{{ __('Title') . '*' }}</label>
                                                                <input type="text" class="form-control"
                                                                       name="{{ $language->code }}_title"
                                                                       placeholder="Enter Title">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                @php
                                                                    $categories = DB::table('user_blog_categories')
                                                                    ->where('language_id', $language->id)->where('user_id', Auth::guard('web')->user()->id)
                                                                    ->where('status', 1)->orderByDesc('id')
                                                                    ->get();
                                                                @endphp

                                                                <label for="">{{ __('Category') . '*' }}</label>
                                                                <select name="{{ $language->code }}_category_id"
                                                                        class="form-control">
                                                                    <option selected
                                                                            disabled>{{ __('Select Category') }}</option>
                                                                    @foreach ($categories as $category)
                                                                        <option
                                                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                <label>{{ __('Author') . '*' }}</label>
                                                                <input type="text" class="form-control"
                                                                       name="{{ $language->code }}_author"
                                                                       placeholder="Enter Author Name">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                <label>{{ __('Content') . '*' }}</label>
                                                                <textarea class="form-control summernote"
                                                                          name="{{ $language->code }}_content"
                                                                          id="{{ $language->code }}_content"
                                                                          placeholder="Enter Blog Content"
                                                                          data-height="300"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                <label>{{ __('Meta Keywords') }}</label>
                                                                <input class="form-control"
                                                                       name="{{ $language->code }}_meta_keywords"
                                                                       placeholder="Enter Meta Keywords"
                                                                       data-role="tagsinput">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                <label>{{ __('Meta Description') }}</label>
                                                                <textarea class="form-control"
                                                                          name="{{ $language->code }}_meta_description"
                                                                          rows="5"
                                                                          placeholder="Enter Meta Description"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            @php $currLang = $language; @endphp
                                                            @foreach ($languages as $lang)
                                                                @continue($lang->id == $currLang->id)
                                                                <div class="form-check py-0">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               onchange="cloneInput('collapse{{ $currLang->id }}', 'collapse{{ $lang->id }}', event)">
                                                                        <span class="form-check-sign">{{ __('Clone for') }} <strong
                                                                                class="text-capitalize text-secondary">{{ $lang->name }}</strong> {{ __('language') }}</span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" form="blogForm" class="btn btn-success">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/tenant/js/partial.js') }}"></script>
@endsection
