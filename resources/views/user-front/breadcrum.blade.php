  @php
      use App\Constants\Constant;
      use App\Http\Helpers\Uploader;
  @endphp
  <section class="page-title-area d-flex align-items-center"
      style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="page-title-item text-center">

                      <h2 class="title">{{ $keywords[$title] ?? $title }}</h2>
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('user.front.index', getParam()) }}"><i
                                          class="flaticon-home"></i>{{ $keywords['Home'] ?? __('Home') }}</a>
                              </li>
                              @if ($title)
                                  <li class="breadcrumb-item active" aria-current="page">
                                      {{ $keywords[$title] ?? __($title) }}
                                  </li>
                              @endif
                          </ol>
                      </nav>
                  </div>
              </div>
          </div>
      </div>
  </section>
