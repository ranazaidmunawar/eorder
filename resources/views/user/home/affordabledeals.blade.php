@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user.layout')

@if (!empty($abe->language) && $abe->language->rtl == 1)
    @section('styles')
        <style>
            form:not(.modal-form) input,
            form:not(.modal-form) textarea,
            form:not(.modal-form) select,
            select[name='language'] {
                direction: rtl;
            }

            form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Affordable Deals</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('user.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Website Pages</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Home Page</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Affordable Deals</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">Update Section</div>
                        </div>
                        <div class="col-lg-2">
                            @if (!empty($userLangs))
                                <select name="language" class="form-control"
                                    onchange="window.location='{{ url()->current() . '?language=' }}'+this.value">
                                    <option value="" selected disabled>Select a Language</option>
                                    @foreach ($userLangs as $lang)
                                        <option value="{{ $lang->code }}"
                                            {{ $lang->code == request()->input('language') ? 'selected' : '' }}>
                                            {{ $lang->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body pt-5 pb-4">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">

                            <form id="ajaxForm" action="{{ route('user.affordableDeal.section.update', $lang_id) }}"
                                method="post">
                                @csrf
                                <div class="row">
                                    @if ($activeTheme == 'seabbq')
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label for="image"><strong>Left Shape Image</strong></label>
                                            <div class="form-group">
                                                <div class="showImage mb-3">

                                                    @if (!empty($abe->left_shape_image))
                                                        <a class="remove-image" data-type="left_shape_image"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->left_shape_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->left_shape_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="..." class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="left_shape_image" class="form-control image">
                                                @if ($errors->has('left_shape_image'))
                                                    <p class="mb-0 text-danger">
                                                        {{ $errors->first('left_shape_image') }}
                                                    </p>
                                                @endif
                                                <p id="errleft_shape_image" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label for="image"><strong>Right Shape Image</strong></label>
                                            <div class="form-group">
                                                <div class="showImage mb-3">

                                                    @if (!empty($abe->right_shape_image))
                                                        <a class="remove-image" data-type="right_shape_image"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->right_shape_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->right_shape_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="..." class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="right_shape_image" class="form-control image">
                                                @if ($errors->has('right_shape_image'))
                                                    <p class="mb-0 text-danger">
                                                        {{ $errors->first('right_shape_image') }}</p>
                                                @endif
                                                <p id="errright_shape_image" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($activeTheme == 'desifoodie')
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label for="image"><strong>Background Image</strong></label>
                                            <div class="form-group">
                                                <div class="showImage mb-3">

                                                    @if (!empty($abe->background_image))
                                                        <a class="remove-image" data-type="background_image"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->background_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->background_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="..." class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="background_image" class="form-control image">
                                                @if ($errors->has('background_image'))
                                                    <p class="mb-0 text-danger">
                                                        {{ $errors->first('background_image') }}</p>
                                                @endif
                                                <p id="errbackground_image" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Title **</label>
                                            <input name="section_title" class="form-control"
                                                value="{{ @$abe->section_title }}">
                                            <p id="errsection_title" class="em text-danger mb-0"></p>
                                            @if ($activeTheme == 'seabbq')
                                                <p class="text-warning mb-0">
                                                    Wrap the text with <code>&lt;span&gt;&lt;/span&gt;</code> to have an
                                                    underline
                                                    under the text.
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Select Products **</label>
                                            <select name="section_items[]" class="form-control select2" multiple>
                                                @php
                                                    $section_items =
                                                        json_decode($abe->section_items ?? '[]', true) ?? [];
                                                @endphp

                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" @selected(in_array($product->id, $section_items))>
                                                        {{ $product->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <p id="errsection_items[]" class="em text-danger mb-0"></p>
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
