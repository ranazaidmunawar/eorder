<?php

namespace App\Http\Controllers;

use App\Models\PaymentInvoice;
use Basel\MyFatoorah\MyFatoorah;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Payment\MyFatoorahController as MembershipMyFatoorahController;

use App\Http\Controllers\Payment\product\MyFatoorahController as ProductMyFatoorahController;

class MyFatoorahController extends Controller
{
    public function callback(Request $request)
    {
        $type = Session::get('myfatoorah_payment_type');
        if ($type == 'buy_plan') {
            $data = new MembershipMyFatoorahController();
            $data = $data->successPayment($request);
            Session::forget('myfatoorah_payment_type');
            if ($data['status'] == 'success') {
                return redirect()->route('success.page');
            } else {
                $cancel_url = route('membership.cancel');
                return redirect($cancel_url);
            }
        } elseif ($type == 'product') {
            try {
                $data = new ProductMyFatoorahController();
                $result = $data->notify($request);
                Session::forget('myfatoorah_payment_type');
                Session::forget('user');
                Session::forget('get_param');
                Session::forget('cancel_url');
                return redirect($result);
            } catch (\Exception $th) {
                Session::forget('myfatoorah_payment_type');
                Session::forget('user');
                Session::forget('get_param');
                Session::forget('cancel_url');
                return redirect($result);
            }
        }
    }

    public function cancel()
    {
        $type = Session::get('myfatoorah_payment_type');
        if ($type == 'buy_plan') {
            return redirect()->route('membership.cancel');
        } elseif ($type == 'product') {
            $cancel_url = Session::get('cancel_url');
            return redirect($cancel_url);
        }
    }
}
