    @php
        use App\Constants\Constant;
        use App\Http\Helpers\Uploader;
        use Illuminate\Support\Facades\Auth;

    @endphp
    <footer class="footer-10 pt-60 bg-cover bg-img"
        data-bg-image="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->footer_bottom_img, $userBs) }}">
        @if ($userBs->top_footer_section == 1)
            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6">
                            <div class="footer-widget mb-30" data-aos="fade-up" data-aos-delay="100">
                                <!-- logo -->
                                <div class="footer-logo mb-20">
                                    <a lass="navbar-brand" href="{{ route('user.front.index', getParam()) }}"
                                        target="_self" title="Link">
                                        <img class="blur-up lazyload"
                                            data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->footer_logo, $userBs) }}"
                                            alt="Logo">
                                    </a>
                                </div>
                                <p class="fw-medium mb-40">{{ convertUtf8($userBs->footer_text) }}</p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-6 col-sm-6">
                            <!-- footer-widget -->
                            <div class="footer-widget mb-30" data-aos="fade-up" data-aos-delay="150">
                                <h5 class="mb-24 fw-medium body-font">
                                    {{ $keywords['Useful_Links'] ?? 'Useful Links' }}</h5>
                                <div class="footer-widget-item">
                                    <ul class="reset-ul">
                                        @php
                                            $ulinks = App\Models\User\Ulink::query()
                                                ->where('language_id', $userCurrentLang->id)
                                                ->where('user_id', $user->id)
                                                ->orderby('id', 'desc')
                                                ->get();
                                        @endphp

                                        @foreach ($ulinks as $ulink)
                                            <li>
                                                <a class="mb-2 fw-medium" href="{{ $ulink->url }}" target="_self"
                                                    title="{{ convertUtf8($ulink->name) }}">{{ convertUtf8($ulink->name) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-sm-6">
                            <!-- footer-widget -->
                            <div class="footer-widget mb-30" data-aos="fade-up" data-aos-delay="250">
                                <h5 class="mb-24 fw-medium body-font">{{ $keywords['Contact_Us'] ?? 'Contact Us' }}
                                </h5>
                                <div class="footer-widget-item2">
                                    <ul class="reset-ul info-list">
                                        @if (!is_null($userBs->contact_address))
                                            <li class="mb-10">
                                                <i class="fa-solid fa-location-dot"></i>
                                                <span class="location">{{ $userBs->contact_address }}</span>
                                            </li>
                                        @endif
                                        @if (!is_null($userBs->contact_number))
                                            @php
                                                $numbers = explode(',', $userBs->contact_number);
                                            @endphp
                                            @if ($numbers)
                                                <li class="mb-10">
                                                    <i class="fa-solid fa-headphones"></i>
                                                    <div class="phone-numbers">
                                                        @foreach ($numbers as $number)
                                                            <a href="tel:{{ $number }}">{{ $number }}</a>
                                                        @endforeach
                                                    </div>
                                                </li>
                                            @endif
                                        @endif
                                        @if (!is_null($userBs->contact_address))
                                            @php
                                                $mails = explode(',', $userBs->contact_mails);
                                            @endphp
                                            @if ($mails)
                                                <li class="mb-10">
                                                    <i class="fal fa-envelope"></i>
                                                    <div class="mail-address">
                                                        @foreach ($mails as $mail)
                                                            <a
                                                                href="mailto:{{ $mail }}">{{ $mail }}</a>
                                                        @endforeach
                                                    </div>
                                                </li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-sm-12">
                            <!-- footer-widget -->
                            <div class="footer-widget mb-30" data-aos="fade-up" data-aos-delay="300">
                                <h5 class="mb-24 fw-medium body-font">
                                    {{ $keywords['Subscribe_Here'] ??  'Subscribe Here' }}</h5>
                                <p class="fw-medium mb-20">{{ $keywords['Stay_update_with_us_and_get_offer!'] ?? 'Stay update with us and get offer!' }}</p>
                                <div class="footer-subscribe-widget mb-24">
                                    <form id="footerSubscribe" action="{{ route('front.subscribe') }}" method="post"
                                        class="subscribeForm">
                                        @csrf
                                        <div class="subscribe-group-btn subscribe">
                                            <input type="email" name="email" placeholder="{{ $keywords['Enter_Your_Email'] ?? 'Enter Your Email' }}" required
                                                autocomplete="off">
                                            <button class="subscribe-btn text-uppercase"
                                                type="submit">{{ $keywords['Subscribe'] ?? __('Subscribe') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="socials">
                                    @foreach ($socialMediaInfos as $social_link)
                                        <a target="_blank" href="{{ $social_link->url }}"><i
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
            <div class="footer-copyright border-top pt-30 pb-30 ">
                <!-- footer-copyright -->
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="copyright-content">
                                <div class="fw-medium small text-center mb-0">
                                    {!! nl2br(replaceBaseUrl(convertUtf8($userBs->copyright_text))) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </footer>
