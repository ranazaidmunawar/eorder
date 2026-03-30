<?php

namespace App\Http\Controllers\User;

use App\Models\User\Bottomlink;
use App\Models\User\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BlinkController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()
            ->where('code', $request->language)
            ->where('user_id', $userId)
            ->first();

        $lang_id = $lang->id;
        $data['bottoms'] = Bottomlink::where([
            ['language_id', $lang_id],
            ['user_id', $userId]
        ])->get();
        $data['lang_id'] = $lang_id;
        return view('user.footer.ulink.bottom_link', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'user_language_id.required' => 'The language field is required'
        ];

        $rules = [
            'user_language_id' => 'required',
            'name' => 'required|max:255',
            'url' => 'required|max:255'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $blink = new Bottomlink;
        $blink->language_id = $request->user_language_id;
        $blink->user_id = $userId;
        $blink->name = $request->name;
        $blink->url = $request->url;
        $blink->save();

        Session::flash('success', 'Bottom link added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'url' => 'required|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $blink = Bottomlink::query()
            ->where('user_id', $userId)
            ->findOrFail($request->link_id);
        $blink->name = $request->name;
        $blink->url = $request->url;
        $blink->save();

        Session::flash('success', 'Bottom link updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $ulink = Bottomlink::query()
            ->where('user_id', $userId)
            ->findOrFail($request->bottom_id);
        $ulink->delete();

        Session::flash('success', 'Bottom link deleted successfully!');
        return back();
    }
}
