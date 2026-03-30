<?php

namespace App\Http\Controllers\Client;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Models\User\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;


class OrderController extends Controller
{
    public function __construct(){}

    public function index()
    {
        $user = getUser();
        $orders = ProductOrder::query()
            ->where('customer_id',Auth::guard('client')->user()->id)
            ->where('user_id',$user->id)
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('user-front.client.order',['orders'=>$orders]);
    }

    public function orderDetails($domain,$id)
    {
      
        $user = getUser();
        $data = ProductOrder::query()
            ->where('customer_id',Auth::guard('client')->user()->id)
            ->where('user_id',$user->id)->with('orderItems')
            ->find($id);     
 
        // if the order has no user_id (guest checkout), then no check
        if (!empty($data->customer_id)) {
            if (Auth::guard('client')->check()
            && Auth::guard('client')->user()->id != $data->customer_id)
            {
                return back();
            }
        }


        if (Auth::guard('client')->user()->can('viewFront', $data)) {

            return view('user-front.client.order_details', ['data' => $data]);
        }
 
        return abort(401);
        
        
    }
    public function downloadFile($domain, Request $request){
        $user = getUser();
        $bs = BasicSetting::query()
            ->where('user_id', $user->id)
            ->first();
        try {
            return Uploader::downloadFile(Constant::WEBSITE_PRODUCT_INVOICE, $request->id, $request->id, $bs);
        } catch (FileNotFoundException $e) {
            Session::flash('error', 'Sorry, this file does not exist anymore!');
            return redirect()->back();
        }
    }
}
