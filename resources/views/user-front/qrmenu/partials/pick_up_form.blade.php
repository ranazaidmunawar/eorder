@php use Illuminate\Support\Facades\Auth; @endphp
<div class="row">
    <div class="col-12">
        <div class="form billing-info">
            <div class="shop-title-box">
                <h3>{{ $keywords['Information'] ?? __('Information') }}</h3>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="field-label">{{ $keywords['Information'] ?? __('Name') }} *</div>
                    <div class="field-input">
                        @php
                            $bname = '';
                            if (empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $bname = Auth::guard('client')->user()->billing_fname;
                                }
                            } else {
                                $bname = old('billing_fname');
                            }
                        @endphp
                        <input type="text" name="billing_fname" value="{{ $bname }}">
                        @error('billing_fname')
                            <p class="text-danger">{{ convertUtf8($message) }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="field-label">{{ $keywords['Contact_Email'] ?? __('Contact Email') }} *</div>
                    <div class="field-input">
                        @php
                            $bmail = '';
                            if (empty(old())) {
                                if (Auth::guard('client')->check()) {
                                    $bmail = Auth::guard('client')->user()->billing_email;
                                }
                            } else {
                                $bmail = old('billing_email');
                            }
                        @endphp
                        <input type="text" name="billing_email" value="{{ $bmail }}">
                        @error('billing_email')
                            <p class="text-danger">{{ convertUtf8($message) }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="field-label">{{ $keywords['Phone'] ?? __('Phone') }} *</div>

                    @php
                        $bnumber = '';
                        if (empty(old())) {
                            if (Auth::guard('client')->check()) {
                                $bnumber = Auth::guard('client')->user()->billing_number;
                            }
                        } else {
                            $bnumber = old('billing_number');
                        }

                        $bccode = '';
                        if (empty(old())) {
                            if (Auth::guard('client')->check()) {
                                $bccode = Auth::guard('client')->user()->billing_country_code;
                            }
                        } else {
                            $bccode = old('billing_country_code');
                        }
                    @endphp
                    <div class="input-group mb-3">
                        <input type="hidden" name="billing_country_code" value="{{ $bccode }}">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary dropdown-toggle billing_country_code"
                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">{{ !empty($bccode) ? $bccode : $keywords['Select'] ?? __('Select') }}</button>
                            <div class="dropdown-menu country-codes" id="billing_country_code">
                                @foreach ($ccodes as $ccode)
                                    <a class="dropdown-item" data-billing_country_code="{{ $ccode['code'] }}"
                                        href="#">{{ $ccode['name'] }} ({{ $ccode['code'] }})</a>
                                @endforeach
                            </div>
                        </div>
                        <input type="text" name="billing_number" class="form-control" value="{{ $bnumber }}">
                    </div>
                    @error('billing_country_code')
                        <p class="text-danger mb-2">{{ $message }}</p>
                    @enderror
                    @error('billing_number')
                        <p class="text-danger mb-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-md-6">
                    <div class="field-label">{{ $keywords['Pick up Date'] ?? __('Pick up Date') }} *</div>
                    <div class="field-input">
                        <input type="text" class="datepicker" name="pick_up_date" value="{{ old('pick_up_date') }}"
                            autocomplete="off">
                        @error('pick_up_date')
                            <p class="text-danger">{{ convertUtf8($message) }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="field-label">{{ $keywords['Pick up Time'] ?? __('Pick up Time') }} *</div>
                    <div class="field-input">
                        <input type="text" class="timepicker" name="pick_up_time" value="{{ old('pick_up_time') }}"
                            autocomplete="off">
                        @error('pick_up_time')
                            <p class="text-danger">{{ convertUtf8($message) }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
