@php
  use App\Constants\Constant;
  use App\Http\Helpers\Uploader;
  use Illuminate\Support\Facades\Auth;

@endphp

<header class="header-area">
    <div class="navigation">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 text-center">
            <div class="support-bar">
              <div class="row">
                <div class="col-xl-6 d-none d-xl-block">
                  <div class="infos">
                    @if (!empty($userBs->support_email))
                      <span>
                        <i class="fas fa-envelope-open-text"></i>
                        {{ convertUtf8($userBs->support_email) }}
                      </span>
                    @endif
                    @if (!empty($userBs->support_phone))
                      <span>
                        <i class="fas fa-phone-alt"></i>
                        {{ convertUtf8($userBs->support_phone) }}
                      </span>
                    @endif
                  </div>
                </div>
                <div class="col-lg-12 col-xl-6 col-12">
                  <div class="links">
                    @if (!empty($socialMediaInfos) && $socialMediaInfos->count() > 0)
                      <ul class="social-links">
                        @foreach ($socialMediaInfos as $social)
                          <li><a href="{{ $social->url }}" target="_blank"><i class="{{ $social->icon }}"></i></a>
                          </li>
                        @endforeach
                      </ul>
                    @endif

                    @if (!empty($allLanguageInfos))
                      <div class="language">
                        <a class="language-btn" href="#"><i class="fas fa-globe-asia"></i>
                          {{ convertUtf8($userCurrentLang->name) }}</a>
                        <ul class="language-dropdown">
                          @foreach ($allLanguageInfos as $key => $lang)
                            <li>
                              <a href='{{ route('user.front.change.language', [getParam(), $lang->code]) }}'>
                                {{ convertUtf8($lang->name) }}
                              </a>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                    @endif

                    @if (!Auth::guard('client')->check())
                      @if (!empty($packagePermissions) && in_array('Online Order', $packagePermissions))
                        <ul class="login">
                          <li>
                            <a
                              href="{{ route('user.client.login', getParam()) }}">{{ $keywords['Login'] ?? __('Login') }}</a>
                          </li>
                        </ul>
                      @endif
                    @else
                    @if (!empty($packagePermissions) && in_array('Online Order', $packagePermissions))
                      <ul class="login">
                        <li>
                          <a
                            href="{{ route('user.client.dashboard', getParam()) }}">{{ $keywords['Dashboard'] ?? __('Dashboard') }}</a>
                        </li>
                      </ul>
                    @endif
                    @endif
                    @if (!empty($packagePermissions) && in_array('Online Order', $packagePermissions))
                      <div id="cartQuantity" class="cart">
                        <a href="{{ route('user.front.cart', getParam()) }}">
                          <i class="fas fa-cart-plus"></i>
                          @php
                            $itemsCount = 0;
                            $cart = session()->get(getUser()->username.'_cart');
                            if (!empty($cart)) {
                                foreach ($cart as $p) {
                                    $itemsCount += $p['qty'];
                                }
                            }
                          @endphp
                          <span class="cart-quantity">{{ $itemsCount }}</span>
                        </a>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <nav class="navbar navbar-expand-lg">
              @if ($userBs->logo)
                <a class="navbar-brand" href="{{ route('user.front.index', getParam()) }}">
                  <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_LOGO, $userBs->logo, $userBs) }}"
                    alt="Logo">
                </a>
                @else
                <a class="navbar-brand" href="{{ route('user.front.index', getParam()) }}">
                  <img src="{{ asset('assets/restaurant/images/logo.png') }}"
                    alt="Logo">
                </a>
              @endif


              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarFive"
                aria-controls="navbarFive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse sub-menu-bar" id="navbarFive">
                <ul class="navbar-nav m-xl-auto mr-auto">
                  @php
                    $links = json_decode($userMenus, true);
                  @endphp

                  @foreach ($links as $link)
                    @php
                      $href = getUserHref($link, $userCurrentLang->id);
                    @endphp

                    @if (!array_key_exists('children', $link))

                      <li class="nav-item">
                        <a class="page-scroll" href="{{ $href }}" target="{{ $link['target'] }}">
                          {{ $link['text'] }}
                        </a>
                      </li>
                    @else

                      <li class="nav-item">
                        <a class="page-scroll" href="{{ $href }}" target="{{ $link['target'] }}">
                          {{ $link['text'] }}
                          <i class="fa fa-angle-down"></i>
                        </a>

                        <ul class="sub-menu">
                          @foreach ($link['children'] as $level2)
                            @php
                              $l2Href = getUserHref($level2, $userCurrentLang->id);
                            @endphp
                            <li class="nav-item @if (array_key_exists('children', $level2)) submenus @endif">
                              <a class="page-scroll" href="{{ $l2Href }}"
                                target="{{ $level2['target'] }}">{{ $level2['text'] }}</a>


                              @php
                                if (array_key_exists('children', $level2)) {
                                    create_user_menu($level2, $userCurrentLang->id);
                                }
                              @endphp

                            </li>
                          @endforeach
                        </ul>
                      </li>
                    @endif
                  @endforeach
                  @if (!is_null($packagePermissions) && in_array('Table Reservation', $packagePermissions) && $userBs->is_quote)
                    <li class="nav-item d-block d-sm-none">
                      <a class="page-scroll" href="{{ route('user.front.reservation', getParam()) }}">
                        {{ $keywords['Reservation'] ?? __('Reservation') }}
                      </a>
                    </li>
                  @endif

                </ul>
              </div>

              <div class="navbar-btns d-flex align-items-center">
                <div class="header-times">
                  @if (!is_null($userBs->office_time))
                    <span>
                      <i class="flaticon-time"></i> {{ $keywords['Opening Time'] ?? __('Opening Time') }}
                    </span>
                    <p>{{ $userBs->office_time }}</p>
                  @endif
                </div>
                @if (
                    !is_null($packagePermissions) &&
                        in_array('Table Reservation', $packagePermissions) &&
                        $userBs->is_quote)
                  <a class="main-btn main-btn-2 d-none d-sm-inline-block"
                    href="{{ route('user.front.reservation', getParam()) }}">
                    {{ $keywords['Reservation'] ?? __('Reservation') }}
                  </a>
                @endif
                @if (
                    !is_null($packagePermissions) &&
                        in_array('Call Waiter', $packagePermissions) &&
                        $userBs->website_call_waiter == 1)
                  <a class="main-btn main-btn d-none d-sm-inline-block text-white ml-2" data-toggle="modal"
                    data-target="#callWaiterModal">
                    {{ $keywords['Call Waiter'] ?? __('Call Waiter') }}
                  </a>
                @endif
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </header>
