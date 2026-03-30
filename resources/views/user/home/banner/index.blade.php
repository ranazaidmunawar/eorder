@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">Banner Section</h4>
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
                <a href="#">Banner Section</a>
            </li>
        </ul>
    </div>
    <div class="row">
        @if ($activeTheme == 'desifoodie')
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="card-title d-inline-block">Banner Section</div>
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
                    <div class="card-body">
                        <div class="col-lg-8 m-auto">
                            <form action="{{ route('user.banner.update_section') }}" method="post" id="ajaxForm">
                                @csrf
                                <input type="hidden" name="language" value="{{ request()->input('language') }}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Section Title</label>
                                            <input type="text" name="title" value="{{ @$bannerSection->title }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Section Product</label>
                                            <select name="items[]" class="form-control select2" multiple>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ in_array($product->id, $selectedItems) ? 'selected' : '' }}>
                                                        {{ $product->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Banner Image --}}
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="image"><strong>Banner Image **</strong></label>
                                            <br>
                                            <div class="showImage mb-3">
                                                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_BANNER_IMAGE, $banner->image, $userBs) }}"
                                                    alt="..." class="img-thumbnail" id="previewImage">
                                            </div>
                                            <input type="file" name="banner_image" id="image"
                                                class="form-control image">
                                            <p id="errbanner_image" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                    {{-- Title --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Banner Title **</label>
                                            <input type="text" name="banner_title" id="title" class="form-control"
                                                placeholder="Enter title" value="{{ $banner->title }}">
                                            <p id="errbanner_title" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                    {{-- Subtitle --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Banner Subtitle **</label>
                                            <input type="text" name="banner_subtitle" id="subtitle" class="form-control"
                                                placeholder="Enter subtitle" value="{{ $banner->subtitle }}">
                                            <p id="errbanner_subtitle" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Button Name **</label>
                                            <input type="text" name="button_text" id="button_text" class="form-control"
                                                placeholder="Enter button name" value="{{ $banner->button_text }}">
                                            <p id="errbutton_text" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                    {{-- Button URL --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Button URL **</label>
                                            <input type="text" name="button_url" id="button_url" class="form-control"
                                                placeholder="Enter button url" value="{{ $banner->button_url }}">
                                            <p id="errbutton_url" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Banner Text **</label>
                                            <textarea name="banner_text" rows="4" class="form-control">{{ $banner->text }}</textarea>
                                            <p id="errbanner_text" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-success" type="submit" id="submitBtn">Update</button>
                    </div>
                </div>
            </div>
        @endif

        @if ($activeTheme == 'desices' || $activeTheme == 'seabbq')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card-title d-inline-block">Banner Section</div>
                            </div>
                            <div class="col-lg-3">
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
                            <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                                @if (count($banners) == 0 && $activeTheme == 'desifoodie')
                                    <a href="#" class="btn btn-primary float-lg-right float-left"
                                        data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add
                                        Banner</a>
                                @elseif (count($banners) < 2 && $activeTheme == 'seabbq')
                                    <a href="#" class="btn btn-primary float-lg-right float-left"
                                        data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add
                                        Banner</a>
                                @elseif (count($banners) < 2 && $activeTheme == 'desices')
                                    <a href="#" class="btn btn-primary float-lg-right float-left"
                                        data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add
                                        Banner</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                @if (count($banners) == 0)
                                    <h3 class="text-center">NO BANNER FOUND</h3>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-striped mt-3" id="basic-datatables">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Position</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($banners as $key => $banner)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_BANNER_IMAGE, $banner->image, $userBs) }}"
                                                                alt="" width="80">
                                                        </td>
                                                        <td>{{ convertUtf8($banner->title) }}</td>
                                                        <td>{{ $banner->position }}</td>
                                                        <td>
                                                            <a class="btn btn-secondary my-2 btn-sm"
                                                                href="{{ route('user.banner.edit', $banner->id) . '?language=' . request()->input('language') }}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            <form class="deleteform d-inline-block"
                                                                action="{{ route('user.banner.delete') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="banner_id"
                                                                    value="{{ $banner->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm deletebtn">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        @endif
    </div>
    @if ($activeTheme == 'desices' || $activeTheme == 'seabbq')
        @include('user.home.banner.create')
    @endif
@endsection
