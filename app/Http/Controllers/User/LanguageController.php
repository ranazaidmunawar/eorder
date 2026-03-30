<?php

namespace App\Http\Controllers\User;

use App\Models\User\Menu;
use App\Constants\Constant;
use App\Models\User\Product;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicExtra;
use Illuminate\Validation\Rule;
use App\Models\User\PageHeading;
use App\Models\User\BasicSetting;
use App\Models\User\Journal\Blog;
use App\Models\User\BasicExtended;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\User\ProductInformation;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\LimitCheckerHelper;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User\Journal\BlogInformation;


class LanguageController extends Controller
{
    public function index()
    {
        $userId = getRootUser()->id;
        $data['languages'] = Language::query()->where('user_id', $userId)->get();
        return view('user.language.index', $data);
    }

    public function store(Request $request)
    {
       
        $userId = getRootUser()->id;

        $rules = [
            'name' => [
                'required',
                Rule::unique('user_languages')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                })
            ],
            'code' => [
                'required',
                function ($attribute, $value, $fail) use ($userId) {
                    $language = Language::where([
                        ['code', $value],
                        ['user_id', $userId]
                    ])->get();
                    if ($language->count() > 0) {
                        $fail(':attribute already taken');
                    }
                },
            ],
            'direction' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $deLang = Language::where('user_id', null)->first();

        $in['name'] = $request->name;
        $in['code'] = $request->code;
        $in['rtl'] = $request->direction;
        $in['keywords'] = $deLang->keywords;
        $in['user_id'] = $userId;
        $in['datepicker_name'] = uniqid();

        $filename = $in['datepicker_name'] . '-' . $request->code;

        // Path to the public folder where the JavaScript file will be stored
        $publicPath = public_path('assets/tenant/js/i18n');

        // Create the directory if it doesn't exist
        File::makeDirectory($publicPath, 0755, true, true);

        // Full path to the JavaScript file
        $filePath = $publicPath . '/' . $filename . '.js';
        if($request->direction == 1){
            $rtl = 'true';
        }else{
            $rtl = 'false';
        }

