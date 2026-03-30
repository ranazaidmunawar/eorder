@extends('admin.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ __('Packages') }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Packages') }}</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block">{{ __('Package Page') }}</div>
                        </div>
                        <div class="col-lg-4 offset-lg-4 mt-2 mt-lg-0">
                            <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal"
                                data-target="#createModal"><i class="fas fa-plus"></i>
                                {{ __('Add Package') }}</a>
                            <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete"
                                data-href="{{ route('admin.package.bulk.delete') }}"><i class="flaticon-interface-5"></i>
                                {{ __('Delete') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($packages) == 0)
                                <h3 class="text-center">{{ __('NO PACKAGE FOUND YET') }}</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <input type="checkbox" class="bulk-check" data-val="all">
                                                </th>
                                                <th scope="col" width="35%">{{ __('Title') }}</th>
                                                <th scope="col">{{ __('Cost') }}</th>
                                                <th scope="col">{{ __('Status') }}</th>
                                                <th scope="col">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($packages as $key => $package)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="bulk-check"
                                                            data-val="{{ $package->id }}">
                                                    </td>
                                                    <td>
                                                         {{ strlen($package->title) > 120 ? mb_substr($package->title, 0, 120, 'UTF-8') . '...' : $package->title }}
                                                        <span class="badge badge-primary">{{ $package->term }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($package->price == 0)
                                                            {{ __('Free') }}
                                                        @else
                                                            {{ format_price($package->price) }}
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($package->status == 1)
                                                            <h2 class="d-inline-block">
                                                                <span
                                                                    class="badge badge-success">{{ __('Active') }}</span>
                                                            </h2>
                                                        @else
                                                            <h2 class="d-inline-block">
                                                                <span
                                                                    class="badge badge-danger">{{ __('Deactive') }}</span>
                                                            </h2>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-secondary btn-sm my-2"
                                                            href="{{ route('admin.package.edit', $package->id) . '?language=' . request()->input('language') }}">
                                                            <span class="btn-label">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                            
                                                        </a>
                                                        <form class="deleteform d-inline-block"
                                                            action="{{ route('admin.package.delete') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="package_id"
                                                                value="{{ $package->id }}">
                                                            <button type="submit" class="btn btn-danger btn-sm deletebtn">
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add Package') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="ajaxForm" enctype="multipart/form-data" class="modal-form"
                        action="{{ route('admin.package.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">{{ __('Package title') }}*</label>
                            <input id="title" type="text" class="form-control" name="title"
                                placeholder="{{ __('Enter Package title') }}" value="">
                            <p id="errtitle" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="price">{{ __('Price') }} ({{ $bex->base_currency_text }})*</label>
                            <input id="price" type="number" class="form-control" name="price"
                                placeholder="{{ __('Enter Package price') }}" value="">
                            <p class="text-warning mb-0">
                                <small>{{ __('If price is 0 , then it will appear as free') }}</small>
                            </p>
                            <p id="errprice" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="term">{{ __('Package term') }}*</label>
                            <select id="term" name="term" class="form-control" required>
                                <option value="" selected disabled>{{ __('Choose a Package term') }}</option>
                                <option value="month">{{ __('month') }}</option>
                                <option value="year">{{ __('year') }}</option>
                                <option value="lifetime">{{ __('lifetime') }}</option>
                            </select>
                            <p id="errterm" class="mb-0 text-danger em"></p>
                        </div>


                        <div class="form-group">
                             
                            <label class="form-label">{{ __('Package Features') }}</label>
                            <div class="selectgroup selectgroup-pills">
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Custom Domain"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Custom Domain') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Subdomain"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Subdomain') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="POS" class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('POS') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Coupon" class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Coupon') }}</span>
                                </label>
                                <label class="selectgroup-item awsBtn">
                                    <input type="checkbox" name="features[]" value="Amazon AWS s3"
                                        class="selectgroup-input awsInput">
                                    <span class="selectgroup-button">{{ __('Amazon AWS s3') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Storage Limit"
                                        class="selectgroup-input storageLabel" id="storage">
                                    <span class="selectgroup-button">{{ __('Storage Limit') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Live Orders"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Realtime Order Refresh & Notification') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Whatsapp Order & Notification"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Whatsapp Order & Notification') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="QR Menu" class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('QR Menu') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Table Reservation"
                                        class="selectgroup-input" id="table-reservations">
                                    <span class="selectgroup-button">{{ __('Table Reservation') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Table QR Builder"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Table QR Builder') }}</span>
                                </label>
                                <label class="selectgroup-item" id="call_waiter">
                                    <input type="checkbox" name="features[]" value="Call Waiter"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Call Waiter') }}</span>
                                </label>

                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Staffs" class="selectgroup-input"
                                        id="staffs">
                                    <span class="selectgroup-button">{{ __('Staffs') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Blog" class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Blog') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Custom Page"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Custom Page') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Online Order"
                                        class="selectgroup-input" id="orders">
                                    <span class="selectgroup-button">{{ __('Online Order') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="On Table" id="onTable"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('On Table') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Pick Up" class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Pick Up') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Home Delivery" id="home_delivery"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Home Delivery') }}</span>
                                </label>
                                <label class="selectgroup-item" id="postal_code">
                                    <input type="checkbox" name="features[]" value="Postal Code Based Delivery Charge"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Postal Code Based Delivery Charge') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="PWA Installability"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('PWA Installability') }}</span>
                                </label>
                            </div>
                          
                            <p id="erronline_order" class="mb-0 text-danger em"></p>
                            <p id="errpos_order" class="mb-0 text-danger em"></p>
                            <p id="errfeatures" class="mb-0 text-danger em"></p>
                        </div>

                        <div class="form-group" id="storage_input">
                            <label for="storage_limit">{{ __('Storage Limit') }}*</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="storage_limit"
                                    placeholder="{{ __('Enter Storage Limit') }}" value="">
                                <span class="input-group-text" id="basic-addon2">MB</span>
                                
                            </div>
                            <p id="errstorage_limit" class="mb-0 text-danger em"></p>
                             <p class="text-warning mb-0">
                                <small>{{ __('Enter 999999 , then it will appear as unlimited') }}</small>
                            </p>
                        </div>

                        <div class="form-group" id="staff_input">
                            <label for="staff_limit">{{ __('Number Of Staffs Limit') }}*</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="staff_limit"
                                    placeholder="{{ __('Enter Staff Limit') }}" value="">
                            </div>
                            <p id="errstaff_limit" class="mb-0 text-danger em"></p>
                            <p class="text-warning mb-0">
                                <small>{{ __('Enter 999999 , then it will appear as unlimited') }}</small>
                            </p>
                        </div>
                        <div class="form-group" id="order_input">
                            <label for="order_limit">{{ __('Number Of Orders Limit') }}*</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="order_limit"
                                    placeholder="{{ __('Enter Order Limit') }}" value="">
                            </div>
                            <p id="errorder_limit" class="mb-0 text-danger em"></p>
                            <p class="text-warning mb-0">
                                <small>{{ __('Enter 999999 , then it will appear as unlimited') }}</small>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="categories_limit">{{ __('Number Of Categories Limit') }}*</label>
                            <input id="categories_limit" type="number" class="form-control" name="categories_limit"
                                placeholder="{{ __('Enter categories limit') }}" value="">
                            <p class="text-warning mb-0">
                                <small>{{ __('Enter 999999 , then it will appear as unlimited') }}</small>
                            </p>
                            <p id="errcategories_limit" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="subcategories_limit">{{ __('Number Of Subcategories Limit') }}*</label>
                            <input id="subcategories_limit" type="number" class="form-control"
                                name="subcategories_limit" placeholder="{{ __('Enter subcategories limit') }}"
                                value="">
                            <p class="text-warning mb-0">
                                <small>{{ __('Enter 999999 , then it will appear as unlimited') }}</small>
                            </p>
                            <p id="errsubcategories_limit" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="items_limit">{{ __('Number Of Items Limit') }}*</label>
                            <input id="items_limit" type="number" class="form-control" name="items_limit"
                                placeholder="{{ __('Enter items limit') }}" value="">
                            <p class="text-warning mb-0">
                                <small>{{ __('Enter 999999 , then it will appear as unlimited') }}</small>
                            </p>
                            <p id="erritems_limit" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group" id="table_reservation_input">
                            <label for="table_reservation_limit">{{ __('Number Of Table Reservations Limit') }}*</label>
                            <input id="table_reservation_limit" type="number" class="form-control"
                                name="table_reservation_limit" placeholder="{{ __('Enter table reservation limit') }}"
                                value="">
                            <p class="text-warning mb-0">
                                <small>{{ __('Enter 999999 , then it will appear as unlimited') }}</small>
                            </p>
                            <p id="errtable_reservation_limit" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="language_limit">{{ __('Number Of Languages Limit') }}*</label>
                            <input id="language_limit" type="number" class="form-control" name="language_limit"
                                placeholder="{{ __('Enter language limit') }}" value="">
                            <p class="text-warning mb-0">
                                <small>{{ __('Enter 999999 , then it will appear as unlimited') }}</small>
                            </p>
                            <p id="errlanguage_limit" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('Featured') }} *</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="featured" value="1" class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Yes') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="featured" value="0" class="selectgroup-input"
                                        checked>
                                    <span class="selectgroup-button">{{ __('No') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Recommended *</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="recommended" value="1" class="selectgroup-input">
                                    <span class="selectgroup-button">Yes</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="recommended" value="0" class="selectgroup-input"
                                        checked>
                                    <span class="selectgroup-button">No</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Icon **</label>
                            <div class="btn-group d-block">
                                <button type="button" class="btn btn-primary iconpicker-component"><i
                                        class="fa fa-fw fa-heart"></i></button>
                                <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                    data-selected="fa-car" data-toggle="dropdown">
                                </button>
                                <div class="dropdown-menu"></div>
                            </div>
                            <input id="inputIcon" type="hidden" name="icon" value="fas fa-heart">
                            @if ($errors->has('icon'))
                                <p class="mb-0 text-danger">{{ $errors->first('icon') }}</p>
                            @endif
                            <div class="mt-2">
                                <small>NB: click on the dropdown sign to select a icon.</small>
                            </div>
                            <p id="erricon" class="mb-0 text-danger em"></p>
                        </div>


                        <div class="form-group">
                            <label class="form-label">{{ __('Trial') }} *</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="is_trial" value="1" class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Yes') }}</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="is_trial" value="0" class="selectgroup-input"
                                        checked>
                                    <span class="selectgroup-button">{{ __('No') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group d-none" id="trial_day">
                            <label for="trial_days">{{ __('Trial days') }}*</label>
                            <input id="trial_days" type="number" class="form-control" name="trial_days"
                                placeholder="{{ __('Enter trial days') }}" value="">
                            <p id="errtrial_days" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('Status') }}*</label>
                            <select id="status" class="form-control ltr" name="status">
                                <option value="" selected disabled>{{ __('Select a status') }}</option>
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Deactive') }}</option>
                            </select>
                            <p id="errstatus" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Meta Keywords') }}</label>
                            <input type="text" class="form-control" name="meta_keywords" value=""
                                data-role="tagsinput">
                        </div>
                        <div class="form-group">
                            <label for="meta_description">{{ __('Meta Description') }}</label>
                            <textarea id="meta_description" type="text" class="form-control" name="meta_description" rows="5">
                            </textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button id="submitBtn" type="button" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/admin/js/packages.js') }}"></script>
 
@endsection
