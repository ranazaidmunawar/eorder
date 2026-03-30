@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

@extends('user.layout')

@if (!empty($testimonial->language) && $testimonial->language->rtl == 1)
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
        <h4 class="page-title">Edit Testimonial</h4>
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
                <a href="#">Edit Testimonial</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Edit Testimonial</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block"
                        href="{{ route('user.testimonial.index') . '?language=' . request()->input('language') }}">
                        <span class="btn-label">
                            <i class="fas fa-backward"></i>
                        </span>
                        Back
                    </a>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">

                            <form id="ajaxForm" class="" action="{{ route('user.testimonial.update') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @if ($activeTheme == 'desifoodie')
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="col-12 mb-2">
                                                    <label for="image"><strong>Background Image** </strong></label>
                                                </div>
                                                <div class="col-md-12 showImage mb-3">
                                                    <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->background_image, $userBs) }}"
                                                        alt="..." class="img-thumbnail">
                                                </div>
                                                <input type="file" name="background_image" 
                                                    class="form-control image">
                                                <p id="errbackground_image" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="col-12 mb-2">
                                                <label for="image"><strong> Image**</strong></label>
                                            </div>
                                            <div class="col-md-12 showImage mb-3">
                                                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->image, $userBs) }}"
                                                    alt="..." class="img-thumbnail" width="200">
                                            </div>
                                            <input type="file" name="image"  class="form-control image">
                                            <p id="errimage" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="testimonial_id" value="{{ $testimonial->id }}">
                                <div class="form-group">
                                    <label for="">Comment **</label>
                                    <textarea class="form-control" name="comment" rows="3" cols="80" placeholder="Enter comment">{{ $testimonial->comment }}</textarea>
                                    <p id="errcomment" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Name **</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ $testimonial->name }}" placeholder="Enter name">
                                    <p id="errname" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    @if ($activeTheme == 'seabbq' || $activeTheme == 'desifoodie')
                                        <label for="">Designation **</label>
                                    @else
                                        <label for="">Rank **</label>
                                    @endif
                                    <input type="text" class="form-control" name="rank"
                                        value="{{ $testimonial->rank }}"
                                        placeholder="Enter {{ $activeTheme == 'seabbq' || $activeTheme == 'desifoodie' ? 'designation' : 'rank' }}">
                                    <p id="errrank" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Rating ** </label>
                                    <input type="text" class="form-control ltr" name="rating"
                                        value="{{ $testimonial->rating }}" placeholder="Enter rating">
                                    <p id="errrating" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Serial Number **</label>
                                    <input type="number" class="form-control ltr" name="serial_number"
                                        value="{{ $testimonial->serial_number }}" placeholder="Enter Serial Number">
                                    <p id="errserial_number" class="mb-0 text-danger em"></p>
                                    <p class="text-warning"><small>The higher the serial number is, the later the
                                            testimonial will be shown.</small></p>
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
