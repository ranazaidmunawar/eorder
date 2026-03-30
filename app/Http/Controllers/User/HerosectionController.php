<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Rules\ImageMimeTypeRule;
use App\Models\User\BasicExtended;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HerosectionController extends Controller
{
    public function imgText(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();
        $data['lang_id'] = $lang->id;
        $data['abe'] = $lang->basic_extended;
        return view('user.home.hero.img-text', $data);
    }

    public function update(Request $request, $langid)
    {
        $userId = Auth::guard('web')->user()->id;
        $currentLang = Language::where('user_id', $userId)->findOrFail($langid);
        $bs = $currentLang->basic_setting;
        $activeTheme = $bs->theme;

        // Image fields mapping
        $imageFields = [
            'hero_image' => 'hero_bg',
            'side_image' => 'hero_side_img',
            'shape_image' => 'hero_shape_img',
            'bottom_image' => 'hero_bottom_img',
            'author_image' => 'author_image',
            'hero_left_image' => 'hero_left_image',
            'hero_right_image' => 'hero_right_image',
            'left_top_shape' => 'left_top_shape',
            'left_bottom_shape' => 'left_bottom_shape',
            'right_top_shape' => 'right_top_shape',
            'right_bottom_shape' => 'right_bottom_shape',
        ];

        $allowedExts = ['jpg', 'png', 'jpeg'];

        // Dynamic image validation
        $rules = [];
        foreach ($imageFields as $requestField => $dbField) {
            $file = $request->file($requestField);
            $rules[$requestField] = [
                function ($attribute, $value, $fail) use ($file, $allowedExts) {
                    if ($file) {
                        $ext = strtolower($file->getClientOriginalExtension());
                        if (!in_array($ext, $allowedExts)) {
                            $fail("Only png, jpg, jpeg images are allowed for {$attribute}");
                        }
                    }
                }
            ];
        }

        // Base text/button rules
        $rules = array_merge($rules, [
            'hero_section_bold_text' => 'nullable|max:255',
            'hero_section_bold_text_color' => 'nullable|max:20',
            'hero_section_text' => 'nullable|max:255',
            'hero_section_text_color' => 'nullable|max:20',
            'hero_section_button_text' => 'nullable|max:30',
            'hero_section_button_color' => 'nullable|max:20',
            'hero_section_button_url' => 'nullable',
            'hero_section_button2_text' => 'nullable|max:30',
            'hero_section_button2_url' => 'nullable',
            'hero_section_person_designation' => 'nullable|max:30',
            'hero_section_person_name' => 'nullable|max:30',
            'hero_section_background_text' => 'nullable|max:191',
        ]);

        // Theme-specific font size rules
        if (!in_array($activeTheme, ['seabbq', 'desifoodie', 'desices'])) {
            $rules['hero_section_bold_text_font_size'] = 'required|numeric|digits_between:1,3';
            $rules['hero_section_button_text_font_size'] = 'required|numeric|digits_between:1,3';
        }

        if (in_array($activeTheme, ['pizza', 'coffee', 'fastfood', 'grocery', 'medicine'])) {
            $rules['hero_section_button2_text_font_size'] = 'required|numeric|digits_between:1,3';
        }

        if ($request->hero_section_background_text) {
            $rules['hero_section_background_text_font_size'] = 'required|numeric|digits_between:1,3';
        }

        if (in_array($activeTheme, ['fastfood', 'pizza', 'grocery', 'medicine', 'coffee', 'bakery'])) {
            $rules['hero_section_text_font_size'] = 'required|numeric|digits_between:1,3';
        }

        // Validate
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $be = BasicExtended::where('language_id', $langid)->where('user_id', $userId)->firstOrFail();

        // Helper function to update fields dynamically
        $setFields = function ($fields) use ($request, $be) {
            foreach ($fields as $field) {
                if ($request->has($field)) {
                    $be->$field = $request->$field;
                }
            }
        };

        // Common fields
        $setFields([
            'hero_section_bold_text',
            'hero_section_bold_text_font_size',
            'hero_section_bold_text_color',
            'hero_section_button_text',
            'hero_section_button_text_font_size',
            'hero_section_button_color',
            'hero_section_button_url',
        ]);

        // Theme-specific fields
        if (in_array($activeTheme, ['fastfood', 'pizza', 'grocery', 'medicine', 'coffee', 'bakery', 'beverage'])) {
            $setFields(['hero_section_text', 'hero_section_text_font_size', 'hero_section_text_color']);
        }

        if (in_array($activeTheme, ['pizza', 'coffee', 'fastfood', 'grocery', 'medicine'])) {
            $setFields(['hero_section_button2_text', 'hero_section_button2_text_font_size', 'hero_section_button2_url', 'hero_section_button_two_color']);
        }

        if ($activeTheme == 'beverage') {
            $be->hero_section_water_shape_text = $request->hero_section_background_text;
            $be->hero_section_water_shape_text_font_size = $request->hero_section_background_text_font_size;
        }
        if ($activeTheme == 'desifoodie' || $activeTheme == 'desices') {
            $be->hero_section_text = $request->hero_section_text;
        }

        if ($activeTheme == 'bakery') {
            $setFields(['hero_section_author_name', 'hero_section_author_designation']);
        }

        if (in_array($activeTheme, ['seabbq', 'desifoodie', 'desices'])) {
            $setFields(['hero_section_button_text1_url', 'hero_section_button2_url', 'hero_section_title', 'hero_section_button2_text']);
        }

        // Upload images dynamically
        foreach ($imageFields as $requestField => $dbField) {
            if ($request->hasFile($requestField)) {
                $be->$dbField = Uploader::update_picture(Constant::WEBSITE_IMAGE, $request->file($requestField), $be->$dbField);
            }
        }

        $be->save();

        Session::flash('success', 'Hero Section updated successfully!');
        return "success";
    }


    public function removeImage(Request $request)
    {
        $lang = Language::where('id', $request->language_id)->where('user_id', Auth::guard('web')->user()->id)->first();

        $type = $request->type;
        $langid = $lang->id;
        $userId = getRootUser()->id;
        $be = BasicExtended::query()
            ->where([
                ['language_id', $langid],
                ['user_id', $userId]
            ])
            ->first();

        if ($type == "background") {
            Uploader::remove(Constant::WEBSITE_IMAGE, $be->hero_bg);
            $be->hero_bg = NULL;
            $be->save();
        }

        if ($type == "side") {
            Uploader::remove(Constant::WEBSITE_IMAGE, $be->hero_side_img);
            $be->hero_side_img = NULL;
            $be->save();
        }

        if ($type == "shape") {
            Uploader::remove(Constant::WEBSITE_IMAGE, $be->hero_shape_img);
            $be->hero_shape_img = NULL;
            $be->save();
        }

        if ($type == "bottom") {
            Uploader::remove(Constant::WEBSITE_IMAGE, $be->hero_bottom_img);
            $be->hero_bottom_img = NULL;
            $be->save();
        }

        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }

    public function video()
    {
        $userId = getRootUser()->id;
        $data['abe'] = BasicExtended::query()
            ->where('user_id', $userId)
            ->first();
        return view('user.home.hero.video', $data);
    }

    public function videoupdate(Request $request)
    {
        $rules = [
            'video_link' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $bes = BasicExtended::query()
            ->where('user_id', $userId)
            ->get();

        $videoLink = $request->video_link;
        if (strpos($videoLink, "&")) {
            $videoLink = substr($videoLink, 0, strpos($videoLink, "&"));
        }

        foreach ($bes as $be) {
            # code...
            $be->hero_section_video_link = $videoLink;
            $be->save();
        }
        Session::flash('success', 'Informations updated successfully!');
        return "success";
    }
}
