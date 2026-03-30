@extends('user.layout')

@if (!empty($data->language) && $data->language->rtl == 1)
    @section('styles')
        <style>
            form input,
            form textarea,
            form select {
                direction: rtl;
            }

            .nicEdit-main {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Edit Subcategory</h4>
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
                <a href="#">Item Management</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Edit Subcategory</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Edit Subcategory</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block"
                        href="{{ route('user.subcategory.index') . '?language=' . request()->input('language') }}">
                        <span class="btn-label">
                            <i class="fas fa-backward"></i>
                        </span>
                        Back
                    </a>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="alert alert-danger pb-1 dis-none" id="blogErrors">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <ul></ul>
                            </div>
                            <form id="blogForm" action="{{ route('user.subcategory.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @foreach ($languages as $language)
                                    @php
                                        $subcat = App\Models\User\PsubCategory::where('indx', $data->indx)
                                            ->where('language_id', $language->id)
                                            ->first();
                                    @endphp
                                    <div class="form-group">
                                        <label for="">Name({{ $language->code }}) **</label>
                                        <input type="text" class="form-control" value="{{ $subcat?->name }}"
                                            name="{{ $language->code }}_name" placeholder="Enter name">
                                        <p id="errname" class="mb-0 text-danger em"></p>
                                    </div>
                                    <input type="hidden" name="{{ $language->code }}_id" value="{{ @$subcat->id }}">
                                @endforeach
                                <input type="hidden" name="subcategory_id" value="{{ $data->id }}">

                                <div class="form-group">
                                    <label for="">Category **</label>
                                    <select class="form-control ltr" name="category_id">
                                        <option value="" selected disabled>Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $data->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <p id="errcategory_id" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Status **</label>
                                    <select class="form-control ltr" name="status">
                                        <option value="" selected disabled>Select a status</option>
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                    <p id="errstatus" class="mb-0 text-danger em"></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" form="blogForm" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
