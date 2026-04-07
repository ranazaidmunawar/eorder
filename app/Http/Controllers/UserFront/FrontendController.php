<?php

namespace App\Http\Controllers\UserFront;

use App\Models\User\Faq;
use App\Models\User\Job;
use App\Models\User\Banner;
use App\Models\User\Member;
use App\Models\User\Slider;
use App\Events\WaiterCalled;
use App\Models\User\Feature;
use App\Models\User\Gallery;
use App\Models\User\Product;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Models\User\Jcategory;
use App\Models\User\Pcategory;
use App\Models\User\TableBook;
use App\Models\BasicExtended as BE;
use App\Models\User\IntroPoint;
use App\Models\User\Subscriber;
use App\Http\Helpers\MegaMailer;
use App\Models\User\Testimonial;
use App\Models\User\BasicSetting;
use App\Models\User\Journal\Blog;
use App\Models\User\BannerSection;
use App\Models\User\BasicExtended;
use App\Models\User\AffordableDeal;
use App\Constants\UserEmailTemplate;
use App\Http\Controllers\Controller;
use App\Models\User\CustomPage\Page;
use App\Models\User\ReservationInput;
use App\Models\User\UserCustomDomain;
use Illuminate\Support\Facades\Config;
use App\Models\User\UserSectionHeading;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Helpers\LimitCheckerHelper;
use App\Traits\UserCurrentLanguageTrait;
use App\Models\User\Journal\BlogCategory;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\UserPermissionHelper;

class FrontendController extends Controller
{

    use UserCurrentLanguageTrait;

    public function __construct()
    {
        if (app()->runningInConsole()) return;

        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();


        if (!empty($be['pusher_app_id']) && !empty($be['pusher_app_key']) && !empty($be['pusher_app_secret']) && !empty($be['pusher_app_cluster'])) {

            $pusherCredentials = [
                'driver' => 'pusher',
                'app_id' => $be['pusher_app_id'],
                'key' => $be['pusher_app_key'],
                'secret' => $be['pusher_app_secret'],
                'options' => [
                    'cluster' => $be['pusher_app_cluster'],
                ],
            ];

            Config::set('broadcasting.connections.pusher', $pusherCredentials);
        }
    }

    public function offlinePWA($domain)
    {
        return view('user-front.offline');
    }

