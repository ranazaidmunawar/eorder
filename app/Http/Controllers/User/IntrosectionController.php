<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Rules\ImageMimeTypeRule;
use App\Models\User\BasicSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class IntrosectionController extends Controller
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

        return view('user.home.intro-section', $data);
    }

    public function update(Request $request, $langid)
    {
        $userId = getRootUser()->id;

        $bs = BasicSetting::where([
            ['language_id', $langid],
            ['user_id', $userId],
        ])->firstOrFail();

        $activeTheme = $bs->theme;
        $allowedExts = ['jpg', 'png', 'jpeg'];

        // File fields
        $fileFields = [
            'intro_main_image',
            'intro_signature',
            'intro_video_image',
            'author_image',
            'intro_section_author_image',
            'intro_left_side_image',
            'intro_right_side_image',
            'intro_section_top_shape_image',
            'intro_section_bottom_shape_image',
        ];

        // Validation rules
        $rules = [
            'intro_title'                         => 'required|max:255',
            'intro_text'                          => $activeTheme !== 'grocery' ? 'required|max:1000' : 'nullable|max:1000',
            'intro_section_highlight_text'        => 'nullable|max:1000',
            'intro_section_video_button_text'     => 'nullable|max:100',
            'intro_section_video_button_title'    => 'nullable|max:100',
            'intro_video_link'                    => 'nullable|max:191',
            'intro_contact_text'                  => 'nullable|max:255',
            'intro_contact_number'                => 'nullable|max:191',
            'intro_section_author_name'           => 'nullable|max:30',
            'intro_section_author_designation'    => 'nullable|max:50',
            'intro_section_button_text'           => 'nullable|max:50',
            'intro_section_button_url'            => 'nullable|max:191',
        ];

        // Dynamically add image validation closures
        foreach ($fileFields as $field) {
            $rules[$field] = [
                function ($attribute, $value, $fail) use ($request, $field, $allowedExts) {
                    if ($request->hasFile($field)) {
                        $ext = strtolower($request->file($field)->getClientOriginalExtension());
                        if (!in_array($ext, $allowedExts)) {
                            $fail('Only png, jpg, jpeg image is allowed');
                        }
                    }
                },
            ];
        }

        // Validate request
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        // Update text fields
        $textFields = [
            'intro_title',
            'intro_text',
            'intro_section_highlight_text',
            'intro_section_video_button_text',
            'intro_section_video_button_title',
            'intro_video_link',
            'intro_contact_text',
            'intro_contact_number',
            'intro_section_author_name',
            'intro_section_author_designation',
            'intro_section_button_text',
            'intro_section_button_url',
        ];

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                $bs->{$field} = $request->input($field, '');
            }
        }

        // Handle file uploads
        $input = $request->all();
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $input[$field] = Uploader::update_picture(
                    Constant::WEBSITE_IMAGE,
                    $request->file($field),
                    $bs->{$field}
                );
            }
        }

        // Update database
        $bs->update($input);

        Session::flash('success', 'Data updated successfully!');
        return 'success';
    }


    public function removeImage(Request $request)
    {
        $lang = Language::where('id', $request->language_id)->where('user_id', Auth::guard('web')->user()->id)->first();
        $userId = getRootUser()->id;
        $bs = BasicSetting::where([
            ['language_id', $lang->id],
            ['user_id', $userId]
        ])->first();
        if ($request->type == "signature") {
            Uploader::remove(Constant::WEBSITE_IMAGE, $bs->intro_signature);
            $bs->intro_signature = NULL;
            $bs->save();
        }
        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }
}
