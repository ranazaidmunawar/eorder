<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SocialController extends Controller
{
    public function index() {
      $userId = getRootUser()->id;
      $data['socials'] = Social::query()
          ->where('user_id', $userId)
          ->orderBy('id', 'DESC')
          ->get();
      return view('user.basic.social.index', $data);
    }

    public function store(Request $request) {
      $request->validate([
        'icon' => 'required',
        'url' => 'required',
        'serial_number' => 'required|integer',
      ]);
      $userId = getRootUser()->id;
      $social = new Social;
      $social->user_id = $userId;
      $social->icon = $request->icon;
      $social->url = $request->url;
      $social->serial_number = $request->serial_number;
      $social->save();

      Session::flash('success', 'New link added successfully!');
      return back();
    }

    public function edit($id) {
      $userId = getRootUser()->id;
      $data['social'] = Social::query()
          ->where('user_id',$userId)
          ->find($id);
      $this->authorize('view',$data['social']);    
      return view('user.basic.social.edit', $data);
    }

    public function update(Request $request) {
      $request->validate([
        'icon' => 'required',
        'url' => 'required',
        'serial_number' => 'required|integer',
      ]);
      $userId = getRootUser()->id;
      $social = Social::query()
                      ->where('user_id',$userId)
                      ->findOrFail($request->socialId);
      $social->user_id = $userId;
      $social->icon = $request->icon;
      $social->url = $request->url;
      $social->serial_number = $request->serial_number;
      $social->save();

      Session::flash('success', 'Social link updated successfully!');
      return back();
    }

    public function delete(Request $request) {
      $userId = getRootUser()->id;
      $social = Social::query()
          ->where('user_id',$userId)
          ->findOrFail($request->socialId);
      $social->delete();

      Session::flash('success', 'Social link deleted successfully!');
      return back();
    }
}
