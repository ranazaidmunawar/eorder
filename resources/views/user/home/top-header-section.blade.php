@extends('user.layout')

@if (!empty($abs->language) && $abs->language->rtl == 1)
    @section('styles')
        <style>
            form input,
            form textarea,
            form select,
            select {
                direction: rtl;
            }

            form .note-editor.note-frame .note-editing-area .note-editable {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Top Header Section</h4>
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
                <a href="#">Top Header Section</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">Update Top Header Section</div>
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
                        <div class="col-lg-8 m-auto">

                            <form id="ajaxForm" action="{{ route('user.topheader.update') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ request()->input('language') }}" name="language">
                                <div class="form-group">
                                    <label for="">Support Text</label>
                                    <input type="text" class="form-control" name="top_header_support_text"
                                        value="{{ $abs->top_header_support_text }}">
                                    <p id="errtop_header_support_text" class="em text-danger mb-0"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Support Email Text</label>
                                    <input type="email" class="form-control" name="top_header_support_email"
                                        value="{{ $abs->top_header_support_email }}">
                                    <p id="errtop_header_support_email" class="em text-danger mb-0"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Header Middle Text</label>
                                    <input type="text" class="form-control" name="top_header_middle_text"
                                        value="{{ $abs->top_header_middle_text }}">
                                    <p id="errtop_header_middle_text" class="em text-danger mb-0"></p>
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
