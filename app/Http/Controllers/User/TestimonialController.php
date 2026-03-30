<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Models\User\Testimonial;
use App\Rules\ImageMimeTypeRule;
use App\Models\User\BasicSetting;
use App\Models\User\BasicExtended;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;
        $data['testimonials'] = Testimonial::where([
            ['language_id', $data['lang_id']],
            ['user_id', $userId]
        ])->orderBy('id', 'DESC')->get();

        return view('user.home.testimonial.index', $data);
    }

    public function edit($id)
    {
        $userId = getRootUser()->id;
        $data['testimonial'] = Testimonial::query()
            ->where('user_id', $userId)
            ->find($id);
        $this->authorize('view', $data['testimonial']);
        return view('user.home.testimonial.edit', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'user_language_id' => 'required',
            'comment' => 'required',
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'rating' => 'required|min:1|max:5|numeric',
            'serial_number' => 'required|integer',
            'image' => ['required', new ImageMimeTypeRule()],
        ];
        $message = [];
        $message = [
            'rating.required' => 'rating field is required',
            'rating.min' => 'min 1 and max 5 rating',
            'rating.max' => 'min 1 and max 5 rating',
            'user_language_id.required' => 'The language field is required'
        ];

        $userId = getRootUser()->id;
        $activeTheme = BasicSetting::where([
            ['user_id', $userId],
        ])->value('theme');

        if ($activeTheme == 'desifoodie') {
            $rules['background_image'] = ['required', new ImageMimeTypeRule()];
        }

        if ($activeTheme == 'seabbq' || $activeTheme == 'desifoodie') {
            $message['rank.required'] = 'The designation  field is required';
        }


        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $input = $request->all();
        if ($request->hasFile('image')) {
            $input['image'] = Uploader::upload_picture(Constant::WEBSITE_TESTIMONIAL_IMAGES, $request->file('image'));
        }
        if ($request->hasFile('background_image')) {
            $input['background_image'] = Uploader::upload_picture(Constant::WEBSITE_TESTIMONIAL_IMAGES, $request->file('background_image'));
        }

        $input['user_id'] = $userId;
        $input['language_id'] = $request->user_language_id;
        $testimonial = new Testimonial;
        $testimonial->create($input);
        Session::flash('success', 'Testimonial added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'comment' => 'required',
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'rating' => 'required|min:1|max:5|numeric',
            'serial_number' => 'required|integer',
            'image' => new ImageMimeTypeRule()
        ];
        $message = [];
        $message = [
            'rating.required' => 'rating field is required',
            'rating.min' => 'min 1 and max 5 rating',
            'rating.max' => 'min 1 and max 5 rating'
        ];
        $userId = getRootUser()->id;
        $activeTheme = BasicSetting::where([
            ['user_id', $userId],
        ])->value('theme');

        if ($activeTheme == 'desifoodie') {
            $rules['background_image'] = ['nullable', new ImageMimeTypeRule()];
        }

        if ($activeTheme == 'seabbq' || $activeTheme == 'desifoodie') {
            $message['rank.required'] = 'The designation  field is required';
        }

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $input = $request->all();
        $testimonial = Testimonial::query()
            ->where('user_id', $userId)
            ->findOrFail($request->testimonial_id);
        if ($request->hasFile('image')) {
            $input['image'] = Uploader::update_picture(Constant::WEBSITE_TESTIMONIAL_IMAGES, $request->file('image'), $testimonial->image);
        }
        if ($request->hasFile('background_image')) {
            $input['background_image'] = Uploader::update_picture(Constant::WEBSITE_TESTIMONIAL_IMAGES, $request->file('background_image'), $testimonial->background_image);
        }
        $testimonial->update($input);
        Session::flash('success', 'Testimonial updated successfully!');
        return "success";
    }

    public function textUpdate(Request $request, $langid)
    {

        $userId = getRootUser()->id;
        $bs = BasicSetting::query()
            ->where([
                ['language_id', $langid],
                ['user_id', $userId]
            ])
            ->first();


        if ($request->hasFile('testimonial_bg_img')) {
            $be = BasicExtended::where([
                ['language_id', $langid],
                ['user_id', $userId]
            ])->first();

            $filename = Uploader::update_picture(Constant::WEBSITE_IMAGE, $request->file('testimonial_bg_img'), $be->testimonial_bg_img);
            $be->testimonial_bg_img  = $filename;

            $be->save();
        }

        $bs->save();

        Session::flash('success', 'Text updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $testimonial = Testimonial::query()
            ->where('user_id', $userId)
            ->findOrFail($request->testimonial_id);
        Uploader::remove(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->image);
        $testimonial->delete();
        Session::flash('success', 'Testimonial deleted successfully!');
        return back();
    }

    public function sideContent(Request $request, $langid)
    {
        $userId = Auth::guard('web')->user()->id;
        $bs = BasicSetting::where('language_id', $langid)
            ->where('user_id', $userId)
            ->firstOrFail();

        $allowedExts = ['jpg', 'png', 'jpeg'];

        // List of image fields for validation & update
        $imageFields = [
            'testimonial_side_img',
            'testimonial_section_top_shape_image',
            'testimonial_section_bottom_shape_image',
            'testimonial_left_shape_image',
            'testimonial_right_shape_image',
            'testimonial_bg_image',
        ];

        // Validation rules
        $rules = [
            'testimonial_section_title' => 'required|max:100',
            'testimonial_section_text' => 'nullable|max:200',
        ];

        // Add custom validation for all image fields
        foreach ($imageFields as $field) {
            $rules[$field] = [
                function ($attribute, $value, $fail) use ($request, $field, $allowedExts) {
                    if ($request->hasFile($field)) {
                        $ext = $request->file($field)->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return back()->withErrors($validator->errors());
        }

        // Update basic setting content
        $bs->testimonial_title = $request->testimonial_section_title;
        $bs->testimonial_section_text = $request->testimonial_section_text ?? $bs->testimonial_section_text;
        $bs->save();

        // Update image fields
        $be = BasicExtended::where('language_id', $langid)
            ->where('user_id', $userId)
            ->firstOrFail();

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $filename = Uploader::update_picture(Constant::WEBSITE_IMAGE, $request->file($field), $be->$field ?? null);
                $be->$field = $filename;
            }
        }

        $be->save();

        Session::flash('success', 'Testimonial Section Side Content updated successfully!');
        return back();
    }


    public function removeImage(Request $request)
    {

        $type = $request->type;
        $langid = $request->language_id;

        $be = BasicExtended::where('language_id', $langid)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();

        if ($type == "testimonial_side_img") {

            Uploader::remove(Constant::WEBSITE_IMAGE, $be->testimonial_side_img);
            $be->testimonial_side_img = NULL;
            $be->save();
        }
        if ($type == 'testimonial_bg_img') {

            Uploader::remove(Constant::WEBSITE_IMAGE, $be->testimonial_bg_img);
            $be->testimonial_bg_img = null;
            $be->save();
        }

        if ($type == 'testimonial_section_top_shape_image') {

            Uploader::remove(Constant::WEBSITE_IMAGE, $be->testimonial_section_top_shape_image);
            $be->testimonial_section_top_shape_image = null;
            $be->save();
        }
        if ($type == 'testimonial_section_bottom_shape_image') {

            Uploader::remove(Constant::WEBSITE_IMAGE, $be->testimonial_section_bottom_shape_image);
            $be->testimonial_section_bottom_shape_image = null;
            $be->save();
        }
        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }
}
