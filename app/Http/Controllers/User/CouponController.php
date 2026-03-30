<?php

namespace App\Http\Controllers\User;

use App\Models\User\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class CouponController extends Controller
{
    public function index()
    {
        $userId = getRootUser()->id;
        $data['coupons'] = Coupon::query()
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('user.product.order.coupons.index', $data);
    }

    public function store(Request $request)
    {
     
        $rules = [
            'name' => 'required',
            'code' => [
                'required',
                Rule::unique('user_coupons')->where(function ($query){
                    return $query->where('user_id', Auth::guard('web')->user()->id);
                }),
            ],
            'type' => 'required',
            'value' => 'required',
            'minimum_spend' => 'nullable|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $input = $request->except('_token');
        $input['user_id'] = $userId;
     
        Coupon::create($input);
        Session::flash('success', 'Coupon added successfully!');
        return "success";
    }

    public function edit($id)
    {
        $userId = getRootUser()->id;
        $data['coupon'] = Coupon::query()->where('user_id', $userId)->find($id);
        $this->authorize('view',$data['coupon']);
        return view('user.product.order.coupons.edit', $data);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'code' => [
                'required',
                Rule::unique('user_coupons')->where(function ($query){
                    return $query->where('user_id', Auth::guard('web')->user()->id);
                })->where('id', !$request->coupon_id)
            ],
            'type' => 'required',
            'value' => 'required',
            'minimum_spend' => 'nullable|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $input = $request->except('_token', 'coupon_id');

        $data = Coupon::query()->where('user_id', $userId)->find($request->coupon_id);
        $data->fill($input)->save();

        Session::flash('success', 'Coupon updated successfully!');
        return "success";
    }

    public function delete(Request $request) {
        $userId = getRootUser()->id;
        $coupon = Coupon::query()
            ->where('user_id', $userId)
            ->find($request->coupon_id);
        $coupon->delete();
        $request->session()->flash('success', 'Coupon deleted successfully!');
        return back();
    }
}
