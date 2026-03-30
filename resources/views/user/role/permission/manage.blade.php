@php
    use App\Http\Helpers\UserPermissionHelper;
    $user = getRootUser();

    $package = UserPermissionHelper::currentPackage($user->id);

    if (!empty($package)) {
        $packageHas = json_decode($package->features, true);
    }

@endphp

@extends('user.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">Roles</h4>
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
                <a href="#">{{ $role->name }}</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Permissions Management</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Permissions Management</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block" href="{{ route('user.role.index') }}">
                        <span class="btn-label">
                            <i class="fas fa-backward"></i>
                        </span>
                        Back
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form id="permissionsForm" class="" action="{{ route('user.role.permissions.update') }}"
                                method="post">
                                @csrf
                                <input type="hidden" name="role_id" value="{{ Request::route('id') }}">

                                @php
                                    $features = $role->permissions;
                                    if (!empty($role->permissions)) {
                                        $features = json_decode($features, true);
                                    }
                                @endphp

                                <div class="form-group">
                                    <label class="form-label">{{ __('Permissions') }}</label>
                                    <div class="selectgroup selectgroup-pills">
                                        @if (is_array($packageHas) && (in_array('Custom Domain', $packageHas) || in_array('Subdomain', $packageHas)))
                                            <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="Domains & URLs"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('Domains & URLs', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('Domains & URLs') }}</span>
                                            </label>
                                        @endif
                                        @if (is_array($packageHas) && in_array('POS', $packageHas))
                                            <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="POS"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('POS', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('POS') }}</span>
                                            </label>
                                        @endif
                                        @if (is_array($packageHas) && (in_array('Online Order', $packageHas)))
                                            <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="Order Management"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('Order Management', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('Order Management') }}</span>
                                            </label>
                                        @endif
                                       
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="permissions[]" value="Items Management"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Items Management', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Items Management') }}</span>
                                        </label>
                                      

                                        @if (is_array($packageHas) && in_array('QR Menu', $packageHas))
                                            <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="QR Code Builder"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('QR Code Builder', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('QR Code Builder') }}</span>
                                            </label>
                                        @endif
                                        @if (is_array($packageHas) && in_array('Table Reservation', $packageHas))
                                            <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="Reservation Settings"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('Reservation Settings', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('Reservation Settings') }}</span>
                                            </label>
                                        @endif
                                          @if (is_array($packageHas) && in_array('Custom Page', $packageHas))
                                            <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="Custom Pages"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('Custom Pages', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('Custom Pages') }}</span>
                                            </label>
                                        @endif
                                        @if (is_array($packageHas) && in_array('Table Reservation', $packageHas))
                                            <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="Table Reservations"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('Table Reservations', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('Table Reservations') }}</span>
                                            </label>
                                        @endif
                                       
                                        @if (is_array($packageHas) && in_array('Table QR Builder', $packageHas))
                                            <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="Tables & QR Builder"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('Tables & QR Builder', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('Tables & QR Builder') }}</span>
                                            </label>
                                            @else
                                             <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="Tables & QR Builder"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('Tables & QR Builder', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('Tables') }}</span>
                                            </label>
                                        @endif
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="permissions[]" value="Drag & Drop Menu Builder"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Drag & Drop Menu Builder', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Drag & Drop Menu Builder') }}</span>
                                        </label>
                                        @if (is_array($packageHas) && in_array('Custom page', $packageHas))
                                            <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="Custom Pages"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('Custom Pages', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('Custom Pages') }}</span>
                                            </label>
                                        @endif
                                        @if (is_array($packageHas) && in_array('Blog', $packageHas))
                                            <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="Blog Management"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('Blog Management', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('Blog Management') }}</span>
                                            </label>
                                        @endif

                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="permissions[]" value="Language Management"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Language Management', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Language Management') }}</span>
                                        </label>
                                        
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="permissions[]" value="Payment Gateways"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Payment Gateways', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Payment Gateways') }}</span>
                                        </label>
                                        @if (is_array($packageHas) && (in_array('Online Order', $packageHas)))
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="permissions[]" value="Website Pages"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Website Pages', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Website Pages') }}</span>
                                        </label>
                                        @endif
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="permissions[]" value="Settings"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Settings', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Settings') }}</span>
                                        </label>
                                         @if (is_array($packageHas) && in_array('Live Orders', $packageHas))
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="permissions[]" value="Push Notification"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Push Notification', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Push Notification') }}</span>
                                        </label>
                                        @endif
                                       @if (is_array($packageHas) && (in_array('Online Order', $packageHas)))
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="permissions[]" value="Subscribers"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Subscribers', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Subscribers') }}</span>
                                        </label>
                                        @endif
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="permissions[]" value="Announcement Popups"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Announcement Popups', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Announcement Popups') }}</span>
                                        </label>
                                        @if (is_array($packageHas) && (in_array('Online Order', $packageHas) || in_array('POS', $packageHas)))
                                            <label class="selectgroup-item">
                                                <input type="checkbox" name="permissions[]" value="Customers"
                                                    class="selectgroup-input"
                                                    @if (is_array($features) && in_array('Customers', $features)) checked @endif>
                                                <span class="selectgroup-button">{{ __('Customers') }}</span>
                                            </label>
                                        @endif
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="permissions[]" value="Sitemap"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Sitemap', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Sitemap') }}</span>
                                        </label>

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
                                <button type="submit" id="permissionBtn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
