<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\LimitCheckerHelper;
use Illuminate\Support\Facades\Response;
use App\Http\Helpers\UserPermissionHelper;

class LimitCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $feature, $method)
    {
        // if the admin is logged in & he has a role defined then this check will be applied

        if (Auth::guard('web')->check()) {
            if (!is_null(Auth::guard('web')->user()->admin_id)) {
                $userId = Auth::guard('web')->user()->admin_id;
            } else {
                $userId = Auth::guard('web')->user()->id;
            }
            $packageId = LimitCheckerHelper::getMembershipId($userId);
            $package = Package::find($packageId);
            $user = User::find($userId);

            if (empty($package)) {
                return redirect()->route('user.dashboard');
            }

            $sfeatures = json_decode($package->features, true);
            if (in_array('Storage Limit', $sfeatures)) {
                $storageCount = LimitCheckerHelper::storageCount(Auth::guard('web')->user()->id, 'storage_usage');
                if (
                    $storageCount >= $package->storage_limit && $package->storage_limit !=
                    999999
                ) {
                    return response()->json('downgrade');
                }
            }


            $userFeaturesCount = LimitCheckerHelper::userFeaturesCount($user->id);

            if ($method == 'store') {

                if ($feature == 'staffs') {

                    if ($package->staff_limit > $userFeaturesCount['staffs'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {
                        session()->put('CrossLimit', 'crossed  limit');
                        return response()->json('downgrade');
                    }
                }
                if ($feature == 'categories') {

                    if ($package->categories_limit > $userFeaturesCount['categories'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {


                        return response()->json('downgrade');
                    }
                }
                if ($feature == 'subcategories') {

                    if ($package->subcategories_limit > $userFeaturesCount['subcategories'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {


                        return response()->json('downgrade');
                    }
                }
                if ($feature == 'orders') {

                    if ($package->order_limit > $userFeaturesCount['orders'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {

                        return response()->json('downgrade');
                    }
                }
                if ($feature == 'products') {

                    if ($package->items_limit > $userFeaturesCount['products'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {


                        return response()->json('downgrade');
                    }
                }
                if ($feature == 'reservations') {

                    if ($package->table_reservation_limit > $userFeaturesCount['reservations'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {

                        return response()->json('downgrade');
                    }
                }

                if ($feature == 'languages') {

                    if ($package->language_limit > $userFeaturesCount['languages'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {

                        return response()->json('downgrade');
                    }
                }
            }

            if ($method == 'update') {


                if ($feature == 'staffs') {

                    if ($package->staff_limit >= $userFeaturesCount['staffs'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {

                        return response()->json('downgrade');
                    }
                }
                if ($feature == 'categories') {

                    if ($package->categories_limit >= $userFeaturesCount['categories'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {


                        return response()->json('downgrade');
                    }
                }
                if ($feature == 'subcategories') {

                    if ($package->subcategories_limit >= $userFeaturesCount['subcategories'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {


                        return response()->json('downgrade');
                    }
                }
                if ($feature == 'orders') {

                    if ($package->order_limit >= $userFeaturesCount['orders'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {

                        return response()->json('downgrade');
                    }
                }
                if ($feature == 'products') {

                    if ($package->items_limit >= $userFeaturesCount['products'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {


                        return $next($request);
                    } else {

                        session()->put('CrossLimit', 'Reached max limit');
                        return response()->json('downgrade');
                    }
                }
                if ($feature == 'reservations') {

                    if ($package->table_reservation_limit >= $userFeaturesCount['reservations'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {

                        return response()->json('downgrade');
                    }
                }

                if ($feature == 'languages') {

                    if ($package->language_limit >= $userFeaturesCount['languages'] && $this->checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)) {

                        return $next($request);
                    } else {

                        return response()->json('downgrade');
                    }
                }
            }
        }
        return $next($request);
    }

    private function checkFeaturesNotDowngraded($feature, $package, $userFeaturesCount)
    {
        $true = true;

        if ($feature != 'staffs') {

            if ($package->staff_limit < $userFeaturesCount['staffs']) {

                return  $true = false;
            }
        }

        if ($feature != 'categories') {

            if ($package->categories_limit < $userFeaturesCount['categories']) {

                return  $true = false;
            }
        }
        if ($feature != 'subcategories') {

            if ($package->subcategories_limit < $userFeaturesCount['subcategories']) {

                return  $true = false;
            }
        }
        if ($feature != 'orders') {

            if ($package->order_limit < $userFeaturesCount['orders']) {

                return  $true = false;
            }
        }
        if ($feature != 'products') {

            if ($package->items_limit < $userFeaturesCount['products']) {

                return  $true = false;
            }
        }

        if ($feature != 'reservations') {

            if ($package->table_reservation_limit < $userFeaturesCount['reservations']) {

                return  $true = false;
            }
        }


        if ($feature != 'languages') {

            if ($package->language_limit < $userFeaturesCount['languages']) {

                return $true = false;
            }
        }


        return $true;
    }
}
