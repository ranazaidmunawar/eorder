<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicSetting as BS;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomePageTextController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->language)) {
            $data['lang_id'] = 0;
            $data['abs'] = BS::first();
        } else {
            $lang = Language::where('code', $request->language)->first();
            $data['lang_id'] = $lang->id;
            $data['abs'] = $lang->basic_setting;
        }
        return view('admin.home.home-page-text', $data);
    }

    public function update(Request $request, $langid)
    {
        $bs = BS::where('language_id', $langid)->first();
        foreach ($request->types as $type) {
            $bs->$type = $request[$type];
        }
        $bs->save();
        Session::flash('success', 'Text updated successfully!');
        return "success";
    }
}
