<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Constants\Constant;
use Illuminate\Support\Str;
use App\Models\User\Product;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Models\User\Pcategory;
use App\Models\User\TimeFrame;
use App\Rules\ImageMimeTypeRule;
use App\Models\User\BasicSetting;
use App\Models\User\ProductImage;
use App\Models\User\PsubCategory;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User\ProductInformation;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\LimitCheckerHelper;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;


class ProductController extends Controller
{
    public function index(Request $request)
    {

        $userId = getRootUser()->id;
        $lang = Language::query()->where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['lang_id'] = $lang->id;

        $data['products'] = DB::table('products')
            ->join('product_informations', 'products.id', '=', 'product_informations.product_id')
            ->join('pcategories', 'pcategories.id', '=', 'product_informations.category_id')
            ->where('product_informations.language_id', '=', $lang->id)
            ->where('product_informations.user_id', '=', $userId)
            ->select(
                'products.id',
                'products.created_at',
                'products.current_price',
                'products.feature_image',
                'products.is_feature',
                'products.is_special',
                'product_informations.title',
                'product_informations.slug',
                'pcategories.name AS category_name'
            )
            ->orderByDesc('products.id')
            ->get();
        return view('user.product.index', $data);
    }


    public function create(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()->where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $categories = Pcategory::query()
            ->where([
                ['user_id', $userId],
                ['language_id', $lang->id],
                ['status', 1]
            ])
            ->get();
        return view('user.product.create', compact('categories'));
    }

