@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>sales Invoice</title>

    <style>

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent
        }

        .table td,
        .table th {
            padding: .75rem;
            vertical-align: top;
            border-right: 1px solid #2c2d2e
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #1f2122
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6
        }

        .table .table {
            background-color: #fff
        }

        .table-sm td,
        .table-sm th {
            padding: .3rem
        }

        .table-bordered {
            border: 1px solid #1e2021
        }


        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 2px
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, .05)
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .075)
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar
        }

        .table-responsive>.table-bordered {
            border: 0
        }

        .bg-primary {
            background-color: #898c8f !important
        }

        a.bg-primary:focus,
        a.bg-primary:hover,
        button.bg-primary:focus,
        button.bg-primary:hover {
            background-color: #0062cc !important
        }

        .text-center {
            text-align: center !important
        }
        .color-dark{
            color: #1e2021 !important;
        }
        .color-white{
            color: #fff !important;
        }
        .font-b{
            font-weight: bold !important;
        }
        .m-0{
            margin: 0 !important;
        }
        .p-0{
            padding: 0 !important;
        }
        .mb-0{
            margin-bottom: 0 !important;
        }
        .pb-0{
            padding-bottom: 0 !important;
        }
        .mt-0{
            margin-top: 0 !important;
        }
        .pt-0{
            padding-top: 0 !important;
        }
        .mb-10 {
            margin-bottom: 10px !important;
        }
        .mb-20{
            margin-bottom: 20px !important;
        }
        .pb-20{
            padding-bottom: 20px !important;
        }
        .pb-10{
            padding-bottom: 10px !important;
        }
        .mt-10 {
            margin-top: 10px !important;
        }
        .mt-20{
            margin-top: 20px !important;
        }
        .pt-20{
            padding-top: 20px !important;
        }
        .pt-10{
            padding-top: 10px !important;
        }
        .m-10{
            margin: 10px !important;
        }
        .mtb-10{
            margin-block: 10px !important;
        }
        .p-10{
            padding: 10px !important;
        }
        .ptb-10{
            padding-block: 10px !important;
        }
    </style>
</head>

<body>
    <div class="order-comfirmation">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo text-center mb-20 pt-20">
                        @if($userBs->logo)
                       <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_LOGO, $userBs->logo,  $userBs) }}"
                         alt="navbar brand" class="navbar-brand" width="120">
                         @else
                        <img src="{{ asset('assets/restaurant/images/logo.png') }}" alt="Logo">
                      @endif
                    </div>
                    <p class="color-dark p-0 mb-0 text-center">
                        <span class="font-b"><u>Searching:<u></span>
                        @if ($rq_from_date)
                            <span class="font-b">From:</span>
                            {{ Carbon\carbon::parse($rq_from_date)->format('m-d-y') }},
                        @endif
                        @if ($rq_to_date)
                            <span class="font-b">To: </span>
                            {{ Carbon\carbon::parse($rq_to_date)->format('m-d-y') }},
                        @endif
                        @if ($rq_order_from)
                            <span class="font-b">Order From: </span>
                            {{ $rq_order_from }},
                        @else
                            <span class="font-b">Order From:</span>
                            All,
                        @endif

                        @if ($rq_serving_method)
                            <span class="font-b">Serving Method: </span>
                            {{ $rq_serving_method }},
                        @else
                            <span class="font-b">Serving Method:</span>
                            All,
                        @endif

                        @if ($rq_order_status)
                            <span class="font-b">Order Status: </span>
                            {{ $rq_order_status }},
                        @else
                            <span class="font-b">Order Status:</span>
                            All,
                        @endif

                        @if ($rq_payment_status)
                            <span class="font-b">Payment Status: </span>
                            {{ $rq_payment_status }},
                        @else
                            <span class="font-b">Payment Status:</span>
                            All,
                        @endif

                        @if ($rq_completed)
                            <span class="font-b">Completed: </span>
                            {{ $rq_completed }}
                        @else
                            <span class="font-b">Completed:</span>
                            All
                        @endif

                    </p>
                    <div class="confirmation-message bg-primary mb-20 mt-0 p-0">
                        <h2 class="text-center"><strong class="color-white">{{ __('Sales Report') }}</strong></h2>
                    </div>

                    <div class="row">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Order Number</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Discount</th>
                                    <th scope="col">Tax</th>
                                    <th scope="col">Shipping Charge</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Serving Method</th>
                                    <th scope="col">Payment</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Completed</th>
                                    <th scope="col">Gateway </th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <tr class="table-row">
                                        <td>{{ $order->order_number }}</td>
                                        <td> {{ convertUtf8($order->billing_fname) }}</td>
                                        <td>{{ $order->billing_country_code }}{{ $order->billing_number }}
                                        </td>
                                        <td> {{ $order->currency_symbol_position == 'left' ? $order->currency_symbol : '' }}
                                            {{ $order->coupon }}
                                            {{ $order->currency_symbol_position == 'right' ? $order->currency_symbol : '' }}
                                        </td>
                                        <td>
                                            {{ $order->currency_symbol_position == 'left' ? $order->currency_symbol : '' }}{{ $order->tax }}{{ $order->currency_symbol_position == 'right' ? $order->currency_symbol : '' }}

                                        </td>
                                        <td>
                                            @if (!empty($order->shipping_charge))
                                                {{ $order->currency_symbol_position == 'left' ? $order->currency_symbol : '' }}{{ $order->shipping_charge }}{{ $order->currency_symbol_position == 'right' ? $order->currency_symbol : '' }}
                                            @else
                                                {{ $order->currency_symbol_position == 'left' ? $order->currency_symbol : '' }}
                                                0
                                                {{ $order->currency_symbol_position == 'right' ? $order->currency_symbol : '' }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order->currency_symbol_position == 'left' ? $order->currency_symbol : '' }}{{ $order->total }}{{ $order->currency_symbol_position == 'right' ? $order->currency_symbol : '' }}
                                        </td>


                                        <td class="text-capitalize">
                                            <span
                                                class="badge badge-dark">{{ str_replace('_', ' ', $order->serving_method) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-dark">
                                                {{ str_replace('_', ' ', $order->payment_status) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-dark">
                                                {{ str_replace('_', ' ', $order->order_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-dark">
                                                {{ str_replace('_', ' ', $order->completed) }}</span>
                                        </td>
                                        <td class="text-capitalize">
                                            <span class="badge badge-dark">
                                                {{ str_replace('_', ' ', $order->method) }}</span>
                                        </td>
                                        <td>
                                            {{ Carbon\carbon::parse($order->created_at)->format('m-d-y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
</body>

</html>
