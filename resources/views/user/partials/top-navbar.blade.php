@php
    use App\Constants\Constant;
    use App\Models\Package;
    use App\Http\Helpers\Uploader;
    use App\Http\Helpers\LimitCheckerHelper;

    // Initialize variables
    $infoIcon = false;
    $username = '';
    $userId = Auth::guard('web')->user()->admin_id ?? Auth::guard('web')->user()->id;

    // Fetch the user's username
if (Auth::guard('web')->user()->admin_id != null) {
    $user = App\Models\User::where('id', Auth::guard('web')->user()->admin_id)->first();
    $username = $user->username;
} else {
    $username = Auth::guard('web')->user()->username;
}

// Fetch the current package
$packageId = LimitCheckerHelper::getMembershipId($userId);
$currentPackage = Package::find($packageId);

// Check if the current package exists
if ($currentPackage) {
    $feature = json_decode($currentPackage->features, true);

    // Fetch usage counts
    $staffCount = LimitCheckerHelper::staffCount($userId);
    $storageCount = LimitCheckerHelper::storageCount($userId, 'storage_usage');
        $orderCount = LimitCheckerHelper::orderCount($userId);
        $categoryCount = LimitCheckerHelper::categoryCount($userId);
        $subcategoryCount = LimitCheckerHelper::subcategoryCount($userId);
        $itemCount = LimitCheckerHelper::itemCount($userId);
        $languageCount = LimitCheckerHelper::languageCount($userId);
        $reservationCount = LimitCheckerHelper::getTableReservationCount($userId);

        // Check if any limit is exceeded
        if (
            $reservationCount >= ($currentPackage->table_reservation_limit ?? PHP_INT_MAX) ||
            $orderCount >= ($currentPackage->order_limit ?? PHP_INT_MAX) ||
            $staffCount > ($currentPackage->staff_limit ?? PHP_INT_MAX) ||
            $storageCount > ($currentPackage->storage_limit ?? PHP_INT_MAX) ||
            $categoryCount > ($currentPackage->categories_limit ?? PHP_INT_MAX) ||
            $subcategoryCount > ($currentPackage->subcategories_limit ?? PHP_INT_MAX) ||
            $itemCount > ($currentPackage->items_limit ?? PHP_INT_MAX) ||
            $languageCount > ($currentPackage->language_limit ?? PHP_INT_MAX)
        ) {
            $infoIcon = true;
        }
    } else {
        // Handle case where the user has no active package
        $infoIcon = true;
    }
@endphp

