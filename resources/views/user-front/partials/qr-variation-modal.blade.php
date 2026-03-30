<div class="modal fade" id="variationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <span></span>
                    <br>
                    <small>
                        (Total:
                        {{$userBe->base_currency_text_position == 'left' ? $userBe->base_currency_text : ''}}
                        <span id="productPrice"></span>
                        {{$userBe->base_currency_text_position == 'right' ? $userBe->base_currency_text : ''}})
                    </small>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="variation-label">
                    <strong>{{$keywords['Variations'] ?? __('Variations')}}</strong>
                </div>
                <div id="variants">
                   
                </div>

                <div class="addon-label mt-3">
                    <strong>{{$keywords["Addons"] ?? __("Addons")}}</strong>
                </div>
                <div id="addons">
                    
                </div>
                
            </div>

        </div>
    </div>
</div>
