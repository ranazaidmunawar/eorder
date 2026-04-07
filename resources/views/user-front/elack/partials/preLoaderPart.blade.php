@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp

@if ($userBs->preloader_status == 1)
    <div id="preLoader">
        <div class="loader">
            <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRELOADER, $userBs->preloader, $userBs)}}" alt="Preloader">
        </div>
    </div>
@endif