<div class="main-header">

    <div class="logo-header" @if (request()->cookie('user-theme') == 'dark') data-background-color="dark2" @endif>
        @if ($userBs->logo)
            <a href="{{ route('user.front.index', $username) }}" class="logo" target="_blank">
                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_LOGO, $userBs->logo, $userBs) }}" alt="navbar brand"
                    width="120">
            </a>
        @else
            <a class="logo" href="{{ route('user.front.index', $username) }}">
                <img src="{{ asset('assets/restaurant/images/logo.png') }}" alt="Logo" width="120">
            </a>
        @endif
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button
                class="btn btn-toggle
          @if (request()->routeIs('user.pos') || request()->routeIs('user.table.qr.builder') || request()->routeIs('user.qrcode')) sidenav-overlay-toggler
          @else
              toggle-sidebar @endif
              toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>

    <nav class="navbar navbar-header navbar-expand-lg"
        @if (request()->cookie('user-theme') == 'dark') data-background-color="dark" @endif>
        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <form action="{{ route('user.theme.change') }}" class="mr-4 form-inline" id="userThemeForm">
                    <div class="form-group">
                        <div class="selectgroup selectgroup-secondary selectgroup-pills">
                            <label class="selectgroup-item">
                                <input type="radio" name="theme" value="light" class="selectgroup-input"
                                    {{ empty(request()->cookie('user-theme')) || request()->cookie('user-theme') == 'light' ? 'checked' : '' }}
                                    onchange="document.getElementById('userThemeForm').submit();">
                                <span class="selectgroup-button selectgroup-button-icon"><i
                                        class="fa fa-sun"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="theme" value="dark" class="selectgroup-input"
                                    {{ request()->cookie('user-theme') == 'dark' ? 'checked' : '' }}
                                    onchange="document.getElementById('userThemeForm').submit();">
                                <span class="selectgroup-button selectgroup-button-icon"><i
                                        class="fa fa-moon"></i></span>
                            </label>
                        </div>
                    </div>
                </form>
                <li>
                    @php
                        $host = request()->getHost();
                        $websiteHost = env('WEBSITE_HOST');

                        if (
                            !str_contains($host, $websiteHost) ||
                            ($host !== $websiteHost && str_ends_with($host, '.' . $websiteHost))
                        ) {
                            $url = 'https://' . $websiteHost . '/' . $username;
                        } else {
                            $url = route('user.front.index', $username);
                        }
                    @endphp

                <li class="mr-4">
                    <a class="btn btn-primary btn-sm btn-round" target="_blank"
                        href="{{ $url }}" title="View Website">
                        <i class="fas fa-eye"></i>
                    </a>
                </li>
                @if (Auth::guard('web')->user()->admin_id == null)
                    <li class="d-flex mr-4">
                        <label class="switch">
                            <input type="checkbox" name="online_status" id="toggle-btn" data-toggle="toggle"
                                data-on="1" data-off="0" @if (Auth::guard('web')->user()->online_status == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                        @if (Auth::guard('web')->user()->online_status == 1)
                            <h5 class="mt-2 ml-2 @if (request()->cookie('user-theme') == 'dark') text-white @endif">
                                {{ __('Active') }}
                            </h5>
                        @else
                            <h5 class="mt-2 ml-2 @if (request()->cookie('user-theme') == 'dark') text-white @endif">
                                {{ __('Deactive') }}
                            </h5>
                        @endif
                    </li>

                    <li class="d-flex mr-4">
                        <a class="btn btn-secondary  btn-sm" data-toggle="modal" data-target="#limitModal">
                            <span class="text-white">Check Limit

                            </span> <br>

                            <span class="view_limit">Click Here To View</span>
                        </a>
                        <sup class="float-start">
                            @if ($infoIcon == true)
                                <img src="{{ asset('assets/user/img/error.png') }}" width="15 class="errorIcon">
                            @endif
                        </sup>
                    </li>
                @endif
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_TENANT_USER_IMAGE, Auth::guard('web')->user()->image, $userBs, 'assets/tenant/image/user.jpg') }}"
                                alt="..." class="avatar-img rounded-circle" width="120">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_TENANT_USER_IMAGE, Auth::guard('web')->user()->image, $userBs, 'assets/tenant/image/user.jpg') }}"
                                            alt="..." class="avatar-img rounded" width="120">
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ Auth::guard('web')->user()->first_name }}</h4>
                                        <p class="text-muted">{{ Auth::guard('web')->user()->email }}</p><a
                                            href="{{ route('user.edit.profile') }}"
                                            class="btn btn-xs btn-secondary btn-sm">Edit Profile</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('user.edit.profile') }}">Edit Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('user.change.password') }}">Change
                                    Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

</div>

