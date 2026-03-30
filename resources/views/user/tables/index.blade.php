@extends('user.layout')

@section('content')
  <div class="page-header">
    @if(!empty($features) && in_array('Table QR Builder',$features) && in_array('QR Menu', $packagePermissions))
    <h4 class="page-title">Tables  & QR Builder</h4>
    @else
    <h4 class="page-title">Tables</h4>
    @endif
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
        @if(!empty($features) && in_array('Table QR Builder',$features) && in_array('QR Menu', $packagePermissions))
        <a href="#">Tables & QR Builder</a>
        @else
         <a href="#">Tables</a>
        @endif
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Tables</div>
                </div>
                <div class="offset-lg-4 col-lg-4 text-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">Add Table</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($tables) == 0)
                <h3 class="text-center">NO TABLE FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">Table No</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                        @if(!empty($packagePermissions) && in_array('Table QR Builder', $packagePermissions) && in_array('QR Menu', $packagePermissions))
                          <th scope="col">QR Code</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($tables as $key => $table)
                        <tr>
                          <td>{{$table->table_no}}</td>
                          <td>
                            @if ($table->status == 0)
                                <span class="badge badge-danger">Deactive</span>
                            @elseif ($table->status == 1)
                                <span class="badge badge-success">Active</span>
                            @endif
                          </td>
                          <td>
                            <a class="btn btn-secondary btn-sm editbtn my-2" href="#editModal" data-toggle="modal" data-table_id="{{$table->id}}" data-table_no="{{$table->table_no}}" data-status="{{$table->status}}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              
                            </a>
                            <form class="deleteform d-inline-block" action="{{route('user.table.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="table_id" value="{{$table->id}}">
                              <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                                
                              </button>
                            </form>
                          </td>
                          @if(!empty($packagePermissions) && in_array('Table QR Builder', $packagePermissions))
                              <td>
                                    <a class="btn btn-info btn-sm editbtn" href="{{route('user.table.qr.builder', $table->id)}}">
                                        <span class="btn-label">
                                          <i class="fas fa-edit"></i>
                                        </span>
                                        Generate
                                    </a>
                              </td>
                          @endif
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


  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Table</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form create" action="{{route('user.table.store')}}" method="POST">
            @csrf
            <div class="form-group">
              <label for="">Table No **</label>
              <input type="text" class="form-control" name="table_no" value="" placeholder="Enter table no">
              <p id="errtable_no" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
                <label for="">Status **</label>
                <select name="status" class="form-control">
                    <option value="" selected disabled>Select a Status</option>
                    <option value="0">Deactive</option>
                    <option value="1">Active</option>
                </select>
                <p id="errstatus" class="mb-0 text-danger em"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Table</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxEditForm" class="" action="{{route('user.table.update')}}" method="POST">
            @csrf
            <input id="intable_id" type="hidden" name="table_id" value="">
            <div class="form-group">
              <label for="">Table No **</label>
              <input id="intable_no" type="text" class="form-control" name="table_no" value="" placeholder="Enter table no">
              <p id="eerrtable_no" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
                <label for="">Status **</label>
                <select id="instatus" name="status" class="form-control">
                    <option value="" selected disabled>Select a Status</option>
                    <option value="0">Deactive</option>
                    <option value="1">Active</option>
                </select>
                <p id="eerrstatus" class="mb-0 text-danger em"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="updateBtn" type="button" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection
