<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\BasicSetting as BS;
use App\Models\BasicExtended as BE;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class LanguageController extends Controller
{
    public function index()
    {
        $data['languages'] = Language::all();
        return view('admin.language.index', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'code' => [
                'required',
                'max:255',
                'unique:languages'
            ],
            'direction' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $data = file_get_contents(resource_path('lang/') . 'default.json');
        $json_file = trim(strtolower($request->code)) . '.json';
        $path = resource_path('lang/') . $json_file;
        File::put($path, $data);
        $in['name'] = $request->name;
        $in['code'] = $request->code;
        $in['rtl'] = $request->direction;
        if (Language::where('is_default', 1)->count() > 0) {
            $in['is_default'] = 0;
        } else {
            $in['is_default'] = 1;
        }
        $lang = Language::create($in);

       $menu = new Menu();
       $menu->language_id = $lang->id;
      $menu->menus = '[{"text":"Home","href":"","icon":"empty","target":"_self","title":"","type":"home"},{"text":"Listings","href":"","icon":"empty","target":"_self","title":"","type":"listings"},{"text":"Pricing","href":"","icon":"empty","target":"_self","title":"","type":"pricing"},{"text":"Pages","href":"","icon":"empty","target":"_self","title":"","type":"custom","children":[{"text":"Privacy Policy","href":"","icon":"empty","target":"_self","title":"","type":"4"},{"text":"About Us","href":"","icon":"empty","target":"_self","title":"","type":"1"}]},{"text":"Blog","href":"","icon":"empty","target":"_self","title":"","type":"blog"},{"text":"FAQs","href":"","icon":"empty","target":"_self","title":"","type":"faq"},{"text":"Contact","href":"","icon":"empty","target":"_self","title":"","type":"contact"},{"type":"8","text":"test","href":"","target":"_self"}]';
      $menu->save();

        // duplicate First row of basic_settings for current language
        $dbs = Language::where('is_default', 1)->first()->basic_setting;
        $cols = json_decode($dbs, true);
        $bs = new BS;
        foreach ($cols as $key => $value) {
            // if the column is 'id' [primary key] then skip it
            if ($key == 'id') {
                continue;
            }
            // create favicon image using default language image & save unique name in database
            if ($key == 'favicon') {
                // take default lang image
                $dimg = url(public_path('/assets/front/img/')) .'/'. $dbs->favicon;

                // copy and paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->favicon, ".")) !== FALSE) {
                    $ext = substr($dbs->favicon, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, public_path('assets/front/img/').$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create logo image using default language image & save unique name in database
            if ($key == 'logo') {
                // take default lang image
                $dimg = url(public_path('/assets/front/img/')) .'/'. $dbs->logo;

                // copy and paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->logo, ".")) !== FALSE) {
                    $ext = substr($dbs->logo, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, public_path('assets/front/img/').$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create logo image using default language image & save unique name in database
            if ($key == 'preloader') {
                // take default lang image
                $dimg = url(public_path('/assets/front/img/')) .'/'. $dbs->preloader;

                // copy and paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->preloader, ".")) !== FALSE) {
                    $ext = substr($dbs->preloader, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, public_path('assets/front/img/').$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create logo image using default language image & save unique name in database
            if ($key == 'maintenance_img') {
                // take default lang image
                $dimg = url(public_path('/assets/front/img/')) .'/'. $dbs->maintenance_img;

                // copy and paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->maintenance_img, ".")) !== FALSE) {
                    $ext = substr($dbs->maintenance_img, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, public_path('assets/front/img/').$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create breadcrumb image using default language image & save unique name in database
            if ($key == 'breadcrumb') {
                // take default lang image
                $dimg = url(public_path('/assets/front/img/')) .'/'. $dbs->breadcrumb;

                // copy and paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->breadcrumb, ".")) !== FALSE) {
                    $ext = substr($dbs->breadcrumb, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, public_path('assets/front/img/').$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create footer_logo image using default language image & save unique name in database
            if ($key == 'footer_logo') {
                // take default lang image
                $dimg = url(public_path('/assets/front/img/')) .'/'. $dbs->footer_logo;

                // copy and paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->footer_logo, ".")) !== FALSE) {
                    $ext = substr($dbs->footer_logo, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, public_path('assets/front/img/').$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create intro_main_image image using default language image & save unique name in database
            if ($key == 'intro_main_image') {
                // take default lang image
                $dimg = url(public_path('/assets/front/img/')) .'/'. $dbs->intro_main_image;

                // copy and paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->intro_main_image, ".")) !== FALSE) {
                    $ext = substr($dbs->intro_main_image, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, public_path('assets/front/img/').$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            $bs[$key] = $value;
        }
        $bs['language_id'] = $lang->id;
        $bs->save();

        // duplicate First row of basic_extendeds for current language
        $dbe = Language::where('is_default', 1)->first()->basic_extended;
        $be = BE::first();
        $cols = json_decode($be, true);
        $be = new BE;
        foreach ($cols as $key => $value) {
            // if the column is 'id' [primary key] then skip it
            if ($key == 'id') {
                continue;
            }

            // create hero image using default language image & save unique name in database
            if ($key == 'hero_img') {
                // take default lang image
                $dimg = url(public_path('/assets/front/img/')) .'/'. $dbe->hero_img;

                // copy and paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbe->hero_img, ".")) !== FALSE) {
                    $ext = substr($dbe->hero_img, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, public_path('assets/front/img/').$newImgName);

                // save the unique name in database
                $be[$key] = $newImgName;

                // continue the loop
                continue;
            }

            $be[$key] = $value;
        }
        $be['language_id'] = $lang->id;
        $be->save();

        Session::flash('success', 'Language added successfully!');
        return "success";
    }

    public function edit($id)
    {
        if ($id > 0) {
            $data['language'] = Language::findOrFail($id);
        }
        $data['id'] = $id;
        return view('admin.language.edit', $data);
    }


    public function update(Request $request)
    {
        $language = Language::findOrFail($request->language_id);

        $rules = [
            'name' => 'required|max:255',
            'code' => [
                'required',
                'max:255',
                Rule::unique('languages')->ignore($language->id),
            ],
            'direction' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $language->name = $request->name;
        $language->code = $request->code;
        $language->rtl = $request->direction;
        $language->save();

        Session::flash('success', 'Language updated successfully!');
        return "success";
    }

    public function editKeyword($id)
    {
        if ($id > 0) {
            $la = Language::query()->findOrFail($id);
            $json = file_get_contents(resource_path('lang/') . $la->code . '.json');
            $json = json_decode($json, true);
            if (empty($json)) {
                return back()->with('alert', 'File Not Found.');
            }
            return view('admin.language.edit-keyword', compact('json', 'la'));
        } elseif ($id == 0) {
            $json = file_get_contents(resource_path('lang/') . 'default.json');
            $json = json_decode($json, true);
            if (empty($json)) {
                return back()->with('alert', 'File Not Found.');
            }
            return view('admin.language.edit-keyword', compact('json'));
        }
    }

    public function addKeyword(Request $request)
    {
      
        $rules = [
            'keyword' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $languages = Language::get();
        foreach ($languages as $language) {
            // get all the keywords of the selected language
            $jsonData = file_get_contents(resource_path('lang/') . $language->code . '.json');
            // convert json encoded string into a php associative array
            $keywords = json_decode($jsonData, true);
            $datas = [];
            $datas[$request->keyword] = $request->keyword;
            foreach ($keywords as $key => $keyword) {
                $datas[$key] = $keyword;
            }
            //put data
            $jsonData = json_encode($datas);
            $fileLocated = resource_path('lang/') . $language->code . '.json';
            // put all the keywords in the selected language file
            file_put_contents($fileLocated, $jsonData);
        }
        //for default json
        // get all the keywords of the selected language
        $jsonData = file_get_contents(resource_path('lang/') . 'default.json');
        // convert json encoded string into a php associative array
        $keywords = json_decode($jsonData, true);
        $datas = [];
        $datas[$request->keyword] = $request->keyword;
        foreach ($keywords as $key => $keyword) {
            $datas[$key] = $keyword;
        }
        //put data
        $jsonData = json_encode($datas);
        $fileLocated = resource_path('lang/') . 'default.json';
        // put all the keywords in the selected language file
        file_put_contents($fileLocated, $jsonData);
        Session::flash('success', 'A new keyword add successfully!');
        return 'success';
    }

    public function updateKeyword(Request $request, $id)
    {
        $lang = Language::query()->findOrFail($id);
        $content = json_encode($request->keys);
        if ($content === 'null') {
            return back()->with('alert', 'At Least One Field Should Be Fill-up');
        }
        $path = resource_path('lang/') . $lang->code . '.json';
        file_put_contents($path, $content);
        return back()->with('success', 'Updated Successfully');
    }


    public function delete($id)
    {
        $la = Language::query()->findOrFail($id);
        if ($la->is_default == 1) {
            return back()->with('warning', 'Default language cannot be deleted!');
        }
        @unlink(resource_path('lang/') . $la->code . '.json');
        if (session()->get('lang') == $la->code) {
            session()->forget('lang');
        }

        // deleting basic_settings and basic_extended for corresponding language & unlink images
        $basicImagePath = public_path('assets/front/img');
        $bs = $la->basic_setting;
        if (!empty($bs)) {
            deleteFile($basicImagePath, $bs->favicon);
            deleteFile($basicImagePath, $bs->logo);
            deleteFile($basicImagePath, $bs->preloader);
            deleteFile($basicImagePath, $bs->breadcrumb);
            deleteFile($basicImagePath, $bs->intro_main_image);
            deleteFile($basicImagePath, $bs->footer_logo);
            deleteFile($basicImagePath, $bs->maintenance_img);
            $bs->delete();
        }
        $be = $la->basic_extended;
        if (!empty($be)) {
            $be->delete();
        }

        // deleting services for corresponding language
        $blogImagePath = public_path('assets/front/img/blogs');
        if (!empty($la->blogs)) {
            $blogs = $la->blogs;
            foreach ($blogs as $blog) {
                deleteFile($blogImagePath,$blog->main_image);
                $blog->delete();
            }
        }

        // deleting blog categories for corresponding language
        if (!empty($la->bcategories)) {
            $bcategories = $la->bcategories;
            foreach ($bcategories as $bcat) {
                $bcat->delete();
            }
        }

        // deleting faqs for corresponding language
        if (!empty($la->faqs)) {
            $la->faqs()->delete();
        }


        // deleting feature for corresponding language
        if (!empty($la->features)) {
            $features = $la->features;
            foreach ($features as $feature) {
                $feature->delete();
            }
        }

        // deleting menus for corresponding language
        if (!empty($la->menus)) {
            $la->menus()->delete();
        }

        // deleting pages for corresponding language
        if (!empty($la->pages)) {
            $la->pages()->delete();
        }

        // deleting partners for corresponding language
        $partnerImagePath = public_path('assets/front/img/partners');
        if (!empty($la->partners)) {
            $partners = $la->partners;
            foreach ($partners as $partner) {
                deleteFile($partnerImagePath,$partner->image);
                $partner->delete();
            }
        }

        // deleting partners for corresponding language
        $popUpImagePath = public_path('assets/front/img/popups');
        if (!empty($la->popups)) {
            $popups = $la->popups;
            foreach ($popups as $popup) {
                deleteFile($popUpImagePath,$popup->background_image);
                deleteFile($popUpImagePath,$popup->image);
                $popup->delete();
            }
        }

        // deleting processes for corresponding language
        $processImagePath = public_path('assets/front/img/process');
        if (!empty($la->processes)) {
            $processes = $la->processes;
            foreach ($processes as $process) {
                deleteFile($popUpImagePath,$process->image);
                $process->delete();
            }
        }

        // deleting seo for corresponding language
        if (!empty($la->seo)) {
            $la->seo->delete();
        }

        // deleting testimonials for corresponding language
        $testimonialImagePath = public_path('assets/front/img/testimonials');
        if (!empty($la->testimonials)) {
            $testimonials = $la->testimonials;
            foreach ($testimonials as $testimonial) {
                deleteFile($testimonialImagePath, $testimonial->image);
                $testimonial->delete();
            }
        }

        // deleting useful links for corresponding language
        if (!empty($la->ulinks)) {
            $la->ulinks()->delete();
        }

        // if the deletable language is the currently selected language in frontend then forget the selected language from session
        session()->forget('lang');

        $la->delete();
        return back()->with('success', 'Delete Successfully');
    }


    public function default(Request $request, $id)
    {
        Language::where('is_default', 1)->update(['is_default' => 0]);
        $lang = Language::find($id);
        $lang->is_default = 1;
        $lang->save();
        return back()->with('success', $lang->name . ' language is set as default.');
    }

    public function rtlcheck($langid) {
        if ($langid > 0) {
            return Language::query()->find($langid)->rtl;
        } else {
            return 0;
        }
    }
}
