<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Package;
use App\Models\User\Menu;
use App\Models\Membership;
use App\Constants\Constant;
use App\Models\BasicSetting;
use App\Models\User\Product;
use Illuminate\Http\Request;
use App\Models\BasicExtended;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Models\OfflineGateway;
use App\Models\PaymentGateway;
use App\Models\User\OrderTime;
use App\Models\User\BasicExtra;
use App\Http\Helpers\MegaMailer;
use App\Models\User\PageHeading;
use App\Rules\ImageMimeTypeRule;
use App\Models\User\Journal\Blog;
use App\Models\User\ServingMethod;
use Illuminate\Support\Facades\DB;
use App\Models\User\UserPermission;
use App\Http\Controllers\Controller;
use App\Models\User\CustomPage\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User\ProductInformation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\User\CustomPage\PageContent;
use App\Models\User\Journal\BlogInformation;
use App\Http\Controllers\Front\CheckoutController;
use App\Models\User\PaymentGateway as UserPaymentGateway;

class RegisterUserController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->term;
        $users = User::query()
            ->when($term, function ($query, $term) {
                $query->where('username', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%');
            })
            ->whereNull('admin_id')
            ->latest()
            ->paginate(10);

        $online = PaymentGateway::query()->where('status', 1)->get();
        $offline = OfflineGateway::query()->where('status', 1)->get();
        $gateways = $online->merge($offline);
        $packages = Package::query()->where('status', '1')->get();
        return view('admin.register_user.index', compact('users', 'gateways', 'packages'));
    }

    public function view($id)
    {
        $user = User::query()->findOrFail($id);
        $packages = Package::query()->where('status', '1')->get();
        $online = PaymentGateway::query()->where('status', 1)->get();
        $offline = OfflineGateway::where('status', 1)->get();
        $gateways = $online->merge($offline);
        return view('admin.register_user.details', compact('user', 'packages', 'gateways'));
    }

    public function store(Request $request)
    {

        $rules = [
            'username' => 'required|alpha_num|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'package_id' => 'required',
            'payment_gateway' => 'required',
            'online_status' => 'required'
        ];

        $messages = [
            'package_id.required' => 'The package field is required',
            'online_status.required' => 'The publicly hidden field is required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $user = User::query()->where('username', $request['username']);
        if ($user->count() == 0) {
            $user = User::create([
                'email' => $request['email'],
                'username' => $request['username'],
                'password' => bcrypt($request['password']),
                'online_status' => $request["online_status"],
                'status' => 1,
                'email_verified' => 1,
            ]);
        }

        if ($user) {
            $checkoutController = new CheckoutController;
            $checkoutController->insertMailTemplate($user);
            $deLang = Language::query()->firstOrFail();
            $langCount = Language::query()
                ->where('user_id', $user->id)
                ->where('is_default', 1)
                ->count();
            if ($langCount == 0) {
                $lang = Language::create([
                    'name' => 'English',
                    'code' => 'en',
                    'is_default' => 1,
                    'rtl' => 0,
                    'user_id' => $user->id,
                    'keywords' => $deLang->keywords
                ]);

                $umenu = new Menu();
                $umenu->language_id = $lang->id;
                $umenu->user_id = $user->id;
                $umenu->menus = '[{"text":"Home","href":"","icon":"empty","target":"_self","title":"","type":"home"},{"text":"Menu","href":"","icon":"empty","target":"_self","title":"","type":"menu"},{"text":"Items","href":"","icon":"empty","target":"_self","title":"","type":"items"},{"text":"Cart","href":"","icon":"empty","target":"_self","title":"","type":"cart"},{"text":"Checkout","href":"","icon":"empty","target":"_self","title":"","type":"checkout"},{"type":"custom","text":"About","href":"","target":"_self","children":[{"text":"Career","href":"","icon":"empty","target":"_self","title":"","type":"career"},{"text":"Team Members","href":"","icon":"empty","target":"_self","title":"","type":"team"},{"text":"Gallery","href":"","icon":"empty","target":"_self","title":"","type":"gallery"},{"text":"FAQ","href":"","icon":"empty","target":"_self","title":"","type":"faq"}]},{"text":"Blog","href":"","icon":"empty","target":"_self","title":"","type":"blog"},{"text":"Contact","href":"","icon":"empty","target":"_self","title":"","type":"contact"}]';
                $umenu->save();
            }

            // create payment gateways
            $payment_keywords = ['flutterwave', 'razorpay', 'paytm', 'paystack', 'instamojo', 'stripe', 'paypal', 'mollie', 'mercadopago', 'authorize.net'];
            foreach ($payment_keywords as $key => $value) {
                UserPaymentGateway::create([
                    'title' => null,
                    'user_id' => $user->id,
                    'details' => null,
                    'keyword' => $value,
                    'subtitle' => null,
                    'name' => ucfirst($value),
                    'type' => 'automatic',
                    'information' => null
                ]);
            }

            $package = Package::query()->find($request['package_id']);
            $be = BasicExtended::query()->first();
            $bs = BasicSetting::query()->select('website_title')->first();
            $transaction_id = UserPermissionHelper::uniqueId(8);

            $startDate = Carbon::today()->format('Y-m-d');
            if ($package->term === "month") {
                $endDate = Carbon::today()->addMonth()->format('Y-m-d');
            } elseif ($package->term === "year") {
                $endDate = Carbon::today()->addYear()->format('Y-m-d');
            } elseif ($package->term === "lifetime") {
                $endDate = Carbon::maxValue()->format('d-m-Y');
            }

            $memb = Membership::create([
                'price' => $package->price,
                'currency' => $be->base_currency_text ? $be->base_currency_text : "USD",
                'currency_symbol' => $be->base_currency_symbol ? $be->base_currency_symbol : $be->base_currency_text,
                'payment_method' => $request["payment_gateway"],
                'transaction_id' => $transaction_id ? $transaction_id : 0,
                'status' => 1,
                'is_trial' => 0,
                'trial_days' => 0,
                'receipt' => $request["receipt_name"] ? $request["receipt_name"] : null,
                'transaction_details' => null,
                'settings' => json_encode($be),
                'package_id' => $request['package_id'],
                'user_id' => $user->id,
                'start_date' => Carbon::parse($startDate),
                'expire_date' => Carbon::parse($endDate),
            ]);
            $package = Package::query()->findOrFail($request['package_id']);
            $features = json_decode($package->features, true);
            $features[] = "Contact";
            UserPermission::create([
                'package_id' => $request['package_id'],
                'user_id' => $user->id,
                'permissions' => json_encode($features)
            ]);
            User\BasicSetting::create([
                'base_color' => 'D3A971',
                'language_id' => $lang->id,
                'user_id' => $user->id,
                'home_version' => 'slider',
                'support_email' => $user->email,
                'support_phone' => $user->phone,
                'website_title' => $user->username,
            ]);

            PageHeading::create([
                'language_id' => $lang->id,
                'user_id' => $user->id,
            ]);

            User\BasicExtended::create([
                'base_currency_symbol' => '$',
                'base_currency_text' => 'USD',
                'base_currency_rate' => 1.00,
                'language_id' => $lang->id,
                'user_id' => $user->id,
                'from_mail' => $user->email,
                'from_name' => $user->username,
            ]);
            BasicExtra::create([
                'user_id' => $user->id,
            ]);

            ServingMethod::query()->insert(['user_id' => $user->id, 'name' => 'On Table', 'value' => 'on_table', 'serial_number' => 1]);
            ServingMethod::query()->insert(['user_id' => $user->id, 'name' => 'Pick Up', 'value' => 'pick_up', 'serial_number' => 2]);
            ServingMethod::query()->insert(['user_id' => $user->id, 'name' => 'Home Delivery', 'value' => 'home_delivery', 'serial_number' => 3]);

            $orderTimeData = [
                ['user_id' => $user->id, 'day' => 'monday'],
                ['user_id' => $user->id, 'day' => 'tuesday'],
                ['user_id' => $user->id, 'day' => 'wednesday'],
                ['user_id' => $user->id, 'day' => 'thursday'],
                ['user_id' => $user->id, 'day' => 'friday'],
                ['user_id' => $user->id, 'day' => 'saturday'],
                ['user_id' => $user->id, 'day' => 'sunday'],
            ];
            OrderTime::query()->insert($orderTimeData);
            // user seo insert
            User\SEO::query()->create([
                'user_id' => $user->id,
                'language_id' => $lang->id,
                'home_meta_keywords' => 'home_meta_keywords',
                'home_meta_description' => 'home_meta_description',
                'career_meta_keywords' => 'career_meta_keywords',
                'career_meta_description' => 'career_meta_description',
                'blogs_meta_keywords' => 'blogs_meta_keywords',
                'blogs_meta_description' => 'blogs_meta_description',
                'gallery_meta_keywords' => 'gallery_meta_keywords',
                'gallery_meta_description' => 'gallery_meta_description',
                'faqs_meta_keywords' => 'faqs_meta_keywords',
                'faqs_meta_description' => 'faqs_meta_description',
                'contact_meta_keywords' => 'contact_meta_keywords',
                'contact_meta_description' => 'contact_meta_description',
                'reservation_meta_keywords' => 'reservation_meta_keywords',
                'reservation_meta_description' => 'reservation_meta_description',
                'team_meta_keywords' => 'team_meta_keywords',
                'team_meta_description' => 'team_meta_description',
                'product_meta_keywords' => 'product_meta_keywords',
                'product_meta_description' => 'product_meta_description',
                'checkout_meta_keywords' => 'checkout_meta_keywords',
                'checkout_meta_description' => 'checkout_meta_description',
                'login_meta_keywords' => 'login_meta_keywords',
                'login_meta_description' => 'login_meta_description',
                'sign_up_meta_keywords' => 'sign_up_meta_keywords',
                'sign_up_meta_description' => 'sign_up_meta_description',
                'forget_password_meta_keywords' => 'forget_password_meta_keywords',
                'forget_password_meta_description' => 'forget_password_meta_description',
                'cart_meta_keywords' => 'cart_meta_keywords',
                'cart_meta_description' => 'cart_meta_description'
            ]);
            $requestData = [
                'start_date' => $startDate,
                'expire_date' => $endDate,
                'payment_method' => $request['payment_gateway']
            ];
            $file_name = $this->makeInvoice($requestData, "membership", $user, null, $package->price, $request['payment_gateway'], null, $be->base_currency_symbol_position, $be->base_currency_symbol, $be->base_currency_text, $transaction_id, $package->title, $memb);

            $mailer = new MegaMailer();
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
            $data = [
                'toMail' => $user->email,
                'toName' => $user->fname,
                'username' => $user->username,
                'package_title' => $package->title,
                'package_price' => ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $package->price . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : ''),
                'activation_date' => $startDate->toFormattedDateString(),
                'expire_date' => $package->term === "lifetime" ? 'Lifetime' : $endDate->toFormattedDateString(),
                'membership_invoice' => $file_name,
                'website_title' => $bs->website_title,
                'templateType' => 'registration_with_free_package',
                'type' => 'registrationWithFreePackage'
            ];
            $mailer->mailFromAdmin($data);
        }
        Session::flash('success', 'User added successfully!');
        return "success";
    }

    public function userban(Request $request)
    {
        $user = User::query()->where('id', $request->user_id)->first();

        $user->update([
            'status' => $request->status,
        ]);
        Session::flash('success', 'Status update successfully!');
        return back();
    }

    public function emailStatus(Request $request)
    {
        $user = User::query()->findOrFail($request->user_id);
        $user->update([
            'email_verified' => $request->email_verified,
        ]);
        Session::flash('success', 'Email status updated for ' . $user->username);
        return back();
    }

    public function userFeatured(Request $request)
    {
        $user = User::query()->where('id', $request->user_id)->first();
        $user->featured = $request->featured;
        $user->save();
        Session::flash('success', 'User featured update successfully!');
        return back();
    }

    public function changePass($id)
    {
        $data['user'] = User::query()->findOrFail($id);
        return view('admin.register_user.password', $data);
    }

    public function updatePassword(Request $request)
    {
        $messages = [
            'npass.required' => 'New password is required',
            'cfpass.required' => 'Confirm password is required',
        ];

        $request->validate([
            'npass' => 'required',
            'cfpass' => 'required',
        ], $messages);

        $user = User::query()->findOrFail($request->user_id);
        if ($request->npass == $request->cfpass) {
            $input['password'] = Hash::make($request->npass);
        } else {
            return back()->with('warning', __('Confirm password does not match.'));
        }
        $user->update($input);
        Session::flash('success', 'Password update for ' . $user->username);
        return back();
    }

    public function delete(Request $request)
    {

        $user = User::query()->findOrFail($request->user_id);
        return DB::transaction(function () use ($request, $user) {

            $bss = null;

            /**
             * delete 'blog categories' info
             */
            if ($user->blog_categories()->count() > 0) {
                $user->blog_categories()->delete();
            }
            /**
             * delete 'blog infos'
             */
            $blogInfos = BlogInformation::query()->where('user_id', $user->id)->get();

            if (count($blogInfos) > 0) {
                foreach ($blogInfos as $blogData) {
                    $blogInfo = $blogData;
                    $blogData->delete();

                    // delete the blog if, this blog does not contain any other blog information in any other language
                    $otherBlogInfos = BlogInformation::query()
                        ->where('user_id', '=', $user->id)
                        ->where('blog_id', '=', $blogInfo->blog_id)
                        ->get();

                    if (count($otherBlogInfos) == 0) {
                        $blog = Blog::query()
                            ->where('user_id', $user->id)
                            ->find($blogInfo->blog_id);
                        Uploader::remove(Constant::WEBSITE_BLOG_IMAGE, $blog->image, $bss, $user->id);
                        $blog->delete();
                    }
                }
            }
            /**
             * delete 'custom domains' info
             */
            $custom_domains = $user->custom_domains()->get();
            if ($custom_domains->count() > 0) {
                foreach ($custom_domains as $custom_domain) {
                    $custom_domain->delete();
                }
            }
            /**
             * delete 'coupons' info
             */
            if ($user->coupons()->count() > 0) {
                $user->coupons()->delete();
            }

            /**
             * delete 'user faqs' info
             */
            $faqs = $user->faqs()->get();
            if ($faqs->count() > 0) {
                foreach ($faqs as $faq) {
                    $faq->delete();
                }
            }
            /**
             * delete 'social medias' info
             */
            if ($user->social_media()->count() > 0) {
                $user->social_media()->delete();
            }
            /**
             * delete 'languages' info
             */
            if ($user->languages()->count() > 0) {
                $user->languages()->delete();
            }
            /**
             * delete 'feature' info
             */
            $features = $user->features()->get();
            if ($features->count() > 0) {
                foreach ($features as $feature) {
                    Uploader::remove(Constant::WEBSITE_FEATURE_IMAGES, $feature->image, $bss, $user->id);
                    $feature->delete();
                }
            }
            /**
             * delete 'mail templates' info
             */
            $mail_templates = $user->mail_templates()->get();

            if (!empty($mail_templates)) {
                foreach ($mail_templates as $mt) {
                    if (!empty($mt)) {
                        $mt->delete();
                    }
                }
            }
            /**
             * delete 'menus' info
             */
            if ($user->menus()->count() > 0) {
                $user->menus()->delete();
            }
            /**
             * delete 'seo' info
             */
            $seos = $user->seos()->get();
            if ($seos->count() > 0) {
                foreach ($seos as $seo) {
                    $seo->delete();
                }
            }
            /**
             * delete 'offline gateways' info
             */
            if ($user->offline_gateways()->count() > 0) {
                $user->offline_gateways()->delete();
            }
            /**
             * delete 'page contents'
             */
            $customPageInfos = $user->customPageInfo()->get();
            if (count($customPageInfos) > 0) {
                foreach ($customPageInfos as $customPageData) {
                    $customPageInfo = $customPageData;
                    $customPageData->delete();

                    // delete the 'custom page' if, this page does not contain any other page content in any other language
                    $otherPageContents = PageContent::query()
                        ->where('user_id', $user->id)
                        ->where('page_id', '=', $customPageInfo->page_id)
                        ->get();

                    if (count($otherPageContents) == 0) {
                        $page = Page::query()
                            ->where('user_id', $user->id)
                            ->find($customPageInfo->page_id);
                        if ($page) {

                            $page->delete();
                        };
                    }
                }
            }
            /**
             * delete 'page heading' info
             */
            $page_heading = $user->page_heading()->first();
            if (!empty($page_heading)) {
                $page_heading->delete();
            }
            /**
             * delete 'payment gateways' info
             */
            if ($user->payment_gateways()->count() > 0) {
                $user->payment_gateways()->delete();
            }
            /**
             * delete 'permissions' info
             */
            if ($user->permissions()->count() > 0) {
                $user->permissions()->delete();
            }
            /**
             * delete 'popup' infos
             */
            $popups = $user->announcementPopup()->get();
            if (count($popups) > 0) {
                foreach ($popups as $popup) {
                    Uploader::remove(Constant::WEBSITE_ANNOUNCEMENT_POPUP_IMAGE, $popup->image, $bss, $user->id);
                    $popup->delete();
                }
            }
            /**
             * delete 'roles' info
             */
            if ($user->roles()->count() > 0) {
                $user->roles()->delete();
            }
            /**
             * delete 'social links' info
             */
            if ($user->social_links()->count() > 0) {
                $user->social_links()->delete();
            }
            /**
             * delete 'subscribers' info
             */
            if ($user->subscribers()->count() > 0) {
                $user->subscribers()->delete();
            }
            /**
             * delete 'user testimonials' info
             */
            if ($user->testimonials()->count() > 0) {
                $testimonials = $user->testimonials()->get();
                foreach ($testimonials as $testimonial) {
                    Uploader::remove(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->image, $bss, $user->id);
                    $testimonial->delete();
                }
            }
            /**
             * delete 'ulinks' info
             */
            if ($user->useful_links()->count() > 0) {
                $user->useful_links()->delete();
            }
            /**
             * delete 'products' info
             */
            $products = $user->products()->get();
            if (count($products) > 0) {
                foreach ($products as $p) {
                    $product = Product::query()
                        ->with('product_images')
                        ->join('product_informations', 'products.id', 'product_informations.product_id')
                        ->where('products.user_id', $user->id)
                        ->where('products.id', $p->id)
                        ->first();
                    foreach ($product->product_images as $pi) {
                        Uploader::remove(Constant::WEBSITE_PRODUCT_SLIDER_IMAGE, $pi->image, $bss, $user->id);
                        $pi->delete();
                    }
                    ProductInformation::query()
                        ->where('product_id', $p->id)
                        ->where('user_id', $user->id)
                        ->delete();
                    Uploader::remove(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $bss, $user->id);
                    $product->query()->find($p->id)->delete();
                }
            }
            /**
             * delete 'product categories' info
             */
            if ($user->product_categories()->count() > 0) {
                $categories = $user->product_categories()->get();
                foreach ($categories as $category) {
                    Uploader::remove(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $category->image, $bss, $user->id);
                    $category->delete();
                }
            }
            /**
             * delete 'postal codes' info
             */
            if ($user->postal_codes()->count() > 0) {
                $user->postal_codes()->delete();
            }
            /**
             * delete 'pos payment methods' info
             */
            if ($user->pos_payment_methods()->count() > 0) {
                $user->pos_payment_methods()->delete();
            }
            /**
             * delete 'product orders' info
             */
            if ($user->product_orders()->count() > 0) {
                $orders = $user->product_orders()->get();
                foreach ($orders as $order) {
                    Uploader::remove(Constant::WEBSITE_PRODUCT_INVOICE, $order->invoice_number, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_PRODUCT_RECEIPT, $order->receipt, $bss, $user->id);
                    $order->delete();
                }
            }
            /**
             * delete 'product reviews' info
             */
            if ($user->product_reviews()->count() > 0) {
                $user->product_reviews()->delete();
            }
            /**
             * delete 'product subcategories' info
             */
            if ($user->product_subcategories()->count() > 0) {
                $user->product_subcategories()->delete();
            }
            /**
             * delete 'reservation inputs' info
             */
            if ($user->reservation_inputs()->count() > 0) {
                $user->reservation_inputs()->delete();
            }
            /**
             * delete 'reservation input options' info
             */
            if ($user->reservation_input_options()->count() > 0) {
                $user->reservation_input_options()->delete();
            }
            /**
             * delete 'serving methods options' info
             */
            if ($user->serving_methods()->count() > 0) {
                $user->serving_methods()->delete();
            }
            /**
             * delete 'shipping charges' info
             */
            if ($user->shipping_charges()->count() > 0) {
                $user->shipping_charges()->delete();
            }
            /**
             * delete 'sitemaps' info
             */
            if ($user->sitemaps()->count() > 0) {
                $user->sitemaps()->delete();
            }
            /**
             * delete 'sliders' info
             */
            if ($user->sliders()->count() > 0) {
                $sliders = $user->sliders()->get();
                foreach ($sliders as $slider) {
                    Uploader::remove(Constant::WEBSITE_SLIDER_IMAGES, $slider->image, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_SLIDER_BACKGROUND_IMAGES, $slider->bg_image, $bss, $user->id);
                    $slider->delete();
                }
            }
            /**
             * delete 'job categories' info
             */
            if ($user->job_categories()->count() > 0) {
                $user->job_categories()->delete();
            }
            /**
             * delete 'jobs' info
             */
            if ($user->jobs()->count() > 0) {
                $user->jobs()->delete();
            }
            /**
             * delete 'galleries' info
             */
            if ($user->gallery()->count() > 0) {
                $galleries = $user->gallery()->get();
                foreach ($galleries as $gallery) {
                    Uploader::remove(Constant::WEBSITE_GALLERY_IMAGES, $gallery->image, $bss, $user->id);
                    $gallery->delete();
                }
            }
            /**
             * delete 'guests' info
             */
            if ($user->guests()->count() > 0) {
                $user->guests()->delete();
            }
            /**
             * delete 'members' info
             */
            if ($user->members()->count() > 0) {
                $members = $user->members()->get();
                foreach ($members as $member) {
                    Uploader::remove(Constant::WEBSITE_MEMBER_IMAGES, $member->image, $bss, $user->id);
                    $member->delete();
                }
            }
            /**
             * delete 'order items' info
             */
            if ($user->order_items()->count() > 0) {
                $user->order_items()->delete();
            }
            /**
             * delete 'order times' info
             */
            if ($user->order_times()->count() > 0) {
                $user->order_times()->delete();
            }
            /**
             * delete 'tables' info
             */
            if ($user->tables()->count() > 0) {
                $tables = $user->tables()->get();
                foreach ($tables as $table) {
                    Uploader::remove(Constant::WEBSITE_TABLE_IMAGE, $table->qr_image, $bss, $user->id);
                    $table->delete();
                }
            }
            /**
             * delete 'table books' info
             */
            if ($user->table_books()->count() > 0) {
                $user->table_books()->delete();
            }
            /**
             * delete 'table books' info
             */
            if ($user->time_frames()->count() > 0) {
                $user->time_frames()->delete();
            }
            /**
             * delete 'products' info
             */
            $products = Product::query()
                ->where('user_id', $user->id)
                ->get();
            foreach ($products as $product) {
                foreach ($product->product_images as $pi) {
                    Uploader::remove(Constant::WEBSITE_PRODUCT_SLIDER_IMAGE, $pi->image, $bss, $user->id);
                    $pi->delete();
                }
                Uploader::remove(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $bss, $user->id);
                ProductInformation::query()
                    ->where('product_id', $product->id)
                    ->where('user_id', $user->id)
                    ->delete();
                $product->delete();
            }
            /**
             * delete 'customers' info
             */
            if ($user->customers()->count() > 0) {
                $user->customers()->delete();
            }
            /**
             * delete 'clients' info
             */
            if ($user->clients()->count() > 0) {
                $clients = $user->clients()->get();
                foreach ($clients as $client) {
                    Uploader::remove(Constant::WEBSITE_CUSTOMER_IMAGE, $client->photo, $bss, $user->id);
                    $client->delete();
                }
            }
            /**
             * delete 'admins' info
             */
            if (!is_null($user?->admin_id)) {

                $admins = User::query()->where('admin_id', $user->id)->get();
                if ($admins->count() > 0) {
                    foreach ($admins as $admin) {
                        deleteFile(Constant::WEBSITE_TENANT_USER_IMAGE, $admin->image);
                        $admin->delete();
                    }
                }
            }
            /**
             * delete 'basic extra' info
             */
            if ($user->basic_extra()->count() > 0) {
                $user->basic_extra()->delete();
            }
            /**
             * delete 'basic extendeds' info
             */
            if ($user->basic_extendeds()->count() > 0) {
                $basic_extendeds = $user->basic_extendeds()->get();
                foreach ($basic_extendeds as $basic_extended) {
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->slider_shape_img, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->slider_bottom_img, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->footer_bottom_img, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->menu_section_img, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->table_section_img, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_bg, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_shape_img, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_bottom_img, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_side_img, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_side_img, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->special_section_bg, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_TABLE_IMAGE, $basic_extended->qr_image, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_QR_IMAGE, $basic_extended->qr_inserted_image, $bss, $user->id);
                    $basic_extended->delete();
                }
            }
            /**
             * delete 'basic settings' info
             */
            if ($user->basic_settings()->count() > 0) {
                $basic_settings = $user->basic_settings()->get();
                foreach ($basic_settings as $basic_setting) {
                    Uploader::remove(Constant::WEBSITE_LOGO, $basic_setting->logo, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_FAVICON, $basic_setting->favicon, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_BREADCRUMB, $basic_setting->breadcrumb, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_PRELOADER, $basic_setting->preloader, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->footer_logo, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->intro_video_image, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->intro_main_image, $bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->intro_signature, $bss, $user->id);
                    $basic_setting->delete();
                }
            }
            //  renter delete
            $renters = User::where('admin_id', $user->id)->get();
            if ($renters->count() > 0) {
                foreach ($renters as $renter) {
                    $renter->delete();
                }
            }
            //user profile image
            deleteFile('assets/front/img/template-previews', $user->template_img);
            deleteFile(Constant::WEBSITE_TENANT_USER_IMAGE, $user->image);
            /**
             * delete 'memberships' info
             */
            $memberships = $user->memberships()->get();
            if ($memberships->count() > 0) {
                foreach ($memberships as $membership) {
                    @unlink(public_path('assets/front/img/membership/receipt/' . $membership->receipt));
                    $membership->delete();
                }
            }

            $user->delete();
            Session::flash('success', 'User deleted successfully!');
            return back();
        });
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $user = User::query()->findOrFail($id);
            DB::transaction(function () use ($request, $user) {

                $bss = null;

                /**
                 * delete 'blog categories' info
                 */
                if ($user->blog_categories()->count() > 0) {
                    $user->blog_categories()->delete();
                }
                /**
                 * delete 'blog infos'
                 */
                $blogInfos = BlogInformation::query()->where('user_id', $user->id)->get();

                if (count($blogInfos) > 0) {
                    foreach ($blogInfos as $blogData) {
                        $blogInfo = $blogData;
                        $blogData->delete();

                        // delete the blog if, this blog does not contain any other blog information in any other language
                        $otherBlogInfos = BlogInformation::query()
                            ->where('user_id', '=', $user->id)
                            ->where('blog_id', '=', $blogInfo->blog_id)
                            ->get();

                        if (count($otherBlogInfos) == 0) {
                            $blog = Blog::query()
                                ->where('user_id', $user->id)
                                ->find($blogInfo->blog_id);
                            Uploader::remove(Constant::WEBSITE_BLOG_IMAGE, $blog->image, $bss, $user->id);
                            $blog->delete();
                        }
                    }
                }
                /**
                 * delete 'custom domains' info
                 */
                $custom_domains = $user->custom_domains()->get();
                if ($custom_domains->count() > 0) {
                    foreach ($custom_domains as $custom_domain) {
                        $custom_domain->delete();
                    }
                }
                /**
                 * delete 'coupons' info
                 */
                if ($user->coupons()->count() > 0) {
                    $user->coupons()->delete();
                }

                /**
                 * delete 'user faqs' info
                 */
                $faqs = $user->faqs()->get();
                if ($faqs->count() > 0) {
                    foreach ($faqs as $faq) {
                        $faq->delete();
                    }
                }
                /**
                 * delete 'social medias' info
                 */
                if ($user->social_media()->count() > 0) {
                    $user->social_media()->delete();
                }
                /**
                 * delete 'languages' info
                 */
                if ($user->languages()->count() > 0) {
                    $user->languages()->delete();
                }
                /**
                 * delete 'feature' info
                 */
                $features = $user->features()->get();
                if ($features->count() > 0) {
                    foreach ($features as $feature) {
                        Uploader::remove(Constant::WEBSITE_FEATURE_IMAGES, $feature->image, $bss, $user->id);
                        $feature->delete();
                    }
                }
                /**
                 * delete 'mail templates' info
                 */
                $mail_templates = $user->mail_templates()->get();

                if (!empty($mail_templates)) {
                    foreach ($mail_templates as $mt) {
                        if (!empty($mt)) {
                            $mt->delete();
                        }
                    }
                }
                /**
                 * delete 'menus' info
                 */
                if ($user->menus()->count() > 0) {
                    $user->menus()->delete();
                }
                /**
                 * delete 'offline gateways' info
                 */
                if ($user->offline_gateways()->count() > 0) {
                    $user->offline_gateways()->delete();
                }
                /**
                 * delete 'page contents'
                 */
                $customPageInfos = $user->customPageInfo()->get();

                if (count($customPageInfos) > 0) {
                    foreach ($customPageInfos as $customPageData) {
                        $customPageInfo = $customPageData;
                        $customPageData->delete();

                        // delete the 'custom page' if, this page does not contain any other page content in any other language
                        $otherPageContents = PageContent::query()
                            ->where('user_id', $user->id)
                            ->where('page_id', '=', $customPageInfo->page_id)
                            ->get();

                        if (count($otherPageContents) == 0) {
                            $page = Page::query()
                                ->where('user_id', $user->id)
                                ->find($customPageInfo->page_id);
                            $page->delete();
                        }
                    }
                }
                /**
                 * delete 'page heading' info
                 */
                $page_heading = $user->page_heading()->first();
                if (!empty($page_heading)) {
                    $page_heading->delete();
                }
                /**
                 * delete 'payment gateways' info
                 */
                if ($user->payment_gateways()->count() > 0) {
                    $user->payment_gateways()->delete();
                }
                /**
                 * delete 'permissions' info
                 */
                if ($user->permissions()->count() > 0) {
                    $user->permissions()->delete();
                }
                /**
                 * delete 'popup' infos
                 */
                $popups = $user->announcementPopup()->get();
                if (count($popups) > 0) {
                    foreach ($popups as $popup) {
                        Uploader::remove(Constant::WEBSITE_ANNOUNCEMENT_POPUP_IMAGE, $popup->image, $bss, $user->id);
                        $popup->delete();
                    }
                }
                /**
                 * delete 'roles' info
                 */
                if ($user->roles()->count() > 0) {
                    $user->roles()->delete();
                }
                /**
                 * delete 'social links' info
                 */
                if ($user->social_links()->count() > 0) {
                    $user->social_links()->delete();
                }
                /**
                 * delete 'subscribers' info
                 */
                if ($user->subscribers()->count() > 0) {
                    $user->subscribers()->delete();
                }
                /**
                 * delete 'user testimonials' info
                 */
                if ($user->testimonials()->count() > 0) {
                    $testimonials = $user->testimonials()->get();
                    foreach ($testimonials as $testimonial) {
                        Uploader::remove(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->image, $bss, $user->id);
                        $testimonial->delete();
                    }
                }
                /**
                 * delete 'ulinks' info
                 */
                if ($user->useful_links()->count() > 0) {
                    $user->useful_links()->delete();
                }
                /**
                 * delete 'products' info
                 */
                $products = $user->products()->get();
                if (count($products) > 0) {
                    foreach ($products as $p) {
                        $product = Product::query()
                            ->with('product_images')
                            ->join('product_informations', 'products.id', 'product_informations.product_id')
                            ->where('products.user_id', $user->id)
                            ->where('products.id', $p->id)
                            ->first();
                        foreach ($product->product_images as $pi) {
                            Uploader::remove(Constant::WEBSITE_PRODUCT_SLIDER_IMAGE, $pi->image, $bss, $user->id);
                            $pi->delete();
                        }
                        ProductInformation::query()
                            ->where('product_id', $p->id)
                            ->where('user_id', $user->id)
                            ->delete();
                        Uploader::remove(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $bss, $user->id);
                        $product->query()->find($p->id)->delete();
                    }
                }
                /**
                 * delete 'product categories' info
                 */
                if ($user->product_categories()->count() > 0) {
                    $categories = $user->product_categories()->get();
                    foreach ($categories as $category) {
                        Uploader::remove(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $category->image, $bss, $user->id);
                        $category->delete();
                    }
                }
                /**
                 * delete 'postal codes' info
                 */
                if ($user->postal_codes()->count() > 0) {
                    $user->postal_codes()->delete();
                }
                /**
                 * delete 'pos payment methods' info
                 */
                if ($user->pos_payment_methods()->count() > 0) {
                    $user->pos_payment_methods()->delete();
                }
                /**
                 * delete 'product orders' info
                 */
                if ($user->product_orders()->count() > 0) {
                    $orders = $user->product_orders()->get();
                    foreach ($orders as $order) {
                        Uploader::remove(Constant::WEBSITE_PRODUCT_INVOICE, $order->invoice_number, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_PRODUCT_RECEIPT, $order->receipt, $bss, $user->id);
                        $order->delete();
                    }
                }
                /**
                 * delete 'product reviews' info
                 */
                if ($user->product_reviews()->count() > 0) {
                    $user->product_reviews()->delete();
                }
                /**
                 * delete 'product subcategories' info
                 */
                if ($user->product_subcategories()->count() > 0) {
                    $user->product_subcategories()->delete();
                }
                /**
                 * delete 'reservation inputs' info
                 */
                if ($user->reservation_inputs()->count() > 0) {
                    $user->reservation_inputs()->delete();
                }
                /**
                 * delete 'reservation input options' info
                 */
                if ($user->reservation_input_options()->count() > 0) {
                    $user->reservation_input_options()->delete();
                }
                /**
                 * delete 'serving methods options' info
                 */
                if ($user->serving_methods()->count() > 0) {
                    $user->serving_methods()->delete();
                }
                /**
                 * delete 'shipping charges' info
                 */
                if ($user->shipping_charges()->count() > 0) {
                    $user->shipping_charges()->delete();
                }
                /**
                 * delete 'sitemaps' info
                 */
                if ($user->sitemaps()->count() > 0) {
                    $user->sitemaps()->delete();
                }
                /**
                 * delete 'sliders' info
                 */
                if ($user->sliders()->count() > 0) {
                    $sliders = $user->sliders()->get();
                    foreach ($sliders as $slider) {
                        Uploader::remove(Constant::WEBSITE_SLIDER_IMAGES, $slider->image, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_SLIDER_BACKGROUND_IMAGES, $slider->bg_image, $bss, $user->id);
                        $slider->delete();
                    }
                }
                /**
                 * delete 'job categories' info
                 */
                if ($user->job_categories()->count() > 0) {
                    $user->job_categories()->delete();
                }
                /**
                 * delete 'jobs' info
                 */
                if ($user->jobs()->count() > 0) {
                    $user->jobs()->delete();
                }
                /**
                 * delete 'galleries' info
                 */
                if ($user->gallery()->count() > 0) {
                    $galleries = $user->gallery()->get();
                    foreach ($galleries as $gallery) {
                        Uploader::remove(Constant::WEBSITE_GALLERY_IMAGES, $gallery->image, $bss, $user->id);
                        $gallery->delete();
                    }
                }
                /**
                 * delete 'guests' info
                 */
                if ($user->guests()->count() > 0) {
                    $user->guests()->delete();
                }
                /**
                 * delete 'members' info
                 */
                if ($user->members()->count() > 0) {
                    $members = $user->members()->get();
                    foreach ($members as $member) {
                        Uploader::remove(Constant::WEBSITE_MEMBER_IMAGES, $member->image, $bss, $user->id);
                        $member->delete();
                    }
                }
                /**
                 * delete 'order items' info
                 */
                if ($user->order_items()->count() > 0) {
                    $user->order_items()->delete();
                }
                /**
                 * delete 'order times' info
                 */
                if ($user->order_times()->count() > 0) {
                    $user->order_times()->delete();
                }
                /**
                 * delete 'tables' info
                 */
                if ($user->tables()->count() > 0) {
                    $tables = $user->tables()->get();
                    foreach ($tables as $table) {
                        Uploader::remove(Constant::WEBSITE_TABLE_IMAGE, $table->qr_image, $bss, $user->id);
                        $table->delete();
                    }
                }
                /**
                 * delete 'table books' info
                 */
                if ($user->table_books()->count() > 0) {
                    $user->table_books()->delete();
                }
                /**
                 * delete 'table books' info
                 */
                if ($user->time_frames()->count() > 0) {
                    $user->time_frames()->delete();
                }
                /**
                 * delete 'products' info
                 */
                $products = Product::query()
                    ->where('user_id', $user->id)
                    ->get();
                foreach ($products as $product) {
                    foreach ($product->product_images as $pi) {
                        Uploader::remove(Constant::WEBSITE_PRODUCT_SLIDER_IMAGE, $pi->image, $bss, $user->id);
                        $pi->delete();
                    }
                    Uploader::remove(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $bss, $user->id);
                    ProductInformation::query()
                        ->where('product_id', $product->id)
                        ->where('user_id', $user->id)
                        ->delete();
                    $product->delete();
                }
                /**
                 * delete 'customers' info
                 */
                if ($user->customers()->count() > 0) {
                    $user->customers()->delete();
                }
                /**
                 * delete 'clients' info
                 */
                if ($user->clients()->count() > 0) {
                    $clients = $user->clients()->get();
                    foreach ($clients as $client) {
                        Uploader::remove(Constant::WEBSITE_CUSTOMER_IMAGE, $client->photo, $bss, $user->id);
                        $client->delete();
                    }
                }
                /**
                 * delete 'admins' info
                 */
                $admins = User::query()->where('admin_id', $user->id)->get();
                if ($admins->count() > 0) {
                    foreach ($admins as $admin) {
                        deleteFile(Constant::WEBSITE_TENANT_USER_IMAGE, $admin->image);
                        $admin->delete();
                    }
                }
                /**
                 * delete 'basic extra' info
                 */
                if ($user->basic_extra()->count() > 0) {
                    $user->basic_extra()->delete();
                }
                /**
                 * delete 'basic extendeds' info
                 */
                if ($user->basic_extendeds()->count() > 0) {
                    $basic_extendeds = $user->basic_extendeds()->get();
                    foreach ($basic_extendeds as $basic_extended) {
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->slider_shape_img, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->slider_bottom_img, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->footer_bottom_img, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->menu_section_img, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->table_section_img, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_bg, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_shape_img, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_bottom_img, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_side_img, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->hero_side_img, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_extended->special_section_bg, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_TABLE_IMAGE, $basic_extended->qr_image, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_QR_IMAGE, $basic_extended->qr_inserted_image, $bss, $user->id);
                        $basic_extended->delete();
                    }
                }
                /**
                 * delete 'basic settings' info
                 */
                if ($user->basic_settings()->count() > 0) {
                    $basic_settings = $user->basic_settings()->get();
                    foreach ($basic_settings as $basic_setting) {
                        Uploader::remove(Constant::WEBSITE_LOGO, $basic_setting->logo, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_FAVICON, $basic_setting->favicon, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_BREADCRUMB, $basic_setting->breadcrumb, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_PRELOADER, $basic_setting->preloader, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->footer_logo, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->intro_video_image, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->intro_main_image, $bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_IMAGE, $basic_setting->intro_signature, $bss, $user->id);
                        $basic_setting->delete();
                    }
                }
                //  renter delete
                $renters = User::where('admin_id', $user->id)->get();
                if (
                    $renters->count() > 0
                ) {
                    foreach ($renters as $renter) {
                        $renter->delete();
                    }
                }
                /**
                 * delete 'memberships' info
                 */
                $memberships = $user->memberships()->get();
                if ($memberships->count() > 0) {
                    foreach ($memberships as $membership) {
                        @unlink(public_path('assets/front/img/membership/receipt/' . $membership->receipt));
                        $membership->delete();
                    }
                }

                //user profile image
                deleteFile('assets/front/img/template-previews', $user->template_img);
                deleteFile(Constant::WEBSITE_TENANT_USER_IMAGE, $user->image, $bss, $user->id);
                $user->delete();
            });
        }
        Session::flash('success', 'Users deleted successfully!');
        return "success";
    }

    public function removeCurrPackage(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        $currMembership = UserPermissionHelper::currMembOrPending($userId);
        $currPackage = Package::select('title')->findOrFail($currMembership->package_id);
        $nextMembership = UserPermissionHelper::nextMembership($userId);
        $be = BasicExtended::first();
        $bs = BasicSetting::select('website_title')->first();

        $today = Carbon::now();

        // just expire the current package
        $currMembership->expire_date = $today->subDay();
        $currMembership->modified = 1;
        if ($currMembership->status == 0) {
            $currMembership->status = 2;
        }
        $currMembership->save();

        // if next package exists
        if (!empty($nextMembership)) {
            $nextPackage = Package::find($nextMembership->package_id);

            $nextMembership->start_date = Carbon::parse(Carbon::today()->format('d-m-Y'));
            if ($nextPackage->term == 'month') {
                $nextMembership->expire_date = Carbon::parse(Carbon::today()->addMonth()->format('d-m-Y'));
            } elseif ($nextPackage->term == 'year') {
                $nextMembership->expire_date = Carbon::parse(Carbon::today()->addYear()->format('d-m-Y'));
            } elseif ($nextPackage->term == 'lifetime') {
                $nextMembership->expire_date = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
            }
            $nextMembership->save();

            $features = json_decode($nextPackage->features, true);
            $features[] = "Contact";
            UserPermission::where('user_id', $user->id)->update([
                'package_id' => $nextPackage->id,
                'user_id' => $user->id,
                'permissions' => json_encode($features)
            ]);
        }

        $this->sendMail(NULL, NULL, $request->payment_method, $user, $bs, $be, 'admin_removed_current_package', NULL, $currPackage->title);

        Session::flash('success', 'Current Package removed successfully!');
        return back();
    }


    public function sendMail($memb, $package, $paymentMethod, $user, $bs, $be, $mailType, $replacedPackage = NULL, $removedPackage = NULL)
    {

        if ($mailType != 'admin_removed_current_package' && $mailType != 'admin_removed_next_package') {
            $transaction_id = UserPermissionHelper::uniqueId(8);
            $activation = $memb->start_date;
            $expire = $memb->expire_date;
            $info['start_date'] = $activation->toFormattedDateString();
            $info['expire_date'] = $expire->toFormattedDateString();
            $info['payment_method'] = $paymentMethod;

            $file_name = $this->makeInvoice($info, "membership", $user, NULL, $package->price, "Stripe", $user->phone, $be->base_currency_symbol_position, $be->base_currency_symbol, $be->base_currency_text, $transaction_id, $package->title, $memb);
        }

        $mailer = new MegaMailer();
        $data = [
            'toMail' => $user->email,
            'toName' => $user->fname,
            'username' => $user->username,
            'website_title' => $bs->website_title,
            'templateType' => $mailType
        ];

        if ($mailType != 'admin_removed_current_package' && $mailType != 'admin_removed_next_package') {
            $data['package_title'] = $package->title;
            $data['package_price'] = ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $package->price . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : '');
            $data['activation_date'] = $activation->toFormattedDateString();
            $data['expire_date'] = Carbon::parse($expire->toFormattedDateString())->format('Y') == '9999' ? 'Lifetime' : $expire->toFormattedDateString();
            $data['membership_invoice'] = $file_name;
        }
        if ($mailType != 'admin_removed_current_package' || $mailType != 'admin_removed_next_package') {
            $data['removed_package_title'] = $removedPackage;
        }

        if (!empty($replacedPackage)) {
            $data['replaced_package'] = $replacedPackage;
        }

        $mailer->mailFromAdmin($data);
    }


    public function changeCurrPackage(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        $currMembership = UserPermissionHelper::currMembOrPending($userId);
        $nextMembership = UserPermissionHelper::nextMembership($userId);

        $be = BasicExtended::first();
        $bs = BasicSetting::select('website_title')->first();

        $selectedPackage = Package::find($request->package_id);


        // if the user has a next package to activate & selected package is 'lifetime' package
        if (!empty($nextMembership) && $selectedPackage->term == 'lifetime') {
            Session::flash('membership_warning', 'To add a Lifetime package as Current Package, You have to remove the next package');
            return back();
        }
        // expire the current package
        $currMembership->expire_date = Carbon::parse(Carbon::now()->subDay()->format('d-m-Y'));
        $currMembership->modified = 1;
        if ($currMembership->status == 0) {
            $currMembership->status = 2;
        }
        $currMembership->save();

        // calculate expire date for selected package
        if ($selectedPackage->term == 'month') {
            $exDate = Carbon::now()->addMonth()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'year') {
            $exDate = Carbon::now()->addYear()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'lifetime') {
            $exDate = Carbon::maxValue()->format('d-m-Y');
        }
        // store a new membership for selected package
        $selectedMemb = Membership::create([
            'price' => $selectedPackage->price,
            'currency' => $be->base_currency_text,
            'currency_symbol' => $be->base_currency_symbol,
            'payment_method' => $request->payment_method,
            'transaction_id' => uniqid(),
            'status' => 1,
            'receipt' => NULL,
            'transaction_details' => NULL,
            'settings' => json_encode($be),
            'package_id' => $selectedPackage->id,
            'user_id' => $userId,
            'start_date' => Carbon::parse(Carbon::now()->format('d-m-Y')),
            'expire_date' => Carbon::parse($exDate),
            'is_trial' => 0,
            'trial_days' => 0,
        ]);

        $features = json_decode($selectedPackage->features, true);
        $features[] = "Contact";
        UserPermission::where('user_id', $user->id)->update([
            'package_id' => $request['package_id'],
            'user_id' => $user->id,
            'permissions' => json_encode($features)
        ]);

        // if the user has a next package to activate & selected package is not 'lifetime' package
        if (!empty($nextMembership) && $selectedPackage->term != 'lifetime') {
            $nextPackage = Package::find($nextMembership->package_id);

            // calculate & store next membership's start_date
            $nextMembership->start_date = Carbon::parse(Carbon::parse($exDate)->addDay()->format('d-m-Y'));

            // calculate & store expire date for next membership
            if ($nextPackage->term == 'month') {
                $exDate = Carbon::parse(Carbon::parse(Carbon::parse($exDate)->addDay()->format('d-m-Y'))->addMonth()->format('d-m-Y'));
            } elseif ($nextPackage->term == 'year') {
                $exDate = Carbon::parse(Carbon::parse(Carbon::parse($exDate)->addDay()->format('d-m-Y'))->addYear()->format('d-m-Y'));
            } else {
                $exDate = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
            }
            $nextMembership->expire_date = $exDate;
            $nextMembership->save();
        }

        $currentPackage = Package::select('title')->findOrFail($currMembership->package_id);
        $this->sendMail($selectedMemb, $selectedPackage, $request->payment_method, $user, $bs, $be, 'admin_changed_current_package', $currentPackage->title);

        Session::flash('success', 'Current Package changed successfully!');
        return back();
    }

    public function addCurrPackage(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        $be = BasicExtended::first();
        $bs = BasicSetting::select('website_title')->first();

        $selectedPackage = Package::find($request->package_id);

        // calculate expire date for selected package
        if ($selectedPackage->term == 'month') {
            $exDate = Carbon::now()->addMonth()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'year') {
            $exDate = Carbon::now()->addYear()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'lifetime') {
            $exDate = Carbon::maxValue()->format('d-m-Y');
        }
        // store a new membership for selected package
        $selectedMemb = Membership::create([
            'price' => $selectedPackage->price,
            'currency' => $be->base_currency_text,
            'currency_symbol' => $be->base_currency_symbol,
            'payment_method' => $request->payment_method,
            'transaction_id' => uniqid(),
            'status' => 1,
            'receipt' => NULL,
            'transaction_details' => NULL,
            'settings' => json_encode($be),
            'package_id' => $selectedPackage->id,
            'user_id' => $userId,
            'start_date' => Carbon::parse(Carbon::now()->format('d-m-Y')),
            'expire_date' => Carbon::parse($exDate),
            'is_trial' => 0,
            'trial_days' => 0,
        ]);

        $features = json_decode($selectedPackage->features, true);
        $features[] = "Contact";
        UserPermission::where('user_id', $user->id)->update([
            'package_id' => $request['package_id'],
            'user_id' => $user->id,
            'permissions' => json_encode($features)
        ]);

        $this->sendMail($selectedMemb, $selectedPackage, $request->payment_method, $user, $bs, $be, 'admin_added_current_package');

        Session::flash('success', 'Current Package has been added successfully!');
        return back();
    }

    public function removeNextPackage(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        $be = BasicExtended::first();
        $bs = BasicSetting::select('website_title')->first();
        $nextMembership = UserPermissionHelper::nextMembership($userId);
        // set the start_date to unlimited
        $nextMembership->start_date = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
        $nextMembership->modified = 1;
        $nextMembership->save();

        $nextPackage = Package::select('title')->findOrFail($nextMembership->package_id);


        $this->sendMail(NULL, NULL, $request->payment_method, $user, $bs, $be, 'admin_removed_next_package', NULL, $nextPackage->title);

        Session::flash('success', 'Next Package removed successfully!');
        return back();
    }

    public function changeNextPackage(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        $bs = BasicSetting::select('website_title')->first();
        $be = BasicExtended::first();
        $nextMembership = UserPermissionHelper::nextMembership($userId);
        $nextPackage = Package::find($nextMembership->package_id);
        $selectedPackage = Package::find($request->package_id);

        $prevStartDate = $nextMembership->start_date;
        // set the start_date to unlimited
        $nextMembership->start_date = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
        $nextMembership->modified = 1;
        $nextMembership->save();

        // calculate expire date for selected package
        if ($selectedPackage->term == 'month') {
            $exDate = Carbon::parse($prevStartDate)->addMonth()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'year') {
            $exDate = Carbon::parse($prevStartDate)->addYear()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'lifetime') {
            $exDate = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
        }

        // store a new membership for selected package
        $selectedMemb = Membership::create([
            'price' => $selectedPackage->price,
            'currency' => $be->base_currency_text,
            'currency_symbol' => $be->base_currency_symbol,
            'payment_method' => $request->payment_method,
            'transaction_id' => uniqid(),
            'status' => 1,
            'receipt' => NULL,
            'transaction_details' => NULL,
            'settings' => json_encode($be),
            'package_id' => $selectedPackage->id,
            'user_id' => $userId,
            'start_date' => Carbon::parse($prevStartDate),
            'expire_date' => Carbon::parse($exDate),
            'is_trial' => 0,
            'trial_days' => 0,
        ]);

        $this->sendMail($selectedMemb, $selectedPackage, $request->payment_method, $user, $bs, $be, 'admin_changed_next_package', $nextPackage->title);

        Session::flash('success', 'Next Package changed successfully!');
        return back();
    }

    public function addNextPackage(Request $request)
    {
        $userId = $request->user_id;

        $hasPendingMemb = UserPermissionHelper::hasPendingMembership($userId);
        if ($hasPendingMemb) {
            Session::flash('membership_warning', 'This user already has a Pending Package. Please take an action (change / remove / approve / reject) for that package first.');
            return back();
        }

        $currMembership = UserPermissionHelper::userPackage($userId);
        $currPackage = Package::find($currMembership->package_id);
        $be = BasicExtended::first();
        $user = User::findOrFail($userId);
        $bs = BasicSetting::select('website_title')->first();

        $selectedPackage = Package::find($request->package_id);

        if ($currMembership->is_trial == 1) {
            Session::flash('membership_warning', 'If your current package is trial package, then you have to change / remove the current package first.');
            return back();
        }


        // if current package is not lifetime package
        if ($currPackage->term != 'lifetime') {
            // calculate expire date for selected package
            if ($selectedPackage->term == 'month') {
                $exDate = Carbon::parse($currMembership->expire_date)->addDay()->addMonth()->format('d-m-Y');
            } elseif ($selectedPackage->term == 'year') {
                $exDate = Carbon::parse($currMembership->expire_date)->addDay()->addYear()->format('d-m-Y');
            } elseif ($selectedPackage->term == 'lifetime') {
                $exDate = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
            }
            // store a new membership for selected package
            $selectedMemb = Membership::create([
                'price' => $selectedPackage->price,
                'currency' => $be->base_currency_text,
                'currency_symbol' => $be->base_currency_symbol,
                'payment_method' => $request->payment_method,
                'transaction_id' => uniqid(),
                'status' => 1,
                'receipt' => NULL,
                'transaction_details' => NULL,
                'settings' => json_encode($be),
                'package_id' => $selectedPackage->id,
                'user_id' => $userId,
                'start_date' => Carbon::parse(Carbon::parse($currMembership->expire_date)->addDay()->format('d-m-Y')),
                'expire_date' => Carbon::parse($exDate),
                'is_trial' => 0,
                'trial_days' => 0,
            ]);

            $this->sendMail($selectedMemb, $selectedPackage, $request->payment_method, $user, $bs, $be, 'admin_added_next_package');
        } else {
            Session::flash('membership_warning', 'If your current package is lifetime package, then you have to change / remove the current package first.');
            return back();
        }


        Session::flash('success', 'Next Package has been added successfully!');
        return back();
    }


    public function secretLogin(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if ($user) {
            Auth::guard('web')->login($user);
            return redirect()->route('user.dashboard')
                ->withSuccess('You have Successfully loggedin');
        } else {

            return redirect()->route('user.login')->withSuccess('Oppes! You have entered invalid credentials');
        }
    }


    public function userTemplate(Request $request)
    {
        if ($request->template == 1) {
            $prevImg = $request->file('preview_image');
            $allowedExts = array('jpg', 'png', 'jpeg');

            $rules = [
                'serial_number' => 'required|integer',
                'preview_image' => [
                    'required',
                    function ($attribute, $value, $fail) use ($prevImg, $allowedExts) {
                        if (!empty($prevImg)) {
                            $ext = $prevImg->getClientOriginalExtension();
                            if (!in_array($ext, $allowedExts)) {
                                return $fail("Only png, jpg, jpeg image is allowed");
                            }
                        }
                    },
                ]
            ];


            $request->validate($rules);
        }

        $user = User::where('id', $request->user_id)->first();

        if ($request->template == 1) {
            if ($request->hasFile('preview_image')) {
                @unlink(public_path('assets/front/img/template-previews/' . $user->template_img));
                $filename = uniqid() . '.' . $prevImg->getClientOriginalExtension();
                $dir = public_path('assets/front/img/template-previews/');
                @mkdir($dir, 0775, true);
                $request->file('preview_image')->move($dir, $filename);
                $user->template_img = $filename;
            }
            $user->template_serial_number = $request->serial_number;
            $user->theme_name = $request->template_name;
            $user->home_show_status = $request->show_in_home;
        } else {
            @unlink(public_path('assets/front/img/template-previews/' . $user->template_img));
            $user->template_img = NULL;
            $user->template_serial_number = 0;
        }
        $user->preview_template = $request->template;
        $user->save();
        Session::flash('success', 'Status updated successfully!');
        return back();
    }

    public function userUpdateTemplate(Request $request)
    {
        $prevImg = $request->file('preview_image');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'serial_number' => 'required|integer',
            'preview_image' => [
                function ($attribute, $value, $fail) use ($prevImg, $allowedExts) {
                    if (!empty($prevImg)) {
                        $ext = $prevImg->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ]
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $user = User::where('id', $request->user_id)->first();


        if ($request->hasFile('preview_image')) {
            @unlink(public_path('assets/front/img/template-previews/' . $user->template_img));
            $filename = uniqid() . '.' . $prevImg->getClientOriginalExtension();
            $dir = public_path('assets/front/img/template-previews/');
            @mkdir($dir, 0775, true);
            $request->file('preview_image')->move($dir, $filename);
            $user->template_img = $filename;
        }
        $user->template_serial_number = $request->serial_number;
        $user->theme_name = $request->template_name;
        $user->home_show_status = $request->show_in_home;
        $user->save();


        Session::flash('success', 'Status updated successfully!');
        return "success";
    }
}
