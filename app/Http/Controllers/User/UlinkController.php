<?php

namespace App\Http\Controllers\User;

use App\Models\User\Language;
use App\Models\User\Ulink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class UlinkController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()
            ->where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();
        $lang_id = $lang->id;
        $data['aulinks'] = Ulink::query()
            ->where([
            ['language_id', $lang_id],
            ['user_id', $userId]
        ])->get();
        $data['lang_id'] = $lang_id;
        return view('user.footer.ulink.index', $data);
    }

    public function edit($id)
    {
        $userId = getRootUser()->id;
        $data['ulink'] = Ulink::query()
            ->where('user_id', $userId)
            ->findOrFail($id);
        return view('user.footer.ulink.edit', $data);
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
        $ulink = new Ulink;
        $ulink->language_id = $request->user_language_id;
        $ulink->user_id = $userId;
        $ulink->name = $request->name;
        $ulink->url = $request->url;
        $ulink->save();

        Session::flash('success', 'Useful link added successfully!');
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
        $ulink = Ulink::query()
            ->where('user_id', $userId)
            ->findOrFail($request->ulink_id);
        $ulink->name = $request->name;
        $ulink->url = $request->url;
        $ulink->save();

        Session::flash('success', 'Useful link updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $ulink = Ulink::query()
            ->where('user_id', $userId)
            ->findOrFail($request->ulink_id);
        $ulink->delete();
        Session::flash('success', 'Ulink deleted successfully!');
        return back();
    }
}
