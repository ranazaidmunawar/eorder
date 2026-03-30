@extends('user.layout')
@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@if (!empty($abs->language) && $abs->language->rtl == 1)
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
        <h4 class="page-title">Blog Section</h4>
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
                <a href="#">Blog Section</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">Update Blog Section</div>
                        </div>
                        <div class="col-lg-2">
                            @if (!empty($langs))
                                <select name="language" class="form-control"
                                    onchange="window.location='{{ url()->current() . '?language=' }}'+this.value">
                                    <option value="" selected disabled>Select a Language</option>
                                    @foreach ($langs as $lang)
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

                            <form id="ajaxForm" action="{{ route('user.blogsection.update', $lang_id) }}" method="post">
                                @csrf



                                @if ($activeTheme == 'desices')
                                    <div class="form-group">
                                        <div class="mb-2">
                                            <label for="image"><strong>Main Image **</strong></label>
                                        </div>
                                        <div class="showImage mb-3">
                                            <img src="{{ $abs->blog_section_bg_image ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abs->blog_section_bg_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                alt="..." class="img-thumbnail">
                                        </div>
                                        <input type="file" name="blog_section_bg_image" id=""
                                            class="form-control image">
                                        <p id="errblog_section_bg_image" class="mb-0 text-danger em"></p>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="">Title **</label>
                                    <input name="blog_section_title" class="form-control"
                                        value="{{ $abs->blog_section_title }}">
                                    <p id="errblog_section_title" class="em text-danger mb-0"></p>
                                    @if ($activeTheme == 'seabbq')
                                        <p class="text-warning">
                                            Wrap the text with <code>&lt;span&gt;&lt;/span&gt;</code> to have an
                                            underline
                                            under the text.
                                        </p>
                                    @endif
                                </div>
                                @if ($activeTheme == 'fastfood')
                                    <div class="form-group">
                                        <label for="">Text **</label>
                                        <input name="blog_section_subtitle" class="form-control"
                                            value="{{ $abs->blog_section_subtitle }}">
                                        <p id="errblog_section_subtitle" class="em text-danger mb-0"></p>
                                    </div>
                                @endif
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
