<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicExtended;
use App\Models\User\BasicSetting;
use App\Models\User\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;

class FooterController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()
            ->where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;
        return view('user.footer.logo-text', $data);
    }

    public function update(Request $request, $langid)
    {
        $rules = [
            'footer_text' => 'required|max:255',
            'copyright_text' => 'required',
            'file' => new ImageMimeTypeRule(),
            'footer_bottom_img' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $bs = BasicSetting::where([
            ['language_id', $langid],
            ['user_id', $userId]
        ])->first();

        if ($request->hasFile('footer_logo')) {
            $bs->footer_logo = Uploader::update_picture(Constant::WEBSITE_IMAGE,$request->file('footer_logo'),$bs->footer_logo);
        }
        if ($request->hasFile('footer_bottom_img')) {
            $be = BasicExtended::query()->where([
                ['language_id', $langid],
                ['user_id', $userId]
            ])->first();
            $be->footer_bottom_img = Uploader::update_picture(Constant::WEBSITE_IMAGE,$request->file('footer_bottom_img'),$be->footer_bottom_img);
            $be->save();
        }
        $bs->footer_text = $request->footer_text;
        $bs->copyright_text = Purifier::clean($request->copyright_text, 'youtube');
        $bs->save();

        Session::flash('success', 'Footer text updated successfully!');
        return "success";
    }

    public function removeImage(Request $request) 
    {
        
        $lang = Language::where('code',$request->language_id)->where('user_id',Auth::guard('web')->user()->id)->first();
        $type = $request->type;
        $userId = getRootUser()->id;
        $be = BasicExtended::where([
            ['language_id', $lang->id],
            ['user_id', $userId]
        ])->first();
        if ($type == "bottom") {
            Uploader::remove(Constant::WEBSITE_IMAGE,$be->footer_bottom_img);
            $be->footer_bottom_img = NULL;
            $be->save();
        }
        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }
}
