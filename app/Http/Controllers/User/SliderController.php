<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Helpers\Uploader;
use App\Models\User\Language;
use App\Models\User\Slider;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();
        $this->authorize('view',$lang);
        $data['sliders'] = Slider::where([
            ['language_id', $lang->id],
            ['user_id', $userId]
        ])
        ->orderBy('id', 'DESC')
        ->get();
        $data['abe'] = $lang->basic_extended;
        $data['lang_id'] = $lang->id;
        return view('user.home.hero.slider.index', $data);
    }

    public function edit($id)
    {
        $userId = getRootUser()->id;
        $data['slider'] = Slider::query()
            ->where('user_id', $userId)
            ->find($id);
        $this->authorize('view', $data['slider']);    
        return view('user.home.hero.slider.edit', $data);
    }


    public function store(Request $request)
    {
        $rules = [
            'user_language_id' => 'required',
            'title' => 'required|max:255',
            'title_font_size' => 'required|numeric|digits_between:1,3',
            'text' => 'required|max:255',
            'text_font_size' => 'required|numeric|digits_between:1,3',
            'button_text_font_size' => 'required|numeric|digits_between:1,3',
            'button_text1_font_size' => 'required|numeric|digits_between:1,3',
            'serial_number' => 'required|integer',
            'main_image' => new ImageMimeTypeRule(),
            'bg_image' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $input = $request->except('user_language_id');
        $input['language_id'] = $request->user_language_id;
        $input['user_id'] = $userId;

        if ($request->hasFile('main_image')) {
            $input['image'] = Uploader::upload_picture(Constant::WEBSITE_SLIDER_IMAGES, $request->file('main_image'));
        }
        if ($request->hasFile('bg_image')) {
            $input['bg_image'] = Uploader::upload_picture(Constant::WEBSITE_SLIDER_BACKGROUND_IMAGES,$request->file('bg_image'));
        }
        $slider = new Slider;
        $slider->create($input);
        Session::flash('success', 'Slider added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'title_font_size' => 'required|numeric|digits_between:1,3',
            'text' => 'required|max:255',
            'text_font_size' => 'required|numeric|digits_between:1,3',
            'button_text_font_size' => 'required|numeric|digits_between:1,3',
            'button_text1_font_size' => 'required|numeric|digits_between:1,3',
            'serial_number' => 'required|integer',
            'main_image' => new ImageMimeTypeRule(),
            'bg_image' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $input = $request->all();

        $slider = Slider::query()
            ->where('user_id', $userId)
            ->findOrFail($request->slider_id);

        if ($request->hasFile('main_image'))
        {
            $input['image'] = Uploader::update_picture(Constant::WEBSITE_SLIDER_IMAGES,$request->file('main_image'),$slider->image);
        }

        if ($request->hasFile('bg_image'))
        {
            $input['bg_image'] = Uploader::update_picture(Constant::WEBSITE_SLIDER_BACKGROUND_IMAGES,$request->file('bg_image'),$slider->bg_image);
        }
        $slider->update($input);
        Session::flash('success', 'Slider updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $slider = Slider::query()
            ->where('user_id', $userId)
            ->findOrFail($request->slider_id);
        Uploader::remove(Constant::WEBSITE_SLIDER_IMAGES,$slider->image);
        Uploader::remove(Constant::WEBSITE_SLIDER_BACKGROUND_IMAGES,$slider->bg_image);
        $slider->delete();
        Session::flash('success', 'Slider deleted successfully!');
        return back();
    }
}
