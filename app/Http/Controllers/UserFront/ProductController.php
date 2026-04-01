<?php

namespace App\Http\Controllers\UserFront;

use Carbon\Carbon;
use App\Models\User\Coupon;
use App\Models\User\Product;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Models\User\Pcategory;
use App\Models\User\TimeFrame;
use App\Models\User\PostalCode;
use App\Models\User\BasicSetting;
use App\Models\User\PsubCategory;
use App\Models\User\BasicExtended;
use App\Models\User\ProductReview;
use App\Models\User\ServingMethod;
use App\Models\User\OfflineGateway;
use App\Models\User\PaymentGateway;
use App\Models\User\ShippingCharge;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\LimitCheckerHelper;
use App\Traits\UserCurrentLanguageTrait;

class ProductController extends Controller
{
    use UserCurrentLanguageTrait;

    public function product(Request $request, $domain)
    {

        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);
        $data['cLang'] = $userCurrentLang;

        $lang_id = $userCurrentLang->id;
        $data['categories'] = Pcategory::query()
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->where('language_id', $userCurrentLang->id)
            ->get();
        $data['products'] = Product::query()
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('status', 1)
            ->where('products.user_id', $user->id)
            ->where('product_informations.language_id', $lang_id)
            ->paginate(10);
        return view('user-front.product.product', $data);
    }

    public function productDetails($domain, $slug, $id)
    {

        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);

        Session::put('link', route('user.front.product.details', [getParam(), 'slug' => $slug, 'id' => $id]));
        $data['product'] = Product::query()
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('products.id', $id)
            ->where('product_informations.language_id', $userCurrentLang->id)
            ->where('products.user_id', $user->id)->with('category', function ($query) {
                $query->where('status', 1);
            })
            ->firstOrFail();
        $data['categories'] = Pcategory::query()
            ->where('status', 1)
            ->where('language_id', $userCurrentLang->id)
            ->where('user_id', $user->id)
            ->get();
        $data['reviews'] = ProductReview::query()
            ->where('product_id', $id)
            ->where('user_id', $user->id)
            ->get();

        $data['related_product'] = Product::query()
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('product_informations.category_id', $data['product']?->category_id)
            ->where('product_informations.language_id', $userCurrentLang->id)
            ->where('products.id', '!=', $data['product']?->id)
            ->where('products.user_id', $user->id)
            ->get();


        return view('user-front.product.details', $data);
    }

    public function items(Request $request, $domain)
    {

        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);
        $data['userCurrentLang'] = $userCurrentLang;
        $lang_id = $userCurrentLang->id;
        $data['categories'] = Pcategory::query()
            ->where('status', 1)
            ->where('user_id', $user->id)
            ->where('language_id', $userCurrentLang->id)
            ->get();

        $search = $request->search;
        $minprice = $request->minprice;
        $maxprice = $request->maxprice;
        $category = $request->category_id;
        $subcategory = $request->subcategory_id;

        if ($request->type) {
            $type = $request->type;
        } else {
            $type = 'new';
        }
        $review = $request->review;


        $data['products'] = Product::query()
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('status', 1)
            ->where('products.user_id', $user->id)
            ->when($category, function ($query, $category) {
                return $query->where('product_informations.category_id', $category);
            })
            ->when($subcategory, function ($query, $subcategory) {
                return $query->where('product_informations.subcategory_id', $subcategory);
            })
            ->when($lang_id, function ($query, $lang_id) {
                return $query->where('product_informations.language_id', $lang_id);
            })
            ->when($search, function ($query, $search) {
                return $query->where('product_informations.title', 'like', '%' . $search . '%')
                    ->orwhere('product_informations.summary', 'like', '%' . $search . '%')
                    ->orwhere('product_informations.description', 'like', '%' . $search . '%');
            })
            ->when($minprice, function ($query, $minprice) {
                return $query->where('products.current_price', '>=', $minprice);
            })
            ->when($maxprice, function ($query, $maxprice) {
                return $query->where('products.current_price', '<=', $maxprice);
            })
            ->when($review, function ($query, $review) {
                return $query->where('products.rating', '>=', $review);
            })
            ->when($type, function ($query, $type) {
                if ($type == 'old') {
                    return $query->orderBy('products.id', 'ASC');
                } elseif ($type == 'high-to-low') {
                    return $query->orderBy('products.current_price', 'DESC');
                } elseif ($type == 'low-to-high') {
                    return $query->orderBy('products.current_price', 'ASC');
                } else {
                    return $query->orderBy('products.id', 'DESC');
                }
            })
            ->orderBy('products.created_at', 'DESC')
            ->where('products.status', 1)
            ->paginate(9);

        return view('user-front.product.items', $data);
    }

    public function cart($domain)
    {
        $user = getUser();
        if (Session::has($user->username . "_cart")) {
            $cart = Session::get($user->username . "_cart");
        } else {
            $cart = null;
        }

        $view = "user-front.{$user->theme_name}.cart";
        if (!view()->exists($view)) {
            $view = 'user-front.product.cart';
        }
        return view($view, ['cart' => $cart]);
    }

    public function addToCart($domain, $id)
    {

        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($userCurrentLang->keywords, true);

        $data = explode(',,,', $id);
        $id = (int)$data[0];
        $qty = (int)$data[1];
        $total = (float)$data[2];

        $variant = json_decode($data[3], true);
        $addons = json_decode($data[4], true);

        $product = Product::query()
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('products.user_id', $user->id)
            ->where('product_informations.language_id', $userCurrentLang->id)
            ->findOrFail($id);
        // validations
        if ($qty < 1) {
            return response()->json(['error' => $keywords['Quantity must be 1 or more than 1.'] ?? 'Quantity must be 1 or more than 1.']);
        }
        $pvariant = json_decode($product->variations, true);
        if (!empty($pvariant) && empty($variant)) {
            return response()->json(['error' => $keywords['You must select a variant.'] ?? 'You must select a variant.']);
        }

        if (!$product) {
            abort(404);
        }
        $cart = Session::get($user->username . "_cart");

        $ckey = uniqid();

        // if cart is empty then this the first product
        if (!$cart) {
            $cart = [
                $ckey => [
                    "id" => $id,
                    "name" => $product->title,
                    "qty" => (int)$qty,
                    "variations" => $variant,
                    "addons" => $addons,
                    "product_price" => (float)$product->current_price,
                    "total" => $total,
                    "photo" => $product->feature_image
                ]
            ];
            Session::put($user->username . "_cart", $cart);
            return response()->json(['message' => $keywords['Product added to cart successfully'] ?? 'Product added to cart successfully']);
        }

        // if cart not empty then check if this product (with same variation) exist then increment quantity
        foreach ($cart as $key => $cartItem) {
            if ($cartItem["id"] == $id && $variant == $cartItem["variations"] && $addons == $cartItem["addons"]) {
                $cart[$key]['qty'] = (int)$cart[$key]['qty'] + $qty;
                $cart[$key]['total'] = (float)$cart[$key]['total'] + $total;
                Session::put($user->username . "_cart", $cart);
                return response()->json(['message' => $keywords['Product added to cart successfully'] ?? 'Product added to cart successfully']);
            }
        }
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$ckey] = [
            "id" => $id,
            "name" => $product->title,
            "qty" => (int)$qty,
            "variations" => $variant,
            "addons" => $addons,
            "product_price" => (float)$product->current_price,
            "total" => $total,
            "photo" => $product->feature_image
        ];
        Session::put($user->username . "_cart", $cart);
        return response()->json(['message' => $keywords['Product added to cart successfully'] ?? 'Product added to cart successfully']);
    }


    public function updateCart(Request $request, $domain)
    {

        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($userCurrentLang->keywords, true);

        $cart = Session::get($user->username . "_cart");
        $qtys = $request->qty;
        $i = 0;
        foreach ($cart as $cartKey => $cartItem) {
            $total = 0;
            $cart[$cartKey]["qty"] = (int)$qtys[$i];

            // calculate total
            $addons = $cartItem["addons"];
            if (is_array($addons)) {
                foreach ($addons as $addon) {
                    $total += (float)$addon["price"];
                }
            }
            $variations = $cartItem["variations"];
            if (is_array($variations)) {
                foreach ($variations as $variation) {
                    $total += (float)$variation["price"];
                }
            }

            $total += (float)$cartItem["product_price"];
            $total = $total * $qtys[$i];

            // save total in the cart item
            $cart[$cartKey]["total"] = $total;

            $i++;
        }
        Session::put($user->username . "_cart", $cart);;
        return response()->json(['message' => $keywords['Cart updated successfully'] ?? 'Cart updated successfully']);
    }


    public function cartItemRemove($domain, $id)
    {
        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($userCurrentLang->keywords, true);

        if ($id) {
            $cart = Session::get($user->username . "_cart");
            unset($cart[$id]);
            Session::put($user->username . "_cart", $cart);
            return response()->json(['message' => $keywords['Item removed successfully'] ?? 'Item removed successfully']);
        }
    }
    public function cartItemAddQuantity($domain, $id)
    {

        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($userCurrentLang->keywords, true);

        $cart = Session::get($user->username . "_cart");
        $element = $cart[$id];
        $element['qty'] = $element['qty'] + 1;
        $element['total'] = $element['total'] + $element['product_price'];
        $variations = $element["variations"];
        if (is_array($variations)) {
            foreach ($variations as $variation) {
                $element['total'] += (float)$variation["price"];
            }
        }
        $addons = $element["addons"];
        if (is_array($addons)) {
            foreach ($addons as $addon) {
                $element['total'] += (float)$addon["price"];
            }
        }
        $cart[$id] = $element;
        Session::put($user->username . "_cart", $cart);
        return response()->json(['message' => $keywords['Item Quantity added successfully'] ?? 'Item Quantity added successfully']);
    }
    public function cartItemLessQuantity($domain, $id)
    {

        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($userCurrentLang->keywords, true);
        $cart = Session::get($user->username . "_cart");
        $element = $cart[$id];
        $element['qty'] = $element['qty'] - 1;
        $element['total'] = $element['total'] - $element['product_price'];
        $variations = $element["variations"];
        if (is_array($variations)) {
            foreach ($variations as $variation) {
                $element['total'] -= (float)$variation["price"];
            }
        }
        $addons = $element["addons"];
        if (is_array($addons)) {
            foreach ($addons as $addon) {
                $element['total'] -= (float)$addon["price"];
            }
        }
        $cart[$id] = $element;
        Session::put($user->username . "_cart", $cart);
        return response()->json(['message' => $keywords['Item Quantity down successfully'] ?? 'Item Quantity down successfully']);
    }


    public function checkout(Request $request, $domain)
    {
        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($userCurrentLang->keywords, true);

        if (session()->get($user->username . "_cart") == null) {
            return back()->with('error', $keywords['Cart is empty'] ?? 'Cart is empty');
        }

        $userId = $user->id;
        if ($request->type != 'guest' && !Auth::guard('client')->check()) {
            Session::put('link', route('user.product.front.checkout', getParam()));
            return redirect(route('user.client.login', [getParam(), 'redirected' => 'checkout']));
        }

        $package = LimitCheckerHelper::getPackageSelectedData($userId, 'features');

        $data['pfeatures'] = json_decode($package->features, true);

        $userCurrentLang = $this->getUserCurrentLanguage($user);

        if (Session::has($user->username . "_cart")) {
            $data['cart'] = Session::get($user->username . "_cart");
        } else {
            $data['cart'] = null;
        }
        $data['shippings'] = ShippingCharge::query()
            ->where('language_id', $userCurrentLang->id)
            ->where('user_id', $user->id)
            ->get();
        $data['postcodes'] = PostalCode::query()
            ->where('language_id', $userCurrentLang->id)
            ->where('user_id', $user->id)
            ->orderBy('serial_number', 'ASC')
            ->get();
        $data['ogateways'] = OfflineGateway::query()
            ->where('status', 1)
            ->where('user_id', $user->id)
            ->orderBy('serial_number', 'ASC')
            ->get();

        $data['payment_getways'] = PaymentGateway::where('user_id', $userId)->whereNotNull('information')
            ->get();


        $data['paypal'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'paypal')->first();
        $data['stripe'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'stripe')->first();
        $data['paystack'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'paystack')->first();
        $data['paytm'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'paytm')->first();
        $data['flutterwave'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'flutterwave')->first();
        $data['instamojo'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'instamojo')->first();
        $data['mollie'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'mollie')->first();
        $data['razorpay'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'razorpay')->first();
        $data['mercadopago'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'mercadopago')->first();
        $data['anet'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'authorize.net')->first();
        $data['yoco'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'yoco')->first();
        $data['xendit'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'xendit')->first();
        $data['perfect_money'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'perfect_money')->first();
        $data['midtrans'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'midtrans')->first();
        $data['myfatoorah'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'myfatoorah')->first();
        $data['toyyibpay'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'toyyibpay')->first();
        $data['paytabs'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'paytabs')->first();
        $data['phonepe'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'phonepe')->first();
        $data['iyzico'] = PaymentGateway::query()->where('user_id', $userId)->where('keyword', 'iyzico')->first();

        $data['scharges'] = $userCurrentLang->shipping_charges->where('user_id', $userId);
        $data['smethods'] = ServingMethod::query()
            ->where('website_menu', 1)
            ->where('user_id', $userId)
            ->orderBy('serial_number', 'ASC')
            ->get();

        $data['discount'] = session()->has('coupon') && !empty(session()->get('coupon'))
            ? session()->get('coupon')
            : 0;

        $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $disDays = [];
        foreach ($days as $day) {
            $count = TimeFrame::query()
                ->where('day', $day)
                ->where('user_id', $userId)
                ->count();
            if ($count == 0) {

                if ($day == 'sunday') {
                    $disDays[] = 0;
                } elseif ($day == 'monday') {
                    $disDays[] = 1;
                } elseif ($day == 'tuesday') {
                    $disDays[] = 2;
                } elseif ($day == 'wednesday') {
                    $disDays[] = 3;
                } elseif ($day == 'thursday') {
                    $disDays[] = 4;
                } elseif ($day == 'friday') {
                    $disDays[] = 5;
                } elseif ($day == 'saturday') {
                    $disDays[] = 6;
                }
            }
        }
        $data['disDays'] = $disDays;


        $data['ccodes'] = [["code" => "+7840", "name" => "Abkhazia"], ["code" => "+93", "name" => "Afghanistan"], ["code" => "+355", "name" => "Albania"], ["code" => "+213", "name" => "Algeria"], ["code" => "+1684", "name" => "American Samoa"], ["code" => "+376", "name" => "Andorra"], ["code" => "+244", "name" => "Angola"], ["code" => "+1264", "name" => "Anguilla"], ["code" => "+1268", "name" => "Antigua and Barbuda"], ["code" => "+54", "name" => "Argentina"], ["code" => "+374", "name" => "Armenia"], ["code" => "+297", "name" => "Aruba"], ["code" => "+247", "name" => "Ascension"], ["code" => "+61", "name" => "Australia"], ["code" => "+672", "name" => "Australian External Territories"], ["code" => "+43", "name" => "Austria"], ["code" => "+994", "name" => "Azerbaijan"], ["code" => "+1242", "name" => "Bahamas"], ["code" => "+973", "name" => "Bahrain"], ["code" => "+880", "name" => "Bangladesh"], ["code" => "+1246", "name" => "Barbados"], ["code" => "+1268", "name" => "Barbuda"], ["code" => "+375", "name" => "Belarus"], ["code" => "+32", "name" => "Belgium"], ["code" => "+501", "name" => "Belize"], ["code" => "+229", "name" => "Benin"], ["code" => "+1441", "name" => "Bermuda"], ["code" => "+975", "name" => "Bhutan"], ["code" => "+591", "name" => "Bolivia"], ["code" => "+387", "name" => "Bosnia and Herzegovina"], ["code" => "+267", "name" => "Botswana"], ["code" => "+55", "name" => "Brazil"], ["code" => "+246", "name" => "British Indian Ocean Territory"], ["code" => "+1284", "name" => "British Virgin Islands"], ["code" => "+673", "name" => "Brunei"], ["code" => "+359", "name" => "Bulgaria"], ["code" => "+226", "name" => "Burkina Faso"], ["code" => "+257", "name" => "Burundi"], ["code" => "+855", "name" => "Cambodia"], ["code" => "+237", "name" => "Cameroon"], ["code" => "+1", "name" => "Canada"], ["code" => "+238", "name" => "Cape Verde"], ["code" => "+345", "name" => "Cayman Islands"], ["code" => "+236", "name" => "Central African Republic"], ["code" => "+235", "name" => "Chad"], ["code" => "+56", "name" => "Chile"], ["code" => "+86", "name" => "China"], ["code" => "+61", "name" => "Christmas Island"], ["code" => "+61", "name" => "Cocos-Keeling Islands"], ["code" => "+57", "name" => "Colombia"], ["code" => "+269", "name" => "Comoros"], ["code" => "+242", "name" => "Congo"], ["code" => "+243", "name" => "Congo, Dem. Rep. of (Zaire)"], ["code" => "+682", "name" => "Cook Islands"], ["code" => "+506", "name" => "Costa Rica"], ["code" => "+385", "name" => "Croatia"], ["code" => "+53", "name" => "Cuba"], ["code" => "+599", "name" => "Curacao"], ["code" => "+537", "name" => "Cyprus"], ["code" => "+420", "name" => "Czech Republic"], ["code" => "+45", "name" => "Denmark"], ["code" => "+246", "name" => "Diego Garcia"], ["code" => "+253", "name" => "Djibouti"], ["code" => "+1767", "name" => "Dominica"], ["code" => "+1809", "name" => "Dominican Republic"], ["code" => "+670", "name" => "East Timor"], ["code" => "+56", "name" => "Easter Island"], ["code" => "+593", "name" => "Ecuador"], ["code" => "+20", "name" => "Egypt"], ["code" => "+503", "name" => "El Salvador"], ["code" => "+240", "name" => "Equatorial Guinea"], ["code" => "+291", "name" => "Eritrea"], ["code" => "+372", "name" => "Estonia"], ["code" => "+251", "name" => "Ethiopia"], ["code" => "+500", "name" => "Falkland Islands"], ["code" => "+298", "name" => "Faroe Islands"], ["code" => "+679", "name" => "Fiji"], ["code" => "+358", "name" => "Finland"], ["code" => "+33", "name" => "France"], ["code" => "+596", "name" => "French Antilles"], ["code" => "+594", "name" => "French Guiana"], ["code" => "+689", "name" => "French Polynesia"], ["code" => "+241", "name" => "Gabon"], ["code" => "+220", "name" => "Gambia"], ["code" => "+995", "name" => "Georgia"], ["code" => "+49", "name" => "Germany"], ["code" => "+233", "name" => "Ghana"], ["code" => "+350", "name" => "Gibraltar"], ["code" => "+30", "name" => "Greece"], ["code" => "+299", "name" => "Greenland"], ["code" => "+1473", "name" => "Grenada"], ["code" => "+590", "name" => "Guadeloupe"], ["code" => "+1671", "name" => "Guam"], ["code" => "+502", "name" => "Guatemala"], ["code" => "+224", "name" => "Guinea"], ["code" => "+245", "name" => "Guinea-Bissau"], ["code" => "+595", "name" => "Guyana"], ["code" => "+509", "name" => "Haiti"], ["code" => "+504", "name" => "Honduras"], ["code" => "+852", "name" => "Hong Kong SAR China"], ["code" => "+36", "name" => "Hungary"], ["code" => "+354", "name" => "Iceland"], ["code" => "+91", "name" => "India"], ["code" => "+62", "name" => "Indonesia"], ["code" => "+98", "name" => "Iran"], ["code" => "+964", "name" => "Iraq"], ["code" => "+353", "name" => "Ireland"], ["code" => "+972", "name" => "Israel"], ["code" => "+39", "name" => "Italy"], ["code" => "+225", "name" => "Ivory Coast"], ["code" => "+1876", "name" => "Jamaica"], ["code" => "+81", "name" => "Japan"], ["code" => "+962", "name" => "Jordan"], ["code" => "+77", "name" => "Kazakhstan"], ["code" => "+254", "name" => "Kenya"], ["code" => "+686", "name" => "Kiribati"], ["code" => "+965", "name" => "Kuwait"], ["code" => "+996", "name" => "Kyrgyzstan"], ["code" => "+856", "name" => "Laos"], ["code" => "+371", "name" => "Latvia"], ["code" => "+961", "name" => "Lebanon"], ["code" => "+266", "name" => "Lesotho"], ["code" => "+231", "name" => "Liberia"], ["code" => "+218", "name" => "Libya"], ["code" => "+423", "name" => "Liechtenstein"], ["code" => "+370", "name" => "Lithuania"], ["code" => "+352", "name" => "Luxembourg"], ["code" => "+853", "name" => "Macau SAR China"], ["code" => "+389", "name" => "Macedonia"], ["code" => "+261", "name" => "Madagascar"], ["code" => "+265", "name" => "Malawi"], ["code" => "+60", "name" => "Malaysia"], ["code" => "+960", "name" => "Maldives"], ["code" => "+223", "name" => "Mali"], ["code" => "+356", "name" => "Malta"], ["code" => "+692", "name" => "Marshall Islands"], ["code" => "+596", "name" => "Martinique"], ["code" => "+222", "name" => "Mauritania"], ["code" => "+230", "name" => "Mauritius"], ["code" => "+262", "name" => "Mayotte"], ["code" => "+52", "name" => "Mexico"], ["code" => "+691", "name" => "Micronesia"], ["code" => "+1808", "name" => "Midway Island"], ["code" => "+373", "name" => "Moldova"], ["code" => "+377", "name" => "Monaco"], ["code" => "+976", "name" => "Mongolia"], ["code" => "+382", "name" => "Montenegro"], ["code" => "+1664", "name" => "Montserrat"], ["code" => "+212", "name" => "Morocco"], ["code" => "+95", "name" => "Myanmar"], ["code" => "+264", "name" => "Namibia"], ["code" => "+674", "name" => "Nauru"], ["code" => "+977", "name" => "Nepal"], ["code" => "+31", "name" => "Netherlands"], ["code" => "+599", "name" => "Netherlands Antilles"], ["code" => "+1869", "name" => "Nevis"], ["code" => "+687", "name" => "New Caledonia"], ["code" => "+64", "name" => "New Zealand"], ["code" => "+505", "name" => "Nicaragua"], ["code" => "+227", "name" => "Niger"], ["code" => "+234", "name" => "Nigeria"], ["code" => "+683", "name" => "Niue"], ["code" => "+672", "name" => "Norfolk Island"], ["code" => "+850", "name" => "North Korea"], ["code" => "+1670", "name" => "Northern Mariana Islands"], ["code" => "+47", "name" => "Norway"], ["code" => "+968", "name" => "Oman"], ["code" => "+92", "name" => "Pakistan"], ["code" => "+680", "name" => "Palau"], ["code" => "+970", "name" => "Palestinian Territory"], ["code" => "+507", "name" => "Panama"], ["code" => "+675", "name" => "Papua New Guinea"], ["code" => "+595", "name" => "Paraguay"], ["code" => "+51", "name" => "Peru"], ["code" => "+63", "name" => "Philippines"], ["code" => "+48", "name" => "Poland"], ["code" => "+351", "name" => "Portugal"], ["code" => "+1787", "name" => "Puerto Rico"], ["code" => "+974", "name" => "Qatar"], ["code" => "+262", "name" => "Reunion"], ["code" => "+40", "name" => "Romania"], ["code" => "+7", "name" => "Russia"], ["code" => "+250", "name" => "Rwanda"], ["code" => "+685", "name" => "Samoa"], ["code" => "+378", "name" => "San Marino"], ["code" => "+966", "name" => "Saudi Arabia"], ["code" => "+221", "name" => "Senegal"], ["code" => "+381", "name" => "Serbia"], ["code" => "+248", "name" => "Seychelles"], ["code" => "+232", "name" => "Sierra Leone"], ["code" => "+65", "name" => "Singapore"], ["code" => "+421", "name" => "Slovakia"], ["code" => "+386", "name" => "Slovenia"], ["code" => "+677", "name" => "Solomon Islands"], ["code" => "+27", "name" => "South Africa"], ["code" => "+500", "name" => "South Georgia and the South Sandwich Islands"], ["code" => "+82", "name" => "South Korea"], ["code" => "+34", "name" => "Spain"], ["code" => "+94", "name" => "Sri Lanka"], ["code" => "+249", "name" => "Sudan"], ["code" => "+597", "name" => "Suriname"], ["code" => "+268", "name" => "Swaziland"], ["code" => "+46", "name" => "Sweden"], ["code" => "+41", "name" => "Switzerland"], ["code" => "+963", "name" => "Syria"], ["code" => "+886", "name" => "Taiwan"], ["code" => "+992", "name" => "Tajikistan"], ["code" => "+255", "name" => "Tanzania"], ["code" => "+66", "name" => "Thailand"], ["code" => "+670", "name" => "Timor Leste"], ["code" => "+228", "name" => "Togo"], ["code" => "+690", "name" => "Tokelau"], ["code" => "+676", "name" => "Tonga"], ["code" => "+1868", "name" => "Trinidad and Tobago"], ["code" => "+216", "name" => "Tunisia"], ["code" => "+90", "name" => "Turkey"], ["code" => "+993", "name" => "Turkmenistan"], ["code" => "+1649", "name" => "Turks and Caicos Islands"], ["code" => "+688", "name" => "Tuvalu"], ["code" => "+1340", "name" => "U.S. Virgin Islands"], ["code" => "+256", "name" => "Uganda"], ["code" => "+380", "name" => "Ukraine"], ["code" => "+971", "name" => "United Arab Emirates"], ["code" => "+44", "name" => "United Kingdom"], ["code" => "+1", "name" => "United States"], ["code" => "+598", "name" => "Uruguay"], ["code" => "+998", "name" => "Uzbekistan"], ["code" => "+678", "name" => "Vanuatu"], ["code" => "+58", "name" => "Venezuela"], ["code" => "+84", "name" => "Vietnam"], ["code" => "+1808", "name" => "Wake Island"], ["code" => "+681", "name" => "Wallis and Futuna"], ["code" => "+967", "name" => "Yemen"], ["code" => "+260", "name" => "Zambia"], ["code" => "+255", "name" => "Zanzibar"], ["code" => "+263", "name" => "Zimbabwe"]];


        if (view()->exists('user-front.' . $user->theme_name . '.checkout')) {
            $view = 'user-front.' . $user->theme_name . '.checkout';
        } elseif ($user->username == 'sushi' || $user->theme_name == 'sushi') {
            $view = 'user-front.sushi.checkout';
        } else {
            $view = 'user-front.product.checkout';
        }
        return view($view, $data);
    }


    public function productCheckout(Request $request, $slug)
    {

        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($userCurrentLang->keywords, true);
        $product = Product::query()
            ->join('product_informations', 'products.id', 'product_informations.product_id')
            ->where('product_informations.slug', $slug)
            ->where('products.user_id', $user->id)
            ->where('product_informations.language_id', $userCurrentLang->id)
            ->first();

        if (!$product) {
            abort(404);
        }

        if ($request->qty) {
            $qty = $request->qty;
        } else {
            $qty = 1;
        }


        $cart = Session::get($user->username . "_cart");
        $id = $product->id;
        // if cart is empty then this the first product
        if (!($cart)) {
            if ($product->stock <  $qty) {
                Session::flash('error', $keywords['Out of stock'] ?? 'Out of stock');
                return back();
            }
            $cart = [
                $id => [
                    "name" => $product->title,
                    "qty" => $qty,
                    "price" => $product->current_price,
                    "photo" => $product->feature_image
                ]
            ];

            Session::put($user->username . "_cart", $cart);;
            return redirect(route('user.product.front.checkout', getParam()));
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {
            if ($product->stock < $cart[$id]['qty'] + $qty) {
                Session::flash('error', $keywords['Out of stock'] ?? 'Out of stock');
                return back();
            }
            $qt = $cart[$id]['qty'];
            $cart[$id]['qty'] = $qt + $qty;
            Session::put($user->username . "_cart", $cart);;
            return redirect(route('user.product.front.checkout', getParam()));
        }

        if ($product->stock <  $qty) {
            Session::flash('error', $keywords['Out of stock'] ?? 'Out of stock');
            return back();
        }
        $cart[$id] = [
            "name" => $product->title,
            "qty" => $qty,
            "price" => $product->current_price,
            "photo" => $product->feature_image
        ];
        Session::put($user->username . "_cart", $cart);;

        return redirect(route('user.product.front.checkout', getParam()));
    }


    public function coupon(Request $request)
    {

        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($userCurrentLang->keywords, true);

        $coupon = Coupon::query()->where('code', $request->coupon)->where('user_id', $user->id);
        $be = BasicExtended::query()->where('user_id', $user->id)->first();
        if ($coupon->count() == 0) {
            return response()->json(['status' => 'error', 'message' => $keywords['Coupon is not valid'] ?? "Coupon is not valid"]);
        } else {
            $coupon = $coupon->first();
            if (cartTotal() < $coupon->minimum_spend) {
                return response()->json(['status' => 'error', 'message' => $keywords['Cart Total must be minimum'] ?? "Cart Total must be minimum" . $coupon->minimum_spend . " " . $be->base_currency_text]);
            }
            $start = Carbon::parse($coupon->start_date);
            $end = Carbon::parse($coupon->end_date);
            $today = Carbon::now();


            // if coupon is active
            if ($today->greaterThanOrEqualTo($start) && $today->lessThan($end)) {
                $cartTotal = cartTotal();
                $value = $coupon->value;
                $type = $coupon->type;

                if ($type == 'fixed') {
                    if ($value > cartTotal()) {
                        return response()->json(['status' => 'error', 'message' => $keywords['Coupon discount is greater than cart total'] ?? "Coupon discount is greater than cart total"]);
                    }
                    $couponAmount = $value;
                } else {
                    $couponAmount = ($cartTotal * $value) / 100;
                }
                session()->put('coupon', round($couponAmount, 2));
                return response()->json(['status' => 'success', 'message' => $keywords['Coupon applied successfully'] ?? "Coupon applied successfully"]);
            } else {
                return response()->json(['status' => 'error', 'message' => $keywords['Coupon is not valid'] ?? "Coupon is not valid"]);
            }
        }
    }

    public function timeFrames(Request $request)
    {
        $user = getUser();
        $userCurrentLang = $this->getUserCurrentLanguage($user);
        $keywords = json_decode($userCurrentLang->keywords, true);
        $date = Carbon::createFromFormat('d/m/Y', $request->date);
        $day = strtolower($date->format('l'));

        $timeframes = TimeFrame::query()
            ->where('day', $day)
            ->where('user_id', $user->id)
            ->get();

        if (count($timeframes) > 0) {
            return response()->json(['status' => 'success', 'timeframes' => $timeframes]);
        } else {
            return response()->json(['status' => 'error', 'message' => $keywords['No delivery time frame is available on'] ?? 'No delivery time frame is available on ' . ucfirst($day)]);
        }
    }
}
