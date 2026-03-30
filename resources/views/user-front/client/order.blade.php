@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Order'] ?? __('Order') }}
@endsection
@section('content')
    <section class="page-title-area d-flex align-items-center"
        style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{ $keywords['My Orders'] ?? __('My Orders') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.client.dashboard', getParam()) }}"><i
                                            class="flaticon-home"></i>{{ $keywords['Dashboard'] ?? __('Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $keywords['My Orders'] ?? __('My Order') }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="user-dashbord content mt-5">
        <div class="container">
            <div class="row">
                @include('user-front.client.inc.site_bar')
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="user-profile-details">
                                <div class="account-info">
                                    <div class="title">
                                        <h4>{{ $keywords['All Orders'] ?? __('All Orders') }}</h4>
                                    </div>
                                    <div class="main-info">
                                        <div class="main-table">
                                            <div class="table-responsive">
                                                <table id="example"
                                                    class="dataTables_wrapper dt-responsive table-striped dt-bootstrap4 w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ $keywords['Order Number'] ?? __('Order Number') }}</th>
                                                            <th>{{ $keywords['Type'] ?? __('Type') }}</th>
                                                            <th>{{ $keywords['Serving_Method'] ?? __('Serving Method') }}
                                                            </th>
                                                            <th>{{ $keywords['Date'] ?? __('Date') }}</th>
                                                            <th>{{ $keywords['Total Price'] ?? __('Total Price') }}</th>
                                                            <th>{{ $keywords['Action'] ?? __('Action') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($orders) > 0)
                                                            @foreach ($orders as $order)
                                                                <tr>
                                                                    <td>{{ $order->order_number }}</td>
                                                                    <td>
                                                                        @if ($order->type == 'website')
                                                                            {{ $keywords['Website'] ?? __('Website') }}
                                                                        @elseif ($order->type == 'qr')
                                                                            {{ $keywords['QR'] ?? __('QR') }}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($order->serving_method == 'on_table')
                                                                            {{ $keywords['On Table'] ?? __('On Table') }}
                                                                        @elseif ($order->serving_method == 'home_delivery')
                                                                            {{ $keywords['Home Delivery'] ?? __('Home Delivery') }}
                                                                        @elseif ($order->serving_method == 'pick_up')
                                                                            {{ $keywords['Pick Up'] ?? __('Pick Up') }}
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                                                    <td>{{ $order->currency_symbol_position == 'left' ? $order->currency_symbol : '' }}
                                                                        {{ $order->total }}
                                                                        {{ $order->currency_symbol_position == 'right' ? $order->currency_symbol : '' }}
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('user.client.orders.details', [getParam(), $order->id]) }}"
                                                                            class="btn">
                                                                            {{ $keywords['Details'] ?? __('Details') }}
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr class="text-center">
                                                                <td colspan="12">
                                                                    {{ $keywords['No Orders'] ?? __('No Orders') }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div>
                                            {{ $orders->links() }}
                                        </div>
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
