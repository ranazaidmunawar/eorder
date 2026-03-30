<?php

namespace App\Http\Controllers\User;

use App\Models\User\BasicExtended;
use App\Models\User\BasicSetting;
use App\Models\User\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ContactController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        if (empty($request->language)) {
            $data['lang_id'] = 0;
            $data['abs'] = BasicSetting::query()
                ->where('user_id', $userId)
                ->first();
            $data['abe'] = BasicExtended::query()
                ->where('user_id', $userId)
                ->first();
        } else {
            $lang = Language::query()
                ->where([
                ['code', $request->language],
                ['user_id', $userId]
            ])->first();
           
            $data['lang_id'] = $lang->id;
            $data['abs'] = $lang->basic_setting;
            $data['abe'] = $lang->basic_extended;
        }
        return view('user.contact', $data);
    }

    public function update(Request $request, $langid)
    {
        $request->validate([
            'contact_form_title' => 'max:255',
            'contact_info_title' => 'max:255',
            'contact_text' => 'max:255',
            'longitude' => 'max:255',
            'latitude' => 'max:255',
            'map_zoom' => 'max:255',
        ]);
        $userId = getRootUser()->id;

        $bs = BasicSetting::query()
            ->where([
                ['language_id', $langid],
                ['user_id', $userId]
            ])
            ->first();
        $bs->contact_form_title = $request->contact_form_title;
        $bs->contact_info_title = $request->contact_info_title;
        $bs->contact_text = $request->contact_text;
        $bs->contact_address = $request->contact_address;
        $bs->contact_number = $request->contact_number;
        $bs->contact_mails = $request->contact_mails;
        $bs->latitude = $request->latitude;
        $bs->longitude = $request->longitude;
        $bs->map_zoom = $request->map_zoom ?? 0;

        $bs->save();

        Session::flash('success', 'Contact page updated successfully!');
        return back();
    }
}
