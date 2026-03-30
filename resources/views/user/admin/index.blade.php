@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

@extends('user.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">Staffs</h4>
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
                <a href="#">Staffs Management</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Staffs</a>
            </li>
        </ul>
    </div>
    <div class="row justify-content-center align-items-center mb-1">
        <div class="col-12">
            <div class="alert border-left border-primary text-dark d-flex justify-content-space-between">
                @php
                    $user = getRootUser();
                @endphp

                <div>
                    Path: <strong class="text-danger">
                        @php
                            $url = url('/') . '/' . $user->username . '/user/login';
                        @endphp
                        <a href="{{ $url }}" target="_blank">{{ $url }}</a>
                    </strong>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Admins</div>
                    <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#createModal">
                        <i class="fas fa-plus"></i>
                        Add Staff
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($users) == 0)
                                <h3 class="text-center">{{ __('NO USER FOUND') }}</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Picture</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $key => $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_TENANT_USER_IMAGE, $user->image, $userBs) }}"
                                                             width="80" height="80">
                                                    </td>
                                                    <td>{{ $user->username }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->first_name }}</td>
                                                    <td>{{ $user->last_name }}</td>
                                                    <td>
                                                        @if (empty($user->role))
                                                            <span class="badge badge-danger">Owner</span>
                                                        @else
                                                            {{ $user->role->name }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($user->status == 1)
                                                            <span class="badge badge-success">Active</span>
                                                        @elseif ($user->status == 0)
                                                            <span class="badge badge-danger">Deactive</span>
                                                        @endif
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
                                                                    href="{{ route('user.admin.edit', $user->id) }}">
                                                                   
                                                                    Edit
                                                                </a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('user.admin.change.password') }}" target="_blank">Change
                                                                    Password</a>
                                                                <form class="deleteform dropdown-item"
                                                                    action="{{ route('user.admin.delete') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $user->id }}">
                                                                    <button type="submit"
                                                                        class=" deletebtn">
                                                                       
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                                <form class="d-block"
                                                                    action="{{ route('user.admin.secretLogin') }}"
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
            </div>
        </div>
    </div>

    @includeif('user.admin.create')
@endsection
