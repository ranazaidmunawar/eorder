<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Models\User\IntroPoint;
use App\Models\User\BasicSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class IntroPointController extends Controller
{
    public function index(Request $request)
    {

        $lang = Language::where('code', $request->language)->where('user_id', Auth::guard('web')->user()->id)->first();
        $lang_id = $lang->id;
        $data['features'] = IntroPoint::where('language_id', $lang_id)->where('user_id', Auth::guard('web')->user()->id)->orderBy('id', 'DESC')->get();
        $data['lang_id'] = $lang_id;

        return view('user.home.intro_point.index', $data);
    }

    public function edit($id)
    {
        $data['feature'] = IntroPoint::where('user_id', Auth::guard('web')->user()->id)->findOrFail($id);
        return view('user.home.intro_point.edit', $data);
    }

    public function store(Request $request)
    {

        $messages = [
            'user_language_id.required' => 'The language field is required'
        ];

        $rules = [
            'user_language_id' => 'required',
            'title' => 'required|max:100',
            'serial_number' => 'required|integer',
            'icon' => 'nullable|max:50|string'
        ];

        $user_id = Auth::guard('web')->user()->id;
        $theme = BasicSetting::where('user_id', $user_id)
            ->value('theme');

        if ($theme == 'seabbq') {
            $rules['background_color'] = 'required';
        }
        if ($theme == 'seabbq' || $theme == 'desifoodie' || $theme == 'desices') {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        if ($theme == 'seabbq' || $theme == 'desices') {
            $rules['text'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');

            return response()->json($validator->errors());
        }

        $introPoint = new IntroPoint;
        if ($request->icon) {

            $introPoint->icon = $request->icon;
        }
        $introPoint->language_id = $request->user_language_id;
        $introPoint->title = $request->title;


        if ($request->has('text')) {
            $introPoint->text = $request->text;
        }
        $introPoint->serial_number = $request->serial_number;

        if ($request->has('intro_section_rating_point')) {
            $introPoint->intro_section_rating_point = $request->intro_section_rating_point;
        }
        if ($request->has('intro_section_rating_symbol')) {
            $introPoint->intro_section_rating_symbol = $request->intro_section_rating_symbol;
        }
        if ($theme == 'seabbq' || $theme == 'desifoodie') {
            $introPoint->background_color = $request->background_color;
        }
        if ($theme == 'seabbq' || $theme == 'desifoodie' || $theme == 'desices') {
            if ($request->hasFile('image')) {
                $filename = Uploader::upload_picture(Constant::WEBSITE_INTRO_POINTER_IMAGE, $request->file('image'));
                $introPoint->image = $filename;
            }
        }
        $introPoint->user_id = $user_id;
        $introPoint->save();

        Session::flash('success', 'Intro Point added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'title' => 'required|max:50',
            'serial_number' => 'required|integer',
            'icon' => 'nullable|max:50|string'
        ];

        $user_id = Auth::guard('web')->user()->id;
        $theme = BasicSetting::where('user_id', $user_id)
            ->value('theme');
        if ($theme == 'seabbq') {
            $rules['text'] = 'required';
            $rules['background_color'] = 'required';
        }

        $request->validate($rules);

        $introPoint = IntroPoint::where('user_id', Auth::guard('web')->user()->id)->findOrFail($request->feature_id);
        $introPoint->title = $request->title;
        if ($request->has('icon')) {

            $introPoint->icon = $request->icon;
        }
        if ($request->has('text')) {
            $introPoint->text = $request->text;
        }

        if ($request->has('intro_section_rating_point')) {
            $introPoint->intro_section_rating_point = $request->intro_section_rating_point;
        }
        if ($request->has('intro_section_rating_symbol')) {
            $introPoint->intro_section_rating_symbol = $request->intro_section_rating_symbol;
        }

        if ($theme == 'seabbq' || $theme == 'desifoodie') {
            $introPoint->background_color = $request->background_color;
        }
        if ($theme == 'seabbq' || $theme == 'desifoodie' || $theme == 'desices') {
            if ($request->hasFile('image')) {
                $filename = Uploader::upload_picture(Constant::WEBSITE_INTRO_POINTER_IMAGE, $request->file('image'));
                $introPoint->image = $filename;
            }
        }

        $introPoint->serial_number = $request->serial_number;
        $introPoint->user_id = Auth::guard('web')->user()->id;
        $introPoint->save();

        Session::flash('success', 'Intro Point Updated Successfully!');
        return back();
    }

    public function delete(Request $request)
    {

        $IntroPoint = IntroPoint::where('user_id', Auth::guard('web')->user()->id)->findOrFail($request->feature_id);
        $IntroPoint->delete();
        Session::flash('success', 'Feature deleted successfully!');
        return back();
    }
}
