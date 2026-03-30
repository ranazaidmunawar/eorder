@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{__('Basic Informations')}}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{__('Basic Settings')}}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{__('Basic Informations')}}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="" action="{{route('admin.basicinfo.update')}}" method="post">
          @csrf
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-10">
                      <div class="card-title">{{__('Update Basic Informations')}}</div>
                  </div>
              </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-8 offset-lg-2">
                @csrf
                <div class="form-group">
                  <h3 class="text-warning">{{__('Information')}}</h3>
                  <hr class="divider"><br>

                  <label>{{__('Website Title')}} **</label>
                  <input class="form-control" name="website_title" value="{{$abs->website_title}}">
                  @if ($errors->has('website_title'))
                    <p class="mb-0 text-danger">{{$errors->first('website_title')}}</p>
                  @endif
                </div>
                  <div class="form-group">
                      <label>{{__('Timezone')}} **</label>
                      <select name="timezone" class="form-control select2">
                          @foreach($timezones as $timezone)
                              <option value="{{$timezone->timezone}}" {{$timezone->timezone == $abe->timezone ? "selected" : "" }}>{{$timezone->timezone}}</option>
                          @endforeach
                      </select>
                      @if ($errors->has('timezone'))
                          <p class="mb-0 text-danger">{{$errors->first('timezone')}}</p>
                      @endif
                  </div>

                <div class="form-group">
                  <br>
                  <h3 class="text-warning">{{__('Website Appearance')}}</h3>
                  <hr class="divider"><br>

                    <div class="row">
                        <div class="col-lg-6">
                            <label>{{__('Base Color Code 1')}} **</label>
                            <input class="jscolor form-control ltr" name="base_color" value="{{$abs->base_color}}">
                            @if ($errors->has('base_color'))
                                <p class="mb-0 text-danger">{{$errors->first('base_color')}}</p>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <label>{{__('Base Color Code 2')}} **</label>
                            <input class="jscolor form-control ltr" name="base_color2" value="{{$abs->base_color2}}">
                            @if ($errors->has('base_color'))
                                <p class="mb-0 text-danger">{{$errors->first('base_color')}}</p>
                            @endif
                        </div>
                    </div>




                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <br>
                            <h3 class="text-warning">{{__('Currency Settings')}}</h3>
                            <hr class="divider">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">

                            <label>{{__('Base Currency Symbol')}} **</label>
                            <input type="text" class="form-control ltr" name="base_currency_symbol" value="{{$abe->base_currency_symbol}}">
                            @if ($errors->has('base_currency_symbol'))
                              <p class="mb-0 text-danger">{{$errors->first('base_currency_symbol')}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>{{__('Base Currency Symbol Position')}} **</label>
                            <select name="base_currency_symbol_position" class="form-control ltr">
                                <option value="left" {{$abe->base_currency_symbol_position == 'left' ? 'selected' : ''}}>{{__('Left')}}</option>
                                <option value="right" {{$abe->base_currency_symbol_position == 'right' ? 'selected' : ''}}>{{__('Right')}}</option>
                            </select>
                            @if ($errors->has('base_currency_symbol_position'))
                              <p class="mb-0 text-danger">{{$errors->first('base_currency_symbol_position')}}</p>
                            @endif
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>{{__('Base Currency Text')}} **</label>
                            <input type="text" class="form-control ltr" name="base_currency_text" value="{{$abe->base_currency_text}}">
                            @if ($errors->has('base_currency_text'))
                              <p class="mb-0 text-danger">{{$errors->first('base_currency_text')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>{{__('Base Currency Text Position')}} **</label>
                            <select name="base_currency_text_position" class="form-control ltr">
                                <option value="left" {{$abe->base_currency_text_position == 'left' ? 'selected' : ''}}>{{__('Left')}}</option>
                                <option value="right" {{$abe->base_currency_text_position == 'right' ? 'selected' : ''}}>{{__('Right')}}</option>
                            </select>
                            @if ($errors->has('base_currency_text_position'))
                              <p class="mb-0 text-danger">{{$errors->first('base_currency_text_position')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>{{__('Base Currency Rate')}} **</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">{{__('1 USD')}} =</span>
                                </div>
                                <input type="text" name="base_currency_rate" class="form-control ltr" value="{{$abe->base_currency_rate}}">
                                <div class="input-group-append">
                                  <span class="input-group-text">{{$abe->base_currency_text}}</span>
                                </div>
                            </div>

                            @if ($errors->has('base_currency_rate'))
                              <p class="mb-0 text-danger">{{$errors->first('base_currency_rate')}}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <br>
                            <h3 class="text-warning">{{__('File & Video Upload Size')}}</h3>
                            <hr class="divider">
                        </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>{{ __('Maximum Size of Single Video') . '*' }}</label>
                        <div class="input-group mb-2">
                          <input type="text" step="0.01" name="max_video_size" class="form-control" value="{{ $abe->max_video_size }}">
                          <div class="input-group-append">
                            <span class="input-group-text">{{ __('MB') }}</span>
                          </div>
                        </div>
                        <p class="text-warning mb-0">{{__('Please increase the file upload size from Hosting')}}</p>
                        @if ($errors->has('max_video_size'))
                          <p class="mb-0 text-danger">{{ $errors->first('max_video_size') }}</p>
                        @endif
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>{{ __('Maximum Size of Single File') . '*' }}</label>
                        <div class="input-group mb-2">
                          <input type="text" step="0.01" name="max_file_size" class="form-control" value="{{ $abe->max_file_size }}">
                          <div class="input-group-append">
                            <span class="input-group-text">{{ __('MB') }}</span>
                          </div>
                        </div>
                        <p class="text-warning mb-0">{{__('Please increase the file upload size from Hosting')}}</p>
                        @if ($errors->has('max_file_size'))
                          <p class="mb-0 text-danger">{{ $errors->first('max_file_size') }}</p>
                        @endif
                      </div>
                    </div>
                </div>

              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success">{{__('Update')}}</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
