@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Language;
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('user.layout')

@includeIf('user.partials.rtl-style')

@section('content')
    <div class="page-header">
        <h4 class="page-title">Items</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('user.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Items Management</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Items</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block">Items</div>
                        </div>
                        <div class="col-lg-3">
                            @if (!empty($userLangs))
                                <select name="language" class="form-control"
                                    onchange="window.location='{{ url()->current() . '?language=' }}'+this.value">
                                    <option value="" selected disabled>Select a Language</option>
                                    @foreach ($userLangs as $lang)
                                        <option value="{{ $lang->code }}"
                                            {{ $lang->code == request()->input('language') ? 'selected' : '' }}>
                                            {{ $lang->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                            <a href="{{ route('user.product.create') . '?language=' . request()->input('language') }}"
                                class="btn btn-primary float-right btn-sm"><i class="fas fa-plus"></i> Add Item</a>
                            <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete"
                                data-href="{{ route('user.product.bulk.delete') }}"><i class="flaticon-interface-5"></i>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($products) == 0)
                                <h3 class="text-center">NO PRODUCT FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <input type="checkbox" class="bulk-check" data-val="all">
                                                </th>
                                                <th scope="col">Image</th>
                                                <th scope="col" width="35%">Title</th>
                                                <th scope="col">Price ({{ $userBe->base_currency_text }})</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Featured</th>
                                                <th scope="col">Special</th>
                                                <th scope="col" width="15%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($products as $key => $product)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="bulk-check"
                                                            data-val="{{ $product->id }}">
                                                    </td>
                                                    <td>
                                                        <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}"
                                                            width="80" height="80">
                                                    </td>
                                                    <td width="35%"> <a
                                                            href="{{ route('user.front.product.details', [$tusername, $product->slug, $product->id]) }}"
                                                            target="_blank">{{ strlen($product->title) > 120 ? substr($product->title, 0, 120) . '...' : $product->title }}</a>
                                                    </td>
                                                    <td>

                                                        {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                        {{ $product->current_price }}
                                                        {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}

                                                    </td>
                                                    <td>
                                                        @if (!empty($product->category_name))
                                                            {{ convertUtf8($product->category_name) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form id="featureForm{{ $product->id }}"
                                                            action="{{ route('user.product.feature') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}">
                                                            <select name="feature" id=""
                                                                class="form-control-sm text-white
                                  @if ($product->is_feature == 1) bg-success
                                  @elseif ($product->is_feature == 0)
                                  bg-danger @endif
                                "
                                                                onchange="document.getElementById('featureForm{{ $product->id }}').submit();">
                                                                <option value="1"
                                                                    {{ $product->is_feature == 1 ? 'selected' : '' }}>
                                                                    Yes
                                                                </option>
                                                                <option value="0"
                                                                    {{ $product->is_feature == 0 ? 'selected' : '' }}>
                                                                    No
                                                                </option>
                                                            </select>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form id="specialForm{{ $product->id }}"
                                                            action="{{ route('user.product.special') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}">
                                                            <select name="special" id=""
                                                                class="form-control-sm text-white
                                  @if ($product->is_special == 1) bg-success
                                  @elseif ($product->is_special == 0)
                                  bg-danger @endif
                                "
                                                                onchange="document.getElementById('specialForm{{ $product->id }}').submit();">
                                                                <option value="1"
                                                                    {{ $product->is_special == 1 ? 'selected' : '' }}>
                                                                    Yes
                                                                </option>
                                                                <option value="0"
                                                                    {{ $product->is_special == 0 ? 'selected' : '' }}>
                                                                    No
                                                                </option>
                                                            </select>
                                                        </form>
                                                    </td>
                                                    <td width="15%">
                                                        <a class="btn btn-secondary my-2 btn-sm p-2"
                                                            href="{{ route('user.product.edit', $product->id) . '?language=' . request()->input('language') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form class="deleteform d-inline-block"
                                                            action="{{ route('user.product.delete') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm deletebtn p-2">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
