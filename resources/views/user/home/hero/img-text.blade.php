@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user.layout')

@if (!empty($abe->language) && $abe->language->rtl == 1)
    @section('styles')
        <style>
            form input,
            form textarea,
            form select,
            select {
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
        <h4 class="page-title">Hero Section</h4>
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
                <a href="#">Hero Section</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Static Version</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">Update Hero Section</div>
                        </div>
                        <div class="col-lg-2">
                            @if (!empty($langs))
                                <select name="language" class="form-control"
                                    onchange="window.location='{{ url()->current() . '?language=' }}'+this.value">
                                    <option value="" selected disabled>Select a Language</option>
                                    @foreach ($langs as $lang)
                                        <option value="{{ $lang->code }}"
                                            {{ $lang->code == request()->input('language') ? 'selected' : '' }}>
                                            {{ $lang->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body pt-5 pb-4">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <form id="ajaxForm" action="{{ route('user.herosection.update', $lang_id) }}" method="post">
                                @csrf

                                <div class="row">
                                    @if ($activeTheme != 'desifoodie')
                                        <!--background image-->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="image"><strong>Background Image</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($abe->hero_bg))
                                                        <a class="remove-image" data-type="background"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->hero_bg) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->hero_bg, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="..." class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="hero_image" class="form-control image">
                                                <p id="errhero_image" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($activeTheme == 'desices')
                                        <!-- Left Top Image -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="left_top_shape"><strong>Left Top Shape</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($abe->left_top_shape))
                                                        <a class="remove-image" data-type="left_top_shape"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->left_top_shape) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->left_top_shape, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="Left Top" class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="left_top_shape" class="form-control image">
                                                <p id="errleft_top_shape" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>

                                        <!-- Left Bottom Image -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="left_bottom_shape"><strong>Left Bottom
                                                            Shape</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($abe->left_bottom_shape))
                                                        <a class="remove-image" data-type="left_bottom_shape"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->left_bottom_shape) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->left_bottom_shape, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="Left Bottom" class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="left_bottom_shape" class="form-control image">
                                                <p id="errleft_bottom_shape" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>

                                        <!-- Right Top Image -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="right_top_shape"><strong>Right Top Shape</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($abe->right_top_shape))
                                                        <a class="remove-image" data-type="right_top_shape"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->right_top_shape) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->right_top_shape, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="Right Top" class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="right_top_shape" class="form-control image">
                                                <p id="errright_top_shape" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>

                                        <!-- Right Bottom Image -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="right_bottom_shape"><strong>Right Bottom
                                                            Shape</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($abe->right_bottom_shape))
                                                        <a class="remove-image" data-type="right_bottom_shape"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->right_bottom_shape) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->right_bottom_shape, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="Right Bottom" class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="right_bottom_shape"
                                                    class="form-control image">
                                                <p id="errright_bottom_shape" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                    @endif


                                    @if ($activeTheme == 'seabbq')
                                        <!--left shape image-->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="image"><strong>Left Shape Image</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($abe->hero_left_image))
                                                        <a class="remove-image" data-type="background"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->hero_left_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->hero_left_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="..." class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="hero_left_image" class="form-control image">
                                                <p id="errhero_left_image" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                        <!--right shape image-->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="image"><strong>Right Shape Image</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($abe->hero_right_image))
                                                        <a class="remove-image" data-type="background"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->hero_right_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->hero_right_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="..." class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="hero_right_image" class="form-control image">
                                                <p id="errhero_right_image" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                    @endif



                                    @if (
                                        $activeTheme == 'fastfood' ||
                                            $activeTheme == 'bakery' ||
                                            $activeTheme == 'medicine' ||
                                            $activeTheme == 'coffee' ||
                                            $activeTheme == 'desifoodie' ||
                                            $activeTheme == 'beverage')
                                        <!--side image -->
                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="image"><strong>Side Image</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($abe->hero_side_img))
                                                        <a class="remove-image" data-type="side"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->hero_side_img) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->hero_side_img, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="..." class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="side_image" class="form-control image">
                                                <p id="errimage" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                    @endif


                                    @if ($activeTheme == 'fastfood')
                                        <!--bottom image -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="image"><strong>Bottom Image</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($abe->hero_bottom_img))
                                                        <a class="remove-image" data-type="bottom"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif

                                                    <img src="{{ !empty($abe->hero_bottom_img) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->hero_bottom_img, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="..." class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="bottom_image" class="form-control image">
                                                <p id="errbottom_image" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if ($activeTheme == 'fastfood' || $activeTheme == 'coffee' || $activeTheme == 'pizza' || $activeTheme == 'beverage')
                                    <div class="row">
                                        <!--shape image -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="image"><strong>Shape Image</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($abe->hero_shape_img))
                                                        <a class="remove-image" data-type="shape"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif
                                                    <img src="{{ !empty($abe->hero_shape_img) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->hero_shape_img, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="..." class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="shape_image" class="form-control image">
                                                <p id="errshape_image" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($activeTheme != 'seabbq' && $activeTheme != 'desifoodie' && $activeTheme != 'desices')
                                    <div class="row">
                                        <!-- bold text -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Bold Text</label>
                                                <input name="hero_section_bold_text" class="form-control"
                                                    value="{{ $abe->hero_section_bold_text }}">
                                                <p id="errhero_section_bold_text" class="em text-danger mb-0"></p>
                                            </div>
                                        </div>
                                        <!-- bold text font size-->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Bold Text Font Size **</label>
                                                <input type="number" class="form-control ltr"
                                                    name="hero_section_bold_text_font_size"
                                                    value="{{ $abe->hero_section_bold_text_font_size }}">
                                                <p id="errhero_section_bold_text_font_size" class="em text-danger mb-0">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- bold text color-->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Bold Text Color</label>
                                                <input name="hero_section_bold_text_color" class="form-control jscolor"
                                                    value="{{ $abe->hero_section_bold_text_color }}">
                                                <p id="errhero_section_bold_text_color" class="em text-danger mb-0"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif



                                @if ($activeTheme == 'beverage')
                                    <div class="row">
                                        <!--background text -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Background Text</label>
                                                <input name="hero_section_background_text" class="form-control"
                                                    value="{{ $abe->hero_section_water_shape_text }}"
                                                    placeholder="Hero Section Background Text">
                                                <p id="errhero_section_background_text" class="em text-danger mb-0"></p>
                                            </div>
                                        </div>
                                        <!--background text font size-->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Background Text Font Size(if there is Backgraound
                                                    Text **)</label>
                                                <input type="number" class="form-control ltr"
                                                    name="hero_section_background_text_font_size"
                                                    value="{{ $abe->hero_section_water_shape_text && $abe->hero_section_water_shape_text_font_size ? $abe->hero_section_water_shape_text_font_size : '' }}"
                                                    placeholder="Hero Section Background Text Font Size">
                                                <p id="errhero_section_background_text_font_size"
                                                    class="em text-danger mb-0"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($activeTheme == 'seabbq' || $activeTheme == 'desifoodie' || $activeTheme == 'desices')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Title </label>
                                                <input type="text" class="form-control" name="hero_section_title"
                                                    value="{{ $abe->hero_section_title }}">
                                                <p id="errhero_section_title" class="em text-danger mb-0"></p>
                                                @if ($activeTheme == 'seabbq')
                                                    <p class="text-warning">
                                                        Wrap the text with <code>&lt;span&gt;&lt;/span&gt;</code> to have an
                                                        underline
                                                        under the text.
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (
                                    $activeTheme == 'fastfood' ||
                                        $activeTheme == 'pizza' ||
                                        $activeTheme == 'grocery' ||
                                        $activeTheme == 'medicine' ||
                                        $activeTheme == 'coffee' ||
                                        $activeTheme == 'beverage' ||
                                        $activeTheme == 'desifoodie' ||
                                        $activeTheme == 'desices' ||
                                        $activeTheme == 'bakery')
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Text</label>
                                                <input name="hero_section_text" class="form-control"
                                                    value="{{ $abe->hero_section_text }}">
                                                <p id="errhero_section_text" class="em text-danger mb-0"></p>
                                            </div>
                                        </div>
                                        @if ($activeTheme != 'desifoodie' && $activeTheme != 'desices')
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="">Text Font Size **</label>
                                                    <input type="number" class="form-control ltr"
                                                        name="hero_section_text_font_size"
                                                        value="{{ $abe->hero_section_text_font_size }}">
                                                    <p id="errhero_section_text_font_size" class="em text-danger mb-0">
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @if ($activeTheme != 'desifoodie' && $activeTheme != 'desices')
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="">Text Color</label>
                                                    <input name="hero_section_text_color" class="form-control jscolor"
                                                        value="{{ $abe->hero_section_text_color }}">
                                                    <p id="errhero_section_text_color" class="em text-danger mb-0"></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif


                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Button 1 Text </label>
                                            <input type="text" class="form-control" name="hero_section_button_text"
                                                value="{{ $abe->hero_section_button_text }}">
                                            <p id="errhero_section_button_text" class="em text-danger mb-0"></p>
                                        </div>
                                    </div>
                                    @if ($activeTheme == 'seabbq' || $activeTheme == 'desifoodie' || $activeTheme == 'desices')
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Button 1 Url</label>
                                                <input type="text" class="form-control ltr"
                                                    name="hero_section_button_text1_url"
                                                    value="{{ $abe->hero_section_button_text1_url }}">
                                                <p id="errhero_section_button_text1_url" class="em text-danger mb-0">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Button 2 Text </label>
                                                <input type="text" class="form-control"
                                                    name="hero_section_button2_text"
                                                    value="{{ $abe->hero_section_button2_text }}">
                                                <p id="errhero_section_button2_text" class="em text-danger mb-0"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Button 2 Url </label>
                                                <input type="text" class="form-control"
                                                    name="hero_section_button2_url"
                                                    value="{{ $abe->hero_section_button2_url }}">
                                                <p id="errhero_section_button2_url" class="em text-danger mb-0"></p>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($activeTheme != 'seabbq' && $activeTheme != 'desifoodie' && $activeTheme != 'desices')
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Button 1 Text Font Size **</label>
                                                <input type="number" class="form-control ltr"
                                                    name="hero_section_button_text_font_size"
                                                    value="{{ $abe->hero_section_button_text_font_size }}">
                                                <p id="errhero_section_button_text_font_size" class="em text-danger mb-0">
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if ($activeTheme != 'seabbq' && $activeTheme != 'desifoodie' && $activeTheme != 'desices')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Button 1 Color</label>
                                                <input name="hero_section_button_color" class="form-control jscolor"
                                                    value="{{ $abe->hero_section_button_color }}">
                                                <p id="errhero_section_button_color" class="em text-danger mb-0"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Button 1 URL </label>
                                                <input type="text" class="form-control ltr"
                                                    name="hero_section_button_url"
                                                    value="{{ $abe->hero_section_button_url }}">
                                                <p id="errhero_section_button_url" class="em text-danger mb-0"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                @if (
                                    $activeTheme == 'fastfood' ||
                                        $activeTheme == 'pizza' ||
                                        $activeTheme == 'grocery' ||
                                        $activeTheme == 'medicine' ||
                                        $activeTheme == 'coffee')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Button 2 Text </label>
                                                <input type="text" class="form-control"
                                                    name="hero_section_button2_text"
                                                    value="{{ $abe->hero_section_button2_text }}">
                                                <p id="errhero_section_button2_text" class="em text-danger mb-0"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Button 2 Text Font Size **</label>
                                                <input type="number" class="form-control ltr"
                                                    name="hero_section_button2_text_font_size"
                                                    value="{{ $abe->hero_section_button2_text_font_size }}">
                                                <p id="errhero_section_button2_text_font_size"
                                                    class="em text-danger mb-0">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Button 2 Color</label>

                                                <input name="hero_section_button_two_color" class="form-control jscolor"
                                                    value="{{ $abe->hero_section_button_two_color }}">
                                                <p id="errhero_section_button_two_color" class="em text-danger mb-0">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Button 2 URL </label>
                                                <input type="text" class="form-control ltr"
                                                    name="hero_section_button2_url"
                                                    value="{{ $abe->hero_section_button2_url }}">
                                                <p id="errhero_section_button2_url" class="em text-danger mb-0"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($activeTheme == 'bakery')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="mb-2">
                                                    <label for="image"><strong>Author Person Image</strong></label>
                                                </div>
                                                <div class="showImage mb-3">
                                                    @if (!empty($abe->author_image))
                                                        <a class="remove-image" data-type="author"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @endif

                                                    <img src="{{ !empty($abe->author_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $abe->author_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                        alt="..." class="img-thumbnail w-100">
                                                </div>
                                                <input type="file" name="author_image" class="form-control image">
                                                <p id="errauthor_image" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Author Person Name</label>
                                                <input type="text" class="form-control ltr"
                                                    name="hero_section_author_name"
                                                    value="{{ $abe->hero_section_author_name }}"
                                                    placeholder="Author Person Name here..">
                                                <p id="errhero_section_author_name" class="em text-danger mb-0">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Author Designation </label>
                                                <input type="text" class="form-control ltr"
                                                    name="hero_section_author_designation"
                                                    value="{{ $abe->hero_section_author_designation }}"
                                                    placeholder="Author Designation here..">
                                                <p id="errhero_section_author_designation" class="em text-danger mb-0">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </form>

                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        $(function($) {
            "use strict";

            $(".remove-image").on('click', function(e) {
                e.preventDefault();
                $(".request-loader").addClass("show");

                let type = $(this).data('type');
                let fd = new FormData();
                fd.append('type', type);
                fd.append('language_id', {{ $abe->language->id }});

                $.ajax({
                    url: "{{ route('user.herosection.rmv.img') }}",
                    data: fd,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data == "success") {
                            window.location =
                                "{{ url()->current() . '?language=' . $abe->language->code }}";
                        }
                    }
                })
            });

        });
    </script>
@endsection
