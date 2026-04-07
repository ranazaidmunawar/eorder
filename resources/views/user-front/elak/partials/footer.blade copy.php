@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp

<div id="sticky-cart" class="bottom-cart-bar hidden" onclick="window.location.href='/cart'">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div class="d-flex flex-column text-start">
            <span class="view-cart-text">View Cart</span>
            <span class="cart-total-price">USD <span class="cart-total">0.00</span></span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="cart-icon-container position-relative">
                <span class="cart-badge-count cart-count">0</span>
                <i class="fas fa-shopping-basket fa-lg"></i>
            </div>
            <i class="fas fa-chevron-right text-white opacity-50"></i>
        </div>
    </div>
</div>


<!-- Footer-area start -->
<footer class="footer-area bg-img bg-cover"
    data-bg-image="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->footer_section_bg_image, $userBs) }}">
    @if ($userBs->top_footer_section == 1)
        <div class="overlay opacity-90"></div>
        <div class="footer-top pt-100 pb-70">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="footer-widget" data-aos="fade-up" data-aos-delay="100">
                            <div class="navbar-brand">
                                <a href="{{ route('user.front.index', getParam()) }}" target="_self" title="Link">
                                    <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->footer_logo, $userBs) }}"
                                        alt="Logo">
                                </a>
                            </div>
                            <p>{{ convertUtf8($userBs->footer_text) }}</p>

                            @if (!empty($userBe->footer_bottom_img))
                                <a class="pt-30" href="javascript:;">
                                    <img class="lazy"
                                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->footer_bottom_img, $userBs) }}"
                                        alt=""
                                        src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->footer_bottom_img, $userBs) }}">
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="footer-widget" data-aos="fade-up" data-aos-delay="200">
                            <h5>{{ $keywords['Useful_Links'] ?? 'Useful Links' }}</h5>
                            <ul class="footer-links">
                                @php
                                    $ulinks = App\Models\User\Ulink::query()
                                        ->where('language_id', $userCurrentLang->id)
                                        ->where('user_id', $user->id)
                                        ->orderby('id', 'desc')
                                        ->get();
                                @endphp

                                @foreach ($ulinks as $ulink)
                                    <li>
                                        <a href="{{ $ulink->url }}" target="_self"
                                            title="{{ convertUtf8($ulink->name) }}">{{ convertUtf8($ulink->name) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-5 col-md-6 col-sm-12">
                        <div class="footer-widget" data-aos="fade-up" data-aos-delay="400">
                            <h5>{{ $keywords['Contact_Us'] ?? 'Contact Us' }}</h5>
                            <ul class="info-list">
                                <li>
                                    <i class="fal fa-map-marker-alt"></i>
                                    <span>{{ $userBs->contact_address }}</span>
                                </li>
                                @php
                                    $numbers = explode(',', $userBs->contact_number);
                                @endphp

                                @if ($numbers)
                                    <li>
                                        <i class="fal fa-headset"></i>
                                        @foreach ($numbers as $number)
                                            <a href="tel:{{ $number }}">{{ $number }}</a>
                                        @endforeach
                                    </li>
                                @endif
                                @php
                                    $mails = explode(',', $userBs->contact_mails);
                                @endphp
                                @if ($mails)
                                    <li>

                                        <i class="fal fa-envelope"></i>
                                        @foreach ($mails as $mail)
                                            <a href="mailto:{{ $mail }}">{{ $mail }}</a>
                                        @endforeach
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-5 col-md-6 col-sm-12">
                        <div class="footer-widget" data-aos="fade-up" data-aos-delay="200">
                            <h5>{{ $keywords['Subscribe_Here'] ??  'Subscribe Here' }}</h5>
                            <p class="lh-1 mb-20">{{ __('Stay update with us and get offer!') }}</p>
                            <div class="newsletter-form">
                                <form id="footerSubscribe" action="{{ route('front.subscribe') }}" method="post"
                                    class="subscribeForm">
                                    @csrf
                                    <div class="form-group">
                                        <input class="form-control shadow-md rounded-pill"
                                            placeholder="{{ $keywords['Enter Your Email'] ?? __('Enter Your Email') }}"
                                            type="text" name="email" required="" autocomplete="off">

                                        <button class="btn btn-md btn-primary no-animation rounded-pill"
                                            type="submit">{{ $keywords['Subscribe'] ?? __('Subscribe') }}</button>
                                    </div>
                                    <p id="erremail" class="text-danger mb-0 err-email"></p>
                                </form>

                            </div>
                            <div class="social-link mt-20">
                                @foreach ($socialMediaInfos as $social_link)
                                    <a href="{{ $social_link->url }}" target="_blank"><i
                                            class="{{ $social_link->icon }}"></i></a>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($userBs->copyright_section == 1)
        <div class="copy-right-area border-top ptb-30">
            <div class="container">
                <div class="copy-right-content">
                    <span>
                        {!! nl2br(replaceBaseUrl(convertUtf8($userBs->copyright_text))) !!}
                    </span>
                </div>
            </div>
        </div>
    @endif
</footer>
<!-- Footer-area end-->
