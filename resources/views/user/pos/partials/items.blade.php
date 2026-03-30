@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
    use App\Models\User\ProductInformation;
@endphp
<div class="row no-gutters">
    @if (count($pcats) === 0)
        <div class="col-lg-12">
            <h5 class="text-center">NO PRODUCT FOUND</h5>
        </div>
    @else
        <div class="col-lg-12">
            <div class="pos-items">
                <div class="card">
                    <div class="card-body px-2 pb-1">
                        <div class="row no-gutters">
                            @foreach ($pcats as $pcat)
                                @if ($pcat->productInformation()->count() > 0)
                                    @foreach ($pcat->productInformation as $productInformation)
                                        @php
                                            $product = Product::query()->find($productInformation->product_id);
                                            $pI = ProductInformation::query()
                                                ->where('product_id', $product->id)
                                                ->where('language_id', $lang->id)
                                                ->first();
                                        @endphp
                                        <div class="col-lg-3 px-2 mb-3 pos-item"
                                            data-title="{{ $productInformation->title }}">
                                            <a href="#" class="single-pos-item d-block cart-link"
                                                data-product="{{ $product }}"
                                                data-title="{{$productInformation->title}}"
                                                data-href="{{ route('user.add.cart', $product->id) }}">
                                                <img class="lazy"
                                                    src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}"
                                                    data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}"
                                                    width="120" height="120">
                                           
                                                <h6 class="text mt-2 text-center">
                                                    {{ strlen($productInformation->title) > 27 ? mb_substr($productInformation->title, 0, 27, 'UTF-8') . '...' : $productInformation->title }}
                                                </h6>
                                                <p class="mt-2 text-center">

                                                    {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ $product->current_price }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}

                                                    @if ($product->previous_price)
                                                        <del>
                                                            {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ $product->previous_price }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                        </del>
                                                    @endif
                                                </p>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
