<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<title>{{$bs->website_title}} - {{__('Admin')}}</title>
	<link rel="icon" href="{{asset('assets/front/img/'.$bs->favicon)}}">
	@includeif('admin.partials.styles')
    @php
        $selLang = App\Models\Language::where('code', request()->input('language'))->first();
    @endphp
    @if (!empty($selLang) && $selLang->rtl == 1)
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
            #editModal form input,
            #editModal form textarea,
            #editModal form select {
                direction: rtl;
            }
            #editModal form .note-editor.note-frame .note-editing-area .note-editable {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endif

    @yield('styles')

</head>
<body @if(request()->cookie('admin-theme') == 'dark') data-background-color="dark" @endif>
	<div class="wrapper">

 
    @includeif('admin.partials.top-navbar')
 
    @includeif('admin.partials.side-navbar')

		<div class="main-panel">
        <div class="content">
            <div class="page-inner">
            @yield('content')
            </div>
        </div>
            @includeif('admin.partials.footer')
		</div>

	</div>
    
	@includeif('admin.partials.scripts')

 
    <div class="request-loader">
        <img src="{{asset('assets/admin/img/loader.gif')}}" alt="">
    </div>
    
</body>
</html>
