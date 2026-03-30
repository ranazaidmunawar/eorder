@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user.layout')

@if (!empty($abs->language) && $abs->language->rtl == 1)
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
        <h4 class="page-title">Team Section</h4>
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
                <a href="#">Team Section</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title d-inline-block">Members</div>
                    <a href="{{ route('user.member.create') . '?language=' . request()->input('language') }}"
                        class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add Member</a>
                        </div>
                        <div class="col-lg-2">
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
                    </div>

                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($members) == 0)
                                <h3 class="text-center">NO MEMBER FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Rank</th>
                                                <th scope="col">Featured</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($members as $key => $member)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><img src="{{ Uploader::getImageUrl(Constant::WEBSITE_MEMBER_IMAGES, $member->image, $userBs) }}"
                                                            alt="" width="80"></td>
                                                    <td>{{ convertUtf8($member->name) }}</td>
                                                    <td>{{ $member->rank }}</td>
                                                    <td>
                                                        <form id="featureForm{{ $member->id }}" class="d-inline-block"
                                                            action="{{ route('user.member.feature') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="member_id"
                                                                value="{{ $member->id }}">
                                                            <select
                                                                class="form-control {{ $member->feature == 1 ? 'bg-success' : 'bg-danger' }}"
                                                                name="feature"
                                                                onchange="document.getElementById('featureForm{{ $member->id }}').submit();">
                                                                <option value="1"
                                                                    {{ $member->feature == 1 ? 'selected' : '' }}>
                                                                    Yes
                                                                </option>
                                                                <option value="0"
                                                                    {{ $member->feature == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                            </select>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-secondary btn-sm my-2"
                                                            href="{{ route('user.member.edit', $member->id) . '?language=' . request()->input('language') }}">
                                                            <span class="btn-label">
                                                                <i class="fas fa-edit"></i>
                                                            </span>

                                                        </a>
                                                        <form class="deleteform d-inline-block"
                                                            action="{{ route('user.member.delete') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="member_id"
                                                                value="{{ $member->id }}">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm deletebtn">
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
@endsection
