@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp
<style>

    .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: white!important;
    opacity: 0.4;
    z-index: -1;
}
</style>

<section class="">
    <div class="overlay"></div>

<!-- Main Slider -->
<div id="mainSlider" class="carousel slide main-slider" data-bs-ride="carousel">
    <!-- <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="0" class="active" aria-current="true"
            aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
    </div> -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ $userBe->hero_bg ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->hero_bg, $userBs) : '' }}" class="d-block w-100" alt="Special Offer 1">
        </div>
        <!-- <div class="carousel-item">
            <img src="{{ asset('http://127.0.0.1:8000/assets/tenant/image/450db601a3dcfef2404a1ecb147b919bf8706731.png') }}" class="d-block w-100" alt="Special Offer 2">
        </div> -->
    </div>

    <!-- <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button> -->
</div>
