<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index() {
      $userId = getRootUser()->id;
      $data['roles'] = Role::query()
          ->where('user_id',$userId)
          ->get();
      return view('user.role.index', $data);
    }

    public function store(Request $request) {

      $rules = [
        'name' => 'required|max:255',
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }
      $userId = getRootUser()->id;
      $role = new Role;
      $role->name = $request->name;
      $role->user_id = $userId;
      $role->save();

      Session::flash('success', 'Role added successfully!');
      return "success";
    }

    public function update(Request $request) {
      $rules = [
        'name' => 'required|max:255',
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }
      $userId = getRootUser()->id;
      $role = Role::query()
          ->where('user_id', $userId)
          ->findOrFail($request->role_id);
      $role->name = $request->name;
      $role->user_id = $userId;
      $role->save();

      Session::flash('success', 'Role updated successfully!');
      return "success";
    }

    public function delete(Request $request) {
      $userId = getRootUser()->id;
      $role = Role::query()
          ->where('user_id', $userId)
          ->findOrFail($request->role_id);
      if ($role->admins()->count() > 0) {
        Session::flash('warning', 'Please delete the users under this role first.');
        return back();
      }
      $role->delete();

      Session::flash('success', 'Role deleted successfully!');
      return back();
    }

    public function managePermissions($id) {
      $userId = getRootUser()->id;
      $data['role'] = Role::query()
          ->where('user_id', $userId)
          ->find($id);
      $this->authorize('view',$data['role']);    
      return view('user.role.permission.manage', $data);
    }

    public function updatePermissions(Request $request) {
      $userId = getRootUser()->id;
      $permissions = json_encode($request->permissions);
      $role = Role::query()
          ->where('user_id', $userId)
          ->find($request->role_id);
      $role->permissions = $permissions;
      $role->save();

      Session::flash('success', "Permissions updated successfully for '$role->name' role");
      return back();
    }
}
