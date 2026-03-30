    <!-- Create Feature Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Intro Point</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ajaxForm" class="modal-form" action="{{ route('user.intro.point.store') }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Language **</label>
                            <select name="user_language_id" class="form-control">
                                <option value="" selected disabled>Select a language</option>
                                @foreach ($userLangs as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                            <p id="erruser_language_id" class="mb-0 text-danger em"></p>
                        </div>
                        @if ($activeTheme == 'seabbq' || $activeTheme == 'desifoodie' || $activeTheme == 'desices')
                            <div class="form-group">
                                <div class="mb-2">
                                    <label for="image"><strong>Image **</strong></label>
                                </div>
                                <div class="showImage mb-3">
                                    <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="..."
                                        class="img-thumbnail">
                                </div>
                                <input type="file" name="image" id="image" class="form-control">
                                <p id="errimage" class="mb-0 text-danger em"></p>
                            </div>
                            @if ($activeTheme != 'desifoodie' && $activeTheme != 'desices')
                                <div class="form-group">
                                    <label for="">Background Color</label>
                                    <input class="form-control jscolor" name="background_color"
                                        placeholder="Enter color">
                                    <p id="errbackground_color" class="mb-0 text-danger em"></p>
                                </div>
                            @endif
                        @endif
                        @if (
                            $activeTheme == 'fastfood' ||
                                $activeTheme == 'pizza' ||
                                $activeTheme == 'grocery' ||
                                $activeTheme == 'medicine' ||
                                $activeTheme == 'bakery')

                            {{-- //Icon Picker --}}

                            <div class="form-group">
                                <label for="">{{ __('Icon') }} **</label>
                                <div class="btn-group d-block">
                                    <button type="button" class="btn btn-primary iconpicker-component"><i
                                            class="fa fa-fw fa-heart"></i></button>
                                    <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                        data-selected="fa-car" data-toggle="dropdown">
                                    </button>
                                    <div class="dropdown-menu"></div>
                                </div>
                                <input id="inputIcon" type="hidden" name="icon" value="fas fa-heart">
                                @if ($errors->has('icon'))
                                    <p class="mb-0 text-danger">{{ $errors->first('icon') }}</p>
                                @endif
                                <div class="mt-2">
                                    <small>{{ __('NB: click on the dropdown sign to select a icon.') }}</small>
                                </div>
                                <p id="erricon" class="mb-0 text-danger em"></p>
                            </div>


                        @endif
                        <div class="form-group">
                            <label for="">Title **</label>
                            <input class="form-control" name="title" placeholder="Enter Title" required>
                            <p id="errtitle" class="mb-0 text-danger em"></p>
                        </div>
                        @if (
                            $activeTheme == 'fastfood' ||
                                $activeTheme == 'pizza' ||
                                $activeTheme == 'grocery' ||
                                $activeTheme == 'medicine' ||
                                $activeTheme == 'seabbq' ||
                                $activeTheme == 'desices' ||
                                $activeTheme == 'bakery')
                            <div class="form-group">
                                <label for="">Text**</label>
                                <input class="form-control" name="text" placeholder="Enter Text">
                                <p id="errtext" class="mb-0 text-danger em"></p>
                            </div>
                        @endif

                        @if ($activeTheme == 'coffee' || $activeTheme == 'medicine' || $activeTheme == 'beverage')
                            <div class="form-group">
                                <label for="">Rating Point</label>
                                <input class="form-control" type="number" name="intro_section_rating_point"
                                    placeholder="Enter Rating Point">
                                <p id="errintro_section_rating_point" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group">
                                <label for="">Rating Symbol</label>
                                <input class="form-control" name="intro_section_rating_symbol"
                                    placeholder="Enter Rating Symbol">
                                <p id="errintro_section_rating_symbol" class="mb-0 text-danger em"></p>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="">Serial Number **</label>
                            <input type="number" class="form-control ltr" name="serial_number" value=""
                                placeholder="Enter Serial Number">
                            <p id="errserial_number" class="mb-0 text-danger em"></p>
                            <p class="text-warning"><small>The higher the serial number is, the later the intro point
                                    will be
                                    shown.</small></p>
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
