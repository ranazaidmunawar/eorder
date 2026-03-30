<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Package;
use App\Models\Membership;
use App\Models\User\Table;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Models\User\TableBook;
use App\Models\User\ProductOrder;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\LimitCheckerHelper;


class DashboardController extends Controller
{
    public function dashboard()
    {
        
      $user = getRootUser();
      $features = LimitCheckerHelper::getPackageSelectedData($user->id,'features');
        // Check if features are null
        if (is_null($features)) {
            // Notify user about pending membership but allow access
            session()->flash('warning', 'Membership is Pending');
        } else {
            // Decode features if they exist
            $data['features'] = json_decode($features->features, true);
        }

      $data['table_books'] = TableBook::query()
          ->where('user_id', $user->id)
          ->orderby('id','desc')
          ->take(10)
          ->get();
    $data['reservations'] = TableBook::query()
            ->where('user_id', $user->id)
            ->get();    
    $data['tables'] = Table::query()
            ->where('user_id', $user->id)
            ->get();    

      $data['orders'] = ProductOrder::query()
          ->where('user_id', $user->id)
          ->orderby('id','desc')
          ->take(10)
          ->get();
        $data['memberships'] = Membership::query()->where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->limit(10)->get();

        $nextPackageCount = Membership::query()->where([
            ['user_id', $user->id],
            ['expire_date', '>=', Carbon::now()->toDateString()]
        ])->whereYear('start_date', '<>', '9999')->where('status', '<>', 2)->count();
        //current package
        $data['current_membership'] = Membership::query()->where([
            ['user_id', $user->id],
            ['start_date', '<=', Carbon::now()->toDateString()],
            ['expire_date', '>=', Carbon::now()->toDateString()]
        ])->where('status', 1)->whereYear('start_date', '<>', '9999')->first();
        if($data['current_membership']){
            $countCurrMem = Membership::query()->where([
                ['user_id', $user->id],
                ['start_date', '<=', Carbon::now()->toDateString()],
                ['expire_date', '>=', Carbon::now()->toDateString()]
            ])->where('status', '<>', 2)->whereYear('start_date', '<>', '9999')->count();
            if ($countCurrMem > 1) {
                $data['next_membership'] = Membership::query()->where([
                    ['user_id', $user->id],
                    ['start_date', '<=', Carbon::now()->toDateString()],
                    ['expire_date', '>=', Carbon::now()->toDateString()]
                ])->where('status', '<>', 2)->whereYear('start_date', '<>', '9999')->orderBy('id', 'DESC')->first();
            } else {
                $data['next_membership'] = Membership::query()->where([
                    ['user_id', $user->id],
                    ['start_date', '>', $data['current_membership']->expire_date]
                ])->whereYear('start_date', '<>', '9999')->where('status', '<>', 2)->first();
            }
            $data['next_package'] = $data['next_membership'] ? Package::query()->where('id', $data['next_membership']->package_id)->first() : null;
        }
        $data['current_package'] = $data['current_membership'] ? Package::query()->where('id', $data['current_membership']->package_id)->first() : null;
        $data['package_count'] = $nextPackageCount;

      return view('user.dashboard', $data);
    }

    public function changeTheme(Request $request): RedirectResponse
    {
        return redirect()->back()->withCookie(cookie()->forever('user-theme', $request->theme));
    }
    public function status(Request $request)
    {
      
        $user = Auth::guard('web')->user();
        $user->online_status = $request->value;
        $user->save();
        if ($request->value == 1) {
            $msg = "Profile has been made visible";
        } else {
            $msg = "Profile has been hidden";
        }
        Session::flash('success', $msg);
        return "success";
    }
}
