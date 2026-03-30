@php use App\Constants\Constant;use App\Http\Helpers\Uploader; @endphp
@extends('user.layout')

@if(!empty($abe->language) && $abe->language->rtl == 1)
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
        <h4 class="page-title">Text & Image</h4>
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
                <a href="#">Reservation Settings</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Text & Image</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">Update Text & Image</div>
                        </div>
                        <div class="col-lg-2">
                              @includeIf('user.partials.languages')
                        </div>
                    </div>
                </div>
                <div class="card-body pt-5 pb-4">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">

                            <form id="ajaxForm" action="{{route('user.table.section.update', $lang_id)}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="mb-2">
                                                <label for="image"><strong> Background Image </strong></label>
                                            </div>
                                            <div class="showImage mb-3">
                                                @if (!empty($abe->table_section_img))
                                                    <a class="remove-image" data-type="table_background"><i
                                                            class="far fa-times-circle"></i></a>
                                                @endif
                                                
                                                @if($abe->table_section_img)
                                                
                                                <img
                                                    src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE,$abe->table_section_img,$userBs)}}"
                                                    alt="..." class="img-thumbnail" width="200">
                                                @else
                                                
                                                <img
                                                    src="{{asset('assets/admin/img/noimage.jpg')}}"
                                                    alt="..." class="img-thumbnail" width="200">
                                                @endif
                                            </div>
                                            <input type="file" name="table_section_img" id="image"
                                                   class="form-control image">
                                            <p id="errtable_section_img" class="mb-0 text-danger em"></p>
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

@section('scripts')
<script>
    let routeUrl = "{{route('user.table.section.rmv.img')}}";
    let currentUrl = "{{url()->current()}}";
    let langCode = "{{$abs->language->code}}";
</script>
<script src="{{ asset('assets/tenant/js/blade.js') }}"></script>

@endsection
