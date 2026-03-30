@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title>{{ $bs->website_title }} - {{ __('User Dashboard') }}</title>
    <link rel="icon" href="{{ Uploader::getImageUrl(Constant::WEBSITE_FAVICON, $userBs->favicon, $userBs) }}" >

    @includeif('user.partials.styles')
    @php
        $user = getRootUser();
        $setLang = App\Models\User\Language::query()
            ->where('code', request()->input('language'))
            ->where('user_id', $user->id)
            ->first();
    @endphp
    @if (!empty($setLang) && $setLang->rtl == 1)
        <style>
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
    

</head>

<body @if (request()->cookie('user-theme') == 'dark') data-background-color="dark" @endif>
    <div class="wrapper @yield('sidebar')">

  
        @includeif('user.partials.top-navbar')

        @includeif('user.partials.side-navbar')

        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>
            @includeif('user.partials.footer')
        </div>

    </div>
    @includeif('user.partials.scripts')
  
    <div class="request-loader">
        <img src="{{ asset('assets/admin/img/loader.gif') }}" alt="">
    </div>
 
</body>

</html>
