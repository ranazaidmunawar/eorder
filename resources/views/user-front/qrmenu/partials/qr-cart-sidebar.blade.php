@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
@endphp
<div class="cart-sidebar">
    <div id="refreshDiv">
        <div class="cart-sidebar-loader-container show">
            <div class="cart-sidebar-loader"></div>
        </div>
        <div class="cart-header">
            <h3>{{ $keywords['Cart'] ?? __('Cart') }}</h3>
            <span class="close">
                <i class="fas fa-times"></i>
            </span>
        </div>
        <div class="cart-body">
            @if ($cart != null)
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
                    <div class="cart-item">
                        <div class="thumb">
                            <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $item['photo'], $userBs) }}"
                                alt="Item Image" />
                        </div>
                        <div class="details">
                            <p class="title mb-0">
                                <strong>{{ strlen(convertUtf8($product->title)) > 27 ? mb_substr(convertUtf8($product->title), 0, 27, 'UTF-8') . '...' : convertUtf8($product->title) }}</strong>
                            </p>
                            @if (!empty($item['variations']))
                                <p class="mb-0"><strong>{{ $keywords['Variation'] ?? __('Variation') }}:</strong> <br>
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
                                            <span class="text-capitalize font-weight-bold {{ $userCurrentLang->rtl == 1 ? 'd-inline-block' : '' }}">{{ $variationName }} :</span>
                                            <span class="{{ $userCurrentLang->rtl == 1 ? 'd-inline-block' : '' }}">{{ $optionName }}</span>

                                            @if (!$loop->last)
                                              <span class="{{ $userCurrentLang->rtl == 1 ? 'd-inline-block' : '' }}">,
                                            </span>
                                            @endif
                                        @endif
                                    @endforeach
                                </p>
                            @endif
                            @if (!empty($item['addons']))
                                <p class="mb-0">
                                    <strong>{{ $keywords['Addons'] ?? __('Addons') }}:</strong>
                                    @php
                                        $addons = $item['addons'];
                                    @endphp
                                    @foreach ($addons as $addon)
                                        @php
                                            $addonkeywords = json_decode($product->addon_keywords, true);

                                            $aname = $userCurrentLang->code . '_' . $addon['name'];
                                        @endphp

                                       <span class="{{ $userCurrentLang->rtl == 1 ? 'd-inline-block' : '' }}"> {{ $addonkeywords['addon_name'][$aname] }}</span>
                                        @if (!$loop->last)
                                            <span class="{{ $userCurrentLang->rtl == 1 ? 'd-inline-block' : '' }}">,
                                            </span>
                                        @endif
                                    @endforeach
                                </p>
                            @endif
                            <div class="details-footer">
                                <span class="qty-price">
                                    {{ $keywords['Item Total'] ?? __('Item Total') }}:
                                    {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}<span>{{ $item['total'] }}</span>{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                </span>
                                <div class="qty">
                                    <span class="qty-sub" data-key="{{ $key }}"><i
                                            class="fas fa-minus"></i></span>
                                    <input type="text" value="{{ $item['qty'] }}" />
                                    <span class="qty-add" data-key="{{ $key }}"><i
                                            class="fas fa-plus"></i></span>
                                </div>
                            </div>
                        </div>
                        <span class="close" data-key="{{ $key }}">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                @endforeach
            @else
                <div class="py-4 text-center bg-light d-block m-2">
                    {{ $keywords['Cart_is_empty'] ?? __('Cart is empty!') }}
                </div>
            @endif

        </div>
        <div class="cart-total">
            <strong>
                {{ $keywords['Total'] ?? __('Total') }}
            </strong>
            <strong class="total">
                {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                <span>{{ $cartTotal }}</span>
                {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
            </strong>
        </div>
        <div class="cart-footer">
            <a href="{{ route('user.front.qrmenu', getParam()) }}" class="cart-button cart">
                {{ $keywords['Menu'] ?? __('Menu') }}
            </a>
            <a href="{{ route('user.front.qrmenu.checkout', getParam()) }}" class="cart-button checkout">
                {{ $keywords['Checkout'] ?? __('Checkout') }}
            </a>
        </div>
    </div>
</div>
<div class="cart-sidebar-overlay"></div>
