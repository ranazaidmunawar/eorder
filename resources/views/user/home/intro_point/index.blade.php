@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

@extends('user.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">Intro Point</h4>
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
                <a href="#">Home Page</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Intro Point</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block">Intro Point</div>
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
                            <a href="#" class="btn btn-primary float-lg-right float-left" data-toggle="modal"
                                data-target="#createModal"><i class="fas fa-plus"></i> Add Intro Point</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($features) == 0)
                                <h3 class="text-center">NO Intro Point FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                @if ($activeTheme == 'seabbq' || $activeTheme == 'desifoodie' || $activeTheme == 'desices')
                                                    <th scope="col">Image</th>
                                                @endif
                                                @if (
                                                    $activeTheme == 'fastfood' ||
                                                        $activeTheme == 'pizza' ||
                                                        $activeTheme == 'grocery' ||
                                                        $activeTheme == 'medicine' ||
                                                        $activeTheme == 'bakery')
                                                    <th scope="col">Icon</th>
                                                @endif

                                                <th scope="col">Title</th>

                                                @if (
                                                    $activeTheme == 'fastfood' ||
                                                        $activeTheme == 'pizza' ||
                                                        $activeTheme == 'grocery' ||
                                                        $activeTheme == 'medicine' ||
                                                        $activeTheme == 'bakery')
                                                    <th scope="col">Text </th>
                                                @endif

                                                @if ($activeTheme == 'coffee' || $activeTheme == 'medicine' || $activeTheme == 'beverage')
                                                    <th scope="col">Rating Point</th>
                                                    <th scope="col">Rating Symbol</th>
                                                @endif

                                                <th scope="col">Serial Number</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($features as $key => $feature)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                  @if ($activeTheme == 'seabbq' || $activeTheme == 'desifoodie' || $activeTheme == 'desices')
                                                        <td> <img
                                                                src="{{ $feature->image ? Uploader::getImageUrl(Constant::WEBSITE_INTRO_POINTER_IMAGE, $feature->image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                                alt=""></td>
                                                    @endif
                                                    @if (
                                                        $activeTheme == 'fastfood' ||
                                                            $activeTheme == 'pizza' ||
                                                            $activeTheme == 'grocery' ||
                                                            $activeTheme == 'medicine' ||
                                                            $activeTheme == 'bakery')
                                                        <td>

                                                            <i class="{{ $feature->icon }}"></i>



                                                        </td>
                                                    @endif

                                                    <td>{{ convertUtf8($feature->title) }}</td>

                                                    @if (
                                                        $activeTheme == 'fastfood' ||
                                                            $activeTheme == 'pizza' ||
                                                            $activeTheme == 'grocery' ||
                                                            $activeTheme == 'medicine' ||
                                                            $activeTheme == 'bakery')
                                                        <td>{{ convertUtf8($feature->text) }}</td>
                                                    @endif

                                                    @if ($activeTheme == 'coffee' || $activeTheme == 'medicine' || $activeTheme == 'beverage')
                                                        <td>{{ $feature->intro_section_rating_point }}</td>
                                                        <td>
                                                            {{ $feature->intro_section_rating_symbol }}
                                                        </td>
                                                    @endif
                                                    <td>{{ $feature->serial_number }}</td>
                                                    <td>
                                                        <a class="btn btn-secondary btn-sm"
                                                            href="{{ route('user.intro.point.edit', $feature->id) . '?language=' . request()->input('language') }}">
                                                            <span class="btn-label">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                            Edit
                                                        </a>
                                                        <form class="deleteform d-inline-block"
                                                            action="{{ route('user.intro.point.delete') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="feature_id"
                                                                value="{{ $feature->id }}">
                                                            <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                                                <span class="btn-label">
                                                                    <i class="fas fa-trash"></i>
                                                                </span>
                                                                Delete
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


    @include('user.home.intro_point.create')

@endsection
