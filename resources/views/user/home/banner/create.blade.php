    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="bannerModalTitle">Add Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="ajaxForm" method="POST" enctype="multipart/form-data"
                        action="{{ route('user.banner.store') }}">
                        @csrf
                        <input type="hidden" name="banner_id" id="banner_id">

                        <div class="form-group">
                            <label>Language **</label>
                            <select name="user_language_id" id="user_language_id" class="form-control">
                                <option value="" selected disabled>Select a language</option>
                                @foreach ($userLangs as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                            <p id="erruser_language_id" class="mb-0 text-danger em"></p>
                        </div>

                        <div class="form-group">
                            <label for="image"><strong>Banner Image **</strong></label>
                            <br>
                            <div class="showImage mb-3">
                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="..."
                                    class="img-thumbnail" id="previewImage">
                            </div>
                            <input type="file" name="image" id="image" class="form-control image">
                            <p id="errimage" class="mb-0 text-danger em"></p>
                        </div>

                        <div class="form-group">
                            <label>Title **</label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter title">
                            <p id="errtitle" class="mb-0 text-danger em"></p>
                        </div>

                        <div class="form-group">
                            <label>Subtitle **</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control"
                                placeholder="Enter subtitle">
                            <p id="errsubtitle" class="mb-0 text-danger em"></p>
                        </div>

                        @if ($activeTheme == 'desifoodie' || $activeTheme == 'desices')
                            <input type="hidden" name="position" value="left">
                            <div class="form-group">
                                <label>Text **</label>
                                <textarea name="text" rows="4" class="form-control"></textarea>
                                <p id="errtext" class="mb-0 text-danger em"></p>
                            </div>
                        @endif


                        <div class="form-group">
                            <label>Button Name **</label>
                            <input type="text" name="button_text" id="button_text" class="form-control"
                                placeholder="Enter button_text">
                            <p id="errbutton_text" class="mb-0 text-danger em"></p>
                        </div>

                        <div class="form-group">
                            <label>Button Url **</label>
                            <input type="text" name="button_url" id="button_url" class="form-control"
                                placeholder="Enter button_url">
                            <p id="errbutton_url" class="mb-0 text-danger em"></p>
                        </div>


                        @if ($activeTheme == 'seabbq' || $activeTheme == 'desices')
                            <div class="form-group">
                                <label>Position **</label>
                                <select name="position" class="form-control">
                                    <option disabled selected>Select a position</option>
                                    @if ($showLeft)
                                        <option value="Left">Left</option>
                                    @endif

                                    @if ($showRight)
                                        <option value="Right">Right</option>
                                    @endif
                                </select>
                                <p id="errposition" class="mb-0 text-danger em"></p>
                            </div>
                        @endif


                        <div class="form-group">
                            <label>Status **</label>
                            <select name="status" class="form-control">
                                <option disabled selected>Select a status</option>
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
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
