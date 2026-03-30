@php
  use App\Constants\Constant;
  use App\Http\Helpers\Uploader;
  use Illuminate\Support\Facades\Auth;

@endphp
<section class="gallery-area">
    <div class="container">
        <div class="swiper gallery-slider" data-aos="fade-up">
            <div class="swiper-wrapper">

                @foreach ($galleries as $gallery)
                    <div class="swiper-slide">
                        <a href="#" class="slider-item" title="{{ $gallery->title }}" target="_blank">
                            <div class="lazy-container ratio ratio-2-3">
                                <img class="lazyload"
                                    data-src="{{ asset('assets/front/img/gallery/' . $gallery->image) }}"
                                    alt="Image">
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
