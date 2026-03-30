@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;use App\Models\User\Product;use App\Models\User\ProductInformation;
@endphp

<div class="row no-gutters">
    @if(count($pcats)=== 0)
        <div class="col-lg-12">
            <h5 class="text-center">NO CATEGORY FOUND</h5>
        </div>
    @else
        <div class="col-lg-4 pr-3">
            <div class="pos-categories">
                <div class="card">
                    <div class="card-body">
                        <div class="nav flex-column nav-pills nav-secondary nav-pills-no-bd"
                             id="v-pills-tab-without-border" role="tablist" aria-orientation="vertical">
                            @foreach ($pcats as $pcat)
                                <a class="nav-link {{$loop->first ? 'active' : ''}}" id="pcat{{$pcat->id}}-tab"
                                   data-toggle="pill" href="#pcat{{$pcat->id}}" role="tab"
                                   aria-controls="pcat{{$pcat->id}}" aria-selected="false">{{$pcat->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-8">
            <div class="pos-items">
                <div class="card">
                    <div class="card-body px-2 pb-1">
                        <div class="tab-content" id="v-pills-tabContent">
                            @foreach ($pcats as $pcat)
                                <div class="tab-pane fade {{$loop->first ? 'show active' : ''}}" id="pcat{{$pcat->id}}"
                                     role="tabpanel" aria-labelledby="pcat{{$pcat->id}}-tab">
                                    @if ($pcat->productInformation()->count() > 0)
                                        <div class="row no-gutters">
                                            @foreach ($pcat->productInformation as $productInformation)
                                                @php
                                                    $product = Product::query()->find($productInformation->product_id);
                                                @endphp
                                                <div class="col-lg-4 px-2 mb-3">
                                                    <a href="#" class="single-pos-item d-block cart-link"
                                                       data-product="{{$product}}"
                                                       data-title="{{$productInformation->title}}"
                                                       data-href="{{route('user.add.cart',$product->id)}}">
                                                        <img class="lazy"
                                                             src="{{Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE,$product->feature_image,$userBs)}}"
                                                             data-src="{{Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE,$product->feature_image,$userBs)}}"
                                                              width="120" height="120">
                                                        <h6 class="mt-2 text-center">
                                                            {{ strlen($productInformation->title) > 27 ? mb_substr($productInformation->title, 0, 27, 'UTF-8') . '...' : $productInformation->title }}
                                                        </h6>
                                                         <p class="mt-2 text-center">
                                                           
                                                                {{$userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : ''}}{{ $product->current_price }}{{$userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : ''}}
                                                            
                                                            @if($product->previous_price)
                                                            <del>
                                                                {{$userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : ''}}{{ $product->previous_price }}{{$userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : ''}}
                                                            </del>
                                                            @endif
                                                        </p>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