<div class="modal fade" id="limitModal" tabindex="-1" aria-labelledby="limitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="limitModalLabel">All Limit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($currentPackage)

                    <ul class="list-group modal_ul">
                        @if (is_array($feature) && in_array('Staffs', $feature))
                            <li class="list-group-item">
                                <div class="d-flex  justify-content-between">
                                    <span>
                                        @if ($staffCount > $currentPackage->staff_limit)
                                            <img src="{{ asset('assets/user/img/error.png') }}" width="15"
                                                class="errorIcon ">
                                        @endif Staffs Left :
                                    </span>
                                    <span
                                        class="badge badge-primary badge-sm">{{ $currentPackage->staff_limit == 999999 ? 'Unlimited' : ($currentPackage->staff_limit - $staffCount < 0 ? 0 : $currentPackage->staff_limit - $staffCount) }}</span>
                                </div>
                                @if ($staffCount > $currentPackage->staff_limit)
                                    <p class="text-warning m-0">Limit has been crossed, you have to delete
                                        {{ abs($currentPackage->staff_limit - $staffCount) }}
                                        {{ abs($currentPackage->staff_limit - $staffCount) == 1 ? 'staff' : 'staffs' }}
                                    </p>
                                @endif
                            </li>
                        @endif
                        @if (is_array($feature) && in_array('Online Order', $feature))
                            <li class="list-group-item">
                                <div class="d-flex  justify-content-between">
                                    <span>
                                        @if ($orderCount >= $currentPackage->order_limit)
                                            <img src="{{ asset('assets/user/img/error.png') }}" width="15"
                                                class="errorIcon ">
                                        @endif Orders Left :
                                    </span>

                                    <span class="badge badge-primary badge-sm">
                                        {{ $currentPackage->order_limit == 999999 ? 'Unlimited' : ($currentPackage->order_limit - $orderCount < 0 ? 0 : $currentPackage->order_limit - $orderCount) }}
                                    </span>
                                </div>

                                @if ($orderCount >= $currentPackage->order_limit)
                                    <p class="text-warning m-0">Please buy a new package to receive more orders

                                    </p>
                                @endif
                            </li>
                        @endif
                        <li class="list-group-item">
                            <div class="d-flex  justify-content-between">
                                <span>
                                    @if ($categoryCount > $currentPackage->categories_limit)
                                        <img src="{{ asset('assets/user/img/error.png') }}" width="15"
                                            class="errorIcon ">
                                    @endif Categories Left :
                                </span>
                                <span class="badge badge-primary badge-sm">
                                    {{ $currentPackage->categories_limit == 999999
                                        ? 'Unlimited'
                                        : ($currentPackage->categories_limit - $categoryCount < 0
                                            ? 0
                                            : $currentPackage->categories_limit - $categoryCount) }}
                                </span>
                            </div>

                            @if ($categoryCount > $currentPackage->categories_limit)
                                <p class="text-warning m-0">Limit has been crossed, you have to delete
                                    {{ abs($currentPackage->categories_limit - $categoryCount) }}
                                    {{ abs($currentPackage->categories_limit - $categoryCount) == 1 ? 'category' : 'categories' }}
                                </p>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex  justify-content-between">
                                <label>
                                    @if ($subcategoryCount > $currentPackage->subcategories_limit)
                                        <img src="{{ asset('assets/user/img/error.png') }}" width="15"
                                            class="errorIcon ">
                                    @endif Subcategories Left :
                                </label>
                                <span
                                    class="badge badge-primary badge-sm">{{ $currentPackage->subcategories_limit == 999999 ? 'Unlimited' : ($currentPackage->subcategories_limit - $subcategoryCount < 0 ? 0 : $currentPackage->subcategories_limit - $subcategoryCount) }}
                                </span>
                            </div>
                            @if ($subcategoryCount > $currentPackage->subcategories_limit)
                                <p class="text-warning m-0">Limit has been crossed, you have to delete
                                    {{ abs($currentPackage->subcategories_limit - $subcategoryCount) }}
                                    {{ abs($currentPackage->subcategories_limit - $subcategoryCount) == 1 ? 'subcategory' : 'subcategories' }}
                                </p>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex  justify-content-between">
                                <span>
                                    @if ($itemCount > $currentPackage->items_limit)
                                        <img src="{{ asset('assets/user/img/error.png') }}" width="15"
                                            class="errorIcon ">
                                    @endif Items Left :
                                </span>
                                <span class="badge badge-primary badge-sm">
                                    {{ $currentPackage->items_limit == 999999
                                        ? 'Unlimited'
                                        : ($currentPackage->items_limit - $itemCount < 0
                                            ? 0
                                            : $currentPackage->items_limit - $itemCount) }}
                                </span>
                            </div>
                            @if ($itemCount > $currentPackage->items_limit)
                                <p class="text-warning m-0">Limit has been crossed, you have to delete
                                    {{ abs($currentPackage->items_limit - $itemCount) }}
                                    {{ abs($currentPackage->items_limit - $itemCount) < 0 ? 'item' : 'items' }}

                                </p>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex  justify-content-between">
                                <span>
                                    @if ($languageCount > $currentPackage->language_limit)
                                        <img src="{{ asset('assets/user/img/error.png') }}" width="15"
                                            class="errorIcon ">
                                    @endif Languages Left :
                                </span>
                                <span
                                    class="badge badge-primary badge-sm">{{ $currentPackage->language_limit == 999999 ? 'Unlimited' : ($currentPackage->language_limit - $languageCount < 0 ? 0 : $currentPackage->language_limit - $languageCount) }}</span>
                            </div>
                            @if ($languageCount > $currentPackage->language_limit)
                                <p class="text-warning m-0">Limit has been crossed, you have to delete
                                    {{ abs($currentPackage->language_limit - $languageCount) }}
                                    {{ abs($currentPackage->language_limit - $languageCount) == 1 ? 'language' : 'languages' }}

                                </p>
                            @endif
                        </li>
                        @if (is_array($feature) && in_array('Table Reservation', $feature))
                            <li class="list-group-item">
                                <div class="d-flex  justify-content-between">
                                    <span>
                                        @if ($reservationCount >= $currentPackage->table_reservation_limit)
                                            <img src="{{ asset('assets/user/img/error.png') }}" width="15"
                                                class="errorIcon">
                                        @endif Table Reservations Left :
                                    </span>
                                    <span
                                        class="badge badge-primary badge-sm">{{ $currentPackage->table_reservation_limit == 999999 ? 'Unlimited' : ($currentPackage->table_reservation_limit - $reservationCount < 0 ? 0 : $currentPackage->table_reservation_limit - $reservationCount) }}</span>
                                </div>
                                @if ($reservationCount >= $currentPackage->table_reservation_limit)
                                    <p class="text-warning m-0"> Please buy a new package to receive more table
                                        reservations
                                    </p>
                                @endif
                            </li>
                        @endif
                        @if (is_array($feature) && in_array('Storage Limit', $feature))
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        @if ($storageCount > $currentPackage->storage_limit)
                                            <img src="{{ asset('assets/user/img/error.png') }}" width="15"
                                                class="errorIcon ">
                                            Storage Left:
                                        @else
                                            Storage Left:
                                        @endif
                                    </span>
                                    <span class="badge badge-primary badge-sm">
                                        @if ($storageCount > $currentPackage->storage_limit)
                                            0
                                        @else
                                            @if ($currentPackage->storage_limit == 999999)
                                                {{ __('Unlimited') }}
                                            @else
                                                @if ($currentPackage->storage_limit >= 1024)
                                                    {{ number_format(($currentPackage->storage_limit - $storageCount) / 1024, 2) }}
                                                    {{ __('GB') }}
                                                @else
                                                    {{ $currentPackage->storage_limit - $storageCount }}
                                                    {{ __('MB') }}
                                                @endif
                                            @endif
                                        @endif
                                    </span>
                                </div>
                                @if ($storageCount > $currentPackage->storage_limit)
                                    <p class="text-warning m-0">
                                        Your storage limit exceeded
                                    </p>
                                @endif
                            </li>

                        @endif

                    </ul>
                @else
                @endif
            </div>

        </div>
    </div>
</div>

<style>
    .modal_ul {
        border: 1px solid #0000005a !important;
    }

    .view_limit {
        color: #ffffffbd;
        font-size: 10px
    }
</style>
