<div class="modal fade" id="variationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title @if (request()->is('user/*')) text-white @endif" id="exampleModalLongTitle">
                    <span></span>
                    <small class="ml-2">
                        ({{ $userBe->base_currency_text_position == 'left' ? $userBe->base_currency_text : '' }}
                        <span id="productPrice"></span>
                        {{ $userBe->base_currency_text_position == 'right' ? $userBe->base_currency_text : '' }})
                    </small>
                </h4>

                  @if ($activeTheme == "fastfood" || request()->routeIs('user.front.index'))
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                @else
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                @endif
            </div>
            <div class="modal-body">
                <div id="variants">

                </div>
                <div class="addon-label mt-3">
                    <h5 @if (request()->is('user-front/*')) class="text-white" @endif>
                        {{ $keywords['Select_Addons'] ?? __('Select Addons') }}
                        ({{ $keywords['Optional'] ?? __('Optional') }})</h5>
                </div>
                <div id="addons">

                </div>
            </div>
            @if (in_array('Online Order', $packagePermissions))
                <div class="modal-footer d-block">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <div class="modal-quantity">
                                <span class="minus"><i class="fas fa-minus"></i></span>
                                <input class="form-control" type="number" name="cart-amount" value="1"
                                    min="1">
                                <span class="plus"><i class="fas fa-plus"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <button type="button"
                                class="btn btn-primary btn-block text-uppercase modal-cart-link mt-2">
                                <span class="d-block">{{ $keywords['Add_to_Cart'] ??  'Add to Cart' }}</span>
                                <i class="fas fa-spinner d-none"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="modal-footer d-block">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="modal-quantity">
                                <span class="minus"><i class="fas fa-minus"></i></span>
                                <input class="form-control" type="number" name="cart-amount" value="1"
                                    min="1">
                                <span class="plus"><i class="fas fa-plus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
