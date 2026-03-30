<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Language;
use App\Models\User\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ShopSettingController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $lang_id = $lang->id;
        $data['shippings'] = ShippingCharge::query()
            ->where([
                ['user_id', $userId],
                ['language_id', $lang_id]
            ])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $data['lang_id'] = $lang_id;
        return view('user.shipping_charge.index', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'user_language_id' => 'required',
            'title' => 'required',
            'text' => 'nullable|max:255',
            'charge' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $input = $request->all();
        $userId = getRootUser()->id;
        $data = new ShippingCharge;
        $input['user_id'] = $userId;
        $input['language_id'] = $request->user_language_id;
        $data->create($input);

        Session::flash('success', 'Shipping Charge added successfully!');
        return "success";
    }

    public function edit($id)
    {
        $userId = getRootUser()->id;
        $shipping = ShippingCharge::query()
            ->where('user_id', $userId)
            ->find($id);
        $this->authorize('view', $shipping);    
        return view('user.shipping_charge.edit', compact('shipping'));
    }

    public function update(Request $request)
    {
        $rules = [
            'user_language_id' => 'required',
            'title' => 'required',
            'text' => 'nullable|max:255',
            'charge' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $data = ShippingCharge::query()
            ->where('user_id', $userId)
            ->findOrFail($request->shipping_id);
        $data->update($request->except('user_language_id')+[
            'language_id' => $request->user_language_id,
        ]);

        Session::flash('success', 'Shipping charge updated successfully!');
        return "success";
    }


    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $data = ShippingCharge::query()
            ->where('user_id', $userId)
            ->findOrFail($request->shipping_id);
        $data->delete();
        Session::flash('success', 'Shipping charge delete successfully!');
        return back();
    }
}
