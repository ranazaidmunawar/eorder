<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UserPermissionHelper;
use App\Jobs\SubscriptionExpiredMail;
use App\Jobs\SubscriptionReminderMail;
use App\Models\BasicExtended;
use App\Models\BasicSetting;
use App\Models\Membership;
use App\Models\PaymentGateway;
use App\Models\User\PaymentGateway as UserPaymentGateway;
use App\Models\User\ProductOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Payment\product\IyzicoController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class CronJobController extends Controller
{
    public function expired()
    {
        try {
            $bs = BasicSetting::first();
            $be = BasicExtended::first();

            Config::set('app.timezone', $bs->timezone);
            $exMembers = Membership::whereDate('expire_date', Carbon::now()->subDays(1))->get();
            foreach ($exMembers as $key => $exMember) {
                if (!empty($exMember->user)) {
                    $user = $exMember->user;
                    $currPackage = UserPermissionHelper::userPackage($user->id);

                    if (is_null($currPackage)) {
                        SubscriptionExpiredMail::dispatch($user, $bs, $be);
                    }
                }
            }


            $rmdMembers = Membership::whereDate('expire_date', Carbon::now()->addDays($be->expiration_reminder))->get();

            foreach ($rmdMembers as $key => $rmdMember) {
                if (!empty($rmdMember->user)) {
                    $user = $rmdMember->user;
                    $nextPackageCount = Membership::query()->where([
                        ['user_id', $user->id],
                        ['start_date', '>', Carbon::now()->toDateString()]
                    ])->where('status', '<>', 2)->count();

                    if ($nextPackageCount == 0) {
                        SubscriptionReminderMail::dispatch($user, $bs, $be, $rmdMember->expire_date);
                    }
                }
            }

            // check iyzico pending payments
            $iyzico_pending_memberships = Membership::where([['status', 0], ['payment_method', 'Iyzico']])->get();
            foreach ($iyzico_pending_memberships as $iyzico_pending_membership) {
                if (!is_null($iyzico_pending_membership->conversation_id)) {
                    $result = $this->IyzicoPaymentStatus('admin', null, $iyzico_pending_membership->conversation_id);
                    if ($result == 'success') {
                        $this->updateIyzicoPendingMemership($iyzico_pending_membership->id, 1);
                    }
                }
            }

            //product_orders pending payments 
            $product_orders = ProductOrder::where([['method', 'iyzico'], ['payment_status', 'Pending']])->get();
            foreach ($product_orders as $product_order) {
                if (!is_null($product_order->conversation_id)) {
                    $result = $this->IyzicoPaymentStatus('user', $product_order->user_id, $product_order->conversation_id);
                    if ($result == 'success') {
                        $data = new IyzicoController();
                        $order = $product_order;
                        $user = User::where('id', $product_order->user_id)->first();
                        $email = $user->email;
                        Session::put('user', $user);
                        $data->completed($order, $email, $user);
                    }
                }
            }

            Artisan::call("queue:work --stop-when-empty");
        } catch (\Exception $th) {
        }
    }

    ##################################################################
    //Get iyzico payment status from iyzico server
    ##################################################################
    private function IyzicoPaymentStatus($type, $user_id, $conversation_id)
    {
        if ($type == 'admin') {
            $paymentMethod = PaymentGateway::where('keyword', 'iyzico')->first();
            $paydata = $paymentMethod->convertAutoData();
        } else {
            $paymentMethod = UserPaymentGateway::where([['user_id', $user_id], ['keyword', 'iyzico']])->first();
            $paydata = json_decode($paymentMethod->information, true);
        }

        $options = new \Iyzipay\Options();
        $options->setApiKey($paydata['api_key']);
        $options->setSecretKey($paydata['secret_key']);
        if ($paydata['sandbox_status'] == 1) {
            $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        } else {
            $options->setBaseUrl("https://api.iyzipay.com"); // production mode
        }

        $request = new \Iyzipay\Request\ReportingPaymentDetailRequest();
        $request->setPaymentConversationId($conversation_id);

        $paymentResponse = \Iyzipay\Model\ReportingPaymentDetail::create($request, $options);
        $result = (array) $paymentResponse;

        foreach ($result as $key => $data) {
            $data = json_decode($data, true);
            if ($data['status'] == 'success' && !empty($data['payments'])) {
                if (is_array($data['payments'])) {
                    if ($data['payments'][0]['paymentStatus'] == 1) {
                        return 'success';
                    } else {
                        return 'not found';
                    }
                } else {
                    return 'not found';
                }
            } else {
                return 'not found';
            }
        }
        return 'not found';
    }

    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    ----------- Update pending membership if payment is successfull ---------
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    private function updateIyzicoPendingMemership($id, $status)
    {
        $membership = Membership::where('id', $id)->first();
        if ($membership) {
            $membership->status = $status;
            $membership->save();
        }
        $user = User::where('id', $membership->user_id)->first();
        if ($user) {
            $user->status = 1;
            $user->save();
        }
    }
}
