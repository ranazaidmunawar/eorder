@extends('user.layout')

@if (!empty($abs->language) && $abs->language->rtl == 1)
    @section('styles')
        <style>
            form input,
            form textarea,
            form select {
                direction: rtl;
            }

            form .note-editor.note-frame .note-editing-area .note-editable {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Section Headings</h4>
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
                <a href="#">Section Headings</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="" action="{{ route('user.section.heading.update', $lang_id) }}" method="post">
                    @csrf
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="card-title">Update Page Headings</div>
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
                    <div class="card-body pt-5 pb-5">
                        <div class="row">
                    
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Menu Title </label>
                                    <input class="form-control" name="menu_title"
                                        value="{{ $sectionHeadings->menu_title ?? null }}">
                                    @if ($errors->has('menu_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('menu_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Menu Subtitle </label>
                                    <input class="form-control" name="menu_subtitle"
                                        value="{{ $sectionHeadings->menu_subtitle ?? null }}">
                                    @if ($errors->has('menu_subtitle'))
                                        <p class="mb-0 text-danger">{{ $errors->first('menu_subtitle') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Team Title </label>
                                    <input class="form-control" name="team_title"
                                        value="{{ $sectionHeadings->team_title ?? null }}">
                                    @if ($errors->has('team_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('team_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Team Subtitle </label>
                                    <input class="form-control" name="team_subtitle"
                                        value="{{ $sectionHeadings->team_subtitle ?? null }}">
                                    @if ($errors->has('team_subtitle'))
                                        <p class="mb-0 text-danger">{{ $errors->first('team_subtitle') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Blog Title </label>
                                    <input class="form-control" name="blog_title"
                                        value="{{ $sectionHeadings->blog_title ?? null }}">
                                    @if ($errors->has('blog_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('blog_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Blog Subtitle </label>
                                    <input class="form-control" name="blog_subtitle"
                                        value="{{ $sectionHeadings->blog_subtitle ?? null }}">
                                    @if ($errors->has('blog_subtitle'))
                                        <p class="mb-0 text-danger">{{ $errors->first('blog_subtitle') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Testimonial Title </label>
                                    <input class="form-control" name="testimonial_title"
                                        value="{{ $sectionHeadings->testimonial_title ?? null }}">
                                    @if ($errors->has('testimonial_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('testimonial_title') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-footer">
                <div class="form">
                    <div class="form-group from-show-notify row">
                        <div class="col-12 text-center">
                            <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>

@endsection
