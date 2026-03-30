@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
    $direction = 'direction:'
@endphp
@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Cart'] ?? __('Cart') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->cart_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->cart_meta_description : '')
@section('pagename')
    -
    {{ $keywords['Product'] ?? __('Product') }}
@endsection


@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/front/css/jquery-ui.min.css') }}">
@endsection


@section('content')

    @include('user-front.breadcrum', ['title' => $upageHeading?->cart_page_title])


    <section class="cart-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div id="refreshDiv">
                        @if ($cart != null)
                            <ul class="total-item-info">
                                @php
                                    $cartTotal = 0;
                                    $countitem = 0;
                                    if ($cart) {
                                        foreach ($cart as $p) {
                                            $cartTotal += $p['total'];
                                            $countitem += $p['qty'];
                                        }
                                    }
                                @endphp
                                <li><span>{{ $keywords['Your_Cart'] ?? __('Your Cart') }}:</span> <span
                                        class="cart-item-view">{{ $cart ? $countitem : 0 }}</span>
                                    {{ $keywords['Items'] ?? __('Items') }}
                                </li>
                                <li style="{{ $direction }} ltr;">
                                    <span>{{ $keywords['Total'] ?? __('Total') }} :</span>
                                    {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                    <span class="cart-total-view">{{ $cartTotal }}</span>
                                    {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                </li>
                            </ul>
                        @endif
                        <div class="table-outer">
                            @if ($cart != null)
                                <table class="cart-table">
                                    <thead class="cart-header">
                                        <tr>
                                            <th class="prod-column">{{ $keywords['Product'] ?? __('Product') }}</th>
                                            <th width="40%">{{ $keywords['Product_Title'] ?? __('Product Title') }}</th>
                                            <th >{{ $keywords['Quantity'] ?? __('Quantity') }}</th>
                                            <th class="price">{{ $keywords['Price'] ?? __('Price') }}</th>
                                            <th>{{ $keywords['Total'] ?? __('Total') }}</th>
                                            <th>{{ $keywords['Remove'] ?? __('Remove') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($cart as $key => $item)
                                            @php
                                                $id = $item['id'];
                                                if (session()->has('user_lang')) {
                                                    $lang = App\Models\User\Language::where('code', session()->get('user_lang'))
                                                        ->where('user_id', getUser()->id)
                                                        ->first();
                                                } else {
                                                    $lang = App\Models\User\Language::where('is_default', 1)
                                                        ->where('user_id', getUser()->id)
                                                        ->first();
                                                }
                                                $product = Product::query()
                                                    ->join('product_informations', 'product_informations.product_id', 'products.id')
                                                    ->where('products.user_id', $user->id)
                                                    ->where('product_informations.language_id', $lang->id)
                                                    ->where('products.id', $id)
                                                    ->first();
                                            @endphp

                                            <tr class="remove{{ $id }}">
                                                <td class="prod-column">
                                                    <div class="column-box">
                                                        <div class="prod-thumb">
                                                            <a href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"
                                                                target="_blank">
                                                                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $item['photo'], $userBs) }}"
                                                                    alt="">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="title">
                                                        <a target="_blank"
                                                            href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}">
                                                            <h5 class="prod-title">
                                                                {{ strlen($product->title) > 27 ? mb_substr($product->title, 0, 27, 'UTF-8') . '...' : $product->title }}

                                                            </h5>
                                                        </a>

                                                        @if (!empty($item['variations']))
                                                            <p><strong>{{ $keywords['Variation'] ?? __('Variation') }}:</strong>
                                                                <br>
                                                                @php
                                                                    $variations = $item['variations'];
                                                                    $prokeywords = json_decode($product->keywords, true);
                                                                    $addonkeywords = json_decode($product->addon_keywords, true);

                                                                @endphp
                                                                @foreach ($variations as $vKey => $variation)
                                                                    @php
                                                                        $vname = $userCurrentLang->code . '_' . str_replace('_', ' ', $vKey);

                                                                        $voption = $userCurrentLang->code . '_' . $variation['name'];

                                                                        $variationName = isset($prokeywords['variation_name'][$vname]) ? $prokeywords['variation_name'][$vname] : '';
                                                                        $optionName = isset($prokeywords['option_name'][$voption]) ? $prokeywords['option_name'][$voption] : '';
                                                                    @endphp
                                                                    @if (!empty($variationName))
                                                                        <span
                                                                            class="text-capitalize font-weight-bold {{ $userCurrentLang->rtl == 1 ? 'd-inline-block' : '' }}">{{ $variationName }} :</span>
                                                                        <span
                                                                            class="text-capitalize {{ $userCurrentLang->rtl == 1 ? 'd-inline-block' : '' }}">{{ $optionName }}</span>
                                                                        @if (!$loop->last)
                                                                            <span
                                                                                class=" {{ $userCurrentLang->rtl == 1 ? 'd-inline-block' : '' }}">,</span>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </p>
                                                        @endif
                                                        @if (!empty($item['addons']))
                                                            <p>
                                                                <strong>{{ $keywords['Addons'] ?? __('Addons') }}:</strong><br>
                                                                @php
                                                                    $addons = $item['addons'];
                                                                @endphp
                                                                @foreach ($addons as $addon)
                                                                    @php
                                                                        $addonkeywords = json_decode($product->addon_keywords, true);

                                                                        $aname = $userCurrentLang->code . '_' . $addon['name'];

                                                                    @endphp

                                                                    <span   class=" {{ $userCurrentLang->rtl == 1 ? 'd-inline-block' : '' }}">{{ $addonkeywords['addon_name'][$aname] }}</span>
                                                                    @if (!$loop->last)
                                                                       <span class=" {{ $userCurrentLang->rtl == 1 ? 'd-inline-block' : '' }}">,</span>
                                                                    @endif
                                                                @endforeach
                                                            </p>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="qty">
                                                    <div class="product-quantity d-flex" id="quantity">
                                                        <button type="button" id="sub" class="sub quantity"
                                                            data-href="{{ route('user.front.cart.item.less.quantity', [getParam(), $key]) }}">-</button>
                                                        <input type="text" class="cart_qty" id="1"
                                                            value="{{ $item['qty'] }}" />
                                                        <button type="button" id="add" class="add quantity"
                                                            data-href="{{ route('user.front.cart.item.add.quantity', [getParam(), $key]) }}">+</button>
                                                    </div>
                                                </td>
                                                <input type="hidden" value="{{ $id }}" class="product_id">
                                                <td class="price cart_price">
                                                    <p>
                                                        <strong>{{ $keywords['Product'] ?? __('Product') }}:</strong>
                                                        {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                        <span>{{ $item['product_price'] * $item['qty'] }}</span>{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                    </p>
                                                    @if (!empty($item['variations']))
                                                        <p>
                                                            <strong>{{ $keywords['Variation'] ?? __('Variation') }}:
                                                            </strong>
                                                            @php
                                                                $variations = $item['variations'];
                                                                $price = 0;
                                                                foreach ($variations as $vKey => $variation) {
                                                                    if (is_array($variation) && array_key_exists('price', $variation)) {
                                                                        $price += $variation['price'];
                                                                    }
                                                                }
                                                            @endphp
                                                            {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                            <span>{{ $price * $item['qty'] }}</span>{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                        </p>
                                                    @endif
                                                    @if (!empty($item['addons']))
                                                        <p>
                                                            <strong>{{ $keywords['Addons'] ?? __('Addons') }}:
                                                            </strong>
                                                            @php
                                                                $addons = $item['addons'];
                                                                $addonTotal = 0;
                                                                foreach ($addons as $addon) {
                                                                    $addonTotal += $addon['price'];
                                                                }
                                                            @endphp
                                                            {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                            <span>{{ $addonTotal * $item['qty'] }}</span>{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                        </p>
                                                    @endif
                                                </td>
                                                <td class="sub-total">
                                                    {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                    {{ $item['total'] }}
                                                    {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                </td>
                                                <td>
                                                    <div class="remove">
                                                        <div class="checkbox">
                                                            <span class="fas fa-times item-remove"
                                                                data-href="{{ route('user.front.cart.item.remove', [getParam(), $key]) }}"></span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @else
                                <div class="bg-light py-5 text-center">
                                    <h3 class="text-uppercase">{{ $keywords['Cart_is_empty'] ?? __('Cart is empty') }}</h3>
                                </div>
                            @endif
                        </div>
                        @if ($cart != null)
                            <div class="row cart-middle">
                                <div class="col-lg-6 offset-lg-6 col-sm-12">
                                    <div class="update-cart float-right d-inline-block ml-4">
                                        <a class="main-btn main-btn-2 proceed-checkout-btn"
                                            href="{{ route('user.product.front.checkout', getParam()) }}">
                                            <span>{{ $keywords['Checkout'] ?? __('Checkout') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

