@php
  use App\Http\Helpers\UserPermissionHelper;
  use App\Models\User;
  use App\Models\User\CustomPage\Page;
  use App\Models\User\Journal\Blog;
  use App\Models\User\Member;
  use App\Models\User\ProductOrder;
  use App\Models\User\Product;
  use App\Models\User\Subscriber;
  use Illuminate\Support\Facades\Auth;
  use App\Models\Membership;
  use App\Models\Package;
  $user = getRootUser();
  $package = UserPermissionHelper::currentPackage($user->id);

  use App\Models\User\Language;
  $userId = getRootUser()->id;
  $userDefaultLang = Language::query()
      ->where([['user_id', $userId], ['is_default', 1]])
      ->first();

  $roleBasedPermission = [];

  if (!is_null(Auth::guard('web')->user()->admin_id)) {
      $roleBasedPermission = json_decode(Auth::guard('web')->user()->role->permissions, true);
  }

@endphp

@extends('user.layout')

@section('content')
  <div class="mt-2 mb-4">
    <h2 class="pb-2">
      Welcome back, {{ Auth::guard('web')->user()->first_name }} {{ Auth::guard('web')->user()->last_name }}!
    </h2>
  </div>
  @if (Auth::guard('web')->user() && Auth::guard('web')->user()->admin_id == null)
    @if (is_null($package))
      @php
        $pendingMemb = Membership::query()
            ->where([['user_id', '=', Auth::id()], ['status', 0]])
            ->whereYear('start_date', '<>', '9999')
            ->orderBy('id', 'DESC')
            ->first();
        $pendingPackage = isset($pendingMemb) ? Package::query()->findOrFail($pendingMemb->package_id) : null;
      @endphp

      @if ($pendingPackage)
        <div class="alert alert-warning">
          {{ __('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.') }}
        </div>
        <div class="alert alert-warning">
          <strong>{{ __('Pending Package') }}: </strong> {{ $pendingPackage->title }}
          <span class="badge badge-secondary">{{ $pendingPackage->term }}</span>
          <span class="badge badge-warning">{{ __('Decision Pending') }}</span>
        </div>
      @else
        <div class="alert alert-warning">
          {{ __('Your membership is expired. Please purchase a new package / extend the current package.') }}
        </div>
      @endif
    @else
      <div class="row justify-content-center align-items-center mb-1">
        <div class="col-12">
          <div class="alert border-left border-primary text-dark">
            @if ($package_count >= 2)
              @if ($next_membership->status == 0)
                <strong
                  class="text-danger">{{ __('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.') }}</strong>
                <br>
              @elseif ($next_membership->status == 1)
                <strong
                  class="text-danger">{{ __('You have another package to activate after the current package expires. You cannot purchase / extend any package, until the next package is activated') }}</strong>
                <br>
              @endif
            @endif


            <strong>{{ __('Current Package') }}: </strong> {{ $current_package->title }}
            <span class="badge badge-secondary">{{ $current_package->term }}</span>
            @if ($current_membership->is_trial == 1)
              ({{ __('Expire Date') }}
              : {{ Carbon\Carbon::parse($current_membership->expire_date)->format('M-d-Y') }})
              <span class="badge badge-primary">{{ __('Trial') }}</span>
            @else
              ({{ __('Expire Date') }}:
              {{ $current_package->term === 'lifetime' ? 'Lifetime' : Carbon\Carbon::parse($current_membership->expire_date)->format('M-d-Y') }})
            @endif

            @if ($package_count >= 2)
              <div>
                <strong>{{ __('Next Package To Activate') }}: </strong> {{ $next_package->title }} <span
                  class="badge badge-secondary">{{ $next_package->term }}</span>
                @if ($current_package->term != 'lifetime' && $current_membership->is_trial != 1)
                  (
                  {{ __('Activation Date') }}:
                  {{ Carbon\Carbon::parse($next_membership->start_date)->format('M-d-Y') }},
                  {{ __('Expire Date') }}
                  :
                  {{ $next_package->term === 'lifetime' ? 'Lifetime' : Carbon\Carbon::parse($next_membership->expire_date)->format('M-d-Y') }}
                  )
                @endif
                @if ($next_membership->status == 0)
                  <span class="badge badge-warning">{{ __('Decision Pending') }}</span>
                @endif
              </div>
            @endif
          </div>
        </div>
      </div>
    @endif
  @endif
  <div class="row">
    @if (
        !empty($packagePermissions) &&
            (is_null(Auth::guard('web')->user()->admin_id) ||
                (is_array($roleBasedPermission) && in_array('Order Management', $roleBasedPermission))) &&
            (in_array('Online Order', $packagePermissions) ||
                in_array('QR Menu', $packagePermissions) ||
                in_array('POS', $packagePermissions)))
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-info card-round">
          <a href="{{ route('user.product.orders') }}" class="text-decoration-none">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center">
                    <i class="fas fa-shopping-cart"></i>
                  </div>
                </div>
                <div class="col-7 col-stats">
                  <div class="numbers">
                    <p class="card-category">Total Orders</p>
                    <h4 class="card-title">
                      {{ ProductOrder::query()->where('user_id', $user->id)->count() }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    @endif
    @if (is_null(Auth::guard('web')->user()->admin_id))
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-primary card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="flaticon-users"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Team Members</p>
                  <h4 class="card-title">{{ Member::query()->where('user_id', $user->id)->count() }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
    @if (is_null(Auth::guard('web')->user()->admin_id) ||
            (is_array($roleBasedPermission) && in_array('Subscribers', $roleBasedPermission)))
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-info card-round">
          <a href="{{ route('user.subscriber.index') }}" class="text-decoration-none">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center">
                    <i class="flaticon-interface-6"></i>
                  </div>
                </div>
                <div class="col-7 col-stats">
                  <div class="numbers">
                    <p class="card-category">Subscribers</p>
                    <h4 class="card-title">
                      {{ Subscriber::query()->where('user_id', $user->id)->count() }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    @endif

    @if (
        !empty($packagePermissions) &&
            in_array('Blog', $packagePermissions) &&
            (is_null(Auth::guard('web')->user()->admin_id) ||
                (is_array($roleBasedPermission) && in_array('Blog Management', $roleBasedPermission))))
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-warning card-round">
          <a href="{{ route('user.blog_management.blogs', ['language' => $userDefaultLang->code]) }}"
            class="text-decoration-none">
            <div class="card-body ">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center">
                    <i class="fab fa-blogger-b"></i>
                  </div>
                </div>
                <div class="col-7 col-stats">
                  <div class="numbers">
                    <p class="card-category">Blogs</p>
                    <h4 class="card-title">{{ Blog::query()->where('user_id', $user->id)->count() }}
                    </h4>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    @endif
    @if (is_null(Auth::guard('web')->user()->admin_id) ||
            (is_array($roleBasedPermission) && in_array('Items Management', $roleBasedPermission)))
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-primary card-round">
          <a href="{{ route('user.product.index', ['language' => $userDefaultLang->code]) }}"
            class="text-decoration-none">
            <div class="card-body ">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center">
                    <i class="fab fa-product-hunt"></i>
                  </div>
                </div>
                <div class="col-7 col-stats">
                  <div class="numbers">
                    <p class="card-category">Total Items</p>
                    <h4 class="card-title">{{ Product::query()->where('user_id', $user->id)->count() }}
                    </h4>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    @endif

    @if (is_null(Auth::guard('web')->user()->admin_id))
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-info card-round">
          <div class="card-body ">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="fas fa-users"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Users</p>
                  <h4 class="card-title">{{ User::query()->where('admin_id', $user->id)->count() }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif

    @if (
        !empty($packagePermissions) &&
            in_array('Custom Page', $packagePermissions) &&
            (is_null(Auth::guard('web')->user()->admin_id) ||
                (is_array($roleBasedPermission) && in_array('Custom Pages', $roleBasedPermission))))
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-success card-round">
          <a href="{{ route('user.custom_pages', ['language' => $userDefaultLang->code]) }}"
            class="text-decoration-none">
            <div class="card-body ">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center">
                    <i class="far fa-file"></i>
                  </div>
                </div>
                <div class="col-7 col-stats">
                  <div class="numbers">
                    <p class="card-category">Custom Pages</p>
                    <h4 class="card-title">{{ Page::query()->where('user_id', $user->id)->count() }}
                    </h4>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    @endif

    @if (
        !empty($features) &&
            in_array('Table Reservation', $features) &&
            (is_null(Auth::guard('web')->user()->admin_id) ||
                (is_array($roleBasedPermission) && in_array('Table Reservations', $roleBasedPermission))))
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-info card-round">
          <a href="{{ route('user.custom_pages', ['language' => $userDefaultLang->code]) }}"
            class="text-decoration-none">
            <div class="card-body ">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center">
                    <i class="far fa-file"></i>
                  </div>
                </div>
                <div class="col-7 col-stats">
                  <div class="numbers">
                    <p class="card-category">Table Reservations</p>
                    <h4 class="card-title">{{ $reservations->count() }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    @endif

    @if (
        !empty($features) &&
            in_array('Table QR Builder', $features) &&
            (is_null(Auth::guard('web')->user()->admin_id) ||
                (is_array($roleBasedPermission) && in_array('Tables & QR Builder', $roleBasedPermission))))
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-info card-round">
          <a href="{{ route('user.custom_pages', ['language' => $userDefaultLang->code]) }}"
            class="text-decoration-none">
            <div class="card-body ">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center">
                    <i class="far fa-file"></i>
                  </div>
                </div>
                <div class="col-7 col-stats">
                  <div class="numbers">
                    <p class="card-category">Tables</p>
                    <h4 class="card-title">{{ $tables->count() }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    @endif

  </div>

  <div class="row">
    @if (
        !empty($features) &&
            in_array('Table Reservation', $features) &&
            (is_null(Auth::guard('web')->user()->admin_id) ||
                (is_array($roleBasedPermission) && in_array('Table Reservations', $roleBasedPermission))))
      <div class="col-lg-6">
        <div class="row row-card-no-pd">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="card-head-row">
                  <h4 class="card-title">Recent Reservation Requests</h4>
                </div>
                <p class="card-category">
                  Top 10 latest table reservation requests
                </p>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    @if (count($table_books) == 0)
                      <h3 class="text-center">NO TABLE BOOKING REQUEST FOUND</h3>
                    @else
                      <div class="table-responsive">
                        <table class="table table-striped mt-3">
                          <thead>
                            <tr>
                              <th scope="col">Name</th>
                              <th scope="col">Email</th>
                              <th scope="col">Details</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($table_books as $key => $reservation)
                              <tr>
                                <td>{{ convertUtf8($reservation->name) }}</td>
                                <td>{{ convertUtf8($reservation->email) }}</td>
                                <td>
                                  <button class="btn btn-secondary btn-sm" data-toggle="modal"
                                    data-target="#detailsModal{{ $reservation->id }}">
                                    <i class="fas fa-eye"></i>
                                    View
                                  </button>
                                </td>
                              </tr>
                              @includeif('user.reservations.reservation-details')
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
      </div>
    @endif
    @if (
        !empty($packagePermissions) &&
            (in_array('Online Order', $packagePermissions) ||
                in_array('QR Menu', $packagePermissions) ||
                in_array('POS', $packagePermissions)) &&
            (is_null(Auth::guard('web')->user()->admin_id) ||
                (is_array($roleBasedPermission) && in_array('Order Management', $roleBasedPermission))))
      <div class="col-lg-6">
        <div class="row row-card-no-pd">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="card-head-row">
                  <h4 class="card-title">Recent Orders</h4>
                </div>
                <p class="card-category">
                  Top 10 latest orders
                </p>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    @if (count($orders) > 0)
                      <div class="table-responsive table-hover table-sales">
                        <table class="table table-striped mt-3">
                          <thead>
                            <tr>
                              <th scope="col">Order Number</th>
                              <th scope="col">Date</th>
                              <th scope="col">Total</th>
                              <th scope="col">Payment Status</th>
                              <th scope="col">Details</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($orders as $key => $order)
                              <tr>
                                <td>#{{ $order->order_number }}</td>
                                <td>{{ convertUtf8($order->created_at->format('d-m-Y')) }}
                                </td>
                                <td>{{ $order->currency_symbol_position == 'left' ? $order->currency_symbol : '' }}
                                  {{ round($order->total, 2) }}
                                  {{ $order->currency_symbol_position == 'right' ? $order->currency_symbol : '' }}
                                </td>
                                <td>
                                  @if ($order->payment_status == 'Pending' || $order->payment_status == 'pending')
                                    <p class="badge badge-danger">
                                      {{ $order->payment_status }}</p>
                                  @else
                                    <p class="badge badge-success">
                                      {{ $order->payment_status }}</p>
                                  @endif
                                </td>

                                <td>
                                  <a href="{{ route('user.product.orders.details', $order->id) }}" target="_blank"
                                    class="btn btn-primary btn-sm " class="text-decoration-none">
                                    <i class="fas fa-eye"></i>
                                    Details
                                  </a>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    @else
                      <h2 class="text-center">NO ORDER FOUND</h2>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
@endsection
