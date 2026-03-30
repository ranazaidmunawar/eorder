<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting as BS;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class BlogsectionController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        if (empty($request->language)) {
            $data['lang_id'] = 0;
            $data['abs'] = BS::where('user_id', $userId)->firstOrFail();
        } else {
            $lang = Language::where('code', $request->language)->where('user_id', $userId)->firstOrFail();
            $data['lang_id'] = $lang->id;
            $data['abs'] = $lang->basic_setting;
        }
        return view('user.home.blog-section', $data);
    }

    public function update(Request $request, $langid)
    {
        $userId = getRootUser()->id;
        $currentLang = Language::where('user_id', $userId)->where('user_id', $userId)->find($langid);
        $bs = $currentLang->basic_setting;
        $activeTheme = $bs->theme;

        $rules = [

            'blog_section_title' => 'required|max:255'
        ];
        if ($activeTheme == 'fastfood') {
            $rules['blog_section_subtitle'] =  'required|max:80';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = BS::where('language_id', $langid)->where('user_id', $userId)->firstOrFail();

        if ($request->hasFile('blog_section_bg_image')) {
            $bs->blog_section_bg_image = Uploader::upload_picture(Constant::WEBSITE_IMAGE, $request->file('blog_section_bg_image'));
        }

        if ($activeTheme == 'fastfood') {
            $bs->blog_section_subtitle = $request->blog_section_subtitle;
        }
        $bs->blog_section_title = $request->blog_section_title;
        $bs->save();

        Session::flash('success', 'Texts updated successfully!');
        return "success";
    }
}
