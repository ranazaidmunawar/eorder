<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\User\Role;
use App\Constants\Constant;
use Illuminate\Http\Request;
use App\Http\Helpers\Uploader;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\LimitCheckerHelper;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
  public function index()
  {
    $userId = getRootUser()->id;
    $features =  LimitCheckerHelper::getPackageSelectedData($userId, 'features');
    $data['features'] = json_decode($features->features, true);

    $data['users'] = User::query()
      ->where('admin_id', $userId)
      ->where('id', '!=', Auth::guard('web')->user()->id)->orderBy('id','desc')
      ->get();
    $data['roles'] = Role::query()
      ->where('user_id', $userId)
      ->get();

    return view('user.admin.index', $data);
  }

  public function edit($id)
  {
    $userId = getRootUser()->id;
    $data['user'] = User::query()
      ->where('admin_id', $userId)
      ->find($id);
     $this->authorize('editview', $data['user']);
      $data['roles'] = Role::query()
      ->where('user_id', $userId)
      ->get();
    return view('user.admin.edit', $data);
  }

  public function store(Request $request)
  {
    $userId = getRootUser()->id;
    
    $rules = [
      'username' => [
        'required',
        'max:255',
        Rule::unique('users')->where(function ($query) use ($userId) {
          return $query->where('admin_id', $userId);
        })
      ],
      'email' => [
        'required',
        'max:255',
        Rule::unique('users')->where(function ($query) use ($userId) {
          return $query->where('admin_id', $userId);
        })
      ],
      'first_name' => 'required|max:255',
      'last_name' => 'required|max:255',
      'password' => 'required|confirmed',
      'role_id' => 'required',
      'image' => 'required|mimes:jpeg,jpg,png',
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      $validator->getMessageBag()->add('error', 'true');
      return response()->json($validator->errors());
    }
    $user = new User;
    $input = $request->all();
    if ($request->hasFile('image')) {
      $input['image'] = Uploader::upload_picture(Constant::WEBSITE_TENANT_USER_IMAGE, $request->file('image'));
    }
    $input['role_id'] = $request->role_id;
    $input['status'] = 1;
    $input['admin_id'] = $userId;
    $input['password'] = bcrypt($request['password']);
    $user->create($input);

    Session::flash('success', 'User created successfully!');
    return "success";
  }

  public function update(Request $request)
  {
    $userId = getRootUser()->id;
    $user = User::query()
      ->where('admin_id', $userId)
      ->findOrFail($request->user_id);

    $rules = [
      'username' => [
        'required',
        'max:255',
        Rule::unique('users')
          ->ignore($user->id)
          ->where(function ($query) use ($userId) {
            return $query->where('admin_id', $userId);
          }),
      ],
      'email' => [
        'required',
        'email',
        'max:255',
        Rule::unique('users')
          ->ignore($user->id)
          ->where(function ($query) use ($userId) {
            return $query->where('admin_id', $userId);
          }),
      ],
      'first_name' => 'required|max:255',
      'last_name' => 'required|max:255',
      'role_id' => 'required',
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      $validator->getMessageBag()->add('error', 'true');
      return response()->json($validator->errors());
    }

    $input = $request->all();

    if ($request->hasFile('image')) {
      $input['image'] = Uploader::update_picture(Constant::WEBSITE_TENANT_USER_IMAGE, $request->file('image'), $user->image);
    }
    $user->update($input);

    Session::flash('success', 'User updated successfully!');
    return "success";
  }

  public function delete(Request $request)
  {
    if ($request->user_id == Auth::guard('web')->user()->admin_id) {
      Session::flash('warning', 'You cannot delete the owner!');
      return back();
    }
    $userId = getRootUser()->id;
    $user = User::query()
      ->where('admin_id', $userId)
      ->findOrFail($request->user_id);
    Uploader::remove(Constant::WEBSITE_TENANT_USER_IMAGE, $user->image);
    $user->delete();
    Session::flash('success', 'User deleted successfully!');
    return back();
  }

  public function change_password()
  {
    return view('user.admin.change_password');
  }

  
  public function updatePassword(Request $request)
  {

    $rules = [
      'password' => 'required|min:8',
      'password_confirmation' => 'required|same:password',
    ];

    $messages = [
      'password_confirmation.same' => 'The password confirmation does not match.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()->toArray()
      ], 400);
    }

    // updating password in database...
    $user = User::query()->where('admin_id',Auth::guard('web')->user()->id)->first();

    $user->password = bcrypt($request->password);
    $user->save();

    Session::flash('success', 'Password changed successfully!');

    return 'success';
  }

  public function secretLogin(Request $request)
  {
    $user = User::where('id', $request->user_id)->first();

    if ($user) {
      Auth::guard('web')->login($user);
      return redirect()->route('user.dashboard')
      ->withSuccess('You have Successfully loggedin');
    } else {

      return redirect()->route('renter.login',getParam())->withSuccess('Oppes! You have entered invalid credentials');
    }
  }
}
