<?php

use App\Models\Page;
use App\Models\User;
use App\Models\Language;
use App\Models\User\Product;
use App\Models\PaymentGateway;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User\ProductInformation;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\User\PaymentGateway as UserPaymentGateway;

if (!function_exists('checkColorCode')) {
    function checkColorCode($color)
    {
        return preg_match('/^#[a-f0-9]{6}/i', $color);
    }
}
if (!function_exists('hexToRgba')) {

    function hexToRgba($hex, $alpha = .5)
    {
        // Remove the hash at the start if it's there
        $hex = ltrim($hex, '#');

        // Parse the hex color
        if (strlen($hex) == 6) {
            list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");
        } elseif (strlen($hex) == 3) {
            list($r, $g, $b) = sscanf($hex, "%1x%1x%1x");
            $r = $r * 17;
            $g = $g * 17;
            $b = $b * 17;
        } else {
            return '10, 71, 46';
        }

        // Ensure alpha is between 0 and 1
        $alpha = min(max($alpha, 0), 1);

        // Return the rgba color code
        return "$r, $g, $b";
    }
}
if (!function_exists('setEnvironmentValue')) {
    function setEnvironmentValue(array $values): bool
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $str .= "\n"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;
    }
}


if (!function_exists('replaceBaseUrl')) {
    function replaceBaseUrl($html)
    {
        $startDelimiter = 'src="';
        $endDelimiter = '/assets/front/img/summernote';
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($html, $startDelimiter, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($html, $endDelimiter, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $html = substr_replace($html, url('/'), $contentStart, $contentEnd - $contentStart);
            $startFrom = $contentEnd + $endDelimiterLength;
        }
        return $html;
    }
}


if (!function_exists('convertUtf8')) {
    function convertUtf8($value)
    {
        return mb_detect_encoding($value, mb_detect_order(), true) === 'UTF-8' ? $value : mb_convert_encoding($value, 'UTF-8');
    }
}


if (!function_exists('make_slug')) {
    function make_slug($string): array|string|null
    {
        $slug = preg_replace('/\s+/u', '-', trim($string));
        $slug = str_replace("/", "", $slug);
        return str_replace("?", "", $slug);
    }
}


if (!function_exists('make_input_name')) {
    function make_input_name($string): array|string|null
    {
        return preg_replace('/\s+/u', '_', trim($string));
    }
}

if (!function_exists('hasCategory')) {
    function hasCategory($version): bool
    {
        if (str_contains($version, "no_category")) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('isDark')) {
    function isDark($version): bool
    {
        if (str_contains($version, "dark")) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('slug_create')) {
    function slug_create($val): array|string|null
    {
        $slug = preg_replace('/\s+/u', '-', trim($val));
        $slug = str_replace("/", "", $slug);
        return str_replace("?", "", $slug);
    }
}

if (!function_exists('hex2rgb')) {
    function hex2rgb($colour): bool|array
    {
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array('red' => $r, 'green' => $g, 'blue' => $b);
    }
}

if (!function_exists('getHref')) {
    function getHref($link)
    {
        if ($link["type"] == 'home') {
            $href = route('front.index');
        } else if ($link["type"] == 'listings') {
            $href = route('front.user.view');
        } else if ($link["type"] == 'templates') {
            $href = route('front.templates');
        } else if ($link['type'] == 'pricing') {
            $href = route('front.pricing');
        } else if ($link["type"] == 'faq') {
            $href = route('front.faq');
        } else if ($link["type"] == 'blog') {
            $href = route('front.blogs');
        } else if ($link["type"] == 'contact') {
            $href = route('front.contact');
        } else if ($link["type"] == 'about_us') {
            $href = route('front.about_us');
        } else if ($link["type"] == 'custom') {
            if (empty($link["href"])) {
                $href = "#";
            } else {
                $href = $link["href"];
            }
        } else {
            $pageId = (int)$link["type"];
            $page = Page::query()->find($pageId);
            if (!empty($page)) {
                $href = route('front.dynamic.page', $page->slug);
            } else {
                $href = "#";
            }
        }
        return $href;
    }
}

if (!function_exists('getUserHref')) {
    function getUserHref($link, $langId)
    {

        $user = getUser();
        if ($link["type"] == 'home') {
            $href = route('user.front.index', getParam());
        } else if ($link["type"] == 'menu') {
            $href = route('user.front.product', getParam());
        } else if ($link["type"] == 'items') {
            $href = route('user.front.items', getParam());
        } else if ($link["type"] == 'team') {
            $href = route('user.front.team', getParam());
        } else if ($link["type"] == 'career') {
            $href = route('user.front.career', getParam());
        } else if ($link["type"] == 'gallery') {
            $href = route('user.front.gallery', getParam());
        } else if ($link["type"] == 'faq') {
            $href = route('user.front.faq', getParam());
        } else if ($link["type"] == 'blog') {
            $href = route('user.front.blogs', getParam());
        } else if ($link["type"] == 'contact') {
            $href = route('user.front.contact', getParam());
        } else if ($link["type"] == 'cart') {
            $href = route('user.front.cart', getParam());
        } else if ($link["type"] == 'checkout') {
            $href = route('user.product.front.checkout', getParam());
        } else if ($link["type"] == 'reservation') {
            $href = route('user.front.reservation', getParam());
        } else if ($link["type"] == 'about-us') {
            $href = route('user.front.about_us', getParam());
        } else if ($link["type"] == 'custom') {
            if (empty($link["href"])) {
                $href = "#";
            } else {
                $href = $link["href"];
            }
        } else {

            $page_id = (int)$link["type"];
            if ($page_id) {
                $page = User\CustomPage\Page::query()->where('user_id', $user->id)->find($page_id);

                if ($page) {
                    $content = User\CustomPage\PageContent::query()
                        ->where('user_id', $user->id)
                        ->where('page_id', $page->id)
                        ->where('language_id', $langId)
                        ->first();
                    if (!empty($content)) {
                        $href = route('user.front.cpage', [getParam(), $content->slug]);
                    } else {
                        $href = "#";
                    }
                } else {
                    $href = "#";
                }
            }
        }
        return $href;
    }
}


if (!function_exists('create_menu')) {
    function create_menu($arr): void
    {
        echo '<ul class="sub-menu">';

        foreach ($arr["children"] as $el) {

            // determine if the class is 'submenus' or not
            $class = 'class="nav-item"';
            if (array_key_exists("children", $el)) {
                $class = 'class="nav-item submenus"';
            }
            // determine the href
            $href = getHref($el);

            echo '<li ' . $class . '>';
            echo '<a  href="' . $href . '" target="' . $el["target"] . '">' . $el["text"] . '</a>';
            if (array_key_exists("children", $el)) {
                create_menu($el);
            }
            echo '</li>';
        }
        echo '</ul>';
    }
}


if (!function_exists('cartTotal')) {
    function cartTotal(): float
    {
        $total = 0;
        if (session()->has(getUser()->username . '_cart') && !empty(session()->get(getUser()->username . '_cart'))) {
            $cart = session()->get(getUser()->username . '_cart');

            foreach ($cart as $cartItem) {
                $total += $cartItem['total'];
            }
        }
        return round($total, 2);
    }
}

if (!function_exists('posCartSubTotal')) {
    function posCartSubTotal(): float
    {
        $total = 0;
        if (session()->has(getRootUser()->username . '_pos_cart') && !empty(session()->get(getRootUser()->username . '_pos_cart'))) {
            $cart = session()->get(getRootUser()->username . '_pos_cart');
            foreach ($cart as $cartItem) {
                $total += $cartItem['total'];
            }
        }
        return round($total, 2);
    }
}


if (!function_exists('tax')) {
    function tax()
    {
        $tax = 0;
        $taxInfo = [
            'percent' => null,
            'tax' => null,
        ];
        if (session()->has(getUser()->username . '_cart') && !empty(session()->get(getUser()->username . '_cart')) && (!session()->has('coupon'))) {
            $cart = session()->get(getUser()->username . '_cart');
            foreach ($cart as $cartItem) {
                $product = ProductInformation::query()->where('product_id', $cartItem['id'])->first();
                $category = $product->category;
                $cTax = $category->tax;
                $taxInfo['percent'] = $cTax;
                $tax += ($cTax * $cartItem['total']) / 100;
            }
        } elseif (session()->has(getUser()->username . '_cart') && !empty(session()->get(getUser()->username . '_cart')) && (session()->has('coupon'))) {

            $cart = session()->get(getUser()->username . '_cart');

            $coupon = session()->get('coupon');
            foreach ($cart as $cartItem) {
                $product = ProductInformation::query()->where('product_id', $cartItem['id'])->first();
                $category = $product->category;
                $cTax = $category->tax;
                $taxInfo['percent'] = $cTax;
                $tax += ($cTax * ($cartItem['total'] - $coupon)) / 100;
            }
        }
        $taxInfo['tax'] = round($tax, 2);

        return json_encode($taxInfo);
    }
}

if (!function_exists('posTax')) {
    function posTax(): float
    {
        $tax = 0;
        if (session()->has(getRootUser()->username . '_pos_cart') && !empty(session()->get(getRootUser()->username . '_pos_cart'))) {
            $cart = session()->get(getRootUser()->username . '_pos_cart');
            foreach ($cart as $cartItem) {
                $product = ProductInformation::query()->where('product_id', $cartItem['id'])->first();
                $category = $product->category;
                $cTax = $category->tax;
                $tax += ($cTax * $cartItem['total']) / 100;
            }
        }

        return round($tax, 2);
    }
}

if (!function_exists('posShipping')) {
    function posShipping(): float
    {
        $shipping = 0;
        if (session()->has(getRootUser()->username . '_pos_shipping_charge') && !empty(session()->get(getRootUser()->username . '_pos_shipping_charge'))) {
            $shipping = session()->get(getRootUser()->username . '_pos_shipping_charge');
        }
        return round($shipping, 2);
    }
}

if (!function_exists('format_price')) {
    function format_price($value): string
    {
        if (session()->has('lang')) {
            $currentLang = Language::query()->where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::query()->where('is_default', 1)->first();
        }
        $bex = $currentLang->basic_extended;
        if ($bex->base_currency_symbol_position == 'left') {
            return $bex->base_currency_symbol . $value;
        } else {
            return $value . $bex->base_currency_symbol;
        }
    }
}
if (!function_exists('upload_picture')) {
    function upload_picture($directory, $img): string
    {
        $directory = public_path($directory);
        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);
        if (!file_exists($directory)) mkdir($directory, 0777, true);
        $ext = $img->getClientOriginalExtension();
        $newFileName = $file_name . "." . $ext;
        $img->move($directory, $newFileName);
        return $newFileName;
    }
}

if (!function_exists('update_picture')) {
    function update_picture($directory, $img, $old_img): string
    {
        $directory = public_path($directory);
        $file_name = sha1(time() . rand());
        if (!file_exists($directory)) mkdir($directory, 0777, true);
        $ext = $img->getClientOriginalExtension();
        $newFileName = $file_name . "." . $ext;
        $oldImgPath = $directory . '/' . $old_img;
        if (file_exists($oldImgPath)) @unlink($oldImgPath);
        $img->move($directory, $newFileName);
        return $newFileName;
    }
}
if (!function_exists('deleteFile')) {
    function deleteFile($path, $file): bool
    {
        if (!$file) return false;
        $oldImgPath = $path . '/' . $file;
        if (file_exists($oldImgPath)) @unlink($oldImgPath);
        return true;
    }
}
if (!function_exists('setAwsCredentials')) {
    function setAwsCredentials($key, $secret, $region, $bucket): void
    {
        config([
            'filesystems.disks.s3.key' => $key,
            'filesystems.disks.s3.secret' => $secret,
            'filesystems.disks.s3.region' => $region,
            'filesystems.disks.s3.bucket' => $bucket,
        ]);
    }
}

if (!function_exists('cPackageHasSubdomain')) {
    function cPackageHasSubdomain($user): bool
    {

        $currPackageFeatures = UserPermissionHelper::packagePermission($user->id);
        $currPackageFeatures = json_decode($currPackageFeatures, true);

        // if the current package does not contain subdomain
        if (empty($currPackageFeatures) || !is_array($currPackageFeatures) || !in_array('Subdomain', $currPackageFeatures)) {
            return false;
        }

        return true;
    }
}


// checks if 'current package has custom domain ?'
if (!function_exists('cPackageHasCdomain')) {
    function cPackageHasCdomain($user): bool
    {

        $currPackageFeatures = UserPermissionHelper::packagePermission($user->id);
        $currPackageFeatures = json_decode($currPackageFeatures, true);
        if (empty($currPackageFeatures) || !is_array($currPackageFeatures) || !in_array('Custom Domain', $currPackageFeatures)) {
            return false;
        }
        return true;
    }
}

if (!function_exists('getCdomain')) {

    function getCdomain($user)
    {
        $cdomains = $user->custom_domains()->where('status', 1);
        return $cdomains->count() > 0 ? $cdomains->orderBy('id', 'DESC')->first()->requested_domain : false;
    }
}

if (!function_exists('getUser')) {

    function getUser()
    {
        if (app()->runningInConsole()) {
            return new \App\Models\User();
        }
        $parsedUrl = parse_url(url()->current());

        $host =  $parsedUrl['host'];
        $websiteHost = trim(env('WEBSITE_HOST'));


        // if the current URL contains the website domain
        if (str_contains($host, $websiteHost)) {
            $host = str_replace('www.', '', $host);
            $username = '';
            // if current URL is a path based URL
            if ($host == $websiteHost && array_key_exists('path', $parsedUrl)) {
                $path = explode('/', $parsedUrl['path']);
                if (isset($path[1])) {
                    $username = trim($path[1]);
                }
            }
            // if the current URL is a subdomain
            else {
                $hostArr = explode('.', $host);
                $username = trim($hostArr[0]);
            }

            if (($host == $username . '.' . $websiteHost) || ($host . '/' == $websiteHost . '/')) {
                \Illuminate\Support\Facades\Log::info('getUser: matching host', ['host' => $host, 'username' => $username]);
                $user = User::query()
                    ->where('username', 'LIKE', $username)
                    ->where('online_status', 1)
                    ->where('status', 1)
                    ->whereHas('memberships', function ($q) {
                        $q->where('status', '=', 1)
                            ->where('start_date', '<=', \Illuminate\Support\Carbon::now()->format('Y-m-d'))
                            ->where('expire_date', '>=', \Illuminate\Support\Carbon::now()->format('Y-m-d'));
                    })->first();

                if (empty($user)) {
                    \Illuminate\Support\Facades\Log::info('getUser: user not found or no active membership', ['username' => $username]);
                    abort(404);
                }

                // if the current url is a subdomain
                if ($host != $websiteHost) {
                    if (!cPackageHasSubdomain($user)) {
                        return view('errors.404');
                    }
                }

                return $user;
            }
        }

        // Always include 'www.' at the beginning of host
        if (!str_starts_with($host, 'www.')) {
            $host = 'www.' . $host;
        }


        $user = User::where('online_status', 1)
            ->whereHas('custom_domains', function ($q) use ($host) {
                $q->where('status', '=', 1)
                    ->where(function ($query) use ($host) {
                        $query->where('requested_domain', '=', $host)
                            ->orWhere('requested_domain', '=', str_replace("www.", "", $host));
                    });
                // fetch the custom domain , if it matches 'with www.' URL or 'without www.' URL
            })
            ->whereHas('memberships', function ($q) {
                $q->where('status', '=', 1)
                    ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
                    ->where('expire_date', '>=', Carbon::now()->format('Y-m-d'));
            })->first();

        if (empty($user)) {
            abort(404);
        }
        if (!cPackageHasCdomain($user)) {
            return view('errors.404');
        }

        return $user;
    }
}

if (!function_exists('getParam')) {

    function getParam()
    {

        $parsedUrl = parse_url(url()->current());
        $host = str_replace("www.", "", $parsedUrl['host']);
        $websiteHost = trim(env('WEBSITE_HOST'));
        // if it is path based URL, then return {username}
        if (str_contains($host, $websiteHost) && $host == $websiteHost) {
            $path = explode('/', $parsedUrl['path']);
            return $path[1];
        }
        // if it is a subdomain / custom domain , then return the host (username.domain.ext / custom_domain.ext)
        return $host;
    }
}
if (!function_exists('detailsUrl')) {

    function detailsUrl($user)
    {
        $currentUrl = url('/');
        $url = str_replace('https:', '', $currentUrl);
        $url = str_replace('http:', '', $url);
        return $url . '/' . $user->username;
    }
}

if (!function_exists('getRootUser')) {
    function getRootUser()
    {
        return is_null(Auth::guard('web')->user()?->admin_id)
            ? Auth::guard('web')->user()
            : Cache::remember('user', 60, function () {
                return User::query()->find(Auth::guard('web')->user()?->admin_id);
            });
    }
}
if (!function_exists('create_user_menu')) {
    function create_user_menu($arr, $langId): void
    {
        echo '<ul class="sub-menu">';

        foreach ($arr["children"] as $el) {

            // determine if the class is 'submenus' or not
            $class = 'class="nav-item"';
            if (array_key_exists("children", $el)) {
                $class = 'class="nav-item submenus"';
            }
            // determine the href
            $href = getUserHref($el, $langId);

            echo '<li ' . $class . '>';
            echo '<a  href="' . $href . '" target="' . $el["target"] . '">' . $el["text"] . '</a>';
            if (array_key_exists("children", $el)) {
                create_user_menu($el, $langId);
            }
            echo '</li>';
        }
        echo '</ul>';
    }
}


if (!function_exists('paytabInfo')) {
    function paytabInfo($type, $user_id = null)
    {
        if ($type == 'user') {
            $paytabs = UserPaymentGateway::where([['user_id', $user_id], ['keyword', 'paytabs']])->first();
        } else {
            $paytabs = PaymentGateway::where('keyword', 'paytabs')->first();
        }
        $paytabsInfo = json_decode($paytabs->information, true);
        if ($paytabsInfo['country'] == 'global') {
            $currency = 'USD';
        } elseif ($paytabsInfo['country'] == 'sa') {
            $currency = 'SAR';
        } elseif ($paytabsInfo['country'] == 'uae') {
            $currency = 'AED';
        } elseif ($paytabsInfo['country'] == 'egypt') {
            $currency = 'EGP';
        } elseif ($paytabsInfo['country'] == 'oman') {
            $currency = 'OMR';
        } elseif ($paytabsInfo['country'] == 'jordan') {
            $currency = 'JOD';
        } elseif ($paytabsInfo['country'] == 'iraq') {
            $currency = 'IQD';
        } else {
            $currency = 'USD';
        }
        return [
            'server_key' => $paytabsInfo['server_key'],
            'profile_id' => $paytabsInfo['profile_id'],
            'url'        => $paytabsInfo['api_endpoint'],
            'currency'   => $currency,
        ];
    }
}

if (!function_exists('getQrFormat')) {
    function getQrFormat()
    {
        return extension_loaded('imagick') ? 'png' : 'svg';
    }
}

if (!function_exists('getQrExtension')) {
    function getQrExtension()
    {
        return extension_loaded('imagick') ? '.png' : '.svg';
    }
}
