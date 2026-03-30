<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Models\User\Pcategory;
use App\Models\User\PsubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\LimitCheckerHelper;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProductSubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['languages'] = Language::where([
            ['user_id', $userId]
        ])->get();

        $lang_id = $lang->id;
        $data['categories'] = Pcategory::where([
            ['language_id', $lang_id],
            ['user_id', $userId],
            ['status', 1]
        ])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $data['psubcategories'] = PsubCategory::where([
            ['language_id', $lang_id],
            ['user_id', $userId]
        ])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $data['lang_id'] = $lang_id;
        return view('user.product.subcategory.index', $data);
    }

    public function store(Request $request)
    {
        $userId = getRootUser()->id;
        $languages = Language::where('user_id', $userId)->get();
        $rules = [
            'category_id' => 'required',
            'status' => 'required',
        ];
        $messages = ['category_id.required' => 'The category field is required'];

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

        $uid = uniqid();

        $categoryId = Pcategory::where('indx', $request->category_id)->pluck('id');

        foreach ($languages as $key => $language) {

            $PsubCategory = new PsubCategory();
            $PsubCategory->name = $request[$language->code . '_name'];
            $PsubCategory->language_id  = $language->id;
            $PsubCategory->category_id  = $categoryId[$key];
            $PsubCategory->status  = $request->status;
            $PsubCategory->slug  = make_slug($request[$language->code . '_name']);
            $PsubCategory->user_id  = $userId;
            $PsubCategory->indx  = $uid;
            $PsubCategory->save();
        }

        Session::flash('success', 'Subcategory added successfully!');
        return "success";
    }

    public function edit($id)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()
            ->where([
                ['code', request('language')],
                ['user_id', $userId]
            ])
            ->first();

        $data['languages'] = Language::where('user_id', $userId)->get();

        $data['data'] = PsubCategory::query()
            ->where('user_id', $userId)
            ->find($id);

        $this->authorize('view', $data['data']);
        $data['categories'] = Pcategory::query()
            ->where([
                ['language_id', $lang->id],
                ['user_id', $userId],
                ['status', 1],
            ])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('user.product.subcategory.edit', $data);
    }

    public function update(Request $request)
    {
        $userId = getRootUser()->id;
        $languages = Language::where('user_id', $userId)->get();

        $rules = [
            'category_id' => 'required',
            'status' => 'required',
        ];
        $messages = [
            'category_id.required' => 'The category field is required'
        ];
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

        $data = PsubCategory::findOrFail($request->subcategory_id);
        $indx = is_null($data->indx) ? uniqid() : $data->indx;
        $category = Pcategory::where('id', $request->category_id)->first();
        $category_indx = $category->indx;

        foreach ($languages as $language) {

            $PsubCategory = PsubCategory::where('id', $request[$language->code . '_id'])->first();

            if (empty($PsubCategory)) {
                $PsubCategory = new PsubCategory();
            }

            $category = Pcategory::where([['indx', $category_indx], ['language_id', $language->id]])->first();

            $PsubCategory->name = $request[$language->code . '_name'];
            $PsubCategory->language_id  = $language->id;
            $PsubCategory->category_id  =  $category->id;
            $PsubCategory->status  = $request->status;
            $PsubCategory->slug  = make_slug($request[$language->code . '_name']);
            $PsubCategory->user_id  = $userId;
            $PsubCategory->update();
        }

        Session::flash('success', 'Subcategory Updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $subIndxs = PsubCategory::query()
            ->where('user_id', $userId)
            ->where('indx', $request->indx)->get();

        foreach ($subIndxs as $subIndx) {

            $category = PsubCategory::query()
                ->where('user_id', $userId)
                ->findOrFail($subIndx->id);
            if ($category->product_informations()->count() > 0) {

                Session::flash('warning', 'First, delete all the product under the selected sub categories!');
                return back();
            }
            $category->delete();
            Session::flash('success', 'Subcategory deleted successfully!');
        }
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $userId = getRootUser()->id;
        $ids = $request->ids;
        foreach ($ids as $id) {

            $subIndxs = PsubCategory::query()
                ->where('user_id', $userId)
                ->where('indx', $id)->get();

            foreach ($subIndxs as $subIndx) {

                $pcategory = PsubCategory::query()
                    ->where('user_id', $userId)
                    ->findOrFail($subIndx->id);
                if ($pcategory->product_informations()->count() > 0) {
                    Session::flash('warning', 'First, delete all the product under the selected sub categories!');
                    return "success";
                }
                $pcategory->delete();
            }
        }
        Session::flash('success', 'Subcategories deleted successfully!');
        return "success";
    }

    public function featureCheck(Request $request)
    {
        $userId = getRootUser()->id;

        $languages = Language::where('user_id', $userId)->get();

        foreach ($languages as $language) {
            PsubCategory::where('language_id', $language->id)->where('indx', $request->subcategory_indx)->update(['is_feature' => $request->feature]);
        }

        Session::flash('success', 'Product subcategory updated successfully!');
        return back();
    }
}
