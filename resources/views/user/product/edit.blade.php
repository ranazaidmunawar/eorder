@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;

@endphp
@extends('user.layout')

@if (!empty($data->language) && $data->language->rtl == 1)
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
        <h4 class="page-title">Edit Item</h4>
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
                <a href="#">Items Management</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Edit Item</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Edit Item</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block"
                        href="{{ route('user.product.index') . '?language=' . request()->input('language') }}">
                        <span class="btn-label">
                            <i class="fas fa-backward"></i>
                        </span>
                        Back
                    </a>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="alert alert-danger pb-1 dis-none" id="blogErrors">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <ul></ul>
                            </div>

                            <div>
                                <label for="" class="mb-2"><strong>Slider Images **</strong></label>
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-striped" id="imgtable">

                                        </table>
                                    </div>
                                </div>
                                <form action="{{ route('user.product.slider.update') }}" id="my-dropzone"
                                    enctype="multipart/form-data" class="dropzone">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $data->id }}">
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                    </div>
                                </form>
                                <p class="em text-danger mb-0" id="errslider_images"></p>
                            </div>

                            <form id="blogForm" class="" action="{{ route('user.product.update') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $data->id }}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group px-0">
                                            <div class="mb-2">
                                                <label for="image"><strong>Featured Image</strong></label>
                                            </div>
                                            <div class="showImage mb-3">
                                                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $data->feature_image, $userBs) }}"
                                                    alt="..." class="img-thumbnail" width="200">
                                            </div>
                                            <input type="file" name="feature_image" id="image"
                                                class="form-control image">
                                        </div>
                                    </div>
                                </div>
                                <div id="sliders"></div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group px-0">
                                            <label for="">Status **</label>
                                            <select class="form-control ltr" name="status">
                                                <option value="" selected disabled>Select a status</option>
                                                <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Show
                                                </option>
                                                <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Hide
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group px-0">
                                            <label for=""> Current Price
                                                ({{ $userBe->base_currency_text }})**</label>
                                            <input type="text" class="form-control ltr" name="current_price"
                                                value="{{ $data->current_price }}" placeholder="Enter Current Price">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group px-0">
                                            <label for="">Previous Price
                                                ({{ $userBe->base_currency_text }})</label>
                                            <input type="text" class="form-control ltr" name="previous_price"
                                                value="{{ $data->previous_price }}" placeholder="Enter Previous Price">
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion accordion-secondary mt-3" id="accordion">

                                    @foreach ($userLangs as $language)
                                        @php
                                            $productData = $language
                                                ->productInformation()
                                                ->where('product_id', $data->id)
                                                ->first();
                                        @endphp

                                        <div class="card">
                                            <div class="card-header {{ $language->is_default == 1 ? '' : 'collapsed' }}"
                                                id="heading{{ $language->id }}" data-toggle="collapse"
                                                data-target="#collapse{{ $language->id }}"
                                                aria-expanded="{{ $language->is_default == 1 ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $language->id }}">
                                                <div class="span-title">
                                                    {{ $language->name . __(' Language') }}
                                                    {{ $language->is_default == 1 ? '(Default)' : '' }}
                                                </div>
                                                <div class="span-mode"></div>
                                            </div>

                                            <div id="collapse{{ $language->id }}"
                                                class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                                                aria-labelledby="heading{{ $language->id }}" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                <label>{{ __('Title') . '*' }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="{{ $language->code }}_title"
                                                                    placeholder="Enter Title"
                                                                    value="{{ is_null($productData) ? '' : $productData->title }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                @php
                                                                    $categories = DB::table('pcategories')
                                                                        ->where('language_id', $language->id)
                                                                        ->where(
                                                                            'user_id',
                                                                            Auth::guard('web')->user()->id,
                                                                        )
                                                                        ->where('status', 1)
                                                                        ->orderByDesc('id')
                                                                        ->get();
                                                                @endphp
                                                                <label for="">{{ __('Category') . '*' }}</label>
                                                                <select name="{{ $language->code }}_category_id"
                                                                    class="form-control"
                                                                    id="{{ $language->id }}_category_id"
                                                                    onchange="getSubCategory(this)">
                                                                    @if (!empty($categories))
                                                                        <option disabled>{{ __('Select Category') }}
                                                                        </option>
                                                                        @foreach ($categories as $category)
                                                                            <option value="{{ $category->id }}"
                                                                                {{ !empty($productData) && $productData->category_id == $category->id ? 'selected' : '' }}>
                                                                                {{ $category->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">

                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                @php
                                                                    $subcategories = DB::table('psub_categories')
                                                                        ->where('language_id', $language->id)
                                                                        ->where(
                                                                            'category_id',
                                                                            $productData?->category_id,
                                                                        )
                                                                        ->where(
                                                                            'user_id',
                                                                            Auth::guard('web')->user()->id,
                                                                        )
                                                                        ->where('status', 1)
                                                                        ->orderByDesc('id')
                                                                        ->get();
                                                                @endphp
                                                                <label for="">{{ __('Subcategory') }}</label>
                                                                <select name="{{ $language->code }}_subcategory_id"
                                                                    class="form-control"
                                                                    id="{{ $language->id }}_subcategory_id">
                                                                    @if (!empty($subcategories))
                                                                        <option selected value="{{ null }}">
                                                                            {{ __('Select Subcategory') }}
                                                                        </option>
                                                                        @foreach ($subcategories as $subcategory)
                                                                            <option value="{{ $subcategory->id }}"
                                                                                {{ !empty($productData) && $productData->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                                                                {{ $subcategory->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                <label>{{ __('Summary') . '*' }}</label>
                                                                <textarea row="6" type="text" class="form-control" name="{{ $language->code }}_summary"
                                                                    placeholder="Enter Product Summary">{{ $productData?->summary }}
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                <label>{{ __('Description') . '*' }}</label>
                                                                <textarea class="form-control summernote" id="description{{ $language->code }}"
                                                                    name="{{ $language->code }}_description" placeholder="Enter Description" data-height="300">{{ is_null($productData) ? '' : replaceBaseUrl($productData?->description, 'summernote') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                <label>{{ __('Meta Keywords') }}</label>
                                                                <input class="form-control"
                                                                    name="{{ $language->code }}_meta_keywords"
                                                                    placeholder="Enter Meta Keywords"
                                                                    data-role="tagsinput"
                                                                    value="{{ is_null($productData) ? '' : $productData->meta_keywords }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <div
                                                                class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                                                <label>{{ __('Meta Description') }}</label>
                                                                <textarea class="form-control" name="{{ $language->code }}_meta_description" rows="5"
                                                                    placeholder="Enter Meta Description">{{ is_null($productData) ? '' : $productData->meta_description }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="js-repeater">
                                    <div class="mb-3">
                                        <label class="form-label mb-2">Variations</label>
                                        <br>
                                        <button class="btn btn-primary  js-repeater-add" type="button">+
                                            Add Variant</button>
                                    </div>
                                    <div id="js-repeater-container">
                                        @php
                                            $variations = json_decode($data->variations, true);
                                            $keywords = json_decode($data->keywords, true);
                                            $addonkeywords = json_decode($data->addon_keywords, true);
                                            $addons = json_decode($data->addons, true);

                                            $indx = json_decode($data->indx, true);
                                        @endphp

                                        @if (!empty($variations))
                                            @php
                                                $v = -1;
                                            @endphp
                                            @foreach ($variations as $vkey => $vname)
                                                @php
                                                    $v++;
                                                @endphp

                                                <div class="js-repeater-item" data-item="{{ $v }}">
                                                    <div class="mb-3 row align-items-end">
                                                        @foreach ($userLangs as $lkey => $lang)
                                                            @php
                                                                $key = $lang->code . '_' . $vkey;
                                                            @endphp
                                                            <div class="col-4">
                                                                <label for="form" class="form-label mb-1">Variation
                                                                    Name ({{ $lang->code }})</label>
                                                                <div class=" mb-2">


                                                                    <input type="text" required=""
                                                                        value="{{ $keywords['variation_name'][$key] ?? '' }}"
                                                                        class="form-control" placeholder=""
                                                                        name="{{ $lang->code }}_variation_{{ $v }}">

                                                                    <input type="hidden" name="variation_helper[]"
                                                                        value="{{ $v }}">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div class="col-4">
                                                            <button class="btn btn-danger btn-sm js-repeater-remove mb-2 mr-2"
                                                            type="button"
                                                            onclick="$(this).parents('.js-repeater-item').remove()">X</button>
                                                        <button class="btn btn-success btn-sm js-repeater-child-add mb-2"
                                                            type="button" data-it="{{ $v }}">
                                                            Add Option
                                                        </button>
                                                        </div>

                                                        <div class="repeater-child-list mt-2 col-12"
                                                            id="options{{ $v }}">

                                                            @foreach ($variations[$vkey] as $okey => $option)
                                                                <div class="repeater-child-item mb-3"
                                                                    id="options{{ $v . $okey }}">
                                                                    <div class="row align-items-start">

                                                                        @foreach ($userLangs as $lkey => $lang)
                                                                            @php
                                                                                $optionK =
                                                                                    $lang->code . '_' . $option['name'];
                                                                            @endphp

                                                                            <div class="col-3">
                                                                                <label for="form"
                                                                                    class="form-label mb-1">Option Name
                                                                                    ({{ $lang->code }})
                                                                                </label>

                                                                                <input required
                                                                                    name="{{ $lang->code }}_options1_{{ $v }}[]"
                                                                                    type="text" class="form-control"
                                                                                    placeholder=""
                                                                                    value="{{ $keywords['option_name'][$optionK] ?? '' }}">

                                                                            </div>
                                                                        @endforeach


                                                                        <div class="col-3">
                                                                            <label for="form"
                                                                                class="form-label mb-1">Price
                                                                                ({{ $userBe->base_currency_symbol }})</label>
                                                                            <input required
                                                                                name="options2_{{ $v }}[]"
                                                                                type="text" class="form-control"
                                                                                value="{{ $variations[$vkey][$okey]['price'] }}"
                                                                                placeholder="0">

                                                                        </div>

                                                                        <div class="col-3">
                                                                            <button
                                                                                class="btn btn-danger mt-4 js-repeater-child-remove btn-sm"
                                                                                type="button"
                                                                                onclick="$(this).parents('.repeater-child-item').remove()">X</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                    </div>
                                    @endif

                                </div>

                                <div class="js-repeater-addon">
                                    <div class="mb-3">
                                        <label class="form-label mb-2">Addons</label>
                                        <br>
                                        <button class="btn btn-primary  js-repeater-addon-add" type="button">+
                                            Add Addon</button>
                                    </div>
                                    <div id="js-repeater-container-addon">

                                        @if (!empty($addonkeywords))
                                            @php
                                                $a = -1;
                                            @endphp
                                            @foreach ($addons as $akey => $addon)
                                                @php
                                                    $a++;
                                                @endphp
                                                <div class=" mb-3 js-repeater-item js-repeater-item-addon "
                                                    id="addonDiv{{ $a }}">
                                                    <div class="mb-3 row align-items-end">
                                                        @foreach ($userLangs as $lkey => $lang)
                                                            @php
                                                                $key = $lang->code . '_' . $addon['name'];
                                                            @endphp

                                                            <div class="col-3">
                                                                <label for="form" class="form-label mb-1">Addon Name
                                                                    (In {{ $lang->code }})
                                                                </label>
                                                                <div class="mb-2">

                                                                    <input required
                                                                        value="{{ $addonkeywords['addon_name'][$key] ?? '' }}"
                                                                        name="{{ $lang->code }}_addonoptions1_{{ $a }}[]"
                                                                        type="text" class="form-control"
                                                                        placeholder="">

                                                                    <input type="hidden" name="addon_variation_helper[]"
                                                                        value="{{ $a }}">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div class="col-3">
                                                            <label for="form" class="form-label mb-1">Price
                                                                ({{ $userBe->base_currency_symbol }})</label>
                                                            <div class="mb-2">
                                                                <input required name="addonoptions2_{{ $a }}[]"
                                                                    type="text" class="form-control"
                                                                    value="{{ $addon['price'] }}" placeholder="0">
                                                            </div>
                                                        </div>

                                                        <div class="col-3">
                                                            <button
                                                                class="btn btn-danger mb-2 js-repeater-child-remove btn-sm"
                                                                type="button"
                                                                onclick="$(this).parents('.js-repeater-item-addon').remove()">X</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" form="blogForm" class="btn btn-success">
                                    {{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('variables')
    <script>
        "use strict";
        var storeUrl = "{{ route('user.product.slider.store') }}";
        var removeUrl = "{{ route('user.product.slider.rmv') }}";
        var rmvdbUrl = "{{ route('user.product.slider.rmv') }}";
        var loadImgs = "{{ route('user.product.images', $data->id) }}";
    </script>
@endsection

@section('scripts')
    <script>
        const languages = <?= $userLangs ?>;
        let symbol = "{{ $userBe->base_currency_symbol }}";
        let variants = [];
        let variantRoute = "{{ route('user.product.variants', $data->id) }}";
        let addonRoute = "{{ route('user.product.addons', $data->id) }}";
    </script>
    <script type="text/javascript" src="{{ asset('assets/tenant/js/partial.js') }}"></script>
    <script src="{{ asset('assets/tenant/js/product-edit.js') }}"></script>
@endsection