    public function index()
    {

        $user = getUser();
        $feature = UserPermissionHelper::packagePermission($user->id);

        $feature = json_decode($feature, true);

        $currentLang = $this->getUserCurrentLanguage($user);

        $lang_id = $currentLang->id;

        $bs = BasicSetting::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

        $currentTheme = $bs->theme;

        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();
        if (!empty($user->pwa)) {
            $pwaData = json_decode($user->pwa, true);
            $pwaData['start_url'] = url()->current();
            if (in_array('Amazon AWS s3', $feature)) {
                foreach ($pwaData['icons'] as $key => $icon) {
                    $pwaData['icons'][$key]['src'] = $icon['src'];
                }
            }
            
            $pwaPath = public_path('assets/pwa/manifest.json');
            if (is_dir(public_path('assets/pwa'))) {
                @file_put_contents($pwaPath, json_encode($pwaData));
            }
        }

        $data['sliders'] = Slider::query()
            ->where('language_id', $lang_id)
            ->where('user_id', $user->id)
            ->orderBy('serial_number', 'ASC')
            ->get();
        $data['features'] = Feature::query()
            ->where('language_id', $lang_id)
            ->where('user_id', $user->id)
            ->get();
        $data['intro_feature_items'] = IntroPoint::query()
            ->where('language_id', $lang_id)
            ->where('user_id', $user->id)
            ->get();
        $data['sectionHeading'] = UserSectionHeading::query()
            ->where('language_id', $lang_id)
            ->where('user_id', $user->id)
            ->first();
        $data['members'] = Member::query()
            ->where('language_id', $lang_id)
            ->where('feature', 1)
            ->where('user_id', $user->id)->take(3)
            ->get();
        $data['testimonials'] = Testimonial::query()
            ->where('language_id', $lang_id)
            ->where('user_id', $user->id)
            ->orderBy('serial_number', 'ASC')
            ->get();
        $data['blogs'] = Blog::query()
            ->join('user_blog_informations', 'user_blogs.id', '=', 'user_blog_informations.blog_id')
            ->where('user_blog_informations.language_id', '=', $lang_id)
            ->where('user_blog_informations.user_id', '=', $user->id)
            ->select(
                'user_blogs.image',
                'user_blogs.created_at',
                'user_blog_informations.title',
                'user_blog_informations.slug',
                'user_blogs.id',
                'user_blog_informations.content',
                'user_blog_informations.author'
            )
            ->orderByDesc('user_blogs.id')
            ->limit(3)
            ->get();
        $data['special_product'] = Product::query()
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('status', 1)
            ->where('is_special', 1)
            ->where('products.user_id', $user->id)
            ->where('product_informations.language_id', $lang_id)
            ->orderBy('products.id', 'desc')
            ->get();
        $data['categories'] = Pcategory::query()
            ->where('status', 1)
            ->where('is_feature', 1)
            ->where('language_id', $currentLang->id)
            ->where('user_id', $user->id)
            ->get();
        $data['featured_products'] = Product::query()
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('status', 1)
            ->where('is_feature', 1)
            ->where('products.user_id', $user->id)
            ->where('product_informations.language_id', $lang_id)
            ->orderBy('products.id', 'desc')
            ->get();

        $data['products'] = Product::query()
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('status', 1)
            ->where('products.user_id', $user->id)
            ->where('product_informations.language_id', $lang_id)
            ->paginate(10);
        if ($bs->home_version == 'slider') {
            $data['shapeImg'] = $be->slider_shape_img ?? null;
            $data['bottomImg'] = $be->slider_bottom_img ?? null;
        } else {
            $data['shapeImg'] = $be->hero_shape_img ?? null;
            $data['bottomImg'] = $be->hero_bottom_img ?? null;
        }


        if (in_array($currentTheme, ['seabbq', 'desifoodie', 'desices'])) {

            $baseQuery = Banner::where('user_id', $user->id)
                ->where('language_id', $lang_id);

            //left banner for both themes
            $data['left_banner'] = (clone $baseQuery)
                ->where('position', 'left')
                ->first();

            //right banner only for 'seabbq' theme
            if ($currentTheme == 'seabbq' || $currentTheme == 'desices') {
                $data['right_banner'] = (clone $baseQuery)
                    ->where('position', 'right')
                    ->first();
            }

            $data['affordable_deals'] = AffordableDeal::where('language_id', $lang_id)
                ->where('user_id', $user->id)
                ->first();
            $affordableSecItems = json_decode(@$data['affordable_deals']->section_items, true) ?? [];

            $data['affordable_products'] = Product::query()
                ->join('product_informations', 'products.id', 'product_informations.product_id')
                ->whereIn('products.id', $affordableSecItems)
                ->where('status', 1)
                ->where('products.user_id', $user->id)
                ->where('product_informations.language_id', $lang_id)
                ->orderBy('products.id', 'desc')
                ->get();
        }

        if ($currentTheme == 'desifoodie') {
            $data['bannerSection'] = BannerSection::where('language_id', $lang_id)
                ->where('user_id', $user->id)
                ->first();

            $selectedItems = json_decode(@$data['bannerSection']->items, true) ?? [];

            $data['banner_products'] = Product::query()
                ->join('product_informations', 'products.id', 'product_informations.product_id')
                ->whereIn('products.id', $selectedItems)
                ->where('status', 1)
                ->where('products.user_id', $user->id)
                ->where('product_informations.language_id', $lang_id)
                ->orderBy('products.id', 'desc')
                ->get();
        }



        $features = LimitCheckerHelper::getPackageSelectedData($user->id, 'features');
        $data['packageFeatures'] = json_decode($features->features, true);

        if ($currentTheme == "fastfood") {
            return view('user-front.fastfood.index', $data);
        } elseif ($currentTheme == "bakery") {
            return view('user-front.bakery.index', $data);
        } elseif ($currentTheme == "pizza") {
            return view('user-front.pizza.index', $data);
        } elseif ($currentTheme == "coffee") {
            return view('user-front.coffee.index', $data);
        } elseif ($currentTheme == "medicine") {
            return view('user-front.medicine.index', $data);
        } elseif ($currentTheme == "grocery") {
            return view('user-front.grocery.index', $data);
        } elseif ($currentTheme == "beverage") {
            return view('user-front.beverage.index', $data);
        } elseif ($currentTheme == "seabbq") {
            return view('user-front.seabbq-desifoodie-desices.seabbq.index', $data);
        } elseif ($currentTheme == "desifoodie") {
            return view('user-front.seabbq-desifoodie-desices.desifoodie.index', $data);
        } elseif ($currentTheme == "desices") {
            return view('user-front.seabbq-desifoodie-desices.desices.index', $data);
        } else if ($currentTheme == "elack" || $currentTheme == "sushi") {
            return view('user-front.elack.index', $data);
        } else {
            return view('user-front.fastfood.index', $data);
        }


    }

