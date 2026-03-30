<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\LimitCheckerHelper;
use App\Http\Helpers\Uploader;
use App\Models\User\Language;
use App\Models\User\Pcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $data['languages'] = Language::query()
            ->where('user_id', $userId)
            ->get();
        $lang = Language::query()
            ->where([
                ['code', $request->language],
                ['user_id', $userId]
            ])
            ->first();
        $lang_id = $lang->id;
        $data['pcategories'] = Pcategory::where([
            ['language_id', $lang_id],
            ['user_id', $userId]
        ])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $data['lang_id'] = $lang_id;

        return view('user.product.category.index', $data);
    }
    public function store(Request $request)
    {

        $userId = getRootUser()->id;

        $rules = [
            'status' => 'required',
            'tax' => 'nullable|numeric',
        ];

        $messages = [];
        $languages = Language::where('user_id', $userId)->get();

        foreach ($languages as $language) {
            $rules[$language->code . '_name'] = 'required|max:255';

            $messages[$language->code . '_name.required'] = 'The name field is required for ' . $language->name . ' language';
        }


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $image = null;
        if ($request->hasFile('image')) {
            $image = Uploader::upload_picture(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $request->file('image'));
        }
        $uid = uniqid();

        foreach ($languages as $language) {
            $Pcategory = new Pcategory();
            $Pcategory->name = $request[$language->code . '_name'];
            $Pcategory->language_id  = $language->id;
            $Pcategory->status  = $request->status;
            $Pcategory->slug  = make_slug($request[$language->code . '_name']);
            $Pcategory->tax  = empty($request->tax) ? 0.00 : $request->tax;
            $Pcategory->user_id  = $userId;
            $Pcategory->image  = $image;
            $Pcategory->indx  = $uid;
            $Pcategory->save();
        }


        Session::flash('success', 'Category added successfully!');
        return "success";
    }
    public function edit($id)
    {
        $userId = getRootUser()->id;

        $data['languages'] = Language::where('user_id', $userId)->get();
        $data['data'] = Pcategory::query()
            ->where('user_id', $userId)
            ->find($id);
              
        return view('user.product.category.edit', $data);
    }
    public function update(Request $request)
    {
        $userId = getRootUser()->id;

        $rules = [
            'status' => 'required',
            'tax' => 'nullable|numeric',
        ];

        $messages = [];
        $languages = Language::where('user_id', $userId)->get();

        foreach ($languages as $language) {
            $rules[$language->code . '_name'] = 'required|max:255';

            $messages[$language->code . '_name.required'] = 'The name field is required for ' . $language->name . ' language';
        }


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }


        $Pcat = Pcategory::query()
            ->where('user_id', $userId)
            ->where('indx', $request->category_indx)->first();


        $image = null;
        if ($request->hasFile('image')) {
            $image = Uploader::update_picture(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $request->file('image'), $Pcat->image);
        }

        foreach ($languages as $language) {
            $Pcategory = Pcategory::query()
                ->where('user_id', $userId)
                ->where('indx', $request->category_indx)->where('language_id', $language->id)->first();

            $Pcategory->name = $request[$language->code . '_name'];
            $Pcategory->language_id  = $language->id;
            $Pcategory->status  = $request->status;
            $Pcategory->slug  = make_slug($request[$language->code . '_name']);
            $Pcategory->tax  = empty($request->tax) ? 0.00 : $request->tax;
            $Pcategory->user_id  = $userId;
            $Pcategory->image  = $request->hasFile('image') ?  $image : $Pcategory->image;
            $Pcategory->update();
        }
        Session::flash('success', 'Category Update successfully!');
        return "success";
    }
    public function delete(Request $request)
    {

        $userId = getRootUser()->id;
        $catIndxs = Pcategory::query()
            ->where('user_id', $userId)
            ->where('indx', $request->indx)->get();
        foreach ($catIndxs as $catIndx) {

            $category = Pcategory::query()
                ->where('user_id', $userId)
                ->findOrFail($catIndx->id);
            if ($category->subcategories()->count() > 0) {
                Session::flash('warning', 'First, delete all the subcategories under the selected categories!');
                return back();
            }
            if ($category->productInformation()->count() > 0) {
                Session::flash('warning', 'First, delete all the product under the selected categories!');
                return back();
            }
            Uploader::remove(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $category->image);
            $category->delete();
            Session::flash('success', 'Category deleted successfully!');
        }
        return back();
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
       
        $userId = getRootUser()->id;
        foreach ($ids as $id) {

            $categoryIndxs = Pcategory::query()
                ->where('user_id', $userId)
                ->where('indx', $id)->get();

            foreach ($categoryIndxs as $categoryIndx) {

                $pcategory = Pcategory::query()
                    ->where('user_id', $userId)
                    ->findOrFail($categoryIndx->id);
               
                if ($pcategory->subcategories()->count() > 0) {
                    Session::flash('warning', 'First, delete all the subcategories under the selected categories!');
                    return 'success';
                }
                if ($pcategory->productInformation()->count() > 0) {
                    Session::flash('warning', 'First, delete all the product under the selected categories!');
                    return "success";
                }
                Uploader::remove(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $pcategory->image);
                $pcategory->delete();
            }
        }
        Session::flash('success', 'product categories deleted successfully!');
        return "success";
    }
    public function featureCheck(Request $request)
    {
        $userId = getRootUser()->id;

        $languages = Language::where('user_id', $userId)->get();

        foreach ($languages as $language) {
            Pcategory::where('language_id', $language->id)->where('indx', $request->pcategory_indx)->update(['is_feature' => $request->feature]);
        }

        Session::flash('success', 'Product category updated successfully!');
        return back();
    }
    public function removeImage(Request $request)
    {
       
        $type = $request->type;
        $pcatid = $request->pcategory_id;
        $userId = getRootUser()->id;
        $pcategory = Pcategory::query()
            ->where('user_id', $userId)
            ->findOrFail($pcatid);
        if ($type == "pcategory") {
            Uploader::remove(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $pcategory->image);
            $pcategory->image = NULL;
            $pcategory->save();
        }
        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }
}
