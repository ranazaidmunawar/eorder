<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Models\User\BasicExtended;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TopHeaderController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_extended;

        return view('user.home.top-header-section', $data);
    }

    public function update(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $langid = Language::where([['code', $request->language], ['user_id', $userId]])->value('id');

        $bex = BasicExtended::query()
            ->where('user_id', $userId)
            ->where('language_id', $langid)
            ->first();

        $bex->top_header_middle_text = $request->top_header_middle_text;
        $bex->top_header_support_text = $request->top_header_support_text;
        $bex->top_header_support_email = $request->top_header_support_email;
        $bex->save();

        Session::flash('success', 'Data updated successfully!');
        return 'success';
    }
}
