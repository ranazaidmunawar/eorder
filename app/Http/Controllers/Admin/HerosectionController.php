<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\BasicExtended;
use App\Models\Language;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class HerosectionController extends Controller
{
    protected string $path ;

    public function __construct()
    {
        $this->path  = 'assets/front/img';
    }

    public function imgtext(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $data['lang_id'] = $lang->id;
        $data['abe'] = $lang->basic_extended;

        return view('admin.home.hero.img-text', $data);
    }

    public function update(Request $request, $langid): JsonResponse|string
    {
        $rules = [
            'image' => new ImageMimeTypeRule(),
            'hero_section_title' => 'nullable|max:255',
            'hero_section_text' => 'nullable|max:255',
            'hero_section_button_text' => 'nullable|max:30',
            'hero_section_button_url' => 'nullable',
            'hero_section_video_url' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $video_url = explode('&',$request->hero_section_video_url);

        $be = BasicExtended::where('language_id', $langid)->first();
        $be->hero_section_title = $request->hero_section_title;
        $be->hero_section_text = $request->hero_section_text;
        $be->hero_section_button_text = $request->hero_section_button_text;
        $be->hero_section_button_url = $request->hero_section_button_url;
        $be->hero_section_video_url = $video_url[0];

        if ($request->hasFile('image')) {
            $be->hero_img =update_picture($this->path,$request->file('image'),$be->hero_img);
        }

        $be->save();
        Session::flash('success', 'Hero Section updated successfully!');
        return "success";
    }

    public function video()
    {
        $data['abe'] = BasicExtended::first();
        return view('admin.home.hero.video', $data);
    }

    public function videoupdate(Request $request): JsonResponse|string
    {
        $rules = [
            'video_link' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $bes = BasicExtended::all();

        $videoLink = $request->video_link;
        if (strpos($videoLink, "&")) {
            $videoLink = substr($videoLink, 0, strpos($videoLink, "&"));
        }

        foreach ($bes as $be) {
            $be->hero_section_video_link = $videoLink;
            $be->save();
        }

        Session::flash('success', 'Informations updated successfully!');
        return "success";
    }
}
