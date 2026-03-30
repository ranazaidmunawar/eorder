<?php

namespace App\Http\Helpers;

use App\Models\Membership;
use App\Models\Package;
use App\Models\User;
use App\Models\User\BasicSetting;
use App\Models\User\Language;
use App\Models\User\OrderItem;
use App\Models\User\Pcategory;
use App\Models\User\Product;
use App\Models\User\ProductInformation;
use App\Models\User\ProductOrder;
use App\Models\User\PsubCategory;
use App\Models\User\TableBook;
use Carbon\Carbon;

class LimitCheckerHelper
{
    public static function getMembershipId($userId)
    {
        return Membership::query()->where([
            ['user_id', '=', $userId],
            ['status', '=', 1],
            ['start_date', '<=', Carbon::now()->format('Y-m-d')],
            ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
        ])
            ->pluck('package_id')
            ->first();
    }

    public static function currentMembership(int $userId)
    {
        $currentMembership = Membership::query()
            ->where([
                ['user_id', '=', $userId],
                ['status', '=', 1],
                ['start_date', '<=', Carbon::now()->format('Y-m-d')],
                ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
            ])->first();

        return isset($currentMembership) ? $currentMembership : collect([]);
    }

    public static function currentMembershipPackage(int $userId)
    {
        $currentMembership = Membership::query()
            ->where([
                ['user_id', '=', $userId],
                ['status', '=', 1],
                ['start_date', '<=', Carbon::now()->format('Y-m-d')],
                ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
            ])->first();
        $package = Package::find($currentMembership->package_id);    

        return isset($package) ? $package : null;
    }

    public static function storageCount($id, ...$selectedColumns)
    {
        $bs = BasicSetting::query()->select($selectedColumns)->where('user_id', $id)->first();
        return $bs?->storage_usage ?? 0;
    }

    public static function getPackageColumnData($id, ...$selectedColumns)
    {
        return Package::query()->select($selectedColumns)->find($id);
    }

    public static function storageLimit(int $user_id)
    {
        $id = self::getMembershipId($user_id);
        if (isset($id)) {
            $package = self::getPackageColumnData($id, 'storage_limit');
        }
        return isset($id) && isset($package) ? $package->storage_limit : 0;
    }

    public static function getPackageSelectedData($userId, ...$selectedColumns)
    {
        $id = Membership::query()->where([
            ['user_id', '=', $userId],
            ['status', '=', 1],
            ['start_date', '<=', Carbon::now()->format('Y-m-d')],
            ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
        ])
            ->pluck('package_id')
            ->first();

        if (isset($id)) {
            return Package::query()->select($selectedColumns)->find($id);
        }
        return null;
    }

    public static function getStaffCount($adminId): int
    {
        return User::query()->where('admin_id', $adminId)->count();
    }

    public static function getProductCategoryCount($userId, $langId): int
    {
        return Pcategory::query()->where([
            ['user_id', $userId],
            ['language_id', $langId]
        ])->count();
    }

    public static function getProductSubCategoryCount($userId, $langId, $categoryId): int
    {
        return PsubCategory::query()->where([
            ['user_id', $userId],
            ['language_id', $langId],
            ['category_id', $categoryId]
        ])->count();
    }

    public static function getProductCount($userId): int
    {
        return Product::query()->where('user_id', $userId)->count();
    }

    public static function getLanguageCount($userId): int
    {
        return Language::query()->where('user_id', $userId)->count();
    }
    public static function getTableReservationCount($userId): int
    {
        $membership = self::currentMembership($userId);
        $countorder = TableBook::where('user_id', $userId)->where('membership_id', $membership->id);
        return $countorder ? $countorder->count() : 0;
    }
    public static function getProductOrderCount($userId): int
    {
        return ProductOrder::query()->where('user_id', $userId)->count();
    }

   public static function staffCount($userId)
    {
        $countStaff = User::where('admin_id', $userId);
        return $countStaff ? $countStaff->count() : 0;
    }
    public static function orderCount($userId)
    {
        $membership = self::currentMembership($userId);
        $countorder = ProductOrder::where('user_id', $userId)->where('membership_id', $membership->id);
        return $countorder ? $countorder->count() : 0;
    } 
    public static function categoryCount($userId)
    {
        $countcategory = Pcategory::where('user_id', $userId)->distinct('indx');
        return $countcategory ? $countcategory->count() : 0;
    } 
    public static function subcategoryCount($userId)
    {
        $subcategory = PsubCategory::where('user_id', $userId)->distinct('indx');
        return $subcategory ? $subcategory->count() : 0;
    }  
    public static function itemCount($userId)
    {
        $countitem = Product::where('user_id', $userId);
        return $countitem ? $countitem->count() : 0;
    }  
 
   public static function languageCount($userId)
    {
        $countlanguage = Language::where('user_id', $userId);
        return $countlanguage ? $countlanguage->count() : 0;
    } 

  public static function userFeaturesCount($userId)
    {
        $user = User::find($userId);
        $membership = self::currentMembership($user->id);
      
        $staff = User::where('admin_id',$userId);
        $userFeaturesCount = [];
        $userFeaturesCount['staffs'] = $staff->count();
        $userFeaturesCount['categories'] = Pcategory::where('user_id', $userId)->distinct('indx')->count();
        $userFeaturesCount['subcategories'] = PsubCategory::where('user_id', $userId)->distinct('indx')->count();
        $userFeaturesCount['orders'] = $user->product_orders()->where('membership_id',$membership->id)->count();
        $userFeaturesCount['items'] = $user->order_items->count();
        $userFeaturesCount['products'] = $user->products->count();
        $userFeaturesCount['reservations'] = $user->table_books()->where('membership_id', $membership->id)->count();
        $userFeaturesCount['languages'] = $user->languages->count();

        return $userFeaturesCount;
    }
}
