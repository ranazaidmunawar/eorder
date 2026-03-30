<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!app()->runningInConsole()) {
            $currentLang = \App\Models\Language::where('is_default', 1)->first();
            if ($currentLang) {
                $bs = \App\Models\BasicSetting::where('language_id', $currentLang->id)->first();
                $be = \App\Models\BasicExtended::where('language_id', $currentLang->id)->first();
                $menu = \App\Models\Menu::where('language_id', $currentLang->id)->first();
                $socials = \App\Models\Social::orderBy('serial_number', 'ASC')->get();
                $langs = \App\Models\Language::all();
                $seo = \App\Models\Seo::where('language_id', $currentLang->id)->first();
                $popups = \App\Models\Popup::where('language_id', $currentLang->id)->where('status', 1)->get();
                \Illuminate\Support\Facades\View::share('bs', $bs);
                \Illuminate\Support\Facades\View::share('be', $be);
                \Illuminate\Support\Facades\View::share('currentLang', $currentLang);
                \Illuminate\Support\Facades\View::share('rtl', $currentLang->rtl);
                \Illuminate\Support\Facades\View::share('menus', $menu ? $menu->menus : '[]');
                \Illuminate\Support\Facades\View::share('socials', $socials);
                \Illuminate\Support\Facades\View::share('langs', $langs);
                \Illuminate\Support\Facades\View::share('seo', $seo);
                \Illuminate\Support\Facades\View::share('popups', $popups);
            }
        }

        \Illuminate\Support\Facades\View::composer('user.*', function ($view) {
            if (\Illuminate\Support\Facades\Auth::guard('web')->check()) {
                $user = getRootUser();
                if ($user) {
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
                    $permissions = \App\Http\Helpers\UserPermissionHelper::packagePermission($user->id);
                    $permissions = json_decode($permissions, true);
                    $view->with('user', $user);
                    $view->with('tusername', $user->username);
                    $view->with('userCurrentLang', $currentLang);
                    $view->with('userBs', $userBs);
                    $view->with('userBe', $userBe);
                    $view->with('userBex', $userBex);
                    $view->with('bs', $userBs);
                    $view->with('be', $userBe);
                    $view->with('activeTheme', $userBs->theme);
                    $allLanguageInfos = \App\Models\User\Language::where('user_id', $user->id)->get();
                    $view->with('allLanguageInfos', $allLanguageInfos);
                    $view->with('userLangs', $allLanguageInfos);
                    $view->with('languages', $allLanguageInfos);
                    $upageHeading = \App\Models\User\PageHeading::where('user_id', $user->id)->where('language_id', $currentLang->id)->first();
                    $userSeo = \App\Models\User\Seo::where('user_id', $user->id)->where('language_id', $currentLang->id)->first();
                    $view->with('upageHeading', $upageHeading);
                    $view->with('userSeo', $userSeo);
                    $view->with('permissions', $permissions);
                    $view->with('packagePermissions', $permissions);
                }
            }
        });
    }
}
