@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">Edit Banner</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('user.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Website Pages</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Home Page</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Banner Section</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Edit Banner</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Edit Banner</div>
                </div>

                <div class="card-body">
                    <div class="col-lg-8 m-auto">
                        <form id="ajaxForm" method="POST" enctype="multipart/form-data"
                            action="{{ route('user.banner.update') }}">
                            @csrf
                            <input type="hidden" name="banner_id" value="{{ $banner->id }}">

                            {{-- Banner Image --}}
                            <div class="form-group">
                                <label for="image"><strong>Banner Image **</strong></label>
                                <br>
                                <div class="showImage mb-3">
                                    <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_BANNER_IMAGE, $banner->image, $userBs) }}"
                                        alt="..." class="img-thumbnail" id="previewImage">
                                </div>
                                <input type="file" name="image" id="image" class="form-control image">
                                <p id="errimage" class="mb-0 text-danger em"></p>
                            </div>

                            {{-- Title --}}
                            <div class="form-group">
                                <label>Title **</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Enter title" value="{{ $banner->title }}">
                                <p id="errtitle" class="mb-0 text-danger em"></p>
                            </div>

                            {{-- Subtitle --}}
                            <div class="form-group">
                                <label>Subtitle **</label>
                                <input type="text" name="subtitle" id="subtitle" class="form-control"
                                    placeholder="Enter subtitle" value="{{ $banner->subtitle }}">
                                <p id="errsubtitle" class="mb-0 text-danger em"></p>
                            </div>

                            @if ($activeTheme == 'desifoodie' || $activeTheme == 'desices')
                                <input type="hidden" name="position" value="left">
                                <div class="form-group">
                                    <label>Text **</label>
                                    <textarea name="text" rows="4" class="form-control">{{ $banner->text }}</textarea>
                                    <p id="errtext" class="mb-0 text-danger em"></p>
                                </div>
                            @endif

                            {{-- Button Name --}}
                            <div class="form-group">
                                <label>Button Name **</label>
                                <input type="text" name="button_text" id="button_text" class="form-control"
                                    placeholder="Enter button name" value="{{ $banner->button_text }}">
                                <p id="errbutton_text" class="mb-0 text-danger em"></p>
                            </div>

                            {{-- Button URL --}}
                            <div class="form-group">
                                <label>Button URL **</label>
                                <input type="text" name="button_url" id="button_url" class="form-control"
                                    placeholder="Enter button url" value="{{ $banner->button_url }}">
                                <p id="errbutton_url" class="mb-0 text-danger em"></p>
                            </div>

                            {{-- Status --}}
                            <div class="form-group">
                                <label>Status **</label>
                                <select name="status" class="form-control">
                                    <option disabled>Select a status</option>
                                    <option value="1" {{ $banner->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $banner->status == 0 ? 'selected' : '' }}>Deactive</option>
                                </select>
                                <p id="errstatus" class="mb-0 text-danger em"></p>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-footer text-center">
                    <button type="submit" id="submitBtn" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection
