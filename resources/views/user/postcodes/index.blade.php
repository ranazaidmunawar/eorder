@php
    use App\Models\User\Language;
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('user.layout')

@php
    $setLang = Language::where([['code', request()->input('language')], ['user_id', Auth::guard('web')->user()->id]])->first();
@endphp
@if (!empty($setLang) && $setLang->rtl == 1)
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
        <h4 class="page-title">Postal Codes</h4>
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
                <a href="#">Order Management</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Postal Codes</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block">Postal Codes</div>
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
                            <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal"
                                data-target="#createModal"><i class="fas fa-plus"></i> Add Postal Code</a>
                            <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete"
                                data-href="{{ route('user.postalcode.bulk.delete') }}"><i class="flaticon-interface-5"></i>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-warning text-center text-dark">
                                This page will be available if 'postal code' is enabled by
                                <strong>{{ Auth::guard('web')->user()->username }} <a
                                        href="{{ route('user.order.settings') }}" target="_blank"
                                        class="text-decoration-none">(Order
                                        Management > Settings)</a> </strong>. For demo version we are always showing this
                                page.
                            </div>
                            @if (count($postcodes) == 0)
                                <h3 class="text-center">NO POSTAL CODE FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <input type="checkbox" class="bulk-check" data-val="all">
                                                </th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Post Code</th>
                                                <th scope="col">Charge</th>
                                                <th scope="col">Serial Number</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($postcodes as $key => $postcode)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="bulk-check"
                                                            data-val="{{ $postcode->id }}">
                                                    </td>
                                                    <td>
                                                        {{ convertUtf8(strlen($postcode->title)) > 60 ? convertUtf8(substr($postcode->title, 0, 60)) . '...' : convertUtf8($postcode->title) }}
                                                    </td>
                                                    <td>{{ $postcode->postcode }}</td>
                                                    <td>
                                                        {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                        {{ $postcode->charge }}
                                                        {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}

                                                    </td>
                                                    <td>{{ $postcode->serial_number }}</td>
                                                    <td>
                                                        <a class="btn btn-secondary btn-sm editbtn mb-2" href="#editModal"
                                                            data-toggle="modal" data-postcode_id="{{ $postcode->id }}"
                                                            data-title="{{ $postcode->title }}"
                                                            data-postcode="{{ $postcode->postcode }}"
                                                            data-charge="{{ $postcode->charge }}"
                                                            data-free_delivery_amount="{{ $postcode->free_delivery_amount }}"
                                                            data-serial_number="{{ $postcode->serial_number }}">
                                                            <span class="btn-label">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </a>
                                                        <form class="deleteform d-inline-block"
                                                            action="{{ route('user.postalcode.delete') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="postcode_id"
                                                                value="{{ $postcode->id }}">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm deletebtn mb-2">
                                                                <span class="btn-label">
                                                                    <i class="fas fa-trash"></i>
                                                                </span>
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Postal Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ajaxForm" class="modal-form create" action="{{ route('user.postalcode.store') }}"
                        method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Language **</label>
                            <select name="user_language_id" class="form-control">
                                <option value="" selected disabled>Select a language</option>
                                @foreach ($userLangs as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                            <p id="erruser_language_id" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Title **</label>
                            <input type="text" class="form-control" name="title" value=""
                                placeholder="Enter title">
                            <p id="errtitle" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Post Code **</label>
                            <input type="text" class="form-control ltr" name="postcode" value=""
                                placeholder="Enter postcode">
                            <p id="errpostcode" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Delivery Charge ({{ $userBe->base_currency_text }}) **</label>
                            <input type="text" class="form-control ltr" name="charge" value=""
                                placeholder="Enter delivery charge">
                            <p id="errcharge" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Minimum Order Amount For Free Delivery
                                ({{ $userBe->base_currency_text }})</label>
                            <input type="text" class="form-control ltr" name="free_delivery_amount" value=""
                                placeholder="Enter Minimum Order Amount For Free Delivery">
                            <p class="mb-0 text-warning">If dont want 'Free Delivery' , then please leave it blank</p>
                            <p id="errfree_delivery_amount" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Serial Number **</label>
                            <input type="number" class="form-control ltr" name="serial_number" value=""
                                placeholder="Enter Serial Number">
                            <p id="errserial_number" class="mb-0 text-danger em"></p>
                            <p class="text-warning"><small>The higher the serial number is, the later the Postal Code
                                    will be shown.</small></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

 
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Faq</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ajaxEditForm" class="" action="{{ route('user.postalcode.update') }}"
                        method="POST">
                        @csrf
                        <input id="inpostcode_id" type="hidden" name="postcode_id" value="">
                        <div class="form-group">
                            <label for="">Title **</label>
                            <input id="intitle" type="text" class="form-control" name="title" value=""
                                placeholder="Enter title">
                            <p id="eerrtitle" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Post Code **</label>
                            <input id="inpostcode" type="text" class="form-control" name="postcode" value=""
                                placeholder="Enter post code">
                            <p id="eerrpostcode" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Delivery Charge **</label>
                            <input id="incharge" type="text" class="form-control" name="charge" value=""
                                placeholder="Enter charge">
                            <p id="eerrcharge" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Minimum Order Amount For Free Delivery
                                ({{ $userBe->base_currency_text }})</label>
                            <input id="infree_delivery_amount" type="text" class="form-control ltr"
                                name="free_delivery_amount" value=""
                                placeholder="Enter Minimum Order Amount For Free Delivery">
                            <p class="mb-0 text-warning">If dont want 'Free Delivery' , then please leave it blank</p>
                            <p id="eerrfree_delivery_amount" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Serial Number **</label>
                            <input id="inserial_number" type="number" class="form-control ltr" name="serial_number"
                                value="" placeholder="Enter Serial Number">
                            <p id="eerrserial_number" class="mb-0 text-danger em"></p>
                            <p class="text-warning"><small>The higher the serial number is, the later the Postal Code
                                    will be shown.</small></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="updateBtn" type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
