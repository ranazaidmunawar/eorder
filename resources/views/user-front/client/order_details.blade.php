@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
    $direction = 'direction:';
@endphp
@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Order Details'] ?? __('Order Details') }}
@endsection
@section('content')
    <section class="page-title-area d-flex align-items-center"
        style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{ $keywords['Order Details'] ?? __('Order Details') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.client.dashboard', getParam()) }}"><i
                                            class="flaticon-home"></i>{{ $keywords['Dashboard'] ?? __('Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $keywords['Order Details'] ?? __('Order Details') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="user-dashbord">
        <div class="container">
            <div class="row">
                @include('user-front.client.inc.site_bar')
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="user-profile-details">
                                <div class="order-details">
                                    <div class="progress-area-step">
                                        <ul class="progress-steps">
                                            <li class="{{ $data->order_status == 'pending' ? 'active' : '' }}">
                                                <div class="icon"></div>
                                                <div class="progress-title">{{ $keywords['Pending'] ?? __('Pending') }}
                                                </div>
                                            </li>
                                            <li class="{{ $data->order_status == 'received' ? 'active' : '' }}">
                                                <div class="icon"></div>
                                                <div class="progress-title">{{ $keywords['Received'] ?? __('Received') }}
                                                </div>
                                            </li>
                                            <li class="{{ $data->order_status == 'preparing' ? 'active' : '' }}">
                                                <div class="icon"></div>
                                                <div class="progress-title">{{ $keywords['Preparing'] ?? __('Preparing') }}
                                                </div>
                                            </li>
                                            @if ($data->serving_method != 'on_table')
                                                <li
                                                    class="{{ $data->order_status == 'ready_to_pick_up' ? 'active' : '' }}">
                                                    <div class="icon"></div>
                                                    <div class="progress-title">
                                                        {{ $keywords['Ready to pick up'] ?? __('Ready to pick up') }}</div>
                                                </li>
                                                <li class="{{ $data->order_status == 'picked_up' ? 'active' : '' }}">
                                                    <div class="icon"></div>
                                                    <div class="progress-title">
                                                        {{ $keywords['Picked up'] ?? __('Picked up') }}</div>
                                                </li>
                                            @endif
                                            @if ($data->serving_method == 'home_delivery')
                                                <li class="{{ $data->order_status == 'delivered' ? 'active' : '' }}">
                                                    <div class="icon"></div>
                                                    <div class="progress-title">
                                                        {{ $keywords['Delivered'] ?? __('Delivered') }}</div>
                                                </li>
                                            @endif
                                            <li class="{{ $data->order_status == 'cancelled' ? 'active' : '' }}">
                                                <div class="icon"></div>
                                                <div class="progress-title">{{ $keywords['Cancelled'] ?? __('Cancelled') }}
                                                </div>
                                            </li>
                                            @if ($data->serving_method == 'on_table')
                                                <li class="{{ $data->order_status == 'ready_to_serve' ? 'active' : '' }}">
                                                    <div class="icon"></div>
                                                    <div class="progress-title">
                                                        {{ $keywords['Ready to Serve'] ?? __('Ready to Serve') }}</div>
                                                </li>
                                                <li class="{{ $data->order_status == 'served' ? 'active' : '' }}">
                                                    <div class="icon"></div>
                                                    <div class="progress-title">{{ $keywords['Served'] ?? __('Served') }}
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="title">
                                        <h4>{{ $keywords['My Order Details'] ?? __('My Order Details') }}</h4>
                                    </div>
                                    <div id="print">
                                        <div class="view-order-page">
                                            <div class="order-info-area">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-8">
                                                        <div class="order-info">
                                                            <h3 class="text-capitalize">
                                                                @php
                                                                    $orderStatus = str_replace(
                                                                        '_',
                                                                        ' ',
                                                                        $data->order_status,
                                                                    );
                                                                @endphp

                                                                {{ $keywords['Order'] ?? __('Order') }}
                                                                {{ $data->order_id }}
                                                                [{{ $keywords[ucfirst($orderStatus)] ?? $orderStatus }}
                                                                ]</h3>
                                                            <p>{{ $keywords['Order Date'] ?? __('Order Date') }}
                                                                {{ $data->created_at->format('d-m-Y') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 print-btn">
                                                        <div class="prinit">
                                                            <form class="d-inline-block"
                                                                action="{{ route('user.client.order.download', [getParam(), 'id' => $data->invoice_number]) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button id="print-click" type="submit"
                                                                    class="btn"><span><i
                                                                            class="fas fa-print"></i></span>{{ $keywords['Download Invoice'] ?? __('Download Invoice') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="billing-add-area">
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <div class="payment-information">
                                                        <h5>{{ $keywords['Order'] ?? __('Order') }} : </h5>
                                                        @if (!empty($data->type))
                                                            <p>{{ $keywords['Ordered From'] ?? __('Ordered From') }} :
                                                                <span>
                                                                    @if (strtolower($data->type) == 'website')
                                                                        {{ $keywords['Website_Menu'] ?? __('Website Menu') }}
                                                                    @else
                                                                        {{ $keywords['QR Menu'] ?? __('QR Menu') }}
                                                                    @endif
                                                                </span>
                                                            </p>
                                                        @endif

                                                        @if (!empty($data->serving_method))
                                                            <p>{{ $keywords['Serving_Method'] ?? __('Serving Method') }} :
                                                                <span>
                                                                    @if (strtolower($data->serving_method) == 'on_table')
                                                                        {{ $keywords['On Table'] ?? __('On Table') }}
                                                                    @elseif(strtolower($data->serving_method) == 'home_delivery')
                                                                        {{ $keywords['Home Delivery'] ?? __('Home Delivery') }}
                                                                    @elseif(strtolower($data->serving_method) == 'pick_up')
                                                                        {{ $keywords['Pick Up'] ?? __('Pick Up') }}
                                                                    @endif
                                                                </span>
                                                            </p>
                                                        @endif

                                                        @if ($data->postal_code_status == 0)
                                                            @if (!empty($data->shipping_method))
                                                                <p>{{ $keywords['Shipping Method'] ?? __('Shipping Method') }}
                                                                    :
                                                                    <span> {{ $data->shipping_method }} </span>
                                                                </p>
                                                            @endif
                                                        @elseif ($data->postal_code_status == 1)
                                                            <p>{{ $keywords['Postal Code'] ?? __('Postal Code') }}
                                                                ({{ $keywords['Delivery Area'] ?? __('Delivery Area') }}) :
                                                                <span> {{ $data->postal_code }} </span>
                                                            </p>
                                                        @endif
                                                        @php
                                                            $cartTotal =
                                                                $data->total -
                                                                ($data->shipping_charge + $data->tax + $data->coupon);
                                                        @endphp
                                                        <p>{{ $keywords['Cart_Total'] ?? __('Cart Total') }}
                                                            : <span style="{{ $direction }} ltr;"
                                                                class="amount">{{ $data->currency_symbol_position == 'left' ? $data->currency_symbol : '' }}
                                                                {{ $cartTotal }}
                                                                {{ $data->currency_symbol_position == 'right' ? $data->currency_symbol : '' }}</span>
                                                        </p>
                                                        @if (!empty($data->coupon))
                                                            <p>{{ $keywords['Discount'] ?? __('Discount') }} : <span
                                                                    style="{{ $direction }} ltr;"
                                                                    class="amount">{{ $data->currency_symbol_position == 'left' ? $data->currency_symbol : '' }}
                                                                    {{ $data->coupon }}
                                                                    {{ $data->currency_symbol_position == 'right' ? $data->currency_symbol : '' }}</span>
                                                            </p>
                                                        @endif

                                                        <p>{{ $keywords['Subtotal'] ?? __('Subtotal') }}
                                                            : <span style="{{ $direction }} ltr;"
                                                                class="amount">{{ $data->currency_symbol_position == 'left' ? $data->currency_symbol : '' }}
                                                                {{ $cartTotal - $data?->coupon }}
                                                                {{ $data->currency_symbol_position == 'right' ? $data->currency_symbol : '' }}</span>
                                                        </p>


                                                        @if (!empty($data->tax))
                                                            <p>{{ $keywords['Tax'] ?? __('Tax') }} : <span
                                                                    style="{{ $direction }} ltr;"
                                                                    class="amount">{{ $data->currency_symbol_position == 'left' ? $data->currency_symbol : '' }}
                                                                    {{ $data->tax }}
                                                                    {{ $data->currency_symbol_position == 'right' ? $data->currency_symbol : '' }}</span>
                                                            </p>
                                                        @endif


                                                        <p>{{ $keywords['Shipping_Charge'] ?? __('Shipping Charge') }}
                                                            : <span style="{{ $direction }} ltr;"
                                                                class="amount">{{ $data->currency_symbol_position == 'left' ? $data->currency_symbol : '' }}
                                                                {{ $data->shipping_charge ? $data->shipping_charge : '0.00' }}
                                                                {{ $data->currency_symbol_position == 'right' ? $data->currency_symbol : '' }}</span>
                                                        </p>



                                                        <p>{{ $keywords['Grand Total'] ?? __('Grand Total') }} : <span
                                                                style="{{ $direction }} ltr;"
                                                                class="amount">{{ $data->currency_symbol_position == 'left' ? $data->currency_symbol : '' }}
                                                                {{ $data->total }}
                                                                {{ $data->currency_symbol_position == 'right' ? $data->currency_symbol : '' }}</span>
                                                        </p>

                                                        <p class="text-capitalize">
                                                            {{ $keywords['Payment Method'] ?? __('Payment Method') }}
                                                            : {{ convertUtf8($data->method) }}</p>

                                                        <p>{{ $keywords['Payment Status'] ?? __('Payment Status') }} :
                                                            @if ($data->payment_status == 'Pending' || $data->payment_status == 'pending')
                                                                <span
                                                                    class="badge badge-danger">{{ $keywords[ucfirst($data->payment_status)] ?? $data->payment_status }}
                                                                </span>
                                                            @else
                                                                <span class="badge badge-success">
                                                                    {{ $keywords[ucfirst($data->payment_status)] ?? $data->payment_status }}
                                                                </span>
                                                            @endif
                                                        </p>

                                                        <p>{{ $keywords['Complete'] ?? __('Complete') }} :
                                                            @if (strtolower($data->complete) == 'yes')
                                                                <span
                                                                    class="badge badge-success">{{ $keywords['Yes'] ?? __('Yes') }}
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="badge badge-danger">{{ $keywords['No'] ?? __('No') }}
                                                                </span>
                                                            @endif
                                                        </p>

                                                        <p>{{ $keywords['Time'] ?? __('Time') }} :
                                                            {{ $data->created_at }}
                                                        </p>

                                                        <p>{{ $keywords['Order_Notes'] ?? __('Order Notes') }} :
                                                            @if (!empty($order->order_notes))
                                                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                                                    data-target="#modalNotes">Show
                                                                </button>
                                                            @else
                                                                -
                                                            @endif
                                                        </p>

                                                    </div>
                                                </div>


                                                <div class="modal fade" id="modalNotes" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">
                                                                    __{{ 'Order Notes' }}</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ $data->order_notes }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if ($data->serving_method == 'home_delivery')
                                                    <div class="col-md-4">
                                                        <div class="main-info">
                                                            <h5>{{ $keywords['Shipping Details'] ?? __('Shipping Details') }}
                                                            </h5>
                                                            <ul class="list">
                                                                <li>
                                                                    <p>
                                                                        <span>{{ $keywords['Email_Address'] ?? __('Email Address') }}:</span>{{ convertUtf8($data->shipping_email) }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <span>{{ $keywords['Phone'] ?? __('Phone') }}:</span>{{ $data->shipping_country_code }}{{ $data->shipping_number }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <span>{{ $keywords['City'] ?? __('City') }}:</span>{{ convertUtf8($data->shipping_city) }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <span>{{ $keywords['Address'] ?? __('Address') }}:</span>{{ convertUtf8($data->shipping_address) }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <span>{{ $keywords['Country'] ?? __('Country') }}:</span>{{ convertUtf8($data->shipping_country) }}
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-4">
                                                    <div class="main-info">
                                                        <h5>
                                                            @if ($data->serving_method == 'home_delivery')
                                                                {{ $keywords['Billing Details'] ?? __('Billing Details') }}
                                                            @else
                                                                {{ $keywords['Information'] ?? __('Information') }}
                                                            @endif
                                                        </h5>
                                                        <ul class="list">
                                                            @if (!empty($data->billing_email))
                                                                <li>
                                                                    <p>
                                                                        <span>{{ $keywords['Email_Address'] ?? __('Email Address') }}:</span>{{ convertUtf8($data->billing_email) }}
                                                                    </p>
                                                                </li>
                                                            @endif
                                                            @if (!empty($data->billing_number))
                                                                <li>
                                                                    <p>
                                                                        <span>{{ $keywords['Phone'] ?? __('Phone') }}:</span>{{ $data->billing_country_code }}{{ $data->billing_number }}
                                                                    </p>
                                                                </li>
                                                            @endif
                                                            @if (!empty($data->billing_city))
                                                                <li>
                                                                    <p>
                                                                        <span>{{ $keywords['City'] ?? __('City') }}:</span>{{ convertUtf8($data->billing_city) }}
                                                                    </p>
                                                                </li>
                                                            @endif
                                                            @if (!empty($data->billing_address))
                                                                <li>
                                                                    <p>
                                                                        <span>{{ $keywords['Address'] ?? __('Address') }}:</span>{{ convertUtf8($data->billing_address) }}
                                                                    </p>
                                                                </li>
                                                            @endif
                                                            @if (!empty($data->billing_country))
                                                                <li>
                                                                    <p>
                                                                        <span>{{ $keywords['Country'] ?? __('Country') }}:</span>{{ convertUtf8($data->billing_country) }}
                                                                    </p>
                                                                </li>
                                                            @endif

                                                            @if ($data->serving_method == 'on_table')
                                                                @if (!empty($data->table_number))
                                                                    <li>
                                                                        <p>
                                                                            <span>{{ $keywords['Table_Number'] ?? __('Table Number') }}:</span>{{ convertUtf8($data->table_number) }}
                                                                        </p>
                                                                    </li>
                                                                @endif
                                                                @if (!empty($data->waiter_name))
                                                                    <li>
                                                                        <p>
                                                                            <span>{{ $keywords['Waiter_Name'] ?? __('Waiter Name') }}:</span>{{ convertUtf8($data->waiter_name) }}
                                                                        </p>
                                                                    </li>
                                                                @endif
                                                            @endif

                                                            @if ($data->serving_method == 'pick_up')
                                                                @if (!empty($data->pick_up_date))
                                                                    <li>
                                                                        <p>
                                                                            <span>{{ $keywords['Pick up Date'] ?? __('Pick up Date') }}:</span>{{ convertUtf8($data->pick_up_date) }}
                                                                        </p>
                                                                    </li>
                                                                @endif
                                                                @if (!empty($data->pick_up_time))
                                                                    <li>
                                                                        <p>
                                                                            <span>{{ $keywords['Pick up Time'] ?? __('Pick up Time') }}:</span>{{ convertUtf8($data->pick_up_time) }}
                                                                        </p>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive product-list">
                                            <h5>{{ $keywords['Ordered Products'] ?? __('Ordered Products') }}</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ $keywords['Product'] ?? __('Product') }}</th>
                                                        <th>{{ $keywords['Product_Title'] ?? __('Product Title') }}</th>
                                                        <th>{{ $keywords['Price'] ?? __('Price') }}</th>
                                                        <th>{{ $keywords['Quantity'] ?? __('Quantity') }}</th>
                                                        <th>{{ $keywords['Total'] ?? __('Total') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    @foreach ($data->orderItems as $key => $item)
                                                        @php
                                                            if (session()->has('user_lang')) {
                                                                $lang = App\Models\User\Language::where(
                                                                    'code',
                                                                    session()->get('user_lang'),
                                                                )
                                                                    ->where('user_id', getUser()->id)
                                                                    ->first();
                                                            } else {
                                                                $lang = App\Models\User\Language::where('is_default', 1)
                                                                    ->where('user_id', getUser()->id)
                                                                    ->first();
                                                            }
                                                            $product = Product::query()
                                                                ->join(
                                                                    'product_informations',
                                                                    'product_informations.product_id',
                                                                    'products.id',
                                                                )
                                                                ->where('products.user_id', $user->id)
                                                                ->where('product_informations.language_id', $lang->id)
                                                                ->where('products.id', $item->product_id)
                                                                ->first();
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>
                                                                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $item->product->feature_image, $userBs) }}"
                                                                    alt="image" width="100">
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"
                                                                    target="_blank">
                                                                    {{ strlen(convertUtf8($product->title)) > 60 ? mb_substr(convertUtf8($product->title), 0, 60, 'UTF-8') . '...' : convertUtf8($product->title) }}
                                                                </a>
                                                                <br>
                                                                @php
                                                                    $variations = json_decode(
                                                                        $item->product->variations,
                                                                        true,
                                                                    );
                                                                    $addonkeywords = json_decode(
                                                                        $product->addon_keywords,
                                                                        true,
                                                                    );
                                                                @endphp
                                                                @if ($variations)
                                                                    <p><strong>{{ $keywords['Variation'] ?? __('Variation') }}:</strong><br>
                                                                        @php
                                                                            $prokeywords = json_decode(
                                                                                $product->keywords,
                                                                                true,
                                                                            );

                                                                        @endphp

                                                                        @foreach ($variations as $vKey => $variation)
                                                                            @php
                                                                                foreach ($variation as $vri) {
                                                                                    $vname =
                                                                                        $userCurrentLang->code .
                                                                                        '_' .
                                                                                        str_replace('_', ' ', $vKey);
                                                                                    $voption =
                                                                                        $userCurrentLang->code .
                                                                                        '_' .
                                                                                        ($vri['name'] ?? '');
                                                                                }

                                                                                $variationName = isset(
                                                                                    $prokeywords['variation_name'][
                                                                                        $vname
                                                                                    ],
                                                                                )
                                                                                    ? $prokeywords['variation_name'][
                                                                                        $vname
                                                                                    ]
                                                                                    : '';
                                                                                $optionName = isset(
                                                                                    $prokeywords['option_name'][
                                                                                        $voption
                                                                                    ],
                                                                                )
                                                                                    ? $prokeywords['option_name'][
                                                                                        $voption
                                                                                    ]
                                                                                    : '';
                                                                                $price = isset($variation['price'])
                                                                                    ? $variation['price']
                                                                                    : '';
                                                                            @endphp

                                                                            @if (!empty($variationName))
                                                                                <span
                                                                                    class="text-capitalize font-weight-bold {{ $userCurrentLang->id == 1 ? 'text-right' : '' }}">{{ $variationName }}
                                                                                    :</span>
                                                                                <span
                                                                                    class="{{ $userCurrentLang->id == 1 ? 'text-right' : '' }}">{{ $optionName }}</span>
                                                                                @if (!empty($price))
                                                                                    (Price: {{ $price }})
                                                                                @endif
                                                                                @if (!$loop->last)
                                                                                    <span
                                                                                        class="{{ $userCurrentLang->id == 1 ? 'text-right' : '' }}">,</span>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    </p>
                                                                @endif
                                                                @php
                                                                    $addons = json_decode($item->addons, true);
                                                                @endphp
                                                                @if (!empty($addons))
                                                                    <strong
                                                                        class="mr-1">{{ $keywords['Addons'] ?? __('Addons') }}:</strong>
                                                                    @foreach ($addons as $addon)
                                                                        @php
                                                                            $addonkeywords = json_decode(
                                                                                $product->addon_keywords,
                                                                                true,
                                                                            );

                                                                            $aname =
                                                                                $userCurrentLang->code .
                                                                                '_' .
                                                                                $addon['name'];

                                                                        @endphp

                                                                        @if ($addonkeywords['addon_name'][$aname])
                                                                            <span
                                                                                class="{{ $userCurrentLang->id == 1 ? 'text-right' : '' }}">
                                                                                {{ $addonkeywords['addon_name'][$aname] }}</span>
                                                                            @if (!$loop->last)
                                                                                <span
                                                                                    class="{{ $userCurrentLang->id == 1 ? 'text-right' : '' }}">,</span>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <strong
                                                                    class="mr-1">{{ $keywords['Product'] ?? __('Product') }}:</strong>
                                                                {{ $data->currency_code_position == 'left' ? $data->currency_code : '' }}
                                                                <span>{{ (float) $item->product_price }}</span>
                                                                {{ $data->currency_code_position == 'right' ? $data->currency_code : '' }}
                                                                <br>
                                                                @if (is_array($variations))
                                                                    <strong
                                                                        class="mr-1">{{ $keywords['Variation'] ?? __('Variation') }}:
                                                                    </strong>
                                                                    {{ $data->currency_code_position == 'left' ? $data->currency_code : '' }}
                                                                    <span>{{ (float) $item->variations_price }}</span>
                                                                    {{ $data->currency_code_position == 'right' ? $data->currency_code : '' }}
                                                                    <br>
                                                                @endif

                                                                @if (is_array($addons))
                                                                    <strong
                                                                        class="mr-1">{{ $keywords['Addons'] ?? __('Addons') }}:
                                                                    </strong>
                                                                    {{ $data->currency_code_position == 'left' ? $data->currency_code : '' }}
                                                                    <span>{{ (float) $item->addons_price }}</span>
                                                                    {{ $data->currency_code_position == 'right' ? $data->currency_code : '' }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $item->qty }}</td>
                                                            <td>
                                                                <span>{{ $data->currency_code_position == 'left' ? $data->currency_code : '' }}</span>
                                                                {{ $item->total }}
                                                                <span>{{ $data->currency_code_position == 'right' ? $data->currency_code : '' }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="edit-account-info">
                                        <a href="{{ route('user.client.orders', getParam()) }}"
                                            class="btn btn-primary">{{ $keywords['back'] ?? __('back') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
