<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Helpers\Uploader;
use App\Models\User\Feature;
use App\Models\User\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\BasicSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class FeatureController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $this->authorize('view',$lang);
        $lang_id = $lang->id;
        $data['features'] = Feature::query()->where([
            ['language_id', $lang_id],
            ['user_id', $userId]
        ])
        ->orderBy('id', 'DESC')
        ->get();
        
        $data['lang_id'] = $lang_id;
        
        if($lang_id){
            $data['code'] = Language::where('id', $lang_id)->first()->code; 
        }
        else{
            $data['code'] = Language::where('is_default', 1)->first()->code;
        }
        
        $data['abs'] = $lang->basic_setting;
        return view('user.home.feature.index', $data);
    }

    public function edit($id)
    {
        $userId = getRootUser()->id;
        $data['feature'] = Feature::query()
            ->where('user_id', $userId)
            ->find($id);
        $this->authorize('view', $data['feature'])  ;  
        return view('user.home.feature.edit', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'user_language_id.required' => 'The language field is required'
        ];

        $rules = [
            'user_language_id' => 'required',
            'title' => 'required|max:50',
            'serial_number' => 'required|integer',
            'image' => [
                'required',
                new ImageMimeTypeRule()
            ]
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        if ($request->hasFile('image')) {
            $image = Uploader::upload_picture(Constant::WEBSITE_FEATURE_IMAGES,$request->file('image'));
        }else{
            $image = null;
        }
        $userId = getRootUser()->id;
        $feature = new Feature;
        $feature->image = $image;
        $feature->language_id = $request->user_language_id;
        $feature->title = $request->title;
        $feature->serial_number = $request->serial_number;
        $feature->user_id = $userId;
        $feature->save();

        Session::flash('success', 'Feature added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'title' => 'required|max:50',
            'serial_number' => 'required|integer',
            'image' => new ImageMimeTypeRule(),
        ];

        $request->validate($rules);
        $userId = getRootUser()->id;
        $feature = Feature::query()
            ->where('user_id', $userId)
            ->findOrFail($request->feature_id);

        if ($request->hasFile('image')) {
            $feature->image = Uploader::update_picture(Constant::WEBSITE_FEATURE_IMAGES,$request->file('image'),$feature->image);
        }
        $feature->title = $request->title;
        $feature->serial_number = $request->serial_number;
        $feature->save();

        Session::flash('success', 'Feature updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $feature = Feature::query()
            ->where('user_id', $userId)
            ->findOrFail($request->feature_id);
        Uploader::remove(Constant::WEBSITE_FEATURE_IMAGES,$feature->image);
        $feature->delete();

        Session::flash('success', 'Feature deleted successfully!');
        return back();
    }

    public function removeImage(Request $request) 
    {
        $userId = getRootUser()->id;
        $lang = Language::where('code', $request->language_id)->where('user_id', $userId)->first();
        $type = $request->type;
        $featId = $request->feature_id;
        $userId = getRootUser()->id;
        $feature = Feature::query()
            ->where('user_id', $userId)->where('language_id', $lang->id)
            ->findOrFail($featId);
            

        if ($type == "feature") {
            Uploader::remove(Constant::WEBSITE_FEATURE_IMAGES,$feature->image);
            $feature->image = NULL;
            $feature->save();
        }

        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }

    public function featureSection(Request $request, $langid)
    {
        $userId = getRootUser()->id;
        $currentLang = Language::where('user_id',$userId)->find($langid);
        $bs = $currentLang->basic_setting;
        $activeTheme = $bs->theme;

        $features_section_top_shape_image = $request->file('features_section_top_shape_image');
        $features_section_bottom_shape_image = $request->file('features_section_bottom_shape_image');

        $allowedExts = array('jpg', 'png', 'jpeg');
        $rules = [
            'features_section_top_shape_image' => [
                function ($attribute, $value, $fail) use ($request, $features_section_top_shape_image, $allowedExts) {
                    if ($request->hasFile('features_section_top_shape_image')) {
                        $ext = $features_section_top_shape_image->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
            'features_section_bottom_shape_image' => [
                function ($attribute, $value, $fail) use ($request, $features_section_bottom_shape_image, $allowedExts) {
                    if ($request->hasFile('features_section_bottom_shape_image')) {
                        $ext = $features_section_bottom_shape_image->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],

        ];

        $rules['feature_title'] = 'required';
        // if($activeTheme == 'coffee' || $activeTheme == 'beverage'){
        //     $rules['features_section_bg_color'] = 'required';
        // }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return back()->withErrors($validator->errors());
            // $errmsgs = $validator->getMessageBag()->add('error', 'true');
            // return response()->json($validator->errors());
        }

        $bs = BasicSetting::where('language_id', $langid)->where('user_id',$userId)->firstOrFail();

        $bs->feature_title = $request->feature_title;

        // if($activeTheme == 'coffee' || $activeTheme == 'beverage'){
        //     $bs->features_section_bg_color =$request->features_section_bg_color;
        // }

        if ($request->hasFile('features_section_top_shape_image')) {

            $filename =  Uploader::upload_picture(Constant::WEBSITE_IMAGE,$request->file('features_section_top_shape_image'));
            $bs->features_section_top_shape_image = $filename;
        }
        if ($request->hasFile('features_section_bottom_shape_image')) {
            $filename =  Uploader::upload_picture(Constant::WEBSITE_IMAGE, $request->file('features_section_bottom_shape_image'));
            $bs->features_section_bottom_shape_image = $filename;
        }


        $bs->save();
        Session::flash('success', 'Feature Section updated successfully!');
        return back();
    }
   
    public function featuresSectionRmvImg(Request $request)
    {
        $userId = getRootUser()->id;
        $type = $request->type;

        $lang = Language::where('code', $request->language_id)->where('user_id', $userId)->first();
        $langid = $lang->id;


        $bs = BasicSetting::where('language_id', $langid)->where('user_id', $userId)->firstOrFail();

        if ($type == "features_section_top_shape_image") {
            @unlink(public_path("assets/front/img/" . $bs->features_section_top_shape_image));
            $bs->features_section_top_shape_image = NULL;
            $bs->save();
        }

        if ($type == "features_section_bottom_shape_image") {
            @unlink(public_path("assets/front/img/" . $bs->features_section_bottom_shape_image));
            $bs->features_section_bottom_shape_image = NULL;
            $bs->save();
        }

        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }
}
