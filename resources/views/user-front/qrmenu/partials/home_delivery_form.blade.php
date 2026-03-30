@php use Illuminate\Support\Facades\Auth; @endphp
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="form shipping-info">
            <div class="shop-title-box">
                <h3>{{$keywords['Shipping Address'] ?? __('Shipping Address')}}</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="field-label">{{$keywords['Country'] ?? __('Country')}} *</div>
                    <div class="field-input">
                        @php
                            $scountry = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $scountry = Auth::guard('client')->user()->shipping_country;
                                }
                            } else {
                                $scountry = old('shipping_country');
                            }
                        @endphp
                        <input type="text" name="shipping_country" value="{{$scountry}}">
                        @error('shipping_country')
                        <p class="text-danger mb-0">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="field-label">{{$keywords['First Name'] ?? __('First Name')}} *</div>
                    <div class="field-input">
                        @php
                            $sfname = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $sfname = Auth::guard('client')->user()->shipping_fname;
                                }
                            } else {
                                $sfname = old('shipping_fname');
                            }
                        @endphp
                        <input type="text" name="shipping_fname" value="{{$sfname}}">
                        @error('shipping_fname')
                        <p class="text-danger">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="field-label">{{$keywords['Last Name'] ?? __('Last Name')}} *</div>
                    <div class="field-input">
                        @php
                            $slname = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $slname = Auth::guard('client')->user()->shipping_lname;
                                }
                            } else {
                                $slname = old('shipping_lname');
                            }
                        @endphp
                        <input type="text" name="shipping_lname" value="{{$slname}}">
                        @error('shipping_lname')
                        <p class="text-danger">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="field-label">{{$keywords['Address'] ?? __('Address')}} *</div>
                    <div class="field-input">
                        @php
                            $saddress = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $saddress = Auth::guard('client')->user()->shipping_address;
                                }
                            } else {
                                $saddress = old('shipping_address');
                            }
                        @endphp
                        <input type="text" name="shipping_address" value="{{$saddress}}">
                        @error('shipping_address')
                        <p class="text-danger">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="field-label">{{$keywords["Town / City"] ??__('Town / City')}} *</div>
                    <div class="field-input">
                        @php
                            $scity = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $scity = Auth::guard('client')->user()->shipping_city;
                                }
                            } else {
                                $scity = old('shipping city');
                            }
                        @endphp
                        <input type="text" name="shipping_city" value="{{$scity}}">
                        @error('shipping_city')
                        <p class="text-danger">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="field-label">{{$keywords["Contact_Email"] ?? __('Contact Email')}} *</div>
                    <div class="field-input">
                        @php
                            $smail = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $smail = Auth::guard('client')->user()->shipping_email;
                                }
                            } else {
                                $smail = old('shipping_email');
                            }
                        @endphp
                        <input type="text" name="shipping_email" value="{{$smail}}">
                        @error('shipping_email')
                        <p class="text-danger">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="field-label">{{$keywords["Phone"] ?? __('Phone')}} *</div>

                    @php
                        $snumber = '';
                        if(empty(old())) {
                            if (Auth::guard('client')->check()) {
                                $snumber = Auth::guard('client')->user()->shipping_number;
                            }
                        } else {
                            $snumber = old('shipping_number');
                        }

                        $sccode = '';
                        if(empty(old())) {
                            if (Auth::guard('client')->check()) {
                                $sccode = Auth::guard('client')->user()->shipping_country_code;
                            }
                        } else {
                            $sccode = old('shipping_country_code');
                        }
                    @endphp
                    <div class="input-group mb-3">
                        <input type="hidden" name="shipping_country_code" value="{{$sccode}}">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary dropdown-toggle shipping_country_code" type="button"
                                    data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">{{!empty($sccode) ? $sccode : $keywords['Select'] ?? __('Select')}}</button>
                            <div class="dropdown-menu country-codes" id="shipping_country_code">
                                @foreach ($ccodes as $ccode)
                                    <a class="dropdown-item" data-shipping_country_code="{{$ccode['code']}}"
                                       href="#">{{$ccode['name']}} ({{$ccode['code']}})</a>
                                @endforeach
                            </div>
                        </div>
                        <input type="text" name="shipping_number" class="form-control" value="{{$snumber}}">
                    </div>
                    @error('shipping_country_code')
                    <p class="text-danger mb-2">{{ $message }}</p>
                    @enderror
                    @error('shipping_number')
                    <p class="text-danger mb-2">{{ $message }}</p>
                    @enderror
                </div>

                @if (($userBs->postal_code == 0 && count($scharges) > 0) || (is_array($packagePermissions) && !in_array('Postal Code Based Delivery Charge',$packagePermissions)) )

                    <div class="col-md-12 mb-4">
                        <div id="shippingCharges">
                            <div class="field-label mb-2">{{$keywords["Shipping_Charges"] ?? __('Shipping Charges')}}
                                *
                            </div>
                            @foreach ($scharges as $scharge)
                                <div class="form-check form-check">
                                    <input class="form-check-input" type="radio"
                                           data="{{!empty($scharge->free_delivery_amount) && cartTotal() >= $scharge->free_delivery_amount ? 0 : $scharge->charge}}"
                                           name="shipping_charge" id="scharge{{$scharge->id}}"
                                           value="{{$scharge->id}}" {{$loop->first ? 'checked' : ''}}>
                                    <label class="form-check-label"
                                           for="scharge{{$scharge->id}}">{{$scharge->title}}</label>
                                    +
                                    <strong>
                                        {{$userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : ''}}{{$scharge->charge}}{{$userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : ''}}
                                    </strong>
                                    @if (!empty($scharge->free_delivery_amount))
                                        (@lang('Free Delivery for Orders over')
                                        {{$userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : ''}}{{$scharge->free_delivery_amount - 1}}{{$userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : ''}}
                                        )
                                    @endif
                                </div>
                                <p class="mb-0 text-secondary pl-3 mb-1"><small>{{$scharge->text}}</small></p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="col-md-12">
                    <div class="form-check form-check-inline mb-3">
                        <input name="same_as_shipping" class="form-check-input ml-0 mr-2" type="checkbox"
                               id="sameAsSHipping" value="1"
                               @guest
                                   @if(empty(old()))
                                       checked
                               @elseif(old('same_as_shipping') == 1)
                                   checked
                               @endif
                               @endguest
                               @auth
                                   @if(old('same_as_shipping') == 1)
                                       checked
                            @endif
                            @endauth
                        >
                        <label class="form-check-label"
                               for="sameAsSHipping">{{$keywords["Billing Address will be Same as Shipping Address"] ?? __('Billing Address will be Same as Shipping Address')}}</label>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" id="billingAddress"
         style="display: {{empty(old()) || old('same_as_shipping') == 1 ? 'none' : 'block'}};">
        <div class="form billing-info">
            <div class="shop-title-box">
                <h3>{{$keywords["Billing Address"] ?? __('Billing Address')}}</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="field-label">{{$keywords["Country"] ?? __('Country')}} *</div>
                    <div class="field-input">
                        @php
                            $bcountry = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $bcountry = Auth::guard('client')->user()->billing_country;
                                }
                            } else {
                                $bcountry = old('billing country');
                            }
                        @endphp
                        <input type="text" name="billing_country" value="{{$bcountry}}">
                        @error('billing_country')
                        <p class="text-danger">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="field-label">{{$keywords["First Name"] ?? __('First Name')}} *</div>
                    <div class="field-input">
                        @php
                            $bfname = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $bfname = Auth::guard('client')->user()->billing_fname;
                                }
                            } else {
                                $bfname = old('billing_fname');
                            }
                        @endphp
                        <input type="text" name="billing_fname" value="{{$bfname}}">
                        @error('billing_fname')
                        <p class="text-danger">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="field-label">{{$keywords["Last Name"] ?? __('Last Name')}} *</div>
                    <div class="field-input">
                        @php
                            $blname = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $blname = Auth::guard('client')->user()->billing_lname;
                                }
                            } else {
                                $blname = old('billing_lname');
                            }
                        @endphp
                        <input type="text" name="billing_lname" value="{{$blname}}">
                        @error('billing_lname')
                        <p class="text-danger">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="field-label">{{$keywords["Address"] ?? __('Address')}} *</div>
                    <div class="field-input">
                        @php
                            $baddress = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $baddress = Auth::guard('client')->user()->billing_address;
                                }
                            } else {
                                $baddress = old('billing_address');
                            }
                        @endphp
                        <input type="text" name="billing_address" value="{{$baddress}}">
                        @error('billing_address')
                        <p class="text-danger">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="field-label">{{$keywords["Town / City"] ?? __('Town / City')}} *</div>
                    <div class="field-input">
                        @php
                            $bcity = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $bcity = Auth::guard('client')->user()->billing_city;
                                }
                            } else {
                                $bcity = old('billing_city');
                            }
                        @endphp
                        <input type="text" name="billing_city" value="{{$bcity}}">
                        @error('billing_city')
                        <p class="text-danger">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="field-label">{{$keywords["Contact_Email"] ?? __('Contact Email')}} *</div>
                    <div class="field-input">
                        @php
                            $bmail = '';
                            if(empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $bmail = Auth::guard('client')->user()->billing_email;
                                }
                            } else {
                                $bmail = old('billing_email');
                            }
                        @endphp
                        <input type="text" name="billing_email" value="{{$bmail}}">
                        @error('billing_email')
                        <p class="text-danger">{{convertUtf8($message)}}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="field-label">{{$keywords["Phone"] ?? __('Phone')}} *</div>

                    @php
                        $bnumber = '';
                        if(empty(old())) {
                            if (Auth::guard('client')->check()) {
                                $bnumber = Auth::guard('client')->user()->billing_number;
                            }
                        } else {
                            $bnumber = old('billing_number');
                        }

                        $bccode = '';
                        if(empty(old())) {
                            if (Auth::guard('client')->check()) {
                                $bccode = Auth::guard('client')->user()->billing_country_code;
                            }
                        } else {
                            $bccode = old('billing_country_code');
                        }
                    @endphp
                    <div class="input-group mb-3">
                        <input type="hidden" name="billing_country_code" value="{{$bccode}}">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary dropdown-toggle billing_country_code" type="button"
                                    data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">{{!empty($bccode) ? $bccode : $keywords['Select'] ?? __('Select')}}</button>
                            <div class="dropdown-menu country-codes" id="billing_country_code">
                                @foreach ($ccodes as $ccode)
                                    <a class="dropdown-item" data-billing_country_code="{{$ccode['code']}}"
                                       href="#">{{$ccode['name']}} ({{$ccode['code']}})</a>
                                @endforeach
                            </div>
                        </div>
                        <input type="text" name="billing_number" class="form-control" value="{{$bnumber}}">
                    </div>
                    @error('billing_country_code')
                    <p class="text-danger mb-2">{{ $message }}</p>
                    @enderror
                    @error('billing_number')
                    <p class="text-danger mb-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>


