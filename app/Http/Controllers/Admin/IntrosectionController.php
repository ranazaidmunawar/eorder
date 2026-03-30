<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BasicSetting as BS;
use App\Models\Language;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\Session;

class IntrosectionController extends Controller
{
    protected string $path ;

    public function __construct()
    {
        $this->path = 'assets/front/img';
    }

    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        return view('admin.home.intro-section', $data);
    }

    public function update(Request $request, $langId)
    {
        $input = $request->all();
        $bs = BS::where('language_id', $langId)->first();
        $input['intro_text'] = Purifier::clean($request->intro_text, 'youtube');
        $bs->update($input);

        Session::flash('success', 'Intro section updated successfully!');
        return "success";
    }

    public function removeImage(Request $request) {
        $type = $request->type;
        $langId = $request->language_id;
        $bs = BS::query()->where('language_id', $langId)->first();
        if ($type == "signature") {
            deleteFile($this->path,$bs->intro_signature);
            $bs->intro_signature = NULL;
            $bs->save();
        }
        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }
}