            $jsContent = <<<JS
            (function(factory) {
                "use strict";

                if (typeof define === "function" && define.amd) {
                    define(["../widgets/datepicker"], factory);
                } else {
                    factory(jQuery.datepicker);
                }
            })(function(datepicker) {
                "use strict";

                datepicker.regional.{$request->code} = {
                    closeText: "Done",
                    prevText: "Prev",
                    nextText: "Next",
                    currentText: "Today",
                    monthNames: [ "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December" ],
                    monthNamesShort: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
                    dayNames: [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ],
                    dayNamesShort: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
                    dayNamesMin: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ],
                    weekHeader: "Wk",
                    dateFormat: "dd/mm/yy",
                    firstDay: 1,
                    isRTL: $rtl,
                    showMonthAfterYear: false,
                    yearSuffix: "" 
                };
                
                datepicker.setDefaults(datepicker.regional.{$request->code});

                return datepicker.regional.{$request->code};
            });
            JS;
        file_put_contents($filePath, $jsContent);

        $defaultLang = Language::query()->where([
            ['is_default', 1],
            ['user_id', $userId]
        ]);
        if ($defaultLang->count() > 0) {
            $in['is_default'] = 0;
        } else {
            $in['is_default'] = 1;
        }
        $language = Language::create($in);
        $menu = new Menu;
        $menu->user_id = $userId;
        $menu->language_id = $language->id;
        $menu->menus = '[{"text":"Home","href":"","icon":"empty","target":"_self","title":"","type":"home"},{"text":"Menu","href":"","icon":"empty","target":"_self","title":"","type":"menu"},{"text":"Items","href":"","icon":"empty","target":"_self","title":"","type":"items"},{"text":"Cart","href":"","icon":"empty","target":"_self","title":"","type":"cart"},{"text":"Checkout","href":"","icon":"empty","target":"_self","title":"","type":"checkout"},{"text":"Pages","href":"","icon":"empty","target":"_self","title":"","type":"custom","children":[{"text":"Career","href":"","icon":"empty","target":"_self","title":"","type":"career"},{"text":"Team Members","href":"","icon":"empty","target":"_self","title":"","type":"team"},{"text":"Gallery","href":"","icon":"empty","target":"_self","title":"","type":"gallery"},{"text":"FAQ","href":"","icon":"empty","target":"_self","title":"","type":"faq"},{"type":"about-us","text":"About Us","href":"","target":"_self"}]},{"text":"Blog","href":"","icon":"empty","target":"_self","title":"","type":"blog"},{"text":"Contact","href":"","icon":"empty","target":"_self","title":"","type":"contact"}]';
        $menu->save();

        $bs = BasicSetting::query()->where('user_id', $userId)->first();
        $newBs = $bs->replicate([
            'logo',
            'favicon',
            'breadcrumb',
            'preloader',
            'footer_logo',
            'intro_video_image',
            'intro_main_image',
            'intro_signature',
            'website_title'
        ]);
        $newBs->language_id = $language->id;
        $newBs->save();

        $be = BasicExtended::query()->where('user_id', $userId)->first();
        $newBe = $be->replicate([
            'slider_shape_img',
            'slider_bottom_img',
            'footer_bottom_img',
            'menu_section_img',
            'table_section_img',
            'hero_bg',
            'hero_shape_img',
            'hero_bottom_img',
            'hero_side_img',
            'special_section_bg',
            'qr_image',
            'qr_inserted_image',
        ]);
        $newBe->language_id = $language->id;
        $newBe->save();

        PageHeading::create([
            'language_id' => $language->id,
            'user_id' => $userId,
        ]);



        Session::flash('success', 'Language added successfully!');
        return "success";
    }

    public function edit($id)
    {

        $userId = getRootUser()->id;
        if ($id > 0) {
            $data['language'] = Language::query()
                ->where('user_id', $userId)
                ->where('id', $id)
                ->first();
            $this->authorize('view', $data['language']);
        }
        $data['id'] = $id;
        return view('user.language.edit', $data);
    }


    public function update(Request $request)
    {
        $userId = getRootUser()->id;
        $language = Language::query()
            ->where('user_id', $userId)
            ->where('id', $request->language_id)
            ->first();

        $rules = [

            'name' => [
                'required',
                Rule::unique('user_languages')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                })->where('id', !$language->id)
            ],
            'code' => [
                'required',
                Rule::unique('user_languages')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                })->where('id', !$language->id)
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
        $language->user_id = $userId;
        $language->save();

        Session::flash('success', 'Language updated successfully!');
        return "success";
    }

    public function editKeyword($id)
    {
        $userId = getRootUser()->id;
        $data['la'] = Language::where('user_id', $userId)->where('id', $id)->first();
        $this->authorize('view', $data['la']);
        $data['keywords'] = json_decode($data['la']->keywords, true);
        return view('user.language.edit-keyword', $data);
    }

    public function updateKeyword(Request $request, $id)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()->where('user_id', $userId)->where('id', $id)->first();
        $keywords = $request->except('_token');
        $lang->keywords = json_encode($keywords);
        $lang->save();

        $translatedDayNamesMin = [];

        // Loop through English day names and get their translations
        foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $englishDay) {
            // Check if the translated keyword exists, otherwise, use the English day name
            $translatedDay = isset($keywords[$englishDay]) ? $keywords[$englishDay] : $englishDay;

            // Add the translated day name to the array
            $translatedDayNamesMin[] = $translatedDay;
        }

        $translatedMonthNames = [];

        // Loop through English month names and get their translations
        foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $englishMonth) {
            $translatedMonth = isset($keywords[$englishMonth]) ? $keywords[$englishMonth] : $englishMonth;

            $translatedMonthNames[] = $translatedMonth;
          
        }

        if (!is_null($lang->datepicker_name)) {
            @unlink('assets/tenant/js/i18n/' . $lang->datepicker_name . '-' . $lang->code . '.js');
        }
        
        $filename = $lang->datepicker_name . '-' . $lang->code;

        // Path to the public folder where the JavaScript file will be stored
        $publicPath = public_path('assets/tenant/js/i18n');

        // Create the directory if it doesn't exist
        File::makeDirectory($publicPath, 0755, true, true);

        // Full path to the JavaScript file
        $filePath = $publicPath . '/' . $filename . '.js';
        if ($lang->rtl == 1) {
            $rtl = 'true';
        } else {
            $rtl = 'false';
        }

        $jsContent = <<<JS
            (function(factory) {
                "use strict";

                if (typeof define === "function" && define.amd) {
                    define(["../widgets/datepicker"], factory);
                } else {
                    factory(jQuery.datepicker);
                }
            })(function(datepicker) {
                "use strict";

                datepicker.regional.{$lang->code} = {
                    closeText: "Done",
                    prevText: "Prev",
                    nextText: "Next",
                    currentText: "Today",
                   monthNames: [ "{$translatedMonthNames[0]}", "{$translatedMonthNames[1]}", "{$translatedMonthNames[2]}", "{$translatedMonthNames[3]}", "{$translatedMonthNames[4]}", "{$translatedMonthNames[5]}", "{$translatedMonthNames[6]}", "{$translatedMonthNames[7]}", "{$translatedMonthNames[8]}", "{$translatedMonthNames[9]}", "{$translatedMonthNames[10]}", "{$translatedMonthNames[11]}" ],
                    monthNamesShort: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
                    dayNames: [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ],
                    dayNamesShort: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
                     dayNamesMin: [ "{$translatedDayNamesMin[0]}", "{$translatedDayNamesMin[1]}", "{$translatedDayNamesMin[2]}", "{$translatedDayNamesMin[3]}", "{$translatedDayNamesMin[4]}", "{$translatedDayNamesMin[5]}", "{$translatedDayNamesMin[6]}" ],
                    weekHeader: "Wk",
                    dateFormat: "dd/mm/yy",
                    firstDay: 1,
                    isRTL: $rtl,
                    showMonthAfterYear: false,
                    yearSuffix: "" 
                };
                
                datepicker.setDefaults(datepicker.regional.{$lang->code});

                return datepicker.regional.{$lang->code};
            });
            JS;
        file_put_contents($filePath, $jsContent);
         
        Session::flash('success', 'Keywords Updated Successfully');
        return 'success';
    }


    public function delete($id)
    {
        $userId = getRootUser()->id;
        $language = Language::query()
            ->where('user_id', $userId)
            ->where('id', $id)
            ->first();
    
        $bss = null;

        if ($language->is_default == 1) {
            return back()->with('warning', 'Default language cannot be deleted!');
        }
        return DB::transaction(function () use ($language, $userId, $bss) {
            /**
             * delete 'custom page' info
             */
            $custom_pages = $language
                ->custom_page_info()
                ->where('user_id', $userId)
                ->get();

            if (count($custom_pages) > 0) {
                foreach ($custom_pages as $custom_page) {
                    $custom_page->delete();
                }
            }
            /**
             * delete 'blog categories' info
             */
            $blog_categories = $language->blogCategory()->where('user_id', $userId)->get();
            if (count($blog_categories) > 0) {
                foreach ($blog_categories as $blog_category) {
                    $blog_category->delete();
                }
            }
            /**
             * delete 'blog informations' info
             */
            $blog_informations = $language->blogInformation()->where('user_id', $userId)->get();
            foreach ($blog_informations as $blog_information) {
                //copy current data to another variable
                $blogInfo = $blog_information;
                $blog_information->delete();
                // delete the blog if, this blog does not contain any other blog information in any other language
                $otherBlogInfos = BlogInformation::query()
                    ->where('user_id', '=', $userId)
                    ->where('blog_id', '=', $blogInfo->blog_id)
                    ->get();

                if (count($otherBlogInfos) == 0) {
                    $blog = Blog::query()
                        ->where('user_id', $userId)
                        ->find($blogInfo->blog_id);
                    Uploader::remove(Constant::WEBSITE_BLOG_IMAGE, $blog->image, $bss, $userId);
                    $blog->delete();
                }
            }
            /**
             * delete 'product informations' info
             */
            $product_informations = $language->productInformation()->where('user_id', $userId)->get();
            foreach ($product_informations as $product_information) {
                $productInfo = $product_information;
                $product_information->delete();
                // delete the blog if, this blog does not contain any other blog information in any other language
                $otherProductInfos = ProductInformation::query()
                    ->where('user_id', '=', $userId)
                    ->where('product_id', '=', $productInfo->product_id)
                    ->get();

                if (count($otherProductInfos) == 0) {
                    $product = Product::query()
                        ->where('user_id', $userId)
                        ->find($productInfo->product_id);
                    Uploader::remove(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $bss, $userId);
                    foreach ($product->product_images as $pi) {
                        Uploader::remove(Constant::WEBSITE_PRODUCT_SLIDER_IMAGE, $pi->image, $bss, $userId);
                        $pi->delete();
                    }
                    $product->delete();
                }
            }
            /**
             * delete 'product categories' info
             */
            $categories = $language->pcategories()->where('user_id', $userId)->get();
            if (count($categories) > 0) {
                $categories = $language->pcategories()->where('user_id', $userId)->get();
                foreach ($categories as $category) {
                    Uploader::remove(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $category->image, $bss, $userId);
                    $category->delete();
                }
            }
            /**
             * delete 'product subcategories' info
             */
            $subcategories = $language->psubcategories()->where('user_id', $userId)->get();
            if (count($subcategories) > 0) {
                foreach ($subcategories as $subcategory) {
                    $subcategory->delete();
                }
            }
            /**
             * delete 'postal codes' info
             */
            $postal_codes = $language->postal_codes()->where('user_id', $userId)->get();
            if (count($postal_codes) > 0) {
                foreach ($postal_codes as $postal_code) {
                    $postal_code->delete();
                }
            }
            /**
             * delete 'shipping charge' info
             */
            $shipping_charges = $language->shipping_charges()->where('user_id', $userId)->get();
            if (count($shipping_charges) > 0) {
                foreach ($shipping_charges as $shipping_charge) {
                    $shipping_charge->delete();
                }
            }
            /**
             * delete 'reservation inputs' info
             */
            $reservation_inputs = $language->reservation_inputs()->where('user_id', $userId)->get();
            if (count($reservation_inputs) > 0) {
                foreach ($reservation_inputs as $reservation_input) {
                    $reservation_input->delete();
                }
            }
            /**
             * delete 'popup' infos
             */
            $popups = $language->popups()->where('user_id', $userId)->get();
            if (count($popups) > 0) {
                foreach ($popups as $popup) {
                    Uploader::remove(Constant::WEBSITE_ANNOUNCEMENT_POPUP_IMAGE, $popup->image, $bss, $userId);
                    $popup->delete();
                }
            }
            /**
             * delete 'job categories' info
             */
            $job_categories = $language->job_categories()->where('user_id', $userId)->get();
            if (count($job_categories) > 0) {
                foreach ($job_categories as $job_category) {
                    $job_category->delete();
                }
            }
            /**
             * delete 'jobs' info
             */
            $jobs = $language->jobs()->where('user_id', $userId)->get();
            if (count($jobs) > 0) {
                foreach ($jobs as $job) {
                    $job->delete();
                }
            }
            /**
             * delete 'testimonials' info
             */
            $testimonials = $language->testimonials()->where('user_id', $userId)->get();
            if (count($testimonials) > 0) {
                foreach ($testimonials as $testimonial) {
                    Uploader::remove(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->image, $bss, $userId);
                    $testimonial->delete();
                }
            }
            /**
             * delete 'useful links' info
             */
            $useful_links = $language->useful_links()->where('user_id', $userId)->get();
            if (count($useful_links) > 0) {
                foreach ($useful_links as $useful_link) {
                    $useful_link->delete();
                }
            }
            /**
             * delete 'features' info
             */
            $features = $language->features()->where('user_id', $userId)->get();
            if (count($features) > 0) {
                foreach ($features as $feature) {
                    Uploader::remove(Constant::WEBSITE_FEATURE_IMAGES, $feature->image, $bss, $userId);
                    $feature->delete();
                }
            }
            /**
             * delete 'faqs' info
             */
            $faqs = $language->faqs()->where('user_id', $userId)->get();
            if (count($faqs) > 0) {
                foreach ($faqs as $faq) {
                    $faq->delete();
                }
            }
            /**
             * delete 'sliders' info
             */
            $sliders = $language->sliders()->where('user_id', $userId)->get();
            if (count($sliders) > 0) {
                foreach ($sliders as $slider) {
                    Uploader::remove(Constant::WEBSITE_SLIDER_IMAGES, $slider->image, $bss, $userId);
                    Uploader::remove(Constant::WEBSITE_SLIDER_BACKGROUND_IMAGES, $slider->bg_image, $bss, $userId);
                    $slider->delete();
                }
            }
            /**
             * delete 'menu builders' info
             */
            $menuInfo = $language->menu()->first();
            if (!empty($menuInfo)) {
                $menuInfo->delete();
            }
            /**
             * delete 'seo' info
             */
            $seoInfo = $language->seo()->first();
            if (!empty($seoInfo)) {
                $seoInfo->delete();
            }
            /**
             * delete 'basic extended' info
             */
            $basic_extended = $language->basic_extended()->first();
            if (!empty($basic_extended)) {
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->slider_shape_img, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->slider_bottom_img, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->footer_bottom_img, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->menu_section_img, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->table_section_img, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_bg, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_shape_img, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_bottom_img, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_side_img, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->special_section_bg, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_TABLE_IMAGE, $basic_extended->qr_image, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_QR_IMAGE, $basic_extended->qr_inserted_image, $bss, $userId);
                $basic_extended->delete();
            }
            /**
             * delete 'basic setting' info
             */
            $basic_setting = $language->basic_setting()->first();
            if (!empty($basic_setting)) {
                Uploader::remove(Constant::WEBSITE_LOGO, $basic_setting->logo, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_FAVICON, $basic_setting->favicon, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_BREADCRUMB, $basic_setting->breadcrumb, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_PRELOADER, $basic_setting->preloader, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->footer_logo, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->intro_video_image, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->intro_main_image, $bss, $userId);
                Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->intro_signature, $bss, $userId);
                $basic_setting->delete();
            }

            // if the deletable language is the currently selected language in frontend then forget the selected language from session
            if (session()->get('user_lang') == $language->code) {
                session()->forget('user_lang');
            }
            if(!is_null($language->datepicker_name)){
                @unlink('assets/tenant/js/i18n/' . $language->datepicker_name.'-'. $language->code.'.js');
            }
            $language->delete();
            return back()->with('success', 'Language Deleted Successfully');
        });
    }

    public function default(Request $request, $id)
    {
        $userId = getRootUser()->id;
        Language::query()
            ->where('is_default', 1)
            ->where('user_id', $userId)
            ->update(['is_default' => 0]);
        $lang = Language::query()
            ->where('user_id', $userId)
            ->find($id);
        $lang->is_default = 1;
        $lang->save();
        return back()->with('success', $lang->name . ' language is set as default.');
    }

    public function rtlCheck($langid)
    {
        $userId = getRootUser()->id;
        if ($langid > 0) {
            return Language::query()
                ->where('user_id', $userId)
                ->find($langid)
                ->rtl;
        } else {
            return 0;
        }
    }
}
