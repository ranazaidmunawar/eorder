<?php

namespace App\Http\Controllers\Admin;

use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BasicSetting as BS;
use App\Models\BasicExtended;
use App\Models\Language;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;

class FooterController extends Controller
{
    protected string $path ;

    public function __construct()
    {
        $this->path  = 'assets/front/img';
    }

    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $data['lang_id'] = $lang->id;

        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;

        return view('admin.footer.logo-text', $data);
    }

    public function update(Request $request, $langid)
    {
        $rules = [
            'footer_text' => 'nullable|max:255',
            'copyright_text' => 'nullable',
            'file' => new ImageMimeTypeRule(),
            'useful_links_title' => 'nullable|max:50',
            'newsletter_title' => 'nullable|max:50'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = BS::where('language_id', $langid)->first();

        if ($request->hasFile('file')) {
            $bs->footer_logo = update_picture($this->path,$request->file('file'),$bs->footer_logo);
        }

        $bs->footer_text = $request->footer_text;
        $bs->useful_links_title = $request->useful_links_title;
        $bs->newsletter_title = $request->newsletter_title;
        $bs->newsletter_subtitle = $request->newsletter_subtitle;
        $bs->copyright_text = Purifier::clean($request->copyright_text, 'youtube');
        $bs->save();

        Session::flash('success', 'Footer text updated successfully!');
        return "success";
    }

    public function removeImage(Request $request) {
        $type = $request->type;
        $langid = $request->language_id;

        $be = BasicExtended::where('language_id', $langid)->first();

        if ($type == "bottom") {
            deleteFile($this->path,$be->footer_bottom_img);
            $be->footer_bottom_img = NULL;
            $be->save();
        }

        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }
}
