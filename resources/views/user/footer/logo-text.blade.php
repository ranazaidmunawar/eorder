@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user.layout')

@includeIf('user.partials.rtl-style')

@section('content')
    <div class="page-header">
        <h4 class="page-title">Logo & Text</h4>
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
                <a href="#">Footer</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Logo & Text</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">Update Logo & Text</div>
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

                            <form id="ajaxForm" action="{{ route('user.footer.update', $lang_id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="mb-2">
                                                <label for="image"><strong>Logo</strong></label>
                                            </div>
                                            <div class="coverImg mb-3">
                                                <img src="{{ $abs->footer_logo ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abs->footer_logo, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                    alt="..." class="img-thumbnail" width="200">
                                            </div>
                                            <input type="file" name="footer_logo" id="cover_image" class="form-control">
                                            <p id="errfooter_logo" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="mb-2">
                                                <label for="footer_bottom_img">
                                                    @if($activeTheme == 'seabbq' || $activeTheme == 'desifoodie' || $activeTheme == 'desices')
                                                     <strong>Background Image</strong>
                                                    @else
                                                    <strong>Bottom Image</strong>
                                                    @endif
                                                </label>
                                            </div>
                                            <div class="showImage mb-3">
                                                @if (!empty($abe->footer_bottom_img))
                                                    <a class="remove-image" data-type="bottom"><i
                                                            class="far fa-times-circle"></i></a>
                                                @endif
                                                <img src="{{ $abe->footer_bottom_img ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->footer_bottom_img, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                    alt="..." class="img-thumbnail" width="200">
                                            </div>
                                            <input type="file" name="footer_bottom_img" class="form-control image">
                                            <p id="errfooter_bottom_img" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Footer Text **</label>
                                    <input type="text" class="form-control" name="footer_text"
                                        value="{{ $abs->footer_text }}">
                                    <p id="errfooter_text" class="em text-danger mb-0"></p>
                                </div>

                                <div class="form-group">
                                    <label for="">Copyright Text **</label>
                                    <textarea id="copyright_text" name="copyright_text" class="summernote form-control" data-height="150">{{ replaceBaseUrl($abs->copyright_text) }}</textarea>
                                    <p id="errcopyright_text" class="em text-danger mb-0"></p>
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


@section('scripts')
    <script>
        let routeUrl = "{{ route('user.footer.rmv.img') }}";
        let currentUrl = "{{ url()->current() }}";
        let langCode = "{{ $abs->language->code }}";
    </script>
    <script src="{{ asset('assets/tenant/js/blade.js') }}"></script>
@endsection