    public function about_us()
    {
        $user = getUser();
        $feature = UserPermissionHelper::packagePermission($user->id);
        $feature = json_decode($feature, true);

        $currentLang = $this->getUserCurrentLanguage($user);
        $lang_id = $currentLang->id;

        $data['sectionHeading'] = UserSectionHeading::query()
            ->where('language_id', $lang_id)
            ->where('user_id', $user->id)
            ->first();
        $data['members'] = Member::query()
            ->where('language_id', $lang_id)
            ->where('feature', 1)
            ->where('user_id', $user->id)->take(3)
            ->get();
        $data['testimonials'] = Testimonial::query()
            ->where('language_id', $lang_id)
            ->where('user_id', $user->id)
            ->orderBy('serial_number', 'ASC')
            ->get();


        $features = LimitCheckerHelper::getPackageSelectedData($user->id, 'features');
        $data['packageFeatures'] = json_decode($features->features, true);

        return view('user-front.fastfood.about_us', $data);
    }

    public function subscribe(Request $request, $domain)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($currentLang->keywords, true);

        $rules = [
            'email' => ['required', function ($attribute, $value, $fail) use ($user, $keywords) {
                $subscriber = Subscriber::query()
                    ->where([
                        ['email', $value],
                        ['user_id', $user->id]
                    ])->get();
                if ($subscriber->count() > 0) {
                    Session::flash('error', $keywords['This email is already subscribed'] ?? 'This email is already subscribed');
                    $fail($keywords['attribute already subscribed for this user'] ?? ':attribute already subscribed for this user');
                }
            }]
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $subsc = new Subscriber;
        $subsc->email = $request->email;
        $subsc->user_id = $user->id;
        $subsc->save();
        return "success";
    }

