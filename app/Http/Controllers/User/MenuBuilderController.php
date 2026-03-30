<?php

namespace App\Http\Controllers\User;

use App\Models\User\CustomPage\Page;
use App\Models\User\Language;
use App\Models\User\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MenuBuilderController extends Controller
{

    public function index(Request $request) {
        $userId = getRootUser()->id;
        $lang = Language::where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();

        $data['lang_id'] = $lang->id;
        $data['keywords'] = json_decode($lang->keywords, true);
        // get page names of selected language
        $data["pages"] = DB::table('user_pages')
            ->join('user_page_contents', 'user_pages.id', '=', 'user_page_contents.page_id')
            ->where('user_page_contents.language_id', '=', $lang->id)
            ->where('user_page_contents.user_id', '=', $userId)
            ->orderByDesc('user_pages.id')
            ->get();
        

        // get previous menus
        $menu = Menu::query()
            ->where([
            ['language_id', $lang->id],
            ['user_id', $userId]
        ])->first();
        $data['prevMenu'] = '';
        if (!empty($menu)) {
            $data['prevMenu'] = $menu->menus;
        }

        return view('user.menu_builder.index', $data);
    }

    public function update(Request $request) {
        $userId = getRootUser()->id;
        Menu::where('language_id', $request->language_id)->where('user_id', $userId)->delete();
        $menu = new Menu;
        $menu->language_id = $request->language_id;
        $menu->user_id = $userId;
        $menu->menus = $request->str;
        $menu->save();
        return response()->json(['status' => 'success', 'message' => 'Menu updated successfully!']);
    }
}
