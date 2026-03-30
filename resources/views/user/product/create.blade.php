@php
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\DB;
@endphp

@extends('user.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Add Item</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="#">
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
        <a href="#">Add Item</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Add Item</div>
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

              <div class="px-0">
                <label for="" class="mb-2"><strong>Slider Images **</strong></label>
                <form action="{{ route('user.product.slider.store') }}" id="my-dropzone" enctype="multipart/form-data"
                  class="dropzone create">
                  @csrf
                  <div class="fallback">
                    <input name="file" type="file" multiple />
                  </div>
                </form>
                <p class="em text-danger mb-0" id="errslider_images"></p>
              </div>


              <form id="blogForm" class="" action="{{ route('user.product.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group px-0">
                      <div class="mb-2">
                        <label for="image"><strong>Featured Image</strong></label>
                      </div>
                      <div class="showImage mb-3">
                        <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="..." class="img-thumbnail"
                          width="200">
                      </div>
                      <input type="file" name="feature_image" id="image" class="form-control image">
                    </div>
                  </div>
                </div>
                <div id="sliders"></div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group px-0">
                      <label for="">Status **</label>
                      <select class="form-control " name="status">
                        <option value="" selected disabled>Select a status</option>
                        <option value="1">Show</option>
                        <option value="0">Hide</option>
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
                        placeholder="Enter Current Price">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group px-0">
                      <label for="">Previous Price ({{ $userBe->base_currency_text }})</label>
                      <input type="text" class="form-control ltr" name="previous_price"
                        placeholder="Enter Previous Price">
                    </div>
                  </div>
                </div>

                <div class="accordion accordion-secondary mt-3" id="accordion">
                  @foreach ($userLangs as $language)
                    <div class="card">
                      <div class="card-header {{ $language->is_default == 1 ? '' : 'collapsed' }}"
                        id="heading{{ $language->id }}" data-toggle="collapse" data-target="#collapse{{ $language->id }}"
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
                              <div class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Title') . '*' }}</label>
                                <input type="text" class="form-control" name="{{ $language->code }}_title"
                                  placeholder="Enter Title">
                              </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                @php
                                  $categories = DB::table('pcategories')
                                      ->where('language_id', $language->id)
                                      ->where('user_id', Auth::guard('web')->user()->id)
                                      ->where('status', 1)
                                      ->orderByDesc('id')
                                      ->get();
                                @endphp

                                <label for="">{{ __('Category') . '*' }}</label>
                                <select class="form-control" name="{{ $language->code }}_category_id"
                                  id="{{ $language->id }}_category_id" onchange="getSubCategory(this)">
                                  <option value="" selected disabled>Select a
                                    category</option>
                                  @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                      {{ $category->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                <label for="category">{{ __('Subcategory') }}</label>
                                <select class="form-control" name="{{ $language->code }}_subcategory_id"
                                  id="{{ $language->id }}_subcategory_id">
                                  <option value="" selected>Select a subcategory
                                  </option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                <label for="summary">{{ __('Summary') . '*' }}</label>
                                <textarea name="{{ $language->code }}_summary" id="summary{{ $language->code }}" class="form-control "
                                  rows="4" placeholder="Enter Product Summary"></textarea>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label>{{ __('Description') . '*' }}</label>
                                <textarea class="form-control summernote" name="{{ $language->code }}_description" placeholder="Enter Description"
                                  data-height="300" id="description{{ $language->code }}" data-langg="{{ $language->rtl == 1 ? 'rtl' : 'ltr' }}">
                                                                </textarea>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Meta Keywords') }}</label>
                                <input class="form-control" name="{{ $language->code }}_meta_keywords"
                                  placeholder="Enter Meta Keywords" data-role="tagsinput">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group {{ $language->rtl == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Meta Description') }}</label>
                                <textarea class="form-control" name="{{ $language->code }}_meta_description" rows="5"
                                  placeholder="Enter Meta Description"></textarea>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              @php $currLang = $language; @endphp
                              @foreach ($userLangs as $lang)
                                @continue($lang->id == $currLang->id)
                                <div class="form-check py-0">
                                  <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox"
                                      onchange="cloneInput('collapse{{ $currLang->id }}', 'collapse{{ $lang->id }}', event)">
                                    <span class="form-check-sign">{{ __('Clone for') }}
                                      <strong class="text-capitalize text-secondary">{{ $lang->name }}</strong>
                                      {{ __('language') }}</span>
                                  </label>
                                </div>
                              @endforeach
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

                  </div>

                </div>
                <div class="js-repeater-addon">
                  <div class="mb-3">
                    <label class="form-label mb-2">Addons</label>
                    <br>
                    <button class="btn btn-primary  js-repeater-addon-add" type="button">+
                      Add Addon</button>
                  </div>
                  <div id="js-repeater-container-addon">

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
                <button type="submit" form="blogForm" class="btn btn-success">Submit</button>
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
  </script>
@endsection

@section('scripts')
  <script>
    let symbol = "{{ $userBe->base_currency_symbol }}";
    const languages = <?= $userLangs ?>;
  </script>

  <script type="text/javascript" src="{{ asset('assets/tenant/js/partial.js') }}"></script>
  <script src="{{ asset('assets/tenant/js/product.js') }}"></script>
@endsection
