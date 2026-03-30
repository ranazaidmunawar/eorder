@php
    use App\Models\Package;
@endphp
@extends('front.layout')

@section('pagename')
    - {{ __('Pricing') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->pricing_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->pricing_meta_keywords : '')

@section('breadcrumb-title')
    {{ __('Pricing') }}
@endsection
@section('breadcrumb-link')
    {{ __('Pricing') }}
@endsection

@section('content')

    <section class="pricing-area pt-120 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="nav-tabs-navigation text-center" data-aos="fade-up">
                        <ul class="nav nav-tabs">
                            @if (count($terms) > 1)
                                @foreach ($terms as $term)
                                    <li class="nav-item">
                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                                            data-bs-target="#{{ __("$term") }}" type="button">
                                            @if ($term == 'Month')
                                                {{ __("$term" . 'ly') }}
                                            @endif
                                            @if ($term == 'Year')
                                                {{ __("$term" . 'ly') }}
                                            @endif
                                            @if ($term == 'Lifetime')
                                                {{ __("$term") }}
                                            @endif
                                        </button>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                     <div class="tab-content">
                            @foreach ($terms as $term)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="{{ __("$term") }}">
                                    @php
                                        $packages = Package::query()
                                            ->where('status', '1')
                                            ->where('featured', '1')
                                            ->where('term', strtolower($term))
                                            ->get();
                                    @endphp
                                    <div class="row justify-content-center">
                                        @foreach ($packages as $package)
                                            @php
                                                $pFeatures = json_decode($package->features);
                                            @endphp
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card mb-30 {{ $package->recommended == '1' ? 'active' : '' }}"
                                                    data-aos="fade-up" data-aos-delay="100">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon"><i class="{{ $package->icon }}"></i></div>
                                                        <div class="label">
                                                            <h3>{{ __($package->title) }}</h3>
                                                            @if ($package->recommended)
                                                                <span>{{ __('Recommended') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <p class="text"></p>
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="price">{{ $package->price != 0 && $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ $package->price == 0 ? 'Free' : $package->price }}{{ $package->price != 0 && $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                                        @php
                                                            $termname = ucfirst($package->term);
                                                        @endphp
                                                        <span class="period">/ {{ __("$termname") }} </span>
                                                    </div>
                                                    <h5>{{ __('Whats Included') }}</h5>
                                                   
                                                    <ul class="pricing-list list-unstyled p-0">
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ __('Categories') }}
                                                            {{ $package->categories_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->categories_limit . ')' }}
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ __('Subcategories') }}
                                                            {{ $package->subcategories_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->subcategories_limit . ')' }}
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ __('Items') }}
                                                            {{ $package->items_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->items_limit . ')' }}
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ __('Languages') }}
                                                            {{ $package->language_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->language_limit . ')' }}
                                                        </li>
                                                        @if (is_array($pFeatures) && in_array('Storage Limit', $pFeatures))
                                                            <li>
                                                                <i class=" fal fa-check"></i>
                                                                {{ __('Storage Limit') }}
                                                                @if ($package->storage_limit == 999999)
                                                                    {{ '(' . __('Unlimited') . ')' }}
                                                                @elseif ($package->storage_limit == 0 || $package->storage_limit == 999999)
                                                                    {{ __("$feature") }}
                                                                @elseif($package->storage_limit < 1024)
                                                                    {{ '(' . $package->storage_limit . 'MB )' }}
                                                                @else
                                                                    {{ '(' . ceil($package->storage_limit / 1024) . 'GB)' }}
                                                                @endif
                                                            </li>
                                                        @endif

                                                        @if (is_array($pFeatures) && in_array('Amazon AWS s3', $pFeatures))
                                                            <li>
                                                                <i class=" fal fa-check"></i>
                                                                {{ __('Amazon AWS s3') }}
                                                            </li>
                                                        @endif

                                                        @foreach ($allPfeatures as $feature)
                                                            <li
                                                                class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? '' : 'disabled' }}">
                                                                <i
                                                                    class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? 'fal fa-check' : 'fal fa-times' }}"></i>
                                                                @if ($feature == 'Staffs')
                                                                    {{ __("$feature") }}
                                                                    @if( is_array($pFeatures) && in_array($feature, $pFeatures))
                                                                    {{$package->staff_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->staff_limit . ')' }}
                                                                    @endif
                                                                @elseif($feature == 'Table Reservation')
                                                                    {{ __("$feature") . 's' }}
                                                                    {{ $package->table_reservation_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->table_reservation_limit . ')' }}
                                                                @elseif($feature == 'Online Order')
                                                                    {{ __("$feature") }}
                                                                @elseif($feature == 'Live Orders')
                                                                    {{ __('Realtime Order Refresh & Notification') }}
                                                                @else
                                                                    {{ __("$feature") }}
                                                                @endif
                                                            </li>
                                                            @if ($feature == 'Online Order')
                                                                 <li
                                                                class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? '' : 'disabled' }}">
                                                                <i
                                                                    class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? 'fal fa-check' : 'fal fa-times' }}">
                                                                </i>
                                                                     {{ __("Orders") }}
                                                                     @if( is_array($pFeatures) && in_array($feature, $pFeatures))
                                                                    {{ $package->order_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->order_limit . ')' }}
                                                                    @endif
                                                                     
                                                               </li>  
                                                            @endif
                                                        @endforeach

                                                    </ul>
                                                    <div class="d-flex align-items-center">
                                                        @if ($package->is_trial === '1' && $package->price != 0)
                                                            <a href="{{ route('front.register.view', ['status' => 'trial', 'id' => $package->id]) }}"
                                                                class="btn secondary-btn">{{ __('Trial') }}</a>
                                                        @endif
                                                        @if ($package->price == 0)
                                                            <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $package->id]) }}"
                                                                class="btn primary-btn">{{ __('Signup') }}</a>
                                                        @else
                                                            <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $package->id]) }}"
                                                                class="btn primary-btn">{{ __('Purchase') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>
    </section>
   
@endsection
