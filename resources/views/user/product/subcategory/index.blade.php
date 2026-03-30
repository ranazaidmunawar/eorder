@php
    use App\Models\User\Language;
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('user.layout')

@php
    $setLang = Language::query()
    ->where([
        ['code', request()->input('language')],
        ['user_id', Auth::guard('web')->user()->id]
    ])->first();
@endphp
@if (!empty($setLang) && $setLang->rtl == 1)
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
        <h4 class="page-title">Item Subcategories</h4>
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
                <a href="#">Item Management</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Subcategory</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block">Subcategories</div>
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
                            <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal"
                               data-target="#createModal"><i class="fas fa-plus"></i> Add Subcategory</a>
                            <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete"
                                    data-href="{{ route('user.subcategory.bulk.delete') }}"><i
                                    class="flaticon-interface-5"></i>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($psubcategories) == 0)
                                <h3 class="text-center">NO PRODUCT SUB CATEGORY FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3">
                                        <thead>
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" class="bulk-check" data-val="all">
                                            </th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Featured</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($psubcategories as $key => $subcategory)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="bulk-check"
                                                           data-val="{{ $subcategory->indx }}">
                                                </td>
                                                <td>{{ convertUtf8($subcategory->name) }}</td>
                                                <td>{{ convertUtf8($subcategory->category->name ?? '') }}</td>
                                                <td>
                                                    @if ($subcategory->status == 1)
                                                        <h2 class="d-inline-block"><span
                                                                class="badge badge-success">Active</span></h2>
                                                    @else
                                                        <h2 class="d-inline-block"><span
                                                                class="badge badge-danger">Deactive</span></h2>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form id="featureForm{{$subcategory->id}}"
                                                          action="{{route('user.subcategory.feature')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="subcategory_indx"
                                                               value="{{$subcategory->indx}}">
                                                        <select name="feature" id="" class="form-control-sm text-white
                                                              @if($subcategory->is_feature == 1)
                                                              bg-success
                                                              @elseif ($subcategory->is_feature == 0)
                                                              bg-danger
                                                              @endif
                                                            "
                                                                onchange="document.getElementById('featureForm{{$subcategory->id}}').submit();">
                                                            <option
                                                                value="1" {{$subcategory->is_feature == 1 ? 'selected' : ''}}>
                                                                Yes
                                                            </option>
                                                            <option
                                                                value="0" {{$subcategory->is_feature == 0 ? 'selected' : ''}}>
                                                                No
                                                            </option>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a class="btn btn-secondary btn-sm my-2 editbtn"
                                                       href="{{ route('user.subcategory.edit', $subcategory->id) . '?language=' . request()->input('language') }}">
                                                            <span class="btn-label">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        
                                                    </a>
                                                    <form class="deleteform d-inline-block"
                                                          action="{{ route('user.subcategory.delete') }}"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" name="indx"
                                                               value="{{ $subcategory->indx }}">
                                                        <button type="submit" class="btn btn-danger btn-sm deletebtn">
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
                <div class="card-footer">
                    <div class="row">
                        <div class="d-inline-block mx-auto">
                            {{ $psubcategories->appends(['language' => request()->input('language')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


 
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Product Sub Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger pb-1 dis-none" id="blogErrors">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <ul></ul>
                    </div>
                    <form id="blogForm" class="modal-form" action="{{ route('user.subcategory.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                       
                        <div class="form-group">
                            <label for="">Categories **</label>
                            <select name="category_id" class="form-control categoryData">
                                <option value="" selected disabled>Select a Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->indx }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <p id="errcategory_id" class="mb-0 text-danger em"></p>
                        </div>
                         @foreach ($languages as $language)
                        <div class="form-group">
                            <label for="">Name({{ $language->code }}) **</label>
                            <input type="text" class="form-control" name="{{ $language->code }}_name" value="" placeholder="Enter name">
                            <p id="errname" class="mb-0 text-danger em"></p>
                        </div>
                        @endforeach
                        <div class="form-group">
                            <label for="">Status **</label>
                            <select class="form-control ltr" name="status">
                                <option value="" selected disabled>Select a status</option>
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                            <p id="errstatus" class="mb-0 text-danger em"></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="blogForm" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

@endsection