    public function sliderStore(Request $request)
    {
        $rules = [
            'file' => new ImageMimeTypeRule(),
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $pi = new ProductImage;
        if (!empty($request->product_id)) {
            $pi->product_id = $request->product_id;
        }
        $pi->image = Uploader::upload_picture(Constant::WEBSITE_PRODUCT_SLIDER_IMAGE, $request->file('file'));
        $pi->user_id = $userId;
        $pi->save();
        return response()->json(['status' => 'success', 'file_id' => $pi->id]);
    }
    public function sliderUpdate(Request $request)
    {
        $userId = getRootUser()->id;
        $pi = ProductImage::query()
            ->where('user_id', $userId)
            ->find($request->product_id);
        //need to work here later

        $pi->user_id = $userId;
        $pi->save();
        return response()->json(['status' => 'success', 'file_id' => $pi->id]);
    }
    public function sliderRemove(Request $request)
    {
        $userId = getRootUser()->id;
        $pi = ProductImage::query()
            ->where('user_id', $userId)
            ->findOrFail($request->fileid);
        Uploader::remove(Constant::WEBSITE_PRODUCT_SLIDER_IMAGE, $pi->image);
        $pi->delete();
        return $pi->id;
    }

    public function getCategory($langid)
    {
        $userId = getRootUser()->id;
        return Pcategory::query()->where([
            ['language_id', $langid],
            ['user_id', $userId],
            ['status', 1]
        ])->get();
    }
    public function getSubcategory($catId, $langId)
    {
        $userId = getRootUser()->id;
        return PsubCategory::query()
            ->where([
                ['user_id', $userId],
                ['category_id', $catId],
                ['status', 1],
                ['language_id', $langId]
            ])
            ->get();
    }


    public function store(StoreRequest $request)
    {

        $userId = getRootUser()->id;
        $languages = Language::query()->where('user_id', $userId)->get();
        $defaultlang = Language::query()->where('user_id', $userId)->first();

        $keywords = [
            'option_name' => [],
            'variation_name' => []
        ];
        $addonkeywords = [
            'addon_name' => [],
        ];
        $variants = [];
        $addons = [];


        if (!empty($request->variation_helper)) {
            $variation_counter = array_count_values($request->variation_helper);

            foreach ($variation_counter as $key => $v_helper) {
                foreach ($languages as $lkey => $value) {
                    if (!empty($request[$value->code . '_options1' . '_' .  $key])) {
                        foreach ($request[$value->code . '_options1' . '_' .  $key] as  $index => $option) {
                            if (empty($option)) {
                                Session::flash('warning', 'Options are missing');
                                return "success";
                            }

                            if ($defaultlang->code . '_' . $request[$value->code . '_options1' . '_' .  $key][$index] == $value->code . '_' . $request[$value->code . '_options1' . '_' .  $key][$index]) {
                                $defaultoption = $request[$value->code . '_options1_' . $key];
                            }

                            $keywords['option_name'][$value->code . '_' . $defaultoption[$index]] =  $option;

                            if ($request[$value->code . '_variation_' . $key] . '_' . $value->code == $request[$value->code . '_variation_' . $key] . '_' . $defaultlang->code) {
                                $variationName = $request[$value->code . '_variation_' . $key];
                                $optionName = $request[$value->code . '_options1' . '_' .  $key][$index];
                                $optionprice = $request['options2' . '_' .  $key][$index];

                                if (!isset($variants[$variationName])) {
                                    $variants[$variationName] = [];
                                }

                                $variants[$variationName][] = [
                                    'name' => $optionName,
                                    'price' => $optionprice
                                ];
                            }
                        }
                    } else {
                        Session::flash('success', 'Variations Updated!');
                        return "success";
                    }
                    if ($defaultlang->code . '_' . $request[$value->code . '_variation_' . $key] == $value->code . '_' . $request[$value->code . '_variation_' . $key]) {

                        $defaultVariation = $request[$value->code . '_variation_' . $key];
                    }
                    $keywords['variation_name'][$value->code . '_' . $defaultVariation] =  $request[$value->code . '_variation_' . $key];
                }
            }
        }


        if (!empty($request->addon_variation_helper)) {
            $addon_variation_helper = array_count_values($request->addon_variation_helper);

            foreach ($addon_variation_helper as $key => $v_helper) {
                foreach ($languages as $lkey => $value) {
                    if (!empty($request[$value->code . '_addonoptions1' . '_' .  $key])) {
                        foreach ($request[$value->code . '_addonoptions1' . '_' .  $key] as $index => $option) {
                            $addon_name =  $option;
                            if ($value->code . $request[$value->code . '_addonoptions1' . $key] == $defaultlang->code . $request[$value->code . '_addonoptions1' . $key]) {
                                $defaultAddon = $option;
                            }
                            $addonkeywords['addon_name'][$value->code . '_' . $defaultAddon] =  $option;

                            if ($request[$value->code . '_addonoptions1' . $key] . '_' . $value->code == $request[$value->code . '_addonoptions1' . $key] . '_' . $defaultlang->code) {
                                $optionprice = $request['addonoptions2_' .  $key][$index];

                                $addons[] = [
                                    'name' => $addon_name,
                                    'price' => floatval($optionprice)
                                ];
                            }
                        }
                    }
                }
            }
        }



        $in[] = $request->all();

        $in['current_price'] = $request->current_price;
        $in['previous_price'] = $request->previous_price;

        if ($request->hasFile('feature_image')) {
            $in['feature_image'] = Uploader::upload_picture(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $request->file('feature_image'));
        }
        !empty($request->variation_helper) ? $in['indx'] = json_encode($request->variation_helper) : null;
        $in['slug'] = make_slug($request->title);
        $in['description'] = Purifier::clean($request->description, 'youtube');
        $in['user_id'] = $userId;

        // store variants as json
        $in['variations'] =  json_encode($variants);
        $in['keywords'] = json_encode($keywords);
        // store addons as json
        $in['addons'] =  json_encode($addons);
        $in['addon_keywords'] = json_encode($addonkeywords);



        $product = Product::create($in);
        $sliders = $request->slider_images;
        $pis = ProductImage::query()
            ->where('user_id', $userId)
            ->findOrFail($sliders);
        foreach ($pis as $pi) {
            $pi->product_id = $product->id;
            $pi->save();
        }


        foreach ($languages as $language) {
            $productInformation = new ProductInformation();
            $productInformation->language_id = $language->id;
            $productInformation->user_id = $userId;
            $productInformation->category_id = $request[$language->code . '_category_id'];
            $productInformation->subcategory_id = $request[$language->code . '_subcategory_id'];
            $productInformation->product_id = $product->id;
            $productInformation->title = $request[$language->code . '_title'];
            $productInformation->slug = make_slug($request[$language->code . '_title']);
            $productInformation->summary = $request[$language->code . '_summary'];
            $productInformation->description = Purifier::clean($request[$language->code . '_description'], 'youtube');
            $productInformation->meta_keywords = $request[$language->code . '_meta_keywords'];
            $productInformation->meta_description = $request[$language->code . '_meta_description'];
            $productInformation->save();
        }
        Session::flash('success', 'Product added successfully!');
        return "success";
    }

    public function edit(Request $request, $id)
    {
        $userId = getRootUser()->id;
        $data['data'] = Product::query()
            ->where('user_id', $userId)
            ->find($id);
        $this->authorize('view', $data['data']);
        return view('user.product.edit', $data);
    }

    public function images($id)
    {
        $userId = getRootUser()->id;
        $userBs = BasicSetting::query()->where('user_id', $userId)->first();
        $productImages = ProductImage::where([
            ['user_id', $userId],
            ['product_id', $id]
        ])->get();
        return $productImages->map(function ($product) use ($userBs) {
            return [
                'id' => $product->id,
                'image' => Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_SLIDER_IMAGE, $product->image, $userBs)
            ];
        });
    }

