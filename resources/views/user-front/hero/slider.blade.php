@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

<div class="banner-slide">
    @if($sliders->count() > 0)
    @foreach ($sliders as $slider)
        <div class="banner-area bg_cover d-flex align-items-center lazy"
             data-bg="{{ Uploader::getImageUrl(Constant::WEBSITE_SLIDER_BACKGROUND_IMAGES,$slider->bg_image,$userBs)  }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-7">
                        <div class="banner-content">
                            <h1 data-animation="fadeInUp" data-delay="1s" class="title"
                                style="color: #{{$slider->title_color}}; font-size: {{$slider->title_font_size}}px;">{{convertUtf8($slider->title)}}</h1>
                            <p data-animation="fadeInUp" data-delay="1.3s"
                               style="color: #{{$slider->text_color}}; font-size: {{$slider->text_font_size}}px;">{{convertUtf8($slider->text)}}</p>
                            <ul data-animation="fadeInUp" data-delay="1.6s">
                                @if($slider->button_text && $slider->button_url)
                                    <li>
                                        <a style="color:#{{$slider->button_color}};border: 2px solid #{{$slider->button_color}};font-size: {{$slider->button_text_font_size}}px;"
                                           class="main-btn"
                                           href="{{$slider->button_url}}">
                                            {{convertUtf8($slider->button_text)}}
                                        </a>
                                    </li>
                                @endif
                                @if($slider->button_text1 && $slider->button_url1)
                                    <li>
                                        <a class="main-btn main-btn-2" href="{{$slider->button_url1}}"
                                           style="font-size: {{$slider->button_text1_font_size}}px;">{{convertUtf8($slider->button_text1)}}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @if($slider->image)
                <div class="banner-thumb d-none d-md-block">
                    <img class="lazy"
                         data-src="{{Uploader::getImageUrl(Constant::WEBSITE_SLIDER_IMAGES,$slider->image,$userBs) }}"
                         alt="banner">
                </div>
            @endif
        </div>
    @endforeach
    @else
    <div class="banner-area bg_cover d-flex align-items-center" style="background-image:url({{ asset('assets/restaurant/images/hero-banner-bg.jpg') }})">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-7">
                        <div class="banner-content">
                            <h1 data-animation="fadeInUp" data-delay="1s" class="title"
                                style="color: #fff; font-size: 59px;">Mexican Chicken Cheese Toaster Pizza</h1>
                            <p data-animation="fadeInUp" data-delay="1.3s"
                               style="color: #fff; font-size: 19px;">Nunc molestie mi nunc, nec accumsan libero dignissim sit amet. Fusce sit amet tincidunt metus. Nunc eu risus sus-cipit massa dapibu.</p>
                            <ul data-animation="fadeInUp" data-delay="1.6s">
                                
                                    <li>
                                        <a style="color:#fff;border: 2px solid #fff;font-size: 15px;"
                                           class="main-btn"
                                           href="#">
                                            View Details
                                        </a>
                                    </li>
                              
                               
                                    <li>
                                        <a class="main-btn main-btn-2" href="#"
                                           style="font-size: 15px;">Book A Table
                                        </a>
                                    </li>
                               
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
         
                <div class="banner-thumb  d-md-block">
                    <img class="lazy"
                         data-src="{{asset('assets/restaurant/images/demoBurger.png') }}"
                         alt="banner">
                </div>
          
        </div>
    
    
    @endif
</div>
