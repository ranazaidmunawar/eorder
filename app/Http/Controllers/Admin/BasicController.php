<?php

namespace App\Http\Controllers\Admin;

use App\Models\Seo;
use App\Models\Language;
use App\Models\Timezone;
use App\Models\BasicSetting;
use Illuminate\Http\Request;
use App\Models\BasicExtended;
use App\Rules\ImageMimeTypeRule;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\LimitCheckerHelper;
use Illuminate\Support\Facades\Validator;

class BasicController extends Controller
{
    protected string $path ;

    public function __construct()
    {
        $this->path = 'assets/front/img';
    }

    public function favicon()
    {
        return view('admin.basic.favicon');
    }

    public function updateFav(Request $request)
    {
        $rules = [
            'favicon' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'favicon']);
        }

        if ($request->hasFile('favicon')) {
            $filename = upload_picture($this->path,$request->file('favicon'));
            $bss = BasicSetting::all();
            foreach ($bss as $bs) {
                deleteFile($this->path,$bs->favicon);
                $bs->favicon = $filename;
                $bs->save();
            }
        }
        Session::flash('success', 'Favicon update successfully.');
        return back();
    }

    public function logo()
    {
        return view('admin.basic.logo');
    }

    public function updateLogo(Request $request)
    {
        $rules = [
            'file' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'logo']);
        }

        if ($request->hasFile('file')) {
            $filename = upload_picture($this->path,$request->file('file'));
            $bss = BasicSetting::all();
            foreach ($bss as $bs) {
                // only remove the previous image, if it is not the same as default image or the first image is being updated
                deleteFile($this->path,$bs->logo);
                $bs->logo = $filename;
                $bs->save();
            }
        }
        Session::flash('success', 'Logo update successfully.');
        return back();
    }

    public function preloader()
    {
        return view('admin.basic.preloader');
    }

    public function updatePreloader(Request $request)
    {
        $rules = [
            'preloader_status' => 'required',
            'file' => new ImageMimeTypeRule(),
        ];

        $request->validate($rules);

        $bss = BasicSetting::all();

        if ($request->hasFile('file')) {
            $filename = upload_picture($this->path,$request->file('file'));
        }

        foreach ($bss as $bs) {
            $bs->preloader_status = $request->preloader_status;
            if ($request->hasFile('file')) {
                deleteFile($this->path,$bs->preloader);
                $bs->preloader = $filename;
            }
            $bs->save();
        }
        Session::flash('success', 'Preloader updated successfully.');
        return back();
    }


    public function basicinfo()
    {
        $data['abs'] = BasicSetting::first();
        $data['abe'] = BasicExtended::first();
        $data['timezones'] = Timezone::all();
        return view('admin.basic.basicinfo', $data);
    }

    public function updateBasicInfo(Request $request)
    {
        $request->validate([
            'website_title' => 'required',
            'timezone' => 'required',
            'base_color' => 'required',
            'base_color2' => 'required',
            'base_currency_symbol' => 'required',
            'base_currency_symbol_position' => 'required',
            'base_currency_text' => 'required',
            'base_currency_text_position' => 'required',
            'base_currency_rate' => 'required|numeric',
            'max_video_size' => 'required|numeric',
            'max_file_size' => 'required|numeric'
        ]);

        $bss = BasicSetting::all();
        foreach ($bss as $bs) {
            $bs->website_title = $request->website_title;
            $bs->base_color = $request->base_color;
            $bs->base_color2 = $request->base_color2;
            $bs->save();
        }

        $bes = BasicExtended::all();
        foreach ($bes as $be) {
            $be->base_currency_symbol = $request->base_currency_symbol;
            $be->base_currency_symbol_position = $request->base_currency_symbol_position;
            $be->base_currency_text = $request->base_currency_text;
            $be->base_currency_text_position = $request->base_currency_text_position;
            $be->base_currency_rate = $request->base_currency_rate;
            $be->timezone = $request->timezone;
            $be->max_video_size = $request->max_video_size;
            $be->max_file_size = $request->max_file_size;
            $be->save();
        }
        // set timezone in .env
        if ($request->has('timezone') && $request->filled('timezone')) {
            $arr = ['TIMEZONE' => $request->timezone];
            setEnvironmentValue($arr);
            Artisan::call('config:clear');
        }
        Session::flash('success', 'Basic informations updated successfully!');
        return back();
    }


    public function updateslider(Request $request, $lang)
    {
        $be = BasicExtended::where('language_id', $lang)->first();
        if ($request->hasFile('slider_shape_img')) {
            $be->slider_shape_img = update_picture($this->path,$request->file('slider_shape_img'),$be->slider_shape_img);
        }

        if ($request->hasFile('slider_bottom_img')) {
            $be->slider_bottom_img = update_picture($this->path,$request->file('slider_bottom_img'),$be->slider_shape_img);
        }

        $be->save();
        Session::flash('success', 'Slider data updated successfully!');
        return back();
    }

    public function breadcrumb()
    {
        return view('admin.basic.breadcrumb');
    }

    public function updateBreadcrumb(Request $request)
    {
        $rules = [
            'file' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'breadcrumb']);
        }
        if ($request->hasFile('file')) {
            $filename = upload_picture($this->path,$request->file('file'));
            $bss = BasicSetting::all();
            foreach ($bss as $bs) {
                deleteFile($this->path,$bs->breadcrumb);
                $bs->breadcrumb = $filename;
                $bs->save();
            }
        }
        Session::flash('success', 'Breadcrumb update successfully.');
        return back();
    }


    public function script()
    {
        $data = BasicSetting::first();
        return view('admin.basic.scripts', ['data' => $data]);
    }

    public function updateScript(Request $request)
    {

        $bss = BasicSetting::all();

        foreach ($bss as $bs) {

            $bs->aws_access_key_id = $request->aws_access_key_id; 
            $bs->aws_secret_access_key = $request->aws_secret_access_key; 
            $bs->aws_default_region = $request->aws_default_region; 
            $bs->aws_bucket = $request->aws_bucket; 

            $bs->tawkto_chat_link = $request->tawkto_chat_link;
            $bs->is_tawkto = $request->is_tawkto;

            $bs->is_disqus = $request->is_disqus;
            $bs->is_user_disqus = $request->is_user_disqus;
            $bs->disqus_shortname = $request->disqus_shortname;

            $bs->is_recaptcha = $request->is_recaptcha;
            $bs->google_recaptcha_site_key = $request->google_recaptcha_site_key;
            $bs->google_recaptcha_secret_key = $request->google_recaptcha_secret_key;

            $bs->is_whatsapp = $request->is_whatsapp;
            $bs->whatsapp_number = $request->whatsapp_number;
            $bs->whatsapp_header_title = $request->whatsapp_header_title;
            $bs->whatsapp_popup_message = Purifier::clean($request->whatsapp_popup_message,'youtube');
            $bs->whatsapp_popup = $request->whatsapp_popup;
            $bs->save();
        }

        Session::flash('success', 'Plugins updated successfully!');
        return back();
    }


    public function maintenance()
    {
        $data = BasicSetting::select(
            'maintainance_mode',
            'maintenance_img',
            'maintenance_status',
            'maintainance_text',
            'secret_path'
        )->first();

        return view('admin.basic.maintainance', ['data' => $data]);
    }

    public function updateMaintenance(Request $request)
    {
        $rules = [
            'file' => new ImageMimeTypeRule(),
            'maintenance_status' => 'required',
            'maintainance_text' => 'required'
        ];

        $message = [
            'maintainance_text.required' => 'The maintenance message field is required.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $bss = BasicSetting::query()->get();
        // first, get the maintenance image from db
        if ($request->hasFile('file')) {
            deleteFile($this->path,$bss[0]->maintenance_img);
            $filename = upload_picture($this->path,$request->file('file'));
        }
        foreach ($bss as $bs){
            $bs->maintenance_img = $request->hasFile('file') ? $filename : $bs->maintenance_img;
            $bs->maintenance_status = $request->maintenance_status;
            $bs->maintainance_text = Purifier::clean($request->maintainance_text, 'youtube');
            $bs->secret_path = $request->secret_path;
            $bs->save();
        }
        $down = "down";
        if ($request->filled('secret_path')) {
            $down .= " --secret=" . $request->secret_path;
        }

        if ($request->maintenance_status == 1) {
            Artisan::call('up');
            Artisan::call($down);
        } else {
            Artisan::call('up');
        }

        Session::flash('success', 'Maintenance Info updated successfully!');
        return redirect()->back();
    }

    public function sections()
    {
        $data['abs'] = BasicSetting::first();
        return view('admin.home.sections', $data);
    }

    public function updateSections(Request $request)
    {
        $bss = BasicSetting::all();
        foreach ($bss as $bs) {
            $bs->update($request->all());
        }
        Session::flash('success', 'Sections customized successfully!');
        return back();
    }


    public function cookieAlert(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $data['lang_id'] = $lang->id;
        $data['abe'] = $lang->basic_extended;

        return view('admin.basic.cookie', $data);
    }

    public function updateCookie(Request $request, $langid)
    {
        $request->validate([
            'cookie_alert_status' => 'required',
            'cookie_alert_text' => 'required',
            'cookie_alert_button_text' => 'required|max:25',
        ]);

        $be = BasicExtended::where('language_id', $langid)->first();
        $be->cookie_alert_status = $request->cookie_alert_status;
        $be->cookie_alert_text = Purifier::clean($request->cookie_alert_text, 'youtube');
        $be->cookie_alert_button_text = $request->cookie_alert_button_text;
        $be->save();

        Session::flash('success', 'Cookie alert updated successfully!');
        return back();
    }

    public function seo(Request $request)
    {
      // first, get the language info from db
      $language = Language::where('code', $request->language)->first();
      $langId = $language->id;

      // then, get the seo info of that language from db
      $seo = Seo::where('language_id', $langId);

      if ($seo->count() == 0) {
        // if seo info of that language does not exist then create a new one
        Seo::create($request->except('language_id') + [
          'language_id' => $langId
        ]);
      }

      $information['language'] = $language;
      // then, get the seo info of that language from db
      $information['data'] = $seo->first();
      // get all the languages from db
      $information['langs'] = Language::all();
      return view('admin.basic.seo', $information);
    }

    public function updateSEO(Request $request)
    {
      // first, get the language info from db
      $language = Language::where('code', $request->language)->first();
      $langId = $language->id;

      // then, get the seo info of that language from db
      $seo = SEO::where('language_id', $langId)->first();

      // else update the existing seo info of that language
      $seo->update($request->all());

      $request->session()->flash('success', 'SEO Informations updated successfully!');

      return redirect()->back();
    }

}
