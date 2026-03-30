@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

@extends('user.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">
            Orders
        </h4>
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
                <a href="#">
                    Orders
                </a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <form id="searchForm" action="{{ route('user.product.orders') }}" method="GET"
                        onsubmit="document.getElementById('searchForm').submit()">
                        <div class="row no-gutters">

                            <div class="col-lg-1">
                                <div class="form-group px-0">
                                    <label for="">Orders From</label>
                                    <select name="orders_from" class="form-control"
                                        onchange="document.getElementById('searchForm').submit()">
                                        <option value=""
                                            {{ empty(request()->input('orders_from')) ? 'selected' : '' }}>
                                            All
                                        </option>
                                        @if (!empty($packagePermissions) && in_array('Online Order', $packagePermissions))
                                            <option value="website"
                                                {{ request()->input('orders_from') == 'website' ? 'selected' : '' }}>
                                                Website Menu
                                            </option>
                                        @endif
                                        @if (
                                            !empty($packagePermissions) &&
                                                in_array('QR Menu', $packagePermissions) &&
                                                in_array('Online Order', $packagePermissions))
                                            <option value="qr"
                                                {{ request()->input('orders_from') == 'qr' ? 'selected' : '' }}> Qr Menu
                                            </option>
                                        @endif
                                        @if (!empty($packagePermissions) && in_array('POS', $packagePermissions))
                                            <option value="pos"
                                                {{ request()->input('orders_from') == 'pos' ? 'selected' : '' }}>
                                                POS
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group px-0">
                                    <label for="">Serving Method</label>
                                    <select name="serving_method" class="form-control"
                                        onchange="document.getElementById('searchForm').submit()">
                                        <option value=""
                                            {{ empty(request()->input('orders_from')) ? 'selected' : '' }}>
                                            All
                                        </option>
                                        @if (!empty($packagePermissions) && in_array('On Table', $packagePermissions))
                                            <option value="on_table"
                                                {{ request()->input('serving_method') == 'on_table' ? 'selected' : '' }}>
                                                On Table
                                            </option>
                                        @endif
                                        @if (!empty($packagePermissions) && in_array('Pick Up', $packagePermissions))
                                            <option value="pick_up"
                                                {{ request()->input('serving_method') == 'pick_up' ? 'selected' : '' }}>
                                                Pick up
                                            </option>
                                        @endif
                                        @if (!empty($packagePermissions) && in_array('Home Delivery', $packagePermissions))
                                            <option value="home_delivery"
                                                {{ request()->input('serving_method') == 'home_delivery' ? 'selected' : '' }}>
                                                Home Delivery
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <div class="form-group px-0">
                                    <label for="">Order</label>
                                    <select name="order_status" id="" class="form-control"
                                        onchange="document.getElementById('searchForm').submit()">
                                        <option value=""
                                            {{ empty(request()->input('order_status')) ? 'selected' : '' }}>
                                            All
                                        </option>
                                        <option value="pending"
                                            {{ request()->input('order_status') == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="received"
                                            {{ request()->input('order_status') == 'received' ? 'selected' : '' }}>
                                            Received
                                        </option>
                                        <option value="preparing"
                                            {{ request()->input('order_status') == 'preparing' ? 'selected' : '' }}>
                                            Preparing
                                        </option>

                                        @if (empty(request()->input('serving_method')) ||
                                                request()->input('serving_method') == 'home_delivery' ||
                                                request()->input('serving_method') == 'pick_up')
                                            <option value="ready_to_pick_up"
                                                {{ request()->input('order_status') == 'ready_to_pick_up' ? 'selected' : '' }}>
                                                Ready to pick up
                                            </option>
                                            <option value="picked_up"
                                                {{ request()->input('order_status') == 'picked_up' ? 'selected' : '' }}>
                                                Picked up
                                            </option>
                                        @endif

                                        @if (empty(request()->input('serving_method')) || request()->input('serving_method') == 'home_delivery')
                                            <option value="delivered"
                                                {{ request()->input('order_status') == 'delivered' ? 'selected' : '' }}>
                                                Delivered
                                            </option>
                                        @endif

                                        @if (empty(request()->input('serving_method')) || request()->input('serving_method') == 'on_table')
                                            <option value="ready_to_serve"
                                                {{ request()->input('order_status') == 'ready_to_serve' ? 'selected' : '' }}>
                                                Ready to Serve
                                            </option>
                                            <option value="served"
                                                {{ request()->input('order_status') == 'served' ? 'selected' : '' }}>
                                                Served
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group px-0">
                                    <label for="">Payment</label>
                                    <select name="payment_status" class="form-control"
                                        onchange="document.getElementById('searchForm').submit()">
                                        <option value="">All</option>
                                        <option value="Pending"
                                            {{ request()->input('payment_status') == 'Pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="Completed"
                                            {{ request()->input('payment_status') == 'Completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group px-0">
                                    <label for="">Completed</label>
                                    <select name="completed" class="form-control"
                                        onchange="document.getElementById('searchForm').submit()">
                                        <option value="">All</option>
                                        <option value="yes"
                                            {{ request()->input('completed') == 'yes' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="no"
                                            {{ request()->input('completed') == 'no' ? 'selected' : '' }}>
                                            No
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group px-0">
                                    <label for="">Order Date</label>
                                    <input class="form-control datepicker" type="text" name="order_date"
                                        onchange="document.getElementById('searchForm').submit()" autocomplete="off"
                                        value="{{ request()->input('order_date') }}">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group px-0">
                                    <label for="">Delivery Date</label>
                                    <input class="form-control datepicker" type="text" name="delivery_date"
                                        onchange="document.getElementById('searchForm').submit()" autocomplete="off"
                                        value="{{ request()->input('delivery_date') }}">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group px-0">
                                    <label for="">Order Number</label>
                                    <input class="form-control" type="text" name="search"
                                        placeholder="Search by Oder Number"
                                        value="{{ request()->input('search') ? request()->input('search') : '' }}">
                                </div>
                            </div>
                            <button type="submit" style="display: none;"></button>
                            <div class="col-lg-12 text-center">
                                <button type="button" class="btn btn-danger btn-sm ml-4 d-none bulk-delete"
                                    data-href="{{ route('user.product.order.bulk.delete') }}"><i
                                        class="flaticon-interface-5"></i> Delete
                                </button>
                            </div>
                        </div>
                    </form>
                    @if ($live_order)
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <span class="text-warning">To load new orders realtime with sound notification, setup
                                        pusher credentials
                                        from <strong><a href="{{ route('user.plugins') }}" target="_blank"
                                                class="text-decoration-none"><span class="text-primary">Settings >
                                                    Plugins</span></a></strong></span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($orders) == 0)
                                <h3 class="text-center">NO ORDER FOUND</h3>
                            @else
                                <div id="refreshOrder">
                                    <div class="table-responsive">
                                        <table class="table table-striped mt-3">
                                            <thead>
                                                <tr>
                                                    <th scope="col">
                                                        <input type="checkbox" class="bulk-check" data-val="all">
                                                    </th>

                                                    <th scope="col">Order Number</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col">Serving Method</th>
                                                    <th scope="col">Payment</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Completed</th>
                                                    <th scope="col">Gateway</th>
                                                    <th scope="col">Time</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($orders as $key => $order)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="bulk-check"
                                                                data-val="{{ $order->id }}">
                                                        </td>
                                                        <td>{{ $order->order_number }}</td>
                                                        <td>

                                                            {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                            {{ $order->total }}
                                                            {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}

                                                        </td>
                                                        <td class="text-capitalize">
                                                            @if ($order->serving_method == 'on_table')
                                                                On Table
                                                            @elseif ($order->serving_method == 'home_delivery')
                                                                Home Delivery
                                                            @elseif ($order->serving_method == 'pick_up')
                                                                Pick up
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($order->type == 'pos' || $order->gateway_type == 'offline')
                                                                <form id="paymentForm{{ $order->id }}"
                                                                    class="d-inline-block"
                                                                    action="{{ route('user.product.order.payment') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="order_id"
                                                                        value="{{ $order->id }}">
                                                                    <select
                                                                        class="form-control form-control-sm
                                            @if ($order->payment_status == 'Pending') bg-warning
                                            @elseif ($order->payment_status == 'Completed')
                                                bg-success @endif
                                        "
                                                                        name="payment_status"
                                                                        onchange="document.getElementById('paymentForm{{ $order->id }}').submit();">
                                                                        <option value="Pending"
                                                                            {{ $order->payment_status == 'Pending' ? 'selected' : '' }}>
                                                                            Pending
                                                                        </option>
                                                                        <option value="Completed"
                                                                            {{ $order->payment_status == 'Completed' ? 'selected' : '' }}>
                                                                            Completed
                                                                        </option>
                                                                    </select>
                                                                </form>
                                                            @else
                                                                @if ($order->payment_status == 'Pending' || $order->payment_status == 'pending')
                                                                    <p class="badge badge-danger">Pending</p>
                                                                @else
                                                                    <p class="badge badge-success">Completed</p>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <form id="statusForm{{ $order->id }}"
                                                                class="d-inline-block"
                                                                action="{{ route('user.product.orders.status') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="order_id"
                                                                    value="{{ $order->id }}">
                                                                <select
                                                                    class="form-control
                                  @if ($order->order_status == 'pending') @elseif ($order->order_status == 'received')
                                    bg-secondary
                                  @elseif ($order->order_status == 'preparing')
                                    bg-warning
                                  @elseif ($order->order_status == 'ready_to_pick_up')
                                    bg-primary
                                  @elseif ($order->order_status == 'picked_up')
                                    bg-info
                                  @elseif ($order->order_status == 'delivered')
                                    bg-success
                                  @elseif ($order->order_status == 'cancelled')
                                    bg-danger
                                  @elseif ($order->order_status == 'ready_to_serve')
                                    bg-white text-dark
                                  @elseif ($order->order_status == 'served')
                                    bg-light text-dark @endif
                                  "
                                                                    name="order_status"
                                                                    onchange="document.getElementById('statusForm{{ $order->id }}').submit();">
                                                                    <option value="pending"
                                                                        {{ $order->order_status == 'pending' ? 'selected' : '' }}>
                                                                        Pending
                                                                    </option>
                                                                    <option value="received"
                                                                        {{ $order->order_status == 'received' ? 'selected' : '' }}>
                                                                        Received
                                                                    </option>
                                                                    <option value="preparing"
                                                                        {{ $order->order_status == 'preparing' ? 'selected' : '' }}>
                                                                        Preparing
                                                                    </option>

                                                                    @if ($order->serving_method != 'on_table')
                                                                        <option value="ready_to_pick_up"
                                                                            {{ $order->order_status == 'ready_to_pick_up' ? 'selected' : '' }}>
                                                                            Ready to pick up
                                                                        </option>
                                                                        <option value="picked_up"
                                                                            {{ $order->order_status == 'picked_up' ? 'selected' : '' }}>
                                                                            Picked up
                                                                        </option>
                                                                    @endif

                                                                    @if ($order->serving_method == 'home_delivery')
                                                                        <option value="delivered"
                                                                            {{ $order->order_status == 'delivered' ? 'selected' : '' }}>
                                                                            Delivered
                                                                        </option>
                                                                    @endif

                                                                    @if ($order->serving_method == 'on_table')
                                                                        <option value="ready_to_serve"
                                                                            {{ $order->order_status == 'ready_to_serve' ? 'selected' : '' }}>
                                                                            Ready to Serve
                                                                        </option>
                                                                        <option value="served"
                                                                            {{ $order->order_status == 'served' ? 'selected' : '' }}>
                                                                            Served
                                                                        </option>
                                                                    @endif

                                                                    <option value="cancelled"
                                                                        {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>
                                                                        Cancelled
                                                                    </option>
                                                                </select>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form id="completeForm{{ $order->id }}"
                                                                class="d-inline-block"
                                                                action="{{ route('user.product.order.completed') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="order_id"
                                                                    value="{{ $order->id }}">
                                                                <select
                                                                    class="form-control
                                        @if (empty($order->completed) || $order->completed == 'no') bg-danger
                                        @elseif ($order->completed == 'yes')
                                            bg-success @endif
                                    "
                                                                    name="completed"
                                                                    onchange="document.getElementById('completeForm{{ $order->id }}').submit();">
                                                                    <option value="no"
                                                                        {{ empty($order->completed) || $order->completed == 'no' ? 'selected' : '' }}>
                                                                        No
                                                                    </option>
                                                                    <option value="yes"
                                                                        {{ $order->completed == 'yes' ? 'selected' : '' }}>
                                                                        Yes
                                                                    </option>
                                                                </select>
                                                            </form>
                                                        </td>
                                                        <td class="text-capitalize">
                                                            {{ $order->method }}
                                                        </td>
                                                        <td>
                                                            {{ Carbon\Carbon::parse($order->created_at)->timezone($userBe->timezone) }} 
                                                        </td>

                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle btn-sm"
                                                                    type="button" id="dropdownMenuButton"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    Actions
                                                                </button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('user.product.orders.details', $order->id) }}">Details</a>

                                                                    <a href="#" class="dropdown-item editbtn"
                                                                        data-toggle="modal" data-target="#mailModal"
                                                                        data-email="{{ $order->billing_email }}">Send
                                                                        Mail</a>

                                                                    @if ($order->type != 'pos')
                                                                        <a class="dropdown-item"
                                                                            href="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_INVOICE, $order->invoice_number, $userBs) }}"
                                                                            target="_blank">Invoice</a>
                                                                    @endif
                                                                    @if ($order->gateway_type == 'offline' && !empty($order->receipt))
                                                                        <a href="#" data-toggle="modal"
                                                                            data-target="#receiptModal{{ $order->id }}"
                                                                            class="dropdown-item">Attchment
                                                                        </a>
                                                                    @endif
                                                                    <a class="dropdown-item" href="#">
                                                                        <form class="deleteform d-inline-block"
                                                                            action="{{ route('user.product.order.delete') }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="order_id"
                                                                                value="{{ $order->id }}">
                                                                            <button type="submit" class="deletebtn">
                                                                                Delete
                                                                            </button>
                                                                        </form>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @if ($order->gateway_type == 'offline' && !empty($order->receipt))
                                                        <div class="modal fade" id="receiptModal{{ $order->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Receipt Image</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_RECEIPT, $order->receipt, $userBs) }}"
                                                                            alt="Receipt" width="200">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="d-inline-block mx-auto">
                            {{ $orders->appends(['orders_from' => request()->input('orders_from'), 'serving_method' => request()->input('serving_method'), 'order_status' => request()->input('order_status'), 'payment_status' => request()->input('payment_status'), 'completed' => request()->input('completed'), 'order_date' => request()->input('order_date'), 'delivery_date' => request()->input('delivery_date'), 'search' => request()->input('search')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('user.product.order.mail')
@endsection

@section('scripts')
      <script src="{{ asset('assets/tenant/js/popup_blade.js') }}"></script>
@endsection
