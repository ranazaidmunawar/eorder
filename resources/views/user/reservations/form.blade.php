@extends('user.layout')

@if(!empty($abs->language) && $abs->language->rtl == 1)
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
    <h4 class="page-title">Form Builder</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('user.dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Reservation Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Form Builder</a>
      </li>
    </ul>
  </div>

  <div class="row" id="app">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card-title">Input Fields</div>
                </div>
                <div class="col-lg-4">
                    @if (!empty($userLangs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($userLangs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <p class="text-warning mb-0">** Do not create <strong class="text-danger">Name & Email</strong> input field, it will be in the Table Reservation form by default.</p>
            <p class="text-warning">** Drag & Drop the input fields to change the order number</p>

            <form class="ui-state-default ui-state-disabled">
                <div class="form-group">
                    <label for="">Name **</label>
                    <div class="row">
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="" value="" placeholder="Full Name">
                        </div>
                    </div>
                </div>
            </form>
            <form class="ui-state-default ui-state-disabled">
                <div class="form-group">
                    <label for="">Email Address **</label>
                    <div class="row">
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="" value="" placeholder="Email Address">
                        </div>
                    </div>

                </div>
            </form>
            @if (count($inputs) > 0)
                <div id="sortable">
                    @includeIf('user.reservations.created-inputs')
                </div>
            @endif

        </div>
      </div>
    </div>

    <div class="col-lg-5">
        @includeIf('user.reservations.create-input')
    </div>
  </div>
@endsection

@section('scripts')
    <script>
       var orderUpdateRoute = "{{route('user.reservation.orderUpdate')}}"
    </script>
     <script src="{{ asset('assets/tenant/js/blade.js') }}"></script>
@endsection
@section('vuescripts')
  <script src="{{ asset('assets/tenant/js/vue_blade.js') }}"></script>
@endsection
