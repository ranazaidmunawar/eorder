<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Timezone;
use App\Models\User\SEO;
use App\Models\Membership;
use App\Constants\Constant;
use App\Models\User\Product;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicExtra;
use App\Models\User\PageHeading;
use App\Rules\ImageMimeTypeRule;
use App\Models\User\BasicSetting;
use App\Models\User\BasicExtended;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\LimitCheckerHelper;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class BasicController extends Controller
{
    public function favicon()
    {
        return view('user.basic.favicon');
    }

    public function updateFav(Request $request)
    {

        $userId = getRootUser()->id;
        $bss = BasicSetting::where('user_id', $userId)->get();
        $basic = BasicSetting::where('user_id', $userId)->select('favicon')->first();

        $rules = [];
        if (!$request->filled('favicon') && is_null($basic->favicon)) {
            $rules['favicon'] = 'required';
        }
        if ($request->hasFile('favicon')) {
            $rules['favicon'] = new ImageMimeTypeRule();
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'favicon']);
        }

        $filename = null;
        if ($request->hasFile('favicon')) {
            $filename = Uploader::update_picture(Constant::WEBSITE_FAVICON, $request->file('favicon'), $basic->favicon);
            Session::flash('success', 'Favicon update successfully.');
        }
        foreach ($bss as $bs) {

            $bs->update(
                [
                    'favicon' => $filename,
                    'user_id' => $userId
                ]
            );
        }

        return "success";
    }

    public function logo()
    {
        return view('user.basic.logo');
    }

    public function updateLogo(Request $request)
    {
        $rules = [];
        $userId = getRootUser()->id;
        $bss = BasicSetting::where('user_id', $userId)->get();
        $basic = BasicSetting::where('user_id', $userId)->select('logo')->first();

        if (!$request->filled('logo') && is_null($basic->logo)) {
            $rules['logo'] = 'required';
        }
        if ($request->hasFile('logo')) {
            $rules['logo'] = new ImageMimeTypeRule();
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'logo']);
        }

        $filename = null;
        if ($request->hasFile('logo')) {
            $filename = Uploader::update_picture(Constant::WEBSITE_LOGO, $request->file('logo'), $basic->logo);
        }

        foreach ($bss as $bs) {
            $bs->update([
                'logo' => $filename,
                'user_id' => $userId,
            ]);
        }
        Session::flash('success', 'Logo update successfully.');
        return "success";
    }

    public function preloader()
    {
        return view('user.basic.preloader');
    }

    public function updatePreloader(Request $request)
    {
        $userId = getRootUser()->id;

        $bss = BasicSetting::where('user_id', $userId)->get();
        $basic = BasicSetting::where('user_id', $userId)->first();

        $rules = ['preloader_status' => 'required'];

        if (!$request->filled('preloader') && is_null($basic->preloader)) {
            $rules['preloader'] = 'required';
        }
        if ($request->hasFile('preloader')) {
            $rules['preloader'] = new ImageMimeTypeRule();
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'preloader']);
        }

        $filename = null;
        if ($request->hasFile('preloader')) {
            $filename = Uploader::update_picture(Constant::WEBSITE_PRELOADER, $request->file('preloader'), $basic->preloader);
        }

        foreach ($bss as $bs) {

            $bs->preloader = $filename;
            $bs->preloader_status = $request->preloader_status;
            $bs->save();
        }


        Session::flash('success', 'Preloader updated successfully.');
        return "success";
    }


    public function basicInfo(Request $request)
    {
        $userId = getRootUser()->id;
        $package = LimitCheckerHelper::getPackageSelectedData($userId, 'features');
        $pfeatures = json_decode($package->features, true);

        $lang = Language::query()->where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;
        $data['timezones'] = Timezone::all();
        $data['features'] = $pfeatures;
        return view('user.basic.basicinfo', $data);
    }

    public function updateBasicInfo(Request $request, $langid)
    {

        $userId = getRootUser()->id;

        $request->validate([
            'website_title' => 'required',
            'base_color' => 'required',
            'office_time' => 'required',
            'base_currency_symbol' => 'required',
            'base_currency_symbol_position' => 'required',
            'base_currency_text' => 'required',
            'base_currency_text_position' => 'required',
            'base_currency_rate' => 'required|numeric',
            'timezone' => 'required'
        ]);

        $bss = BasicSetting::query()->where([
            ['user_id', $userId],
        ])->get();

        foreach ($bss as $bs) {

            $bs->website_title = $request->website_title;
            $bs->base_color = $request->base_color;
            $bs->office_time = $request->office_time;
            $bs->home_version = 'slider';
            $bs->save();
        }

        $bes = BasicExtended::query()->where([
            ['user_id', $userId]
        ])->get();
        foreach ($bes as $be) {

            $be->base_currency_symbol = $request->base_currency_symbol;
            $be->base_currency_symbol_position = $request->base_currency_symbol_position;
            $be->base_currency_text = $request->base_currency_text;
            $be->base_currency_text_position = $request->base_currency_text_position;
            $be->base_currency_rate = $request->base_currency_rate;
            $be->timezone = $request->timezone;
            $be->update();
        }
        Session::flash('success', 'Basic informations updated successfully!');
        return redirect()->back();
    }

    public function themes(Request $request)
    {

        $lang = Language::where('code', $request->language)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();
        $data['abs'] = $lang->basic_setting;

        return view('user.basic.themes', $data);
    }

    public function updateTheme(Request $request)
    {

        $rule = [
            'theme' => 'required'
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $bss = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->get();
        foreach ($bss as $key => $bs) {
            $bs->theme = $request->theme;
            $bs->save();
        }


        $request->session()->flash('success', 'Theme updated successfully!');
        return 'success';
    }

    public function pwa(Request $request)
    {
        $user = User::where('id', Auth::guard('web')->user()->id)->first();

        if (is_null($user->pwa)) {
            $user->update([
                'pwa' => '{
                    "short_name": "",
                    "name": "",
                    "background_color": "#1640D3",
                    "theme_color": "#43D37A",
                    "start_url": ".\/",
                    "display": "standalone",
                    "icons": [
                        {
                        "src": "",
                        "type": "image\/png",
                        "sizes": "128X128"
                        },
                        {
                        "src": "",
                        "type": "image\/png",
                        "sizes": "256X256"
                        },
                        {
                        "src": "",
                        "type": "image\/png",
                        "sizes": "512X512"
                        }
                    ]
                    }'
            ]);
        }
        $data['pwa'] = json_decode($user->pwa, true);

        return view('user.basic.pwa', $data);
    }


    public function updatePwa(Request $request)
    {


        $user = User::findOrFail(Auth::guard('web')->user()->id);


        $request->validate([
            'short_name' => 'required',
            'name' => 'required',
            'theme_color' => 'required',
            'background_color' => 'required',
            'icon_128' => 'image|mimes:png,svg|dimensions:width=128,height=128',
            'icon_256' => 'image|mimes:png,svg|dimensions:width=256,height=256',
            'icon_512' => 'image|mimes:png,svg|dimensions:width=512,height=512'
        ]);
        $content = $request->except('_token', 'icon_128', 'icon_256', 'icon_512', 'pwa_offline_img', 'start_url');
        $content['start_url'] = '';
        $content['display'] = 'standalone';
        $content['theme_color'] = '#' . $request->theme_color;
        $content['background_color'] = '#' . $request->background_color;

        $preManifest = json_decode($user->pwa, true);

        if ($request->hasFile('icon_128')) {

            $ext = $request->icon_128->getClientOriginalExtension();
            $filename =  Uploader::upload_picture(Constant::WEBSITE_PWA_IMAGE, $request->file('icon_128'));
            $content['icons'][0] = [
                "src" => '' . $filename,
                "type" => "image/" . $ext,
                "sizes" => "128X128"
            ];
        } else {
            $content['icons'][0] = [
                "src" => $preManifest['icons'][0]['src'],
                "type" => $preManifest['icons'][0]['type'],
                "sizes" => $preManifest['icons'][0]['sizes']
            ];
        }

        if ($request->hasFile('icon_256')) {

            $ext = $request->icon_256->getClientOriginalExtension();
            $filename =  Uploader::upload_picture(Constant::WEBSITE_PWA_IMAGE, $request->file('icon_256'));
            $content['icons'][1] = [
                "src" =>  "" . $filename,
                "type" => "image/" . $ext,
                "sizes" => "256X256"
            ];
        } else {
            $content['icons'][1] = [
                "src" => $preManifest['icons'][1]['src'],
                "type" => $preManifest['icons'][1]['type'],
                "sizes" => $preManifest['icons'][1]['sizes']
            ];
        }

        if ($request->hasFile('icon_512')) {

            $ext = $request->icon_512->getClientOriginalExtension();
            $filename =  Uploader::upload_picture(Constant::WEBSITE_PWA_IMAGE, $request->file('icon_512'));
            $content['icons'][2] = [
                "src" =>  "" . $filename,
                "type" => "image/" . $ext,
                "sizes" => "512X512"
            ];
        } else {
            $content['icons'][2] = [
                "src" => $preManifest['icons'][2]['src'],
                "type" => $preManifest['icons'][2]['type'],
                "sizes" => $preManifest['icons'][2]['sizes']
            ];
        }


        $user->update([
            'pwa' => json_encode($content)
        ]);

        return back()->with('success', 'Updated Successfully');
    }


    public function updateSlider(Request $request, $lang)
    {
        $userId = getRootUser()->id;
        $be = BasicExtended::where([
            ['language_id', $lang],
            ['user_id', $userId]
        ])->first();

        if ($request->hasFile('slider_shape_img')) {
            $be->slider_shape_img = Uploader::update_picture(Constant::WEBSITE_IMAGE, $request->file('slider_shape_img'), $be->slider_shape_img);
        }

        if ($request->hasFile('slider_bottom_img')) {
            $be->slider_bottom_img = Uploader::update_picture(Constant::WEBSITE_IMAGE, $request->file('slider_bottom_img'), $be->slider_bottom_img);
        }

        $be->save();
        Session::flash('success', 'Slider data updated successfully!');
        return back();
    }

    public function removeSliderImage(Request $request)
    {

        $lang = Language::where('code', $request->language_id)->where('user_id', Auth::guard('web')->user()->id)->first();

        $userId = getRootUser()->id;
        $type = $request->type;
        $langid = $lang->id;

        $be = BasicExtended::where([
            ['language_id', $langid],
            ['user_id', $userId]
        ])->first();

        if ($type == "shape") {
            Uploader::remove(Constant::WEBSITE_IMAGE, $be->slider_shape_img);
            $be->slider_shape_img = NULL;
            $be->save();
        }

        if ($type == "bottom") {
            Uploader::remove(Constant::WEBSITE_IMAGE, $be->slider_bottom_img);
            $be->slider_bottom_img = NULL;
            $be->save();
        }

        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }


    public function support(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        return view('user.basic.support', $data);
    }

    public function updateSupport(Request $request, $langid)
    {
        $userId = getRootUser()->id;

        $request->validate([
            'support_email' => 'required|email|max:100',
            'support_phone' => 'required|max:30',
        ]);

        $bs = BasicSetting::where([
            ['language_id', $langid],
            ['user_id', $userId]
        ])->first();
        $bs->support_email = $request->support_email;
        $bs->support_phone = $request->support_phone;
        $bs->save();

        Session::flash('success', 'Support Informations updated successfully!');
        return back();
    }

    public function breadcrumb()
    {
        return view('user.basic.breadcrumb');
    }

    public function updateBreadcrumb(Request $request)
    {
        $userId = getRootUser()->id;
        $bss = BasicSetting::query()->where('user_id', $userId)->get();
        $basic = BasicSetting::query()->where('user_id', $userId)->select('breadcrumb')->first();
        $rules = [];
        if (!$request->filled('breadcrumb') && is_null($basic->breadcrumb)) {
            $rules['breadcrumb'] = 'required';
        }
        if ($request->hasFile('breadcrumb')) {
            $rules['breadcrumb'] = new ImageMimeTypeRule();
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'breadcrumb']);
        }

        $filename = null;
        if ($request->hasFile('breadcrumb')) {
            $filename = Uploader::update_picture(Constant::WEBSITE_BREADCRUMB, $request->file('breadcrumb'), $basic->breadcrumb);
        }

        foreach ($bss as $bs) {

            $bs->update(
                [
                    'breadcrumb' => $filename,
                    'user_id' => $userId
                ]
            );
        }
        Session::flash('success', 'Breadcrumb update successfully.');
        return "success";
    }

    public function heading(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $page = PageHeading::query()
            ->where([
                ['language_id', $lang->id],
                ['user_id', $userId]
            ])->first();

        $data['lang_id'] = $lang->id;
        $data['pageHead'] = $page;

        return view('user.basic.headings', $data);
    }

    public function updateHeading(Request $request, $langid)
    {
        $userId = getRootUser()->id;

        $page = PageHeading::query()
            ->where([
                ['language_id', $langid],
                ['user_id', $userId]
            ])->first();
        $page->menu_page_title = $request->menu_page_title;
        $page->items_page_title = $request->items_page_title;
        $page->items_details_page_title = $request->items_details_page_title;
        $page->cart_page_title = $request->cart_page_title;
        $page->checkout_page_title = $request->checkout_page_title;
        $page->career_page_title = $request->career_page_title;
        $page->career_details_title = $request->career_details_title;
        $page->gallery_page_title = $request->gallery_page_title;
        $page->error_page_title = $request->error_page_title;
        $page->team_page_title = $request->team_page_title;
        $page->reservation_page_title = $request->reservation_page_title;
        $page->blog_page_title = $request->blog_page_title;
        $page->blog_details_page_title = $request->blog_details_page_title;
        $page->contact_page_title = $request->contact_page_title;
        $page->faq_page_title = $request->faq_page_title;
        $page->forget_password_page_title = $request->forget_password_page_title;
        $page->login_page_title = $request->login_page_title;
        $page->about_page_title = $request->about_page_title;
        $page->signup_page_title = $request->signup_page_title;

        $page->save();

        Session::flash('success', 'Pageheading updated successfully!');
        return back();
    }


    public function plugins()
    {
        $userId = getRootUser()->id;
        $features = LimitCheckerHelper::getPackageSelectedData($userId, 'features');
        $data['features'] = json_decode($features->features, true);

        $data['abex'] = BasicExtra::query()
            ->where('user_id', $userId)
            ->first();
        return view('user.basic.plugins', $data);
    }

    public function updatepusher(Request $request)
    {
        $userId = getRootUser()->id;
        $bes = BasicExtended::query()
            ->where('user_id', $userId)
            ->get();
        foreach ($bes as $be) {

            $be->pusher_app_id = $request->pusher_app_id;
            $be->pusher_app_key = $request->pusher_app_key;
            $be->pusher_app_secret = $request->pusher_app_secret;
            $be->pusher_app_cluster = $request->pusher_app_cluster;
            $be->save();
        }
        Session::flash('success', 'Pusher credentials updated successfully!');
        return back();
    }

    public function updatefblogin(Request $request)
    {
        $userId = getRootUser()->id;
        $bes = BasicExtended::query()
            ->where('user_id', $userId)
            ->get();
        foreach ($bes as $be) {
            $be->is_facebook_login = $request->is_facebook_login;
            $be->facebook_app_id = $request->facebook_app_id;
            $be->facebook_app_secret = $request->facebook_app_secret;
            $be->save();
        }
        Session::flash('success', 'Facebook login credentials updated successfully!');
        return back();
    }

    public function updategooglelogin(Request $request)
    {
        $userId = getRootUser()->id;
        $bes = BasicExtended::query()
            ->where('user_id', $userId)
            ->get();
        foreach ($bes as $be) {
            $be->is_google_login = $request->is_google_login;
            $be->google_client_id = $request->google_client_id;
            $be->google_client_secret = $request->google_client_secret;
            $be->save();
        }

        Session::flash('success', 'Google Login credentials successfully!');
        return back();
    }

    public function updateTwilio(Request $request)
    {
        $userId = getRootUser()->id;
        $bex = BasicExtra::query()
            ->where('user_id', $userId)
            ->first();
        $bex->twilio_sid = $request->twilio_sid;
        $bex->twilio_token = $request->twilio_token;
        $bex->twilio_phone_number = $request->twilio_phone_number;
        $bex->save();

        Session::flash('success', 'Twilio credentials updated successfully!');
        return back();
    }

    public function updateWhatsapp(Request $request)
    {
        $userId = getRootUser()->id;
        $bss = BasicSetting::query()
            ->where('user_id', $userId)
            ->get();
        foreach ($bss as $bs) {
            $bs->is_whatsapp = $request->is_whatsapp;
            $bs->whatsapp_number = $request->whatsapp_number;
            $bs->whatsapp_header_title = $request->whatsapp_header_title;
            $bs->whatsapp_popup_message = $request->whatsapp_popup_message;
            $bs->whatsapp_popup = $request->whatsapp_popup;
            $bs->save();
        }

        Session::flash('success', 'Whatsapp Chat button info updated successfully!');
        return back();
    }

    public function updateTawk(Request $request)
    {
        $userId = getRootUser()->id;
        $bss = BasicSetting::query()
            ->where('user_id', $userId)
            ->get();

        foreach ($bss as $bs) {
            $bs->tawkto_direct_chat_link = $request->tawkto_direct_chat_link;
            $bs->is_tawkto = $request->is_tawkto;
            $bs->save();
        }
        Session::flash('success', 'Tawk.to script updated successfully!');
        return back();
    }

    public function updateDisqus(Request $request)
    {
        $userId = getRootUser()->id;
        $bss = BasicSetting::query()
            ->where('user_id', $userId)
            ->get();

        foreach ($bss as $bs) {
            $bs->is_disqus = $request->is_disqus;
            $bs->disqus_shortname = $request->disqus_shortname;
            $bs->save();
        }

        Session::flash('success', 'Disqus script updated successfully!');
        return back();
    }

    public function updatega(Request $request)
    {
        $userId = getRootUser()->id;
        $bss = BasicSetting::query()
            ->where('user_id', $userId)
            ->get();

        foreach ($bss as $bs) {
            $bs->measurement_id = $request->measurement_id;
            $bs->is_analytics = $request->is_analytics;
            $bs->save();
        }
        Session::flash('success', 'Google Analytics updated successfully!');
        return back();
    }

    public function updaterecaptcha(Request $request)
    {
        $userId = getRootUser()->id;
        $bss = BasicSetting::query()
            ->where('user_id', $userId)
            ->get();

        foreach ($bss as $bs) {
            $bs->is_recaptcha = $request->is_recaptcha;
            $bs->google_recaptcha_site_key = $request->google_recaptcha_site_key;
            $bs->google_recaptcha_secret_key = $request->google_recaptcha_secret_key;
            $bs->save();
        }

        Session::flash('success', 'Google recaptcha credentials updated successfully!');
        return back();
    }

    public function updatepixel(Request $request)
    {

        $userId = getRootUser()->id;
        $bes = BasicExtended::query()
            ->where('user_id', $userId)
            ->get();
        foreach ($bes as $be) {
            $be->pixel_id = $request->pixel_id;
            $be->is_facebook_pixel = $request->is_facebook_pixel ?? 0;
            $be->save();
        }

        Session::flash('success', 'Facebook pixel updated successfully!');
        return back();
    }


    public function maintenance()
    {
        return view('user.basic.maintenance');
    }

    public function updateMaintenance(Request $request)
    {
        $userId = getRootUser()->id;
        $bss = BasicSetting::where('user_id', $userId)->get();
        $basic = BasicSetting::where('user_id', $userId)->first();
        $rules = [];

        if (!$request->filled('maintenance_img') && is_null($basic->maintenance_img)) {
            $rules['maintenance_img'] = 'required';
        }
        if ($request->hasFile('maintenance_img')) {
            $rules['maintenance_img'] = new ImageMimeTypeRule();
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'maintenance_img']);
        }

        $filename = null;
        if ($request->hasFile('maintenance_img')) {
            $filename = Uploader::update_picture(Constant::WEBSITE_MAINTENANCE, $request->file('maintenance_img'), $basic->maintenance_img);
        }


        foreach ($bss as $bs) {
            $bs->update([
                'maintenance_img' => $filename ?? $bs->maintenance_img,
                'maintenance_text' => Purifier::clean($request->maintenance_text, 'youtube'),
                'maintenance_mode' => $request->maintenance_mode,
                'ips' => $request->ips
            ]);
        }

        Session::flash('success', 'Maintenance mode & page updated successfully!');
        return 'success';
    }


    public function sections(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])
            ->first();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;

        return view('user.basic.sections', $data);
    }

    public function updateSections(Request $request, $langid)
    {
        $userId = getRootUser()->id;
        $bs = BasicSetting::where([
            ['language_id', $langid],
            ['user_id', $userId]
        ])->first();
        $bs->update($request->all());

        Session::flash('success', 'Sections customized successfully!');
        return back();
    }


    public function cookieAlert(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()
            ->where('code', $request->language)
            ->where('user_id', $userId)
            ->first();

        $data['lang_id'] = $lang->id;
        $data['abe'] = $lang->basic_extended;
        return view('user.basic.cookie', $data);
    }

    public function updatecookie(Request $request, $langid)
    {
        $userId = getRootUser()->id;
        $request->validate([
            'cookie_alert_status' => 'required',
            'cookie_alert_text' => 'required',
            'cookie_alert_button_text' => 'required|max:255',
        ]);

        $be = BasicExtended::query()
            ->where('user_id', $userId)
            ->where('language_id', $langid)
            ->first();
        $be->cookie_alert_status = $request->cookie_alert_status;
        $be->cookie_alert_text = Purifier::clean($request->cookie_alert_text, 'youtube');
        $be->cookie_alert_button_text = $request->cookie_alert_button_text;
        $be->save();

        Session::flash('success', 'Cookie alert updated successfully!');
        return back();
    }

    public function callWaiter()
    {
        return view('user.basic.callwaiter');
    }

    public function updateCallWaiter(Request $request)
    {
        $userId = getRootUser()->id;
        $rules = [
            'website_call_waiter' => 'required',
            'qr_call_waiter' => 'required',
        ];

        $request->validate($rules);

        $bs = BasicSetting::query()
            ->where('user_id', $userId)
            ->first();
        $bs->website_call_waiter = $request->website_call_waiter;
        $bs->qr_call_waiter = $request->qr_call_waiter;
        $bs->save();
        Session::flash('success', 'Status updated successfully.');
        return back();
    }


    public function tableSection(Request $request)
    {

        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['abs'] = $lang->basic_setting;
        $data['lang_id'] = $lang->id;
        $data['abe'] = $lang->basic_extended;
        return view('user.home.tablesection', $data);
    }

    public function tableSectionUpdate(Request $request, $langid)
    {
        $userId = getRootUser()->id;
        $rules = [
            'table_section_img' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $be = BasicExtended::query()
            ->where([
                ['language_id', $langid],
                ['user_id', $userId]
            ])->first();

        if ($request->hasFile('table_section_img')) {
            $be->table_section_img = Uploader::update_picture(Constant::WEBSITE_IMAGE, $request->file('table_section_img'), $be->table_section_img);
        }

        $be->save();

        Session::flash('success', 'Texts updated successfully!');
        return "success";
    }



    public function specialSection(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['abs'] = $lang->basic_setting;
        $data['lang_id'] = $lang->id;
        $data['abe'] = $lang->basic_extended;

        return view('user.home.specialsection', $data);
    }

    public function specialSectionUpdate(Request $request, $langid)
    {
        $rules = [
            'special_section_title' => 'required|max:255',
        ];

        $allowedExts = ['jpg', 'png', 'jpeg'];

        // List of image fields for validation & update
        $imageFields = [
            'special_right_shape_image',
            'special_left_shape_image',
            'special_section_bg_image',
        ];

        // Add custom validation for all image fields
        foreach ($imageFields as $field) {
            $rules[$field] = [
                function ($attribute, $value, $fail) use ($request, $field, $allowedExts) {
                    if ($request->hasFile($field)) {
                        $ext = $request->file($field)->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;

        $be = BasicExtended::where([
            ['language_id', $langid],
            ['user_id', $userId]
        ])->first();

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $filename = Uploader::update_picture(Constant::WEBSITE_IMAGE, $request->file($field), $be->$field ?? null);
                $be->$field = $filename;
            }
        }

        $be->special_section_title = $request->special_section_title;
        $be->save();

        Session::flash('success', 'Texts updated successfully!');
        return "success";
    }


    public function featuredSection(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['abs'] = $lang->basic_setting;
        $data['lang_id'] = $lang->id;
        $data['abe'] = $lang->basic_extended;

        return view('user.home.featuredsection', $data);
    }

    public function featuredSectionUpdate(Request $request, $langid)
    {
        $rules = [
            'featured_section_title' => 'required|max:255',
        ];

        $allowedExts = ['jpg', 'png', 'jpeg'];

        // List of image fields for validation & update
        $imageFields = [
            'featured_right_shape_image',
            'featured_left_shape_image',
        ];

        // Add custom validation for all image fields
        foreach ($imageFields as $field) {
            $rules[$field] = [
                function ($attribute, $value, $fail) use ($request, $field, $allowedExts) {
                    if ($request->hasFile($field)) {
                        $ext = $request->file($field)->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;

        $be = BasicExtended::where([
            ['language_id', $langid],
            ['user_id', $userId]
        ])->first();

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $filename = Uploader::update_picture(Constant::WEBSITE_IMAGE, $request->file($field), $be->$field ?? null);
                $be->$field = $filename;
            }
        }

        $be->featured_section_title = $request->featured_section_title;
        $be->save();

        Session::flash('success', 'Updated successfully!');
        return "success";
    }


    public function removeImage(Request $request)
    {
        $lang = Language::where('code', $request->language_id)->where('user_id', Auth::guard('web')->user()->id)->first();
        $userId = getRootUser()->id;
        $be = BasicExtended::query()
            ->where([
                ['language_id', $lang->id],
                ['user_id', $userId]
            ])->first();

        if ($request->type == "menu_background") {
            Uploader::remove(Constant::WEBSITE_IMAGE, $be->menu_section_img);
            $be->menu_section_img = NULL;
            $be->save();
        } elseif ($request->type == "table_background") {
            Uploader::remove(Constant::WEBSITE_IMAGE, $be->table_section_img);
            $be->table_section_img = NULL;
            $be->save();
        }

        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }

    public function getMailInformation()
    {
        $userId = getRootUser()->id;
        $data['info'] = BasicSetting::query()
            ->where('user_id', $userId)
            ->select('email', 'from_name')
            ->first();
        $data['infoBe'] = BasicExtended::query()
            ->where('user_id', $userId)
            ->select('from_mail', 'from_name')
            ->first();
        return view('user.basic.email.mail-information', $data);
    }

    public function storeMailInformation(Request $request)
    {
        $userId = getRootUser()->id;
        $request->validate([
            'email' => 'required',
            'from_name' => 'required',
            'from_mail' => 'required',
        ], [
            'email.required' => 'The email field is required',
            'from_name.required' => 'The from name field is required',
            'from_mail.required' => 'The from name field is required',
        ]);
        $info = BasicSetting::where('user_id', $userId)->first();

        $info->email = $request->email;
        $info->from_name = $request->from_name;
        $info->save();
        $be = BasicExtended::where('user_id', $userId)->first();
        $be->from_mail = $request->from_mail;
        $be->save();
        Session::flash('success', 'Mail information saved successfully!');
        return back();
    }
    public function updateAWSCredentials(Request $request)
    {

        $request->validate([
            'aws_access_key_id' => 'required',
            'aws_secret_access_key' => 'required',
            'aws_default_region' => 'required',
            'aws_bucket' => 'required',
        ], [
            'aws_access_key_id' => 'The access key id field is required.',
            'aws_secret_access_key' => 'The secret access key field is required.',
            'aws_default_region' => 'The aws default region field is required.',
            'aws_bucket' => 'The aws bucket field is required.',
        ]);
        $userId = getRootUser()->id;
        $features = LimitCheckerHelper::getPackageSelectedData($userId, 'features');
        $packageF = json_decode($features->features, true);

        if (!empty($packageF) && in_array('Amazon AWS s3', $packageF)) {

            BasicSetting::query()->updateOrInsert(
                ['user_id' => $userId],
                $request->except(['_token', 'user_id']) + [
                    'user_id' => $userId
                ]
            );
            $request->session()->flash('success', 'AWS info updated successfully!');
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
    public function seo(Request $request)
    {
        $userId = getRootUser()->id;
        // first, get the language info from db
        $language = Language::query()
            ->where('code', $request->language)
            ->where('user_id', $userId)
            ->first();

        $langId = $language->id;

        // then, get the seo info of that language from db
        $seo = SEO::query()
            ->where('language_id', $langId)
            ->where('user_id', $userId);

        if ($seo->count() == 0) {
            // if seo info of that language does not exist then create a new one
            SEO::query()
                ->create($request->except('language_id', 'user_id') + [
                    'language_id' => $langId,
                    'user_id' => $userId
                ]);
        }

        $information['language'] = $language;

        // then, get the seo info of that language from db
        $information['data'] = $seo->first();

        // get all the languages from db
        $information['langs'] = Language::query()
            ->where('user_id', $userId)
            ->get();

        return view('user.basic.seo', $information);
    }

    public function updateSEO(Request $request)
    {
        $userId = getRootUser()->id;
        // first, get the language info from db
        $language = Language::query()
            ->where('code', $request->userLanguage)
            ->where('user_id', $userId)
            ->first();
        // then, get the seo info of that language from db
        SEO::query()->updateOrInsert(
            [
                'user_id' => $userId,
                'language_id' => $language->id
            ],
            $request->except(['_token', 'userLanguage']) + [
                'language_id' =>  $language->id,
                'user_id' => $userId
            ]
        );
        $request->session()->flash('success', 'SEO Informations updated successfully!');
        return redirect()->back();
    }

    public function menusection(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::where('code', $request->language)->where('user_id', $userId)->firstOrFail();
        $data['lang_id'] = $lang->id;

        $data['abs'] = $lang->basic_setting;
        $data['lang_id'] = $lang->id;
        $data['abe'] = $lang->basic_extended;
        return view('user.home.menusection', $data);
    }

    public function menusectionUpdate(Request $request, $langid)
    {
        $currentLang = Language::find($langid);
        $bs = $currentLang->basic_setting;


        $img = $request->file('menu_section_img');
        $allowedExts = array('jpg', 'png', 'jpeg');
        $rules = [
            'menu_section_title' => 'required|max:255',
            'menu_section_img' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        if ($bs->theme == "fastfood") {
            $rules['menu_version'] = "required";
            $rules['menu_section_subtitle'] = "required|max:255";
        }


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }


        $be = BasicExtended::where('language_id', $langid)->firstOrFail();

        if ($request->hasFile('menu_section_img')) {
            $filename =  Uploader::update_picture(Constant::WEBSITE_IMAGE, $request->file('menu_section_img'), $be->menu_section_img);
            $be->menu_section_img = $filename;
        }


        $be->menu_version = $request->menu_version;
        $be->menu_section_subtitle = $request->menu_section_subtitle;
        $be->menu_section_title = $request->menu_section_title;
        $be->save();

        Session::flash('success', 'Texts updated successfully!');
        return "success";
    }
}
