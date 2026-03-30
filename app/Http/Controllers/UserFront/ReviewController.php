<?php

namespace App\Http\Controllers\UserFront;

use App\Http\Controllers\Controller;
use App\Models\User\Product;
use App\Models\User\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Traits\UserCurrentLanguageTrait;

class ReviewController extends Controller
{
    use UserCurrentLanguageTrait;
    public function __construct()
    {
        $this->middleware('setlang');
    }

    public function reviewSubmit(Request $request)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);

        $keywords = json_decode($currentLang->keywords, true);
        if ($request->review) {
            if (ProductReview::query()
                ->where('customer_id', Auth::guard('client')->user()->id)
                ->where('product_id', $request->product_id)
                ->where('user_id', $user->id)
                ->exists()) {
                $exists = ProductReview::query()
                    ->where('customer_id', Auth::guard('client')->user()->id)
                    ->where('product_id', $request->product_id)
                    ->where('user_id', $user->id)
                    ->first();
                if ($request->review) {
                    $exists->update([
                        'review' => $request->review,
                    ]);
                    $avgreview = ProductReview::query()
                        ->where('product_id', $request->product_id)
                        ->where('user_id', $user->id)
                        ->avg('review');
                    Product::query()
                        ->where('user_id', $user->id)
                        ->find($request->product_id)
                        ->update([
                        'rating' => $avgreview
                    ]);
                }
                if ($request->comment) {
                    $exists->update([
                        'comment' => $request->comment,
                    ]);
                }
                Session::flash('success', $keywords['Review update successfully'] ?? 'Review update successfully');
                return back();
            } else {
                $input = $request->all();
                $input['user_id'] = $user->id;
                $input['customer_id'] = Auth::guard('client')->user()->id;
                $data = new ProductReview;
                $data->create($input);
                $avgreview = ProductReview::query()
                    ->where('product_id', $request->product_id)
                    ->where('user_id', $user->id)
                    ->avg('review');
                Product::query()
                    ->where('user_id', $user->id)
                    ->find($request->product_id)
                    ->update([
                    'rating' => $avgreview
                ]);
                Session::flash('success', $keywords['Review submit successfully'] ?? 'Review submit successfully');
                return back();
            }
        } else {
            Session::flash('error', $keywords['Review submit not successful'] ?? 'Review submit not successful');
            return back();
        }
    }

    public function authcheck()
    {
        if (!Auth::user()) {
            Session::put('link', url()->current());
            return redirect(route('user.login'));
        }
    }
}
