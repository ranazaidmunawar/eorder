  <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form id="ajaxEditForm" class="modal-form" action="{{route('user.change.customer.password')}}" method="POST">
          <input type="hidden" id="inid" name="id" value="">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                           <label for=""> New Password **</label>
                           <input type="password" class="form-control" name="password" placeholder="Enter password" value="">
                           <p id="eerrpassword" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                           <label for="">New Confirmation Password **</label>
                           <input type="password" class="form-control" name="password_confirmation" placeholder="Enter password again" value="">
                           <p id="eerrpassword_confirmation" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                </div>
             </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="updateBtn" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
