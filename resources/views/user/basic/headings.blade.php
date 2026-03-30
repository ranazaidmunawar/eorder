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
        <h4 class="page-title">Page Headings</h4>
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
                <a href="#">Settings</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Page Headings</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="" action="{{ route('user.heading.update', $lang_id) }}" method="post">
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
                                @csrf
                                <div class="form-group">
                                    <label>Menu Title </label>
                                    <input class="form-control" name="menu_page_title"
                                        value="{{ $pageHead->menu_page_title ?? null }}">
                                    @if ($errors->has('menu_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('menu_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Items Title </label>
                                    <input class="form-control" name="items_page_title"
                                        value="{{ $pageHead->items_page_title ?? null }}">
                                    @if ($errors->has('items_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('items_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Item Details Title </label>
                                    <input class="form-control" name="items_details_page_title"
                                        value="{{ $pageHead->items_details_page_title ?? null }}">
                                    @if ($errors->has('items_details_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('items_details_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Cart Title </label>
                                    <input class="form-control" name="cart_page_title"
                                        value="{{ $pageHead->cart_page_title ?? null }}">
                                    @if ($errors->has('cart_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('cart_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Checkout Title </label>
                                    <input class="form-control" name="checkout_page_title"
                                        value="{{ $pageHead->checkout_page_title ?? null }}">
                                    @if ($errors->has('checkout_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('checkout_page_title') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Blog Title </label>
                                    <input class="form-control" name="blog_page_title"
                                        value="{{ $pageHead->blog_page_title ?? null }}">
                                    @if ($errors->has('blog_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('blog_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Blog Details Title </label>
                                    <input class="form-control" name="blog_details_page_title"
                                        value="{{ $pageHead->blog_details_page_title ?? null }}">
                                    @if ($errors->has('blog_details_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('blog_details_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Career Title </label>
                                    <input class="form-control" name="career_page_title"
                                        value="{{ $pageHead->career_page_title ?? null }}">
                                    @if ($errors->has('career_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('career_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Career Details Title </label>
                                    <input class="form-control" name="career_details_title"
                                        value="{{ $pageHead->career_details_title ?? null }}">
                                    @if ($errors->has('career_details_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('career_details_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Gallery Title </label>
                                    <input class="form-control" name="gallery_page_title"
                                        value="{{ $pageHead->gallery_page_title ?? null }}">
                                    @if ($errors->has('gallery_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('gallery_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>FAQ Title </label>
                                    <input class="form-control" name="faq_page_title" value="{{ $pageHead->faq_page_title ?? null }}">
                                    @if ($errors->has('faq_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('faq_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Team Title </label>
                                    <input class="form-control" name="team_page_title"
                                        value="{{ $pageHead->team_page_title ?? null }}">
                                    @if ($errors->has('team_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('team_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Reservation Title </label>
                                    <input class="form-control" name="reservation_page_title"
                                        value="{{ $pageHead->reservation_page_title ?? null }}">
                                    @if ($errors->has('reservation_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('reservation_page_title') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Contact Title </label>
                                    <input class="form-control" name="contact_page_title"
                                        value="{{ $pageHead->contact_page_title ?? null }}">
                                    @if ($errors->has('contact_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('contact_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Login Title </label>
                                    <input class="form-control" name="login_page_title"
                                        value="{{ $pageHead->login_page_title ?? null }}">
                                    @if ($errors->has('login_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('login_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Signup Title </label>
                                    <input class="form-control" name="signup_page_title"
                                        value="{{ $pageHead->signup_page_title ?? null }}">
                                    @if ($errors->has('signup_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('signup_page_title') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Error Page Title </label>
                                    <input class="form-control" name="error_page_title"
                                        value="{{ $pageHead->error_page_title ?? null }}">
                                    @if ($errors->has('error_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('error_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Forget Password Page Title </label>
                                    <input class="form-control" name="forget_password_page_title"
                                        value="{{ $pageHead->forget_password_page_title ?? null }}">
                                    @if ($errors->has('forget_password_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('forget_password_page_title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>About Page Title </label>
                                    <input class="form-control" name="about_page_title"
                                        value="{{ $pageHead->about_page_title ?? null }}">
                                    @if ($errors->has('about_page_title'))
                                        <p class="mb-0 text-danger">{{ $errors->first('about_page_title') }}</p>
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
