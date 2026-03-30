  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form id="ajaxForm" class="modal-form" action="{{route('user.add.customer')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                           <label for="">Username **</label>
                           <input type="text" class="form-control" name="username" placeholder="Enter name"  autocomplete="off">
                           <p id="errusername" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                           <label for="">Email **</label>
                           <input type="email" class="form-control" name="email" placeholder="Enter email" autocomplete="off">
                           <p id="erremail" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                           <label for="">Password **</label>
                           <input type="password" class="form-control" name="password" placeholder="Enter password" autocomplete="off">
                           <p id="errpassword" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                           <label for="">Confirmation Password **</label>
                           <input type="password" class="form-control" name="password_confirmation" placeholder="Enter password again" autocomplete="off">
                           <p id="errpassword_confirmation" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                </div>
             </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