</div>


@if ($userBs->postal_code == 1 && !empty($pfeatures) && in_array('Postal Code Based Delivery Charge',$pfeatures))
    <div class="row">
        <div class="col-md-12">
            <div class="field-label">{{$keywords["Postal Code"] ?? __('Postal Code')}}
                ({{$keywords["Delivery Area"] ?? __('Delivery Area')}}) *
            </div>
            <div class="field-input">
                @php
                    $snumber = '';
                    if(empty(old())) {
                        if (Auth::guard('client')->check()) {
                            $snumber = Auth::guard('client')->user()->shipping_number;
                        }
                    } else {
                        $snumber = old('shipping_number');
                    }
                @endphp
                <select name="postal_code" class="select2">
                    <option value="" selected
                            disabled>{{$keywords["Select_a_postal_code"] ?? __('Select a postal code')}}</option>
                    @foreach ($postcodes as $postcode)
                        <option value="{{$postcode->id}}"
                                data="{{!empty($postcode->free_delivery_amount) && (cartTotal() >= $postcode->free_delivery_amount) ? 0 : $postcode->charge}}">
                            @if (!empty($postcode->title))
                                {{$postcode->title}} -
                            @endif
                            {{$postcode->postcode}}

                            ({{$keywords["Delivery Charge"] ?? __('Delivery Charge')}}
                            - {{$userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : ''}}{{$postcode->charge}}{{$userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : ''}}
                            @if (!empty($postcode->free_delivery_amount))
                                ,  @lang('Free Delivery for Orders over')
                                {{$userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : ''}}{{$postcode->free_delivery_amount - 1}}{{$userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : ''}}
                            @endif
                            )

                        </option>
                    @endforeach
                </select>
                @error('postal_code')
                <p class="text-danger">{{convertUtf8($message)}}</p>
                @enderror
            </div>
        </div>
    </div>
@endif
@if ($userBe->delivery_date_time_status == 1)
    <div class="row">
        <div class="col-md-6">
            <div
                class="field-label">{{$keywords["Delivery Date"] ?? __('Delivery Date') }} {{$userBe->delivery_date_time_required == 1 ? '*' : ''}}</div>
            <div class="field-input cross {{!empty(old('delivery_date')) ? 'cross-show' : ''}}">
                <input class="form-control delivery-datepicker" type="text" name="delivery_date" autocomplete="off"
                       value="{{old('delivery_date')}}">
                <i class="far fa-times-circle"></i>
                @error('delivery_date')
                <p class="text-danger">{{convertUtf8($message)}}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div
                class="field-label">{{$keywords["Delivery Time"] ??  __('Delivery Time') }} {{$userBe->delivery_date_time_required == 1 ? '*' : ''}}</div>
            <div class="field-input">
                <select id="deliveryTime" class="form-control" name="delivery_time" disabled>
                    <option value="" selected disabled>
                        {{$keywords['Select a time frame'] ?? __('Select a time frame')}}
                    </option>
                </select>
                @error('delivery_time')
                <p class="text-danger">{{convertUtf8($message)}}</p>
                @enderror
            </div>
        </div>
    </div>
@endif
