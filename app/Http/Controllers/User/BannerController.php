<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Models\User\Banner;
use App\Models\User\Product;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Models\User\BannerSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Show banner list.
     */
    public function index(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $language = Language::where([['code', $request->language], ['user_id', $user_id]])->firstOrFail();

        $data['banners'] = Banner::where([['user_id', $user_id], ['language_id', $language->id]])
            ->latest()
            ->get();

        $data['userLangs'] = Language::where('user_id', $user_id)->get();

        //get banner section data if theme is [desifoodie]
        $activeTheme = BasicSetting::query()
            ->where('user_id', $user_id)
            ->value('theme');
        if ($activeTheme == 'desifoodie') {
            $data['bannerSection'] = BannerSection::where('language_id', $language->id)
                ->where('user_id', $user_id)
                ->first();

            $data['selectedItems'] = json_decode(@$data['bannerSection']->items, true) ?? [];

            $data['products'] = Product::query()
                ->join('product_informations', 'products.id', 'product_informations.product_id')
                ->where('status', 1)
                ->where('products.user_id', $user_id)
                ->where('product_informations.language_id', $language->id)
                ->orderBy('products.id', 'desc')
                ->select('products.id', 'product_informations.title')
                ->get();
            $data['banner'] = Banner::where([['user_id', $user_id], ['language_id', $language->id]])->first();
        }


        $data['showRight'] = $data['banners']->where('position', 'Right')->count() == 0 ? true : false;
        $data['showLeft'] = $data['banners']->where('position', 'Left')->count() == 0 ? true : false;

        return view('user.home.banner.index', $data);
    }

    /**
     * update banner section
     */
    public function updateBannerSection(Request $request)
    {

        $user_id = Auth::guard('web')->user()->id;
        $language = Language::where([['code', $request->language], ['user_id', $user_id]])->firstOrFail();

        //store banner information for theme [desifoodie]
        $activeTheme = BasicSetting::query()
            ->where('user_id', $user_id)
            ->value('theme');
        if ($activeTheme == 'desifoodie') {
            $banner = Banner::where([
                ['user_id', $user_id],
                ['language_id', $language->id]
            ])->first();

            // Validation rules
            $rules = [
                'banner_title' => 'required',
                'banner_subtitle' => 'required',
                'button_text' => 'required',
                'button_url' => 'required',
                'banner_text' => 'required',
            ];


            if (!$banner || empty($banner->image)) {
                $rules['banner_image'] = 'required';
            } else {
                $rules['banner_image'] = 'nullable';
            }

            $request->validate($rules);

            if (!$banner) {
                $banner = new Banner();
            }

            $banner->user_id = $user_id;
            $banner->language_id = $language->id;
            $banner->title = $request->banner_title;
            $banner->subtitle = $request->banner_subtitle;
            $banner->text = $request->banner_text;
            $banner->button_text = $request->button_text;
            $banner->button_url = $request->button_url;
            $banner->position = 'left';
            $banner->status = 1;
            $banner->serial_number = 1;

            // Image upload
            if ($request->hasFile('banner_image')) {
                $banner->image = Uploader::upload_picture(
                    Constant::WEBSITE_BANNER_IMAGE,
                    $request->file('banner_image')
                );
            }

            $banner->save();
        }

        $bannerSection = BannerSection::where('language_id', $language->id)
            ->where('user_id', $user_id)
            ->first();
        if (is_null($bannerSection)) {
            $bannerSection = new BannerSection();
        }
        $bannerSection->language_id = $language->id;
        $bannerSection->user_id = $user_id;
        $bannerSection->title = $request->title;
        $bannerSection->items = json_encode($request->items);
        $bannerSection->save();

        session()->flash('success', 'Banner section updated successfully!');
        return "success";
    }

    /**
     * Store banner.
     */
    public function store(Request $request)
    {
        $rules = [
            'user_language_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            'button_text' => 'required|max:255',
            'button_url' => 'required',
            'position' => 'required',
            'status' => 'required',
        ];


        $userId = Auth::guard('web')->user()->id;
        $activeTheme = BasicSetting::query()
            ->where('user_id', $userId)
            ->value('theme');

        if ($activeTheme == 'desifoodie') {
            $rules['text'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }


        $banner = new Banner();
        $banner->user_id = $userId;
        $banner->language_id = $request->user_language_id;
        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->text = $request->text;
        $banner->button_text = $request->button_text;
        $banner->button_url = $request->button_url;
        $banner->position = $request->position;
        $banner->status = $request->status;
        $banner->serial_number = 1;

        // image upload
        if ($request->hasFile('image')) {
            $banner->image = Uploader::upload_picture(Constant::WEBSITE_BANNER_IMAGE, $request->file('image'));
        }

        $banner->save();

        session()->flash('success', 'Added successfully!');
        return "success";
    }

    /**
     * Edit banner
     */
    public function edit($id)
    {
        $data['banner'] = Banner::findOrFail($id);
        return view('user.home.banner.edit', $data);
    }

    /**
     * Update banner.
     */
    public function update(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            'button_text' => 'required|max:255',
            'button_url' => 'required',
            'position' => 'required',
            'status' => 'required',
        ];

        $userId = Auth::guard('web')->user()->id;
        $activeTheme = BasicSetting::query()
            ->where('user_id', $userId)
            ->value('theme');

        if ($activeTheme == 'desifoodie') {
            $rules['text'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }


        $banner = Banner::where([['id', $request->banner_id], ['user_id', $userId]])->firstOrFail();
        $banner->user_id = $userId;
        $banner->language_id = $banner->language_id;
        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->text = $request->text;
        $banner->button_text = $request->button_text;
        $banner->button_url = $request->button_url;
        $banner->position = $banner->position;
        $banner->status = $request->status;
        $banner->serial_number = 1;

        if ($request->hasFile('image')) {
            $banner->image = Uploader::update_picture(Constant::WEBSITE_BANNER_IMAGE, $request->file('image'), $banner->image);
        }

        $banner->save();
        session()->flash('success', 'Updated successfully!');
        return "success";
    }

    /**
     * Delete banner.
     */
    public function delete(Request $request)
    {
        $request->validate([
            'banner_id' => 'required|exists:banners,id',
        ]);

        $user_id = Auth::guard('web')->user()->id;
        $banner = Banner::where([['id', $request->banner_id], ['user_id', $user_id]])->firstOrFail();

        Uploader::remove(Constant::WEBSITE_BANNER_IMAGE, $banner->image);
        $banner->delete();

        session()->flash('success', 'Deleted successfully!');
        return back();
    }
}
