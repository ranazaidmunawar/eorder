@extends('user.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-iconpicker.min.css') }}">
@endsection

@includeIf('user.partials.rtl-style')

@section('content')
    <div class="page-header">
        <h4 class="page-title">Drag & Drop Menu Builder</h4>
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
                <a href="#">Menu Builder</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">Menu Builder</div>
                        </div>
                        <div class="col-lg-2">
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
                    </div>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card border-primary mb-3">
                                <div class="card-header bg-primary text-white">Choose from Ready made Menus</div>
                                <div class="card-body">
                                    <ul class="list-group">

                                        <li class="list-group-item">{{ $keywords['Home'] ?? __('Home') }}
                                            <a data-text="{{ $keywords['Home'] ?? __('Home') }}" data-type="home"
                                                class="addToMenus btn btn-primary btn-sm float-right" href="">Add to
                                                Menus
                                            </a>
                                        </li>
                                        <li class="list-group-item"> {{ $keywords['Menu'] ?? __('Menu') }}
                                            <a data-text="{{ $keywords['Menu'] ?? __('Menu') }}" data-type="menu"
                                                class="addToMenus btn btn-primary btn-sm float-right" href="">Add to
                                                Menus
                                            </a>
                                        </li>

                                        <li class="list-group-item">{{ $keywords['Items'] ?? __('Items') }} <a
                                                data-text="{{ $keywords['Items'] ?? __('Items') }}" data-type="items"
                                                class="addToMenus btn btn-primary btn-sm float-right" href="">Add to
                                                Menus</a></li>
                                        @if (!is_null($packagePermissions) && in_array('Online Order', $packagePermissions))
                                            <li class="list-group-item">
                                                {{ $keywords['Cart'] ?? __('Cart') }}
                                                <a data-text="{{ $keywords['Cart'] ?? __('Cart') }}" data-type="cart"
                                                    class="addToMenus btn btn-primary btn-sm float-right" href="">
                                                    Add to Menus
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                {{ $keywords['Checkout'] ?? __('Checkout') }}
                                                <a data-text="{{ $keywords['Checkout'] ?? __('Checkout') }}"
                                                    data-type="checkout"
                                                    class="addToMenus btn btn-primary btn-sm float-right" href="">
                                                    Add to Menus
                                                </a>
                                            </li>
                                        @endif

                                        <li class="list-group-item">{{ $keywords['Career'] ?? __('Career') }}
                                            <a data-text="{{ $keywords['Career'] ?? __('Career') }}" data-type="career"
                                                class="addToMenus btn btn-primary btn-sm float-right" href="">Add to
                                                Menus
                                            </a>
                                        </li>
                                        <li class="list-group-item">{{ $keywords['Team Members'] ?? __('Team Members') }}
                                            <a data-text="{{ $keywords['Team Members'] ?? __('Team Members') }}"
                                                data-type="team" class="addToMenus btn btn-primary btn-sm float-right"
                                                href="">Add to Menus
                                            </a>
                                        </li>
                                        <li class="list-group-item">{{ $keywords['Gallery'] ?? __('Gallery') }}
                                            <a data-text="{{ $keywords['Gallery'] ?? __('Gallery') }}" data-type="gallery"
                                                class="addToMenus btn btn-primary btn-sm float-right" href="">Add to
                                                Menus
                                            </a>
                                        </li>
                                        <li class="list-group-item">{{ $keywords['FAQ'] ?? __('FAQ') }}
                                            <a data-text="{{ $keywords['FAQ'] ?? __('FAQ') }}" data-type="faq"
                                                class="addToMenus btn btn-primary btn-sm float-right" href="">Add to
                                                Menus
                                            </a>
                                        </li>

                                        @if (!is_null($packagePermissions) && in_array('Blog', $packagePermissions))
                                            <li class="list-group-item">{{ $keywords['Blog'] ?? __('Blog') }}
                                                <a data-text="{{ $keywords['Blog'] ?? __('Blog') }}" data-type="blog"
                                                    class="addToMenus btn btn-primary btn-sm float-right" href="">
                                                    Add to Menus
                                                </a>
                                            </li>
                                        @endif
                                        <li class="list-group-item">{{ $keywords['Contact'] ?? __('Contact') }}
                                            <a data-text="{{ $keywords['Contact'] ?? __('Contact') }}" data-type="contact"
                                                class="addToMenus btn btn-primary btn-sm float-right" href="">Add to
                                                Menus
                                            </a>
                                        </li>
                                        <li class="list-group-item">{{ $keywords['About Us'] ?? __('About Us') }}
                                            <a data-text="{{ $keywords['About Us'] ?? __('About Us') }}" data-type="about-us"
                                                class="addToMenus btn btn-primary btn-sm float-right" href="">Add to
                                                Menus
                                            </a>
                                        </li>

                                        @if (!is_null($packagePermissions) && in_array('Custom Page', $packagePermissions))
                                            @foreach ($pages as $page)
                                                <li class="list-group-item">
                                                    {{ $page->title }} <span
                                                        class="badge badge-primary">{{ $keywords['custom_page'] ?? __('Custom Page') }}</span>
                                                    <a data-text="{{ $page->title }}" data-type="{{ $page->page_id }}"
                                                        class="addToMenus btn btn-primary btn-sm float-right"
                                                        href="">Add to Menus</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border-primary mb-3">
                                <div class="card-header bg-primary text-white">Add / Edit Menu</div>
                                <div class="card-body">
                                    <form id="frmEdit" class="form-horizontal">
                                        <input class="item-menu" type="hidden" name="type" value="">

                                        <div id="withUrl">
                                            <div class="form-group">
                                                <label for="text">Text</label>
                                                <input type="text" class="form-control item-menu" name="text"
                                                    placeholder="Text">
                                            </div>
                                            <div class="form-group">
                                                <label for="href">URL</label>
                                                <input type="text" class="form-control item-menu" name="href"
                                                    placeholder="URL">
                                            </div>
                                            <div class="form-group">
                                                <label for="target">Target</label>
                                                <select name="target" id="target" class="form-control item-menu">
                                                    <option value="_self">Self</option>
                                                    <option value="_blank">Blank</option>
                                                    <option value="_top">Top</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="withoutUrl" class="d-none">
                                            <div class="form-group">
                                                <label for="text">Text</label>
                                                <input type="text" class="form-control item-menu" name="text"
                                                    placeholder="Text">
                                            </div>
                                            <div class="form-group">
                                                <label for="href">URL</label>
                                                <input type="text" class="form-control item-menu" name="href"
                                                    placeholder="URL">
                                            </div>
                                            <div class="form-group">
                                                <label for="target">Target</label>
                                                <select name="target" class="form-control item-menu">
                                                    <option value="_self">Self</option>
                                                    <option value="_blank">Blank</option>
                                                    <option value="_top">Top</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i
                                            class="fas fa-sync-alt"></i> Update
                                    </button>
                                    <button type="button" id="btnAdd" class="btn btn-success"><i
                                            class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">Website Menus</div>
                                <div class="card-body">
                                    <ul id="myEditor" class="sortableLists list-group">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer pt-3">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button id="btnOutput" class="btn btn-success">Update Menu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/admin/js/plugin/jquery-menu-editor/jquery-menu-editor.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('assets/admin/js/plugin/bootstrap-iconpicker/iconset/fontawesome5-3-1.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/admin/js/plugin/bootstrap-iconpicker/bootstrap-iconpicker.min.js') }}">
    </script>
    <script>
      var menuRoute = "{{ route('user.menu_builder.update') }}";
      var langId = "{{ $lang_id }}";
       var arrayjson = {!! json_encode($prevMenu) !!};

            var iconPickerOptions = {
                searchText: "Buscar...",
                labelHeader: "{0}/{1}"
            };

            var sortableListOptions = {
                placeholderCss: {
                    'background-color': "#cccccc"
                }
            };

            var editor = new MenuEditor('myEditor', {
                listOptions: sortableListOptions,
                iconPicker: iconPickerOptions,
                maxLevel: 1

            });
            editor.setForm($('#frmEdit'));
            editor.setUpdateButton($('#btnUpdate'));

            editor.setData({!! $prevMenu !!});
    </script>
     <script src="{{ asset('assets/tenant/js/menubuilder.js') }}"></script>

@endsection