    public function reservationForm($domain)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $bs = $currentLang->basic_setting;
        if ($bs->is_quote == 0) {
            return view('errors.user-404');
        }
        $data['inputs'] = ReservationInput::query()
            ->where('language_id', $currentLang->id)
            ->where('user_id', $user->id)
            ->orderBy('order_number', 'ASC')
            ->with('reservation_input_options')
            ->get();
        if ($bs->is_quote == 1) {
            return view('user-front.fastfood.reservation', $data);
        }
    }

    public function tableBook(Request $request)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($currentLang->keywords, true);

        $count = LimitCheckerHelper::getTableReservationCount($user->id);
        $package = LimitCheckerHelper::currentMembershipPackage($user->id);
        $membership = LimitCheckerHelper::currentMembership($user->id);

        if (is_null($package) ||  $count >= $package->table_reservation_limit) {

            return back()->with('error', "we are currently unable to receive any reservation")->withInput($request->all());
        }

        $currentLang = $this->getUserCurrentLanguage($user);

        $bs = BasicSetting::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

        $reservation_inputs = $currentLang->reservation_inputs;

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
        ];

        foreach ($reservation_inputs as $input) {
            if ($input->required == 1) {
                $rules["$input->name"] = 'required';
            }
        }

        if ($bs->is_recaptcha == 1 && empty($request->type)) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $fields = [];
        foreach ($reservation_inputs as $input) {
            $in_name = $input->name;
            if ($request["$in_name"]) {
                $fields["$in_name"] = $request["$in_name"];
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/", "/", $jsonfields);

        $data = new TableBook;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->fields = $jsonfields;
        $data->user_id = $user->id;
        $data->membership_id = $membership->id;
        $data->save();

        $mailer = new MegaMailer();

        $data['toMail'] = $user->email;
        $data['toName'] = $user->username;

        $data['fullname'] = $request->name;
        $data['email'] = $request->email;
        $data['subject'] = 'Table Reservation Request';
        $data['body'] = "<p><strong>You have received a new table reservation request</strong></p>  <p><strong>Name:</strong> $request->name </p><p><strong>Email:</strong> $request->email </p>";

        $mailer->mailContactMessage($data);

        Session::flash('success', $keywords['Reservation request sent successfully. We will contact you soon.'] ?? 'Reservation request sent successfully. We will contact you soon.');
        return back();
    }

    // blog section start
    public function blogs(Request $request, $domain)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $data['currentLang'] = $currentLang;
        $lang_id = $currentLang->id;
        $category = $request->category;

        if (!empty($category)) {
            $data['category'] = BlogCategory::query()
                ->where('user_id', $user->id)
                ->findOrFail($category);
        }
        $term = $request->term;

        $data['bcats'] = BlogCategory::query()
            ->where('user_id', $user->id)
            ->where('language_id', $lang_id)
            ->where('status', 1)
            ->orderBy('serial_number', 'ASC')
            ->get();

        $data['blogs'] = Blog::query()->join('user_blog_informations', 'user_blogs.id', '=', 'user_blog_informations.blog_id')
            ->where('user_blog_informations.language_id', '=', $lang_id)
            ->where('user_blog_informations.user_id', '=', $user->id)
            ->select('user_blogs.image', 'user_blogs.created_at', 'user_blog_informations.title', 'user_blog_informations.slug', 'user_blogs.id', 'user_blog_informations.content', 'user_blog_informations.blog_category_id', 'user_blog_informations.language_id')
            ->when($category, function ($query, $category) {
                return $query->where('blog_category_id', $category);
            })->when($term, function ($query, $term) {
                return $query->where('title', 'like', '%' . $term . '%');
            })->when($currentLang, function ($query, $currentLang) {
                return $query->where('language_id', $currentLang->id);
            })
            ->orderBy('serial_number', 'ASC')
            ->paginate(9);
        return view('user-front.fastfood.blogs', $data);
    }

    public function blogDetails($domain, $slug, $id)
    {

        $user = getUser();

        $currentLang = $this->getUserCurrentLanguage($user);
        $lang_id = $currentLang->id;
        $data['blog'] = Blog::query()
            ->join('user_blog_informations', 'user_blogs.id', '=', 'user_blog_informations.blog_id')
            ->where('user_blog_informations.language_id', '=', $lang_id)
            ->where('user_blog_informations.user_id', '=', $user->id)
            ->select(
                'user_blogs.image',
                'user_blogs.created_at',
                'user_blog_informations.title',
                'user_blog_informations.slug',
                'user_blogs.id',
                'user_blog_informations.content',
                'user_blog_informations.blog_category_id',
                'user_blog_informations.language_id'
            )
            ->findOrFail($id);

        $data['bcats'] = BlogCategory::query()
            ->where('status', 1)
            ->where('language_id', $lang_id)
            ->where('user_id', $user->id)
            ->orderBy('serial_number', 'ASC')
            ->get();
        return view('user-front.fastfood.blog-details', $data);
    }

    public function contact($domain)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $data['contact'] = BasicSetting::query()
            ->where('language_id', $currentLang->id)
            ->where('user_id', $user->id)
            ->select(
                'contact_form_title',
                'contact_info_title',
                'contact_address',
                'contact_number',
                'contact_text'
            )->first();

        return view('user-front.fastfood.contact', $data);
    }

    public function sendmail(Request $request)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($currentLang->keywords, true);
        $userBs = $currentLang->basic_setting;
        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ];

        if ($userBs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $toUser = getUser();
        $data['toMail'] = $toUser->email;
        $data['toName'] = $toUser->username;
        $data['subject'] = $request->subject;
        $data['body'] = "<div>$request->message</div><br>
                         <strong>To contact further with the enquirer please use the below information:</strong><br>
                         <strong>Enquirer Name:</strong> $request->name <br>
                         <strong>Enquirer Mail:</strong> $request->email <br>
                         ";
        $data['fullname'] = $request->name;
        $data['email'] = $request->email;
        $mailer = new MegaMailer();
        $mailer->mailContactMessage($data);
        Session::flash('success', $keywords['Email sent successfully!'] ?? 'Email sent successfully!');
        return back();
    }


    public function career(Request $request, $domain)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $data['jcats'] = $currentLang->job_categories()
            ->where('status', 1)
            ->where('user_id', $user->id)
            ->orderBy('serial_number', 'ASC')
            ->get();
        $category = $request->category;
        $term = $request->term;
        if (!empty($category)) {
            $data['category'] = Jcategory::query()
                ->where('user_id', $user->id)
                ->findOrFail($category);
        }
        $data['jobs'] = Job::query()
            ->where('user_id', $user->id)
            ->when($category, function ($query, $category) {
                return $query->where('jcategory_id', $category);
            })->when($term, function ($query, $term) {
                return $query->where('title', 'like', '%' . $term . '%');
            })->when($currentLang, function ($query, $currentLang) {
                return $query->where('language_id', $currentLang->id);
            })
            ->orderBy('serial_number', 'ASC')
            ->paginate(4);

        $data['jobscount'] = Job::query()
            ->where('user_id', $user->id)
            ->when($currentLang, function ($query, $currentLang) {
                return $query->where('language_id', $currentLang->id);
            })->count();

        return view('user-front.fastfood.career', $data);
    }


    public function careerDetails($domain, $slug, $id)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $data['jcats'] = $currentLang->job_categories()
            ->where('status', 1)
            ->where('user_id', $user->id)
            ->orderBy('serial_number', 'ASC')
            ->get();
        $data['job'] = Job::query()
            ->where('user_id', $user->id)
            ->findOrFail($id);
        $data['jobscount'] = Job::query()
            ->where('user_id', $user->id)
            ->when($currentLang, function ($query, $currentLang) {
                return $query->where('language_id', $currentLang->id);
            })->count();
        return view('user-front.fastfood.career-details', $data);
    }

    public function gallery($domain)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $lang_id = $currentLang->id;
        $data['galleries'] = Gallery::query()
            ->where('user_id', $user->id)
            ->where('language_id', $lang_id)
            ->orderBy('serial_number', 'ASC')
            ->get();
        return view('user-front.fastfood.gallery', $data);
    }

    public function faq($domain)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $lang_id = $currentLang->id;
        $data['faqs'] = Faq::query()
            ->where('user_id', $user->id)
            ->where('language_id', $lang_id)
            ->orderBy('serial_number', 'ASC')
            ->get();
        return view('user-front.fastfood.faq', $data);
    }

    public function team($domain)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $data['members'] = Member::query()
            ->when($currentLang, function ($query, $currentLang) use ($user) {
                return $query->where('language_id', $currentLang->id)
                    ->where('user_id', $user->id);
            })->get();
        return view('user-front.fastfood.teams', $data);
    }

    public function dynamicPage($domain, $slug)
    {
        $user = getUser();
        if (session()->has('user_lang')) {
            $currentLang = Language::query()
                ->where('code', session()->get('user_lang'))
                ->where('user_id', $user->id)
                ->first();
        } else {
            $currentLang = Language::query()
                ->where('is_default', 1)
                ->where('user_id', $user->id)
                ->first();
        }
        $data['page'] = Page::query()
            ->join('user_page_contents', 'user_pages.id', '=', 'user_page_contents.page_id')
            ->where('user_pages.status', '=', 1)
            ->where('user_page_contents.language_id', '=', $currentLang->id)
            ->where('user_page_contents.slug', '=', $slug)
            ->firstOrFail();
        return view('user-front.fastfood.dynamic', $data);
    }

    public function changeLanguage($domain, $lang, $type = 'website')
    {
        session()->put('user_lang', $lang);
        if ($type == 'qr') {
            return redirect()->route('user.front.qrmenu', getParam());
        } else {
            return redirect()->route('user.front.index', getParam());
        }
    }

    public function callWaiter(Request $request)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($currentLang->keywords, true);

        $currPackageFeatures = UserPermissionHelper::packagePermission($user->id);
        $currPackageFeatures = json_decode($currPackageFeatures, true);


        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

        $request->validate([
            'table' => 'required'
        ]);

        $messages = [
            'table.required' => 'The new password field is required',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'table' => 'required',
            ],
            $messages
        );

        // if given old password matches with the password of this authenticated user...

        if ($validator->fails()) {

            return redirect()->route('user.change.password')
                ->withErrors($validator);
        }

        if (!empty($be['pusher_app_id']) && !empty($be['pusher_app_key']) && !empty($be['pusher_app_secret']) && !empty($be['pusher_app_cluster']) && (is_array($currPackageFeatures) && in_array('Live Orders', $currPackageFeatures))) {

            $pusherCredentials = [
                'driver' => 'pusher',
                'app_id' => $be['pusher_app_id'],
                'key' => $be['pusher_app_key'],
                'secret' => $be['pusher_app_secret'],
                'options' => [
                    'cluster' => $be['pusher_app_cluster'],
                ],
            ];

            Config::set('broadcasting.connections.pusher', $pusherCredentials);
            event(new WaiterCalled($request->table));
            Session::flash('success', $keywords['Restaurant is informed!'] ?? __('Restaurant is informed!'));
            return back();
        } else {

            Session::flash('success', $keywords['Credetials not set yet'] ?? __('Credetials not set yet'));
            return back();
        }
    }
    public function ajaxSearchProducts(Request $request)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $searchTerm = $request->term;

        if (empty($searchTerm)) {
            return response()->json([]);
        }

        $products = Product::query()
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('products.user_id', $user->id)
            ->where('product_informations.language_id', $currentLang->id)
            ->where('product_informations.title', 'LIKE', '%' . $searchTerm . '%')
            ->where('products.status', 1)
            ->select(
                'products.id',
                'products.image',
                'products.current_price',
                'product_informations.title',
                'product_informations.slug'
            )
            ->limit(8)
            ->get();

        foreach ($products as $product) {
            $product->image_url = !empty($product->image) ? Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_IMAGE, $product->image, $user) : asset('assets/tenant/image/default.png');
            $product->details_url = route('user.front.product.details', [$product->slug, $product->id] + getParam());
        }

        return response()->json($products);
    }
}
