@php
    use App\Models\User\Product;
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('user.layout')

@section('sidebar', 'overlay-sidebar')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/calculator.min.css') }}">
@endsection

@section('content')

    <div class="row" id="outsidePrintScreen">
        <div class="col-md-12">

            <div class="row">
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-12 px-0">
                            <form>
                                <div class="form-group pt-0">
                                    <input name="search" type="text" class="form-control"
                                        placeholder="Search by Item Name here...">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="posCatItems" style="display: block;">
                        @includeIf('user.pos.partials.cats-items')
                    </div>
                    <div id="posItems" style="display: none;">
                        @includeIf('user.pos.partials.items')
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card">
                        <div class="card-body px-2">
                            <form id="ajaxForm" action="{{ route('user.pos.placeOrder') }}" method="POST">
                                @csrf
                                <div class="form-group p-0 pb-2">
                                    <div class="ui-widget">
                                        <label for="">Customer Phone</label>
                                        <input class="form-control" type="text" name="customer_phone"
                                            placeholder="Customer Phone Number" value="{{ old('customer_phone') }}"
                                            onchange="loadCustomerName(this.value)">
                                        <p class="text-warning mb-0">Use <strong>Country Code</strong> in phone number
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group p-0 pb-2">
                                    <div class="ui-widget">
                                        <label for="">Customer Name</label>
                                        <input class="form-control" name="customer_name" type="text"
                                            placeholder="Customer Name" value="{{ old('customer_name') }}" disabled>
                                        <small class="text-warning">Enter customer phone first.</small>
                                    </div>
                                </div>
                                <div class="form-group p-0 pb-2">
                                    <div class="ui-widget">
                                        <label for="">Customer Email</label>
                                        <input class="form-control" name="customer_email" type="email"
                                            placeholder="Customer Email" value="{{ old('customer_email') }}" disabled>
                                        <small class="text-warning">Enter customer email first.</small>
                                    </div>
                                </div>
                                <div class="form-group p-0 pb-2">
                                    <label for="">Serving Method **</label>
                                    <select class="form-control" name="serving_method" required>
                                        @foreach ($smethods as $smethod)
                                            @if (!empty($packagePermissions) && in_array($smethod->name, $packagePermissions))
                                                <option value="{{ $smethod->value }}"
                                                    {{ $smethod->value == old('serving_method') ? 'selected' : '' }}>
                                                    {{ $smethod->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group p-0 pb-2">
                                    <label for="">Payment Method </label>
                                    <select class="form-control select2" name="payment_method">
                                        <option value="" selected disabled>Select Payment Method</option>
                                        @foreach ($pmethods as $pmethod)
                                            <option value="{{ $pmethod->name }}"
                                                {{ $pmethod->name == old('payment_method') ? 'selected' : '' }}>
                                                {{ $pmethod->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group p-0 pb-2">
                                    <label for="">Payment Status **</label>
                                    <select class="form-control" name="payment_status" required>
                                        <option value="Pending" {{ 'Pending' == old('payment_status') ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="Completed"
                                            {{ 'Completed' == old('payment_status') ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                    </select>
                                </div>
                                <div id="on_table" class="d-none extra-fields">
                                    <div class="form-group p-0 pb-2">
                                        <label for="">Table No</label>
                                        <select class="form-control select2" name="table_no">
                                            <option value="" selected disabled>Select Table No</option>
                                            @foreach ($tables as $table)
                                                <option value="{{ $table->table_no }}"
                                                    {{ $table->table_no == old('table_no') ? 'selected' : '' }}>
                                                    Table - {{ $table->table_no }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="pick_up" class="d-none extra-fields">
                                    <div class="form-group p-0 pb-2">
                                        <label for="">Pickup Date</label>
                                        <input name="pick_up_date" type="text" class="form-control pickupdatepicker"
                                            placeholder="Pickup Date" autocomplete="off">
                                    </div>
                                    <div class="form-group p-0 pb-2">
                                        <label for="">Pickup Time</label>
                                        <input name="pick_up_time" type="text" class="form-control timepicker"
                                            placeholder="Pickup Time" autocomplete="off">
                                    </div>
                                </div>

                                <div id="home_delivery" class="d-none extra-fields">
                                    @if ($userBe->delivery_date_time_status == 1)
                                        <div class="form-group p-0 pb-2">
                                            <label>Delivery Date {{ $userBe->delivery_date_time_required == 1 ? '*' : '' }}
                                            </label>
                                            <div
                                                class="field-input cross {{ !empty(old('delivery_date')) ? 'cross-show' : '' }}">
                                                <input class="form-control delivery-datepicker" type="text"
                                                    name="delivery_date" autocomplete="off"
                                                    value="{{ old('delivery_date') }}">
                                                <i class="far fa-times-circle"></i>
                                            </div>
                                        </div>
                                        <div class="form-group p-0 pb-2">
                                            <label>Delivery Time
                                                {{ $userBe->delivery_date_time_required == 1 ? '*' : '' }}</label>
                                            <select id="deliveryTime" class="form-control" name="delivery_time" disabled>
                                                <option value="" selected disabled>Select a time frame</option>
                                            </select>
                                        </div>
                                    @endif

                                    <div id="shippingPostCharges">
                                        @if (
                                            $userBs->postal_code == 0 ||
                                                (is_array($packagePermissions) && !in_array('Postal Code Based Delivery Charge', $packagePermissions)))

                                            @if (count($scharges) > 0)
                                                <div id="shippingCharges" class="form-group p-0 pb-2">
                                                    <label>{{ __('Shipping Charges') }}</label>
                                                    @foreach ($scharges as $scharge)
                                                        <div class="form-check p-0 pl-4">
                                                            <input class="form-check-input" type="radio"
                                                                data="{{ !empty($scharge->free_delivery_amount) && posCartSubTotal() >= $scharge->free_delivery_amount ? 0 : $scharge->charge }}"
                                                                name="shipping_charge" id="scharge{{ $scharge->id }}"
                                                                value="{{ $scharge->id }}"
                                                                {{ $loop->first ? 'checked' : '' }}
                                                                data-free_delivery_amount="{{ $scharge->free_delivery_amount }}">
                                                            <label class="form-check-label mb-0"
                                                                for="scharge{{ $scharge->id }}">{{ $scharge->title }}</label>
                                                            +
                                                            <strong>
                                                                {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ $scharge->charge }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                            </strong>
                                                        </div>

                                                        @if (!empty($scharge->free_delivery_amount))
                                                            <p class="mb-0 pl-2">(@lang('Free Delivery for Orders over')
                                                                {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ $scharge->free_delivery_amount - 1 }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                                )</p>
                                                        @endif
                                                        <p class="mb-0 text-warning pl-2">
                                                            <small>{{ $scharge->text }}</small>
                                                        </p>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @else
                                            <div class="form-group p-0 pb-2">
                                                <label>{{ __('Postal Code') }} (Delivery Area)</label>
                                                <select name="postal_code" class="select2 form-control">
                                                    @foreach ($postcodes as $postcode)
                                                        <option value="{{ $postcode->id }}"
                                                            data="{{ $postcode->charge }}"
                                                            data-free_delivery_amount="{{ $postcode->free_delivery_amount }}">
                                                            @if (!empty($postcode->title))
                                                                {{ $postcode->title }} -
                                                            @endif
                                                            {{ $postcode->postcode }}

                                                            ({{ __('Delivery Charge') }}
                                                            -
                                                            {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ $postcode->charge }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                            @if (!empty($postcode->free_delivery_amount))
                                                                , @lang('Free Delivery for Orders over')
                                                                {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ $postcode->free_delivery_amount - 1 }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                            @endif)
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </form>
                        </div>

                        <div class="card-footer text-center">
                            <button id="submitBtn" class="btn btn-success" type="button">Place Order</button>
                            @if (!empty($onTable) && $onTable->pos == 1)
                                <p class="mb-0 text-warning">Token No. print option (for '{{ $onTable->name }}' orders)
                                    will be shown after placing order.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h4>Ordered Foods</h4>
                                </div>
                            </div>


                            <div id="divRefresh">
                                @if (empty($cart))
                                    <div class="text-center py-5 mt-4">
                                        <h4>NO ITEMS ADDED</h4>
                                    </div>
                                @else
                                    <div id="cartTable">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Item</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Price
                                                        ({{ $userBe->base_currency_symbol }})
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cart as $key => $item)
                                                    @php
                                                        $id = $item['id'];
                                                        $user = getRootUser();
                                                        $product = Product::query()
                                                            ->where('user_id', $user->id)
                                                            ->findOrFail($id);
                                                    @endphp
                                                    <tr class="cart-item">
                                                        <td width="55%" class="item">
                                                            <h5>
                                                                {{ strlen($item['name']) > 27 ? mb_substr($item['name'], 0, 27, 'UTF-8') . '...' : $item['name'] }}

                                                            </h5>
                                                            @if (!empty($item['variations']))
                                                                <p><strong>{{ __('Variation') }}:</strong>
                                                                    <br>
                                                                    @php
                                                                        $variations = $item['variations'];
                                                                    @endphp
                                                                    @foreach ($variations as $vKey => $variation)
                                                                        <span
                                                                            class="text-capitalize">{{ str_replace('_', ' ', $vKey) }}:</span>
                                                                        {{ $variation['name'] }}
                                                                        @if (!$loop->last)
                                                                            ,
                                                                        @endif
                                                                    @endforeach
                                                                </p>
                                                            @endif

                                                            @if (!empty($item['addons']))
                                                                <p>
                                                                    <strong>{{ __('Addons') }}:</strong>
                                                                    @php
                                                                        $addons = $item['addons'];
                                                                    @endphp
                                                                    @foreach ($addons as $addon)
                                                                        {{ $addon['name'] }}
                                                                        @if (!$loop->last)
                                                                            ,
                                                                        @endif
                                                                    @endforeach
                                                                </p>
                                                            @endif
                                                            <i class="fas fa-times text-danger item-remove"
                                                                data-href="{{ route('user.cart.item.remove', $key) }}"></i>
                                                        </td>
                                                        <td width="25%"
                                                            style="padding-left: 0 !important;padding-right: 0 !important;">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text sub decreaseQty"
                                                                        data-key="{{ $key }}">
                                                                        <i class="fas fa-minus"></i>
                                                                    </span>
                                                                </div>
                                                                <input name="quantity" type="number"
                                                                    class="form-control" value="{{ $item['qty'] }}"
                                                                    data-key="{{ $key }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text add increaseQty"
                                                                        data-key="{{ $key }}">
                                                                        <i class="fas fa-plus"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td width="20%">
                                                            {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                            {{ $item['total'] }}
                                                            {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Subtotal
                                            <span>
                                                {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                <span id="subtotal">{{ posCartSubTotal() }}</span>
                                                {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Tax
                                            <span>
                                                +
                                                {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                <span id="tax">{{ posTax() }}</span>
                                                {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Shipping Charge
                                            <span>
                                                +
                                                {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                <span id="shipping">{{ posShipping() }}</span>
                                                {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                            </span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center bg-primary text-white">
                                            <strong>Total</strong>
                                            <span>
                                                {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                <span
                                                    class="grandTotal">{{ posCartSubTotal() + posTax() + posShipping() }}</span>
                                                {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                            </span>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <div class="row no-gutters">
                                <div class="col-lg-4">
                                    <button id="calcModalBtn" type="button" class="btn btn-primary btn-block"
                                        data-toggle="tooltip" data-placement="bottom" title="Calculator">
                                        <i class="fas fa-calculator"></i>
                                        Calculator
                                    </button>
                                </div>
                                <div class="col-lg-4">
                                    <button class="btn btn-success btn-block" id="printBtn">Print Receipt</button>
                                </div>
                                <div class="col-lg-4">
                                    <button class="btn btn-danger btn-block" id="clearCartBtn">Clear Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

   
    <div class="modal fade" id="calcModal" tabindex="-1" role="dialog" aria-labelledby="calcModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Calculator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">

                        <form>
                            <input readonly id="display1" type="text" class="form-control-lg text-right">
                            <input readonly id="display2" type="text" class="form-control-lg text-right">
                        </form>

                        <div class="d-flex justify-content-between button-row">
                            <button id="left-parenthesis" type="button" class="operator-group">&#40;</button>
                            <button id="right-parenthesis" type="button" class="operator-group">&#41;</button>
                            <button id="square-root" type="button" class="operator-group">&#8730;</button>
                            <button id="square" type="button" class="operator-group">&#120;&#178;</button>
                        </div>

                        <div class="d-flex justify-content-between button-row">
                            <button id="clear" type="button">&#67;</button>
                            <button id="backspace" type="button">&#9003;</button>
                            <button id="ans" type="button" class="operand-group">&#65;&#110;&#115;</button>
                            <button id="divide" type="button" class="operator-group">&#247;</button>
                        </div>


                        <div class="d-flex justify-content-between button-row">
                            <button id="seven" type="button" class="operand-group">&#55;</button>
                            <button id="eight" type="button" class="operand-group">&#56;</button>
                            <button id="nine" type="button" class="operand-group">&#57;</button>
                            <button id="multiply" type="button" class="operator-group">&#215;</button>
                        </div>


                        <div class="d-flex justify-content-between button-row">
                            <button id="four" type="button" class="operand-group">&#52;</button>
                            <button id="five" type="button" class="operand-group">&#53;</button>
                            <button id="six" type="button" class="operand-group">&#54;</button>
                            <button id="subtract" type="button" class="operator-group">&#8722;</button>
                        </div>


                        <div class="d-flex justify-content-between button-row">
                            <button id="one" type="button" class="operand-group">&#49;</button>
                            <button id="two" type="button" class="operand-group">&#50;</button>
                            <button id="three" type="button" class="operand-group">&#51;</button>
                            <button id="add" type="button" class="operator-group">&#43;</button>
                        </div>

                   
                        <label class="switch" style="display: none;">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                        <div class="d-flex justify-content-between button-row">
                            <button id="percentage" type="button" class="operand-group">
                              

                            </button>
                            <button id="zero" type="button" class="operand-group">&#48;</button>
                            <button id="decimal" type="button" class="operand-group">&#46;</button>
                            <button id="equal" type="button">&#61;</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


    @includeIf('user.pos.variation-modal')
  

    <div id="customerCopy">
        <iframe id="customerReceipt" src="{{ url('user/print/customer-copy') }}" style="display:none;"></iframe>
    </div>
    <div id="kitchenCopy">
        <iframe id="kitchenReceipt" src="{{ url('user/print/kitchen-copy') }}" style="display:none;"></iframe>
    </div>
    <div id="tokenNo">
        <iframe id="tokenNoPrintable" src="{{ url('user/print/token-no') }}" style="display:none;"></iframe>
    </div>
@endsection

@section('scripts')
    
    <script src="{{ asset('assets/admin/js/plugin/math.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/plugin/calculator/calculator.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/plugin/printthis.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugin.min.js') }}"></script>


    @if (
        !empty($onTable) &&
            $onTable->pos == 1 &&
            Session::has('success') &&
            Session::has('previous_serving_method') &&
            Session::get('previous_serving_method') == 'on_table')
        <script>
            var tokenFrame = document.getElementById("tokenNoPrintable");
            tokenFrame.focus();
            tokenFrame.contentWindow.print();
        </script>
    @endif

      <script>
    const postalCode = "{{ $userBs->postal_code }}";
        let getServingMethod = "";
        var cartRoute = "{{ route('user.cart.clear') }}";
        var timeFramesRoute = "{{ route('user.pos.timeframes') }}";
        var shippingChargeRoute = "{{ route('user.pos.shippingCharge') }}";
    </script>
    <script src="{{ asset('assets/tenant/js/pos.js') }}"></script>
  

    <script>
        var textPosition = "{{ $userBe->base_currency_text_position }}";
        var currText = "{{ $userBe->base_currency_text }}";
        var posAudio = new Audio("{{ asset('assets/front/files/beep-07.mp3') }}");
        var select = "{{ __('Select') }}";
    </script>
   
    <script src="{{ asset('assets/admin/js/cart.js') }}"></script>
@endsection
