<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UserPermissionHelper;
use Illuminate\Support\Facades\Auth;

class SubdomainController extends Controller
{
    public function subdomain() {
        $userId = getRootUser()->id;
        $features = UserPermissionHelper::packagePermission($userId);
        $data['features'] = json_decode($features, true);
        return view('user.subdomain', $data);
    }
}
