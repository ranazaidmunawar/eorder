@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Ulink;
    use App\Models\User\Table;
    use Illuminate\Support\Facades\Auth;

@endphp
@if ($userBs->top_footer_section == 1)
    <footer class="footer-area footer-area-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-widget-1">
                        <div class="header-times d-none d-md-inline-block">
                            @if (!is_null($userBs->office_time))
                                <i class="flaticon-time"></i>
                                <h5>{{ $keywords['Opening Time'] ?? __('Opening Time') }}</h5>
                                <span>{{ convertUtf8($userBs->office_time) }}</span>
                            @endif
                        </div>
                        <p>{{ convertUtf8($userBs->footer_text) }}</p>


                        <ul>
                            @foreach ($socialMediaInfos as $social_link)
                                <li>
                                    <a href="{{ $social_link->url }}" target="_blank">
                                        <i class="{{ $social_link->icon }}"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 order-3 order-lg-2">
                    <div class="footer-widget-2 text-left text-sm-center">
                        @if ($userBs->footer_logo)
                            <a href="{{ route('user.front.index', getParam()) }}">
                                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->footer_logo, $userBs) }}"
                                    alt="logo">
                            </a>
                        @endif
                        <ul class="pt-25">
                            @php
                                $blinks = Ulink::query()
                                    ->where('language_id', $userCurrentLang->id)
                                    ->where('user_id', $user->id)
                                    ->orderby('id', 'desc')
                                    ->get();
                            @endphp
                            @foreach ($blinks as $blink)
                                <li><a href="{{ $blink->url }}" target="_blank">{{ convertUtf8($blink->name) }}</a>
                                </li>
                            @endforeach
                        </ul>
                        @if (!empty($userBe->footer_bottom_img))
                            <a class="pt-30" href="javascript:void(0);">
                                <img class="lazy"
                                    data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->footer_bottom_img, $userBs) }}"
                                    alt="">
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 order-2 order-lg-3">
                    <h3 class="subscribe-title">{{ $keywords['Subscribe_Here'] ??  'Subscribe Here' }}</h3>
                    <form id="footerSubscribe" action="{{ route('user.front.subscribe', getParam()) }}" method="post"
                        class="subscribe-form subscribeForm">
                        @csrf
                        <div class="subscribe-inputs">
                            <input name="email" type="text"
                                placeholder="{{ $keywords['Enter Your Email'] ?? __('Enter Your Email') }}">
                            <button type="submit"><i class="far fa-paper-plane"></i></button>
                        </div>
                        <p id="erremail" class="text-danger mb-0 err-email"></p>
                    </form>
                    <div class="footer-widget-3">
                        <ul>
                            @php
                                $ulinks = Ulink::query()
                                    ->where('language_id', $userCurrentLang->id)
                                    ->where('user_id', $user->id)
                                    ->orderby('id', 'desc')
                                    ->get();
                            @endphp

                            @foreach ($ulinks as $ulink)
                                <li><a href="{{ $ulink->url }}" target="_blank">+
                                        {{ convertUtf8($ulink->name) }}</a></li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </footer>
@endif
@if ($userBs->copyright_section == 1)
    <div class="footer-copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-copyright d-block justify-content-center d-md-flex">
                        <div class="tinymce-content">
                            {!! $userBs->copyright_text !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
