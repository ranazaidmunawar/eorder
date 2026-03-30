<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Models\User\Language;
use App\Models\User\PostalCode;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PostalCodeController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()
            ->where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $lang_id = $lang->id;
        $data['postcodes'] = PostalCode::query()
            ->where([
                ['language_id', $lang_id],
                ['user_id', $userId]
            ])
            ->orderBy('id', 'DESC')
            ->get();

        $data['lang_id'] = $lang_id;

        return view('user.postcodes.index', $data);
    }

    public function store(Request $request)
    {
      
        $messages = [
            'user_language_id.required' => 'The language field is required'
        ];

        $rules = [
            'user_language_id' => 'required',
            'title' => 'required|max:255',
            'postcode' => [
                'required',
                Rule::unique('postal_codes')->where(function ($query) {
                    return $query->where('user_id', Auth::guard('web')->user()->id);
                })
            ],
            'charge' => 'required|numeric',
            'serial_number' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $postalCode = new PostalCode;
        $postalCode->language_id = $request->user_language_id;
        $postalCode->user_id = $userId;
        $postalCode->title = $request->title;
        $postalCode->postcode = $request->postcode;
        $postalCode->charge = $request->charge;
        $postalCode->free_delivery_amount = $request->free_delivery_amount;
        $postalCode->serial_number = $request->serial_number;
        $postalCode->save();

        Session::flash('success', 'Postal Code added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'postcode' => [
                'required',
                Rule::unique('postal_codes')->where(function ($query) {
                    return $query->where('user_id', Auth::guard('web')->user()->id);
                })->where('id', !$request->postcode_id)
            ],
            'charge' => 'required|numeric',
            'serial_number' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $postalCode = PostalCode::query()
            ->where('user_id', $userId)
            ->findOrFail($request->postcode_id);
        $postalCode->title = $request->title;
        $postalCode->postcode = $request->postcode;
        $postalCode->charge = $request->charge;
        $postalCode->free_delivery_amount = $request->free_delivery_amount;
        $postalCode->serial_number = $request->serial_number;
        $postalCode->save();

        Session::flash('success', 'Postal code updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $postalCode = PostalCode::query()
            ->where('user_id', $userId)
            ->findOrFail($request->postcode_id);
        $postalCode->delete();

        Session::flash('success', 'Postal Code deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $userId = getRootUser()->id;
        $ids = $request->ids;
        foreach ($ids as $id) {
            $postalCode = PostalCode::query()
                ->where('user_id', $userId)
                ->findOrFail($id);
            $postalCode->delete();
        }
        Session::flash('success', 'Postal Codes deleted successfully!');
        return "success";
    }
}