    public function variants($pid)
    {
        $userId = getRootUser()->id;
        $variations = Product::where('id', $pid)->orderBy('indx')->get();
        $variants = [];
        $languages = Language::where('user_id', $userId)->get();
        $i = 0;
        $v_index = 0;
        foreach ($languages as $lkey => $lvak) {
            return $lvak;
        }
        return response()->json($variants);
    }

    public function addons($pid)
    {
        $userId = getRootUser()->id;
        $addons = Product::query()
            ->where('user_id', $userId)
            ->find($pid)
            ->addons;
        $addonArr = json_decode($addons, true);

        $addons = [];
        if (!is_null($addonArr) > 0) {
            for ($i = 0; $i < count($addonArr); $i++) {
                $addons[$i]['name'] = $addonArr[$i]["name"];
                $addons[$i]['price'] = $addonArr[$i]["price"];
            }
        }
        return response()->json($addons);
    }

    public function update(UpdateRequest $request)
    {


        $userId = getRootUser()->id;
        $in = $request->except('product_id');


        $languages = Language::query()->where('user_id', $userId)->get();
        $defaultlang = Language::query()->where('user_id', $userId)->first();

        $keywords = [
            'option_name' => [],
            'variation_name' => []
        ];
        $addonkeywords = [
            'addon_name' => [],
        ];
        $variants = [];
        $addons = [];


        if (!empty($request->variation_helper)) {
            $variation_counter = array_count_values($request->variation_helper);

            foreach ($variation_counter as $key => $v_helper) {
                foreach ($languages as $lkey => $value) {
                    if (!empty($request[$value->code . '_options1' . '_' .  $key])) {
                        foreach ($request[$value->code . '_options1' . '_' .  $key] as  $index => $option) {
                            if (empty($option)) {
                                Session::flash('warning', 'Options are missing');
                                return "success";
                            }

                            if ($defaultlang->code . '_' . $request[$value->code . '_options1' . '_' .  $key][$index] == $value->code . '_' . $request[$value->code . '_options1' . '_' .  $key][$index]) {

                                $defaultoption = $request[$value->code . '_options1_' . $key];
                            }
                            $keywords['option_name'][$value->code . '_' . $defaultoption[$index]] =  $option;

                            if ($request[$value->code . '_variation_' . $key] . '_' . $value->code == $request[$value->code . '_variation_' . $key] . '_' . $defaultlang->code) {
                                $variationName = $request[$value->code . '_variation_' . $key];
                                $optionName = $request[$value->code . '_options1' . '_' .  $key][$index];
                                $optionprice = $request['options2' . '_' .  $key][$index];

                                if (!isset($variants[$variationName])) {
                                    $variants[$variationName] = [];
                                }

                                $variants[$variationName][] = [
                                    'name' => $optionName,
                                    'price' => $optionprice
                                ];
                            }
                        }
                    } else {
                        Session::flash('success', 'Variations Updated!');
                        return "success";
                    }
                    if ($defaultlang->code . '_' . $request[$value->code . '_variation_' . $key] == $value->code . '_' . $request[$value->code . '_variation_' . $key]) {

                        $defaultVariation = $request[$value->code . '_variation_' . $key];
                    }
                    $keywords['variation_name'][$value->code . '_' . $defaultVariation] =  $request[$value->code . '_variation_' . $key];
                }
            }
        }


        if (!empty($request->addon_variation_helper)) {
            $addon_variation_helper = array_count_values($request->addon_variation_helper);

            foreach ($addon_variation_helper as $key => $v_helper) {
                foreach ($languages as $lkey => $value) {
                    if (!empty($request[$value->code . '_addonoptions1' . '_' .  $key])) {
                        foreach ($request[$value->code . '_addonoptions1' . '_' .  $key] as $index => $option) {
                            $addon_name =  $option;
                            if ($value->code . $request[$value->code . '_addonoptions1' . $key] == $defaultlang->code . $request[$value->code . '_addonoptions1' . $key]) {
                                $defaultAddon = $option;
                            }
                            $addonkeywords['addon_name'][$value->code . '_' . $defaultAddon] =  $option;

                            if ($request[$value->code . '_addonoptions1' . $key] . '_' . $value->code == $request[$value->code . '_addonoptions1' . $key] . '_' . $defaultlang->code) {
                                $optionprice = $request['addonoptions2_' .  $key][$index];

                                $addons[] = [
                                    'name' => $addon_name,
                                   'price' => floatval($optionprice)
                                ];
                            }
                        }
                    }
                }
            }
        }

        $product = Product::query()
            ->where('user_id', $userId)
            ->where('id', $request->product_id)
            ->first();
        if ($request->hasFile('feature_image')) {
            Uploader::remove(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image);
            $in['feature_image'] = Uploader::update_picture(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $request->file('feature_image'), $product->feature_image);
        }
        $in['slug'] = make_slug($request->title);
        $in['description'] = Purifier::clean($request->description, 'youtube');

        // store variants as json
        $in['variations'] =  json_encode($variants);
        $in['keywords'] = json_encode($keywords);
        // store addons as json
        $in['addons'] =  json_encode($addons);
        $in['addon_keywords'] = json_encode($addonkeywords);

        $product->fill($in)->save();


        foreach ($languages as $language) {
            ProductInformation::query()->updateOrCreate([
                'product_id' => $request->product_id,
                'user_id' => $userId,
                'language_id' => $language->id
            ], [
                'category_id' => $request[$language->code . '_category_id'],
                'subcategory_id' => $request[$language->code . '_subcategory_id'],
                'title' => $request[$language->code . '_title'],
                'slug' => make_slug($request[$language->code . '_title']),
                'summary' => $request[$language->code . '_summary'],
                'description' => Purifier::clean($request[$language->code . '_description'], 'youtube'),
                'user_id' => $userId,
                'language_id' => $language->id,
                'meta_keywords' => $request[$language->code . '_meta_keywords'],
                'meta_description' => $request[$language->code . '_meta_description']
            ]);
        }
        Session::flash('success', 'Product updated successfully!');
        return "success";
    }


    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $product = Product::query()
            ->with('product_images')
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('products.user_id', $userId)
            ->where('products.id', $request->product_id)
            ->first();
        foreach ($product->product_images as $pi) {
            Uploader::remove(Constant::WEBSITE_PRODUCT_SLIDER_IMAGE, $pi->image);
            $pi->delete();
        }
        ProductInformation::query()
            ->where('product_id', $request->product_id)
            ->where('user_id', $userId)
            ->delete();
        Uploader::remove(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image);
        $product->query()->find($request->product_id)->delete();
        Session::flash('success', 'Product deleted successfully!');
        return back();
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        $userId = getRootUser()->id;
        foreach ($ids as $id) {
            $product = Product::query()
                ->with('product_images')
                ->join('product_informations', 'products.id', 'product_informations.product_id')
                ->where('products.user_id', $userId)
                ->where('products.id', $id)
                ->first();
            foreach ($product->product_images as $pi) {
                Uploader::remove(Constant::WEBSITE_PRODUCT_SLIDER_IMAGE, $pi->image);
                $pi->delete();
            }
            ProductInformation::query()
                ->where('product_id', $id)
                ->where('user_id', $userId)
                ->delete();
            Uploader::remove(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image);
            $product->query()->find($id)->delete();
        }
        Session::flash('success', 'Product deleted successfully!');
        return "success";
    }

    public function featureCheck(Request $request)
    {
        $userId = getRootUser()->id;
        $id = $request->product_id;
        $value = $request->feature;

        $product = Product::query()
            ->where('user_id', $userId)
            ->findOrFail($id);
        $product->is_feature = $value;
        $product->save();

        Session::flash('success', 'Product updated successfully!');
        return back();
    }

    public function specialCheck(Request $request)
    {
        $userId = getRootUser()->id;
        $id = $request->product_id;
        $value = $request->special;

        $product = Product::query()
            ->where('user_id', $userId)
            ->findOrFail($id);
        $product->is_special = $value;
        $product->save();

        Session::flash('success', 'Product updated successfully!');
        return back();
    }
    public function timeFrames(Request $request)
    {
        $userId = getRootUser()->id;
        $date = Carbon::parse($request->date);
        $day = strtolower($date->format('l'));

        $timeframes = TimeFrame::query()
            ->where('day', $day)
            ->where('user_id', $userId)
            ->get();

        if (count($timeframes) > 0) {
            return response()->json(['status' => 'success', 'timeframes' => $timeframes]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'No delivery time frame is available on ' . ucfirst($day)]);
        }
    }
}
