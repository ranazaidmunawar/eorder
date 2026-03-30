@extends('user.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">
            Registered Customers
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
                <a href="#">Customer</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Registered Customers</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="card-title">
                                Registered Customers
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                            <button class="btn btn-danger float-right btn-sm ml-2 mt-2 d-none bulk-delete"
                                data-href="{{ route('user.bulk_delete_user') }}"><i class="flaticon-interface-5"></i>
                                Delete</button>
                            <button class="btn btn-primary float-lg-right float-none btn-sm ml-2 mt-2" data-toggle="modal"
                                data-target="#createModal"><i class="fas fa-plus"></i> Add Customer</button>
                            <form action="{{ url()->full() }}" class="float-lg-right float-none my-2">
                                <input type="text" name="term" class="form-control"
                                    value="{{ request()->input('term') }}" placeholder="Search by Username / Email"
                                    style="min-width: 250px;">
                            </form>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if ($users->count() == 0)
                                <h3 class="text-center">NO CUSTOMER FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <input type="checkbox" class="bulk-check" data-val="all">
                                                </th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Email Status</th>
                                                <th scope="col">Account</th>
                                                <td scope="col">Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $key => $user)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="bulk-check"
                                                            data-val="{{ $user->id }}">
                                                    </td>
                                                    <td>{{ convertUtf8($user->username) }}</td>
                                                    <td>{{ convertUtf8($user->email) }}</td>

                                                    <td>
                                                        <form id="emailForm{{ $user->id }}" class="d-inline-block"
                                                            action="{{ route('register.client.email') }}" method="post">
                                                            @csrf
                                                            <select
                                                                class="form-control form-control-sm {{ strtolower($user->email_verified) == 'yes' ? 'bg-success' : 'bg-danger' }}"
                                                                name="email_verified"
                                                                onchange="document.getElementById('emailForm{{ $user->id }}').submit();">
                                                                <option value="Yes"
                                                                    {{ strtolower($user->email_verified) == 'yes' ? 'selected' : '' }}>
                                                                    Verify</option>
                                                                <option value="no"
                                                                    {{ strtolower($user->email_verified) == 'no' ? 'selected' : '' }}>
                                                                    Unverify</option>
                                                            </select>
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $user->id }}">
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <form id="userFrom{{ $user->id }}" class="d-inline-block"
                                                            action="{{ route('register.client.ban') }}" method="post">
                                                            @csrf
                                                            <select
                                                                class="form-control form-control-sm {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}"
                                                                name="status"
                                                                onchange="document.getElementById('userFrom{{ $user->id }}').submit();">
                                                                <option value="1"
                                                                    {{ $user->status == 1 ? 'selected' : '' }}>Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $user->status == 0 ? 'selected' : '' }}>Deactive
                                                                </option>
                                                            </select>
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $user->id }}">
                                                        </form>
                                                    </td>
                                                    <td>

                                                        <div class="dropdown">
                                                            <button class="btn btn-info btn-sm dropdown-toggle"
                                                                type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                Actions
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('register.client.details', $user->id) }}">Details</a>
                                                                <a href="#" data-id="{{ $user->id }}"
                                                                    class="dropdown-item editbtn" data-toggle="modal"
                                                                    data-target="#passwordModal">Change Password</a>

                                                                <form class="deleteform d-block"
                                                                    action="{{ route('register.client.delete') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $user->id }}">
                                                                    <button type="submit"
                                                                        class="deletebtn pl-4 dropdown-item">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                                <form class="d-block"
                                                                    action="{{ route('user.registered_clients.secret.login') }}"
                                                                    method="post" target="_blank">
                                                                    @csrf
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $user->id }}">
                                                                    <button class="dropdown-item "
                                                                        role="button">{{ __('Secret Login') }}</button>
                                                                </form>
                                                            </div>
                                                        </div>
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
                <div class="card-footer">
                    <div class="row">
                        <div class="d-inline-block mx-auto">
                            {{ $users->appends(['term' => request()->input('term')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('user.register_user.create_client')
    @includeIf('user.register_user.change_password')


@endsection
