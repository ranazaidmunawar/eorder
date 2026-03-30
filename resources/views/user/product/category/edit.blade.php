@extends('user.layout')

@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;

@endphp
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
        <h4 class="page-title">Edit Category</h4>
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
                <a href="#">Service Page</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Edit Category</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Edit Category</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block"
                        href="{{ route('user.category.index') . '?language=' . request()->input('language') }}">
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
                            <form id="blogForm" action="{{ route('user.category.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @if ($activeTheme != 'seabbq')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="image"><strong>Image</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($data->image))
                                                        <a class="remove-image" data-type="pcategory"><i
                                                                class="far fa-times-circle"></i></a>
                                                        <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $data->image, $userBs) }}"
                                                            alt="..." class="img-thumbnail" width="200">
                                                    @else
                                                        <img src="{{ asset('assets/admin/img/noimage.jpg') }}"
                                                            alt="..." class="img-thumbnail" width="200">
                                                    @endif
                                                </div>
                                                <input type="file" name="image" id="image"
                                                    class="form-control image">
                                                <p id="errimage" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @foreach ($languages as $language)
                                    @php
                                        $category = App\Models\User\Pcategory::where('indx', $data->indx)
                                            ->where('language_id', $language->id)
                                            ->first();
                                    @endphp
                                    <div class="form-group">
                                        <label for="">Name({{ $language->code }}) **</label>
                                        <input type="text" class="form-control" value="{{ $category?->name }}"
                                            name="{{ $language->code }}_name" placeholder="Enter name">
                                        <p id="errname" class="mb-0 text-danger em"></p>
                                    </div>
                                @endforeach
                                <div class="form-group">
                                    <label for="">Tax</label>
                                    <input type="text" class="form-control" name="tax" value="{{ $data->tax }}"
                                        placeholder="Enter tax in %" autocomplete="off">
                                    <p id="errtax" class="mb-0 text-danger em"></p>
                                </div>
                                <input type="hidden" name="category_indx" value="{{ $data->indx }}">

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


@section('scripts')
    <script>
        let routeUrl = "{{ route('user.pcategory.rmv.img') }}";
        let currentUrl = "{{ url()->current() }}";
        let langCode = "{{ $data->language->code }}";
        let pcategory_id = "{{ $data->id }}";
    </script>
    <script src="{{ asset('assets/tenant/js/blade.js') }}"></script>
@endsection
