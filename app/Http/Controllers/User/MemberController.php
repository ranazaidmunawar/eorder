<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Models\User\Language;
use App\Models\User\Member;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()
            ->where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();
       
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['members'] = Member::query()
            ->where([
            ['language_id', $data['lang_id']],
            ['user_id', $userId]
        ])->get();

        return view('user.home.member.index', $data);
    }

    public function create()
    {
        return view('user.home.member.create');
    }

    public function edit($id)
    {
        $userId = getRootUser()->id;
        $data['member'] = Member::query()
            ->where('user_id', $userId)
            ->find($id);
        $this->authorize('view',$data['member']);    
        return view('user.home.member.edit', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'user_language_id.required' => 'The language field is required'
        ];
        $rules = [
            'user_language_id' => 'required',
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'facebook' => 'nullable|max:50',
            'twitter' => 'nullable|max:50',
            'linkedin' => 'nullable|max:50',
            'instagram' => 'nullable|max:50',
            'image' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $input = $request->all();
        $input['user_id'] = $userId;
        $input['language_id'] = $request->user_language_id;
        if ($request->hasFile('image')) {
            $input['image'] = Uploader::upload_picture(Constant::WEBSITE_MEMBER_IMAGES,$request->file('image'));
        }
        $member = new Member;
        $member->create($input);
        Session::flash('success', 'Member added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'facebook' => 'nullable|max:50',
            'twitter' => 'nullable|max:50',
            'linkedin' => 'nullable|max:50',
            'instagram' => 'nullable|max:50',
            'image' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $member = Member::query()
            ->where('user_id', $userId)
            ->findOrFail($request->member_id);
        $input = $request->all();
        if ($request->hasFile('image')) {
            $input['image'] = Uploader::update_picture(Constant::WEBSITE_MEMBER_IMAGES,$request->file('image'),$member->image);
        }
        $member->update($input);
        Session::flash('success', 'Member updated successfully!');
        return "success";
    }


    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $member = Member::query()
            ->where('user_id', $userId)
            ->findOrFail($request->member_id);
        Uploader::remove(Constant::WEBSITE_MEMBER_IMAGES,$member->image);
        $member->delete();
        Session::flash('success', 'Member deleted successfully!');
        return back();
    }

    public function feature(Request $request)
    {
        $userId = getRootUser()->id;
        $member = Member::query()
            ->where('user_id', $userId)
            ->find($request->member_id);
        $member->feature = $request->feature;
        $member->save();
        if ($request->feature == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }
        return back();
    }
}
