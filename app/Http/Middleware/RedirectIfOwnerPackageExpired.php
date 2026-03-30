<?php

namespace App\Http\Middleware;

use App\Http\Helpers\UserPermissionHelper;
use App\Models\User\BasicExtended;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RedirectIfOwnerPackageExpired
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = getUser();
        if (is_null(UserPermissionHelper::currentPackage($user->id))) {
            Session::flash('warning', 'Owner account has expired');
            return redirect()->route('front.index');
        }

        $currentLang = \App\Models\User\Language::where('user_id', $user->id)->where('is_default', 1)->first();
        if (session()->has('user_lang')) {
            $sessLang = \App\Models\User\Language::where('code', session()->get('user_lang'))->where('user_id', $user->id)->first();
            if ($sessLang) {
                $currentLang = $sessLang;
            }
        }

        $userBs = \App\Models\User\BasicSetting::where('user_id', $user->id)->where('language_id', $currentLang->id)->first();
        $userBe = \App\Models\User\BasicExtended::where('user_id', $user->id)->where('language_id', $currentLang->id)->first();
        $userBex = \App\Models\User\BasicExtra::where('user_id', $user->id)->first();

        if($userBe?->timezone){
            date_default_timezone_set($userBe->timezone);
        }

        $allLanguageInfos = \App\Models\User\Language::where('user_id', $user->id)->get();
        $packagePermissions = UserPermissionHelper::currentPackageFeatures($user->id);
        $menu = \App\Models\User\Menu::where('user_id', $user->id)->where('language_id', $currentLang->id)->first();
        $userMenus = $menu ? $menu->menus : '[]';
        $socialMediaInfos = \App\Models\User\Social::where('user_id', $user->id)->orderBy('serial_number', 'ASC')->get();
        $apopups = \App\Models\User\Popup::where('user_id', $user->id)->where('language_id', $currentLang->id)->where('status', 1)->get();
        $upageHeading = \App\Models\User\PageHeading::where('user_id', $user->id)->where('language_id', $currentLang->id)->first();
        $userSeo = \App\Models\User\Seo::where('user_id', $user->id)->where('language_id', $currentLang->id)->first();

        \Illuminate\Support\Facades\View::share('user', $user);
        \Illuminate\Support\Facades\View::share('userCurrentLang', $currentLang);
        \Illuminate\Support\Facades\View::share('userBs', $userBs);
        \Illuminate\Support\Facades\View::share('userBe', $userBe);
        \Illuminate\Support\Facades\View::share('userBex', $userBex);
        \Illuminate\Support\Facades\View::share('bs', $userBs);
        \Illuminate\Support\Facades\View::share('be', $userBe);
        \Illuminate\Support\Facades\View::share('rtl', $currentLang->rtl);
        \Illuminate\Support\Facades\View::share('activeTheme', $userBs->theme);
        \Illuminate\Support\Facades\View::share('keywords', json_decode($currentLang->keywords, true));
        \Illuminate\Support\Facades\View::share('allLanguageInfos', $allLanguageInfos);
        \Illuminate\Support\Facades\View::share('packagePermissions', $packagePermissions);
        \Illuminate\Support\Facades\View::share('userMenus', $userMenus);
        \Illuminate\Support\Facades\View::share('socialMediaInfos', $socialMediaInfos);
        \Illuminate\Support\Facades\View::share('apopups', $apopups);
        \Illuminate\Support\Facades\View::share('upageHeading', $upageHeading);
        \Illuminate\Support\Facades\View::share('userSeo', $userSeo);

        return $next($request);
    }
}
