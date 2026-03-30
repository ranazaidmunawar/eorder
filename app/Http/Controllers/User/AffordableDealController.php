<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Models\User\Product;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Models\User\AffordableDeal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AffordableDealController extends Controller
{
    public function index(Request $request)
    {

        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['lang_id'] = $lang->id;
        $data['abe'] = AffordableDeal::where('language_id', $lang->id)->where('user_id', $userId)->first();

        $data['products'] = Product::query()
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('status', 1)
            ->where('products.user_id', $userId)
            ->where('product_informations.language_id', $lang->id)
            ->orderBy('products.created_at', 'desc')
            ->select(
                'products.id',
                'product_informations.title',
            )
            ->get();

        return view('user.home.affordabledeals', $data);
    }


    public function update(Request $request, $lang_id)
    {
        $data = $request->validate([
            'section_title' => 'nullable|string|max:255',
            'section_items' => 'nullable|array',
            'left_shape_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'right_shape_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $abe = AffordableDeal::firstOrNew(['language_id' => $lang_id]);

        if ($request->hasFile('left_shape_image')) {
            $data['left_shape_image'] = Uploader::upload_picture(Constant::WEBSITE_IMAGE, $request->file('left_shape_image'));
        }

        if ($request->hasFile('right_shape_image')) {
            $data['right_shape_image'] = Uploader::upload_picture(Constant::WEBSITE_IMAGE, $request->file('right_shape_image'));
        }

        if ($request->hasFile('background_image')) {
            $data['background_image'] = Uploader::upload_picture(Constant::WEBSITE_IMAGE, $request->file('background_image'));
        }

        $data['language_id'] = $lang_id;
        $data['section_items'] = json_encode($request->section_items);
        $data['user_id'] = getRootUser()->id;

        $abe->fill($data)->save();

        Session::flash('success', 'Updated successfully!');
        return "success";
    }
}
