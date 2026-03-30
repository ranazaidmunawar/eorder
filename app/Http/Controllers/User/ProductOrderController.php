<?php

namespace App\Http\Controllers\User;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Constants\Constant;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use App\Http\Helpers\Uploader;
use App\Models\User\OrderTime;
use App\Models\User\TimeFrame;
use App\Models\User\BasicExtra;
use App\Http\Helpers\MegaMailer;
use App\Models\User\BasicSetting;
use App\Models\User\ProductOrder;
use App\Models\User\BasicExtended;
use App\Models\User\ServingMethod;
use App\Models\User\OfflineGateway;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\UserPermissionHelper;
use App\Notifications\WAStatusNotification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductOrderController extends Controller
{
   
    public function index(Request $request)
    {
        $userId = getRootUser()->id;

       
        $packagePermissions = UserPermissionHelper::packagePermission($userId);
        $packagePermissions = json_decode($packagePermissions, true);
        $search = $request->search;
        if(!empty($packagePermissions) && in_array('Online Order', $packagePermissions)){
            $type = $request->orders_from;
        }else{

          $type='pos';
        }
        
        $servingMethod = $request->serving_method;
        $orderStatus = $request->order_status;
        $paymentStatus = $request->payment_status;
        $completed = $request->completed;
        $orderDate = $request->order_date;
        $deliveryDate = $request->delivery_date;

        if (!empty($packagePermissions) && in_array('Live Orders', $packagePermissions)) {
            $data['live_order'] = true;
        } else {
            $data['live_order'] = false;
        }

        $data['orders'] = ProductOrder::query()
        ->where('user_id', $userId)
        ->when($search, function ($query, $search) {
            return $query->where('order_number', 'LIKE', '%' . $search . '%');
        })->when($type, function ($query, $type) {
            return $query->where('type', $type);
        })->when($servingMethod, function ($query, $servingMethod) {
            return $query->where('serving_method', $servingMethod);
        })->when($orderStatus, function ($query, $orderStatus) {
            return $query->where('order_status', $orderStatus);
        })->when($paymentStatus, function ($query, $paymentStatus) {
            return $query->where('payment_status', $paymentStatus);
        })->when($completed, function ($query, $completed) {
            return $query->where('completed', $completed);
        })->when($orderDate, function ($query, $orderDate) {
            return $query->whereDate('created_at', Carbon::parse($orderDate));
        })->when($deliveryDate, function ($query, $deliveryDate) {
            return $query->where('delivery_date', $deliveryDate);
        })
        ->orderBy('id', 'DESC')
        ->paginate(10);
     
        return view('user.product.order.index', $data);
    }

    public function settings() {
        $userId = getRootUser()->id;
        $data['abex'] = BasicExtra::query()
            ->where('user_id', $userId)
            ->first();
        return view('user.product.order.settings', $data);
    }

    public function resetToken(Request $request) {
        $userId = getRootUser()->id;
        $bss = BasicSetting::query()
            ->where('user_id', $userId)
            ->get();
        foreach ($bss as $bs) {
            $bs->token_no_start = $request->token_no;
            $bs->token_no = $request->token_no - 1;
            $bs->save();
        }
        Session::flash('success', 'Token no reset successfully');
        return back();
    }

    public function updateSettings(Request $request) {
      
        $userId = getRootUser()->id;
        $bss = BasicSetting::query()
            ->where('user_id', $userId)
            ->get();
        if($request->has('postal_code')){

            foreach ($bss as $bs) {
                $bs->postal_code = $request->postal_code ?? 0;
                $bs->save();
            }
        }

        $bes = BasicExtended::query()
            ->where('user_id', $userId)
            ->get();
        foreach ($bes as $be) {
            $be->delivery_date_time_status = $request->delivery_date_time_status ?? 0;
            $be->delivery_date_time_required = $request->delivery_date_time_required ?? 0;
            $be->save();
        }

        $bex = BasicExtra::query()
            ->where('user_id', $userId)
            ->first();
        $bex->whatsapp_home_delivery = $request->whatsapp_home_delivery ?? 0;
        $bex->whatsapp_pickup = $request->whatsapp_pickup ?? 0;
        $bex->whatsapp_on_table = $request->whatsapp_on_table ?? 0;
        $bex->whatsapp_order_status_notification = $request->whatsapp_order_status_notification ?? 0;
        $bex->save();

        Session::flash('success', 'Settings updated successfully');
        return back();
    }

    public function status(Request $request)
    {
        $userId = getRootUser()->id;
        $packagePermissions = UserPermissionHelper::packagePermission($userId);
        $packagePermissions = json_decode($packagePermissions, true);

        $user = User::where('id', getRootUser()->id)->first();
        $po = ProductOrder::query()
            ->where('user_id', $user->id)
            ->find($request->order_id);
        $po->order_status = $request->order_status;
        $po->save();

        $bs = BasicSetting::query()->where('user_id', $user->id)->first();

        $status = $request->order_status;
        $servingMethod = $po->serving_method;
        if ($status == 'received') {
            $templateType = 'order_received';
        } elseif ($status == 'preparing') {
            $templateType = 'order_preparing';
        } elseif ($status == 'ready_to_pick_up' && $servingMethod == 'home_delivery') {
            $templateType = 'order_ready_to_pickup';
        } elseif ($status == 'ready_to_pick_up' && $servingMethod == 'pick_up') {
            $templateType = 'order_ready_to_pickup_pick_up';
        } elseif ($status == 'picked_up' && $servingMethod == 'home_delivery') {
            $templateType = 'order_pickedup';
        } elseif ($status == 'picked_up' && $servingMethod == 'pick_up') {
            $templateType = 'order_pickedup_pick_up';
        } elseif ($status == 'delivered') {
            $templateType = 'order_delivered';
        } elseif ($status == 'cancelled') {
            $templateType = 'order_cancelled';
        } elseif ($status == 'served') {
            $templateType = 'order_served';
        } elseif ($status == 'ready_to_serve') {
            $templateType = 'order_ready_to_serve';
        } else {
            Session::flash('success', 'Order status changed successfully!');
            return back();
        }

        $bex = BasicExtra::query()
            ->where('user_id', $user->id)
            ->first();
      
        if(!empty($packagePermissions) && in_array('Whatsapp Order & Notification', $packagePermissions)){
            if ($bex->twilio_sid && $bex->twilio_token && $bex->twilio_phone_number) {

                if ($bex->whatsapp_order_status_notification == 1 ) {
                    try {
                        Config::set('services.twilio.sid', $bex->twilio_sid);
                        Config::set('services.twilio.token', $bex->twilio_token);
                        Config::set('services.twilio.whatsapp_from', $bex->twilio_phone_number);
                        // whatsapp notification
                        $po->notify(new WAStatusNotification($po));
                    } catch (Exception $e) {}
                }
            }
        }    

        if (!is_null($po->customer_id)) {
            $mailer = new MegaMailer();
            $data = [
                'toMail' => $po->billing_email,
                'toName' => $po->billing_fname ?? '',
                'customer_name' => $po->billing_fname ?? '',
                'order_number' => $po->order_number,
                'order_link' => "<a href='" . route('user.client.orders.details', [$user->username, $po->id]) . "'>" . route('user.client.orders.details', [$user->username, $po->id]) . "</a>",
                'website_title' => $bs->website_title ?? '',
                'templateType' => $templateType,
                'type' => 'foodOrderStatus'
            ];
        }else{
            $mailer = new MegaMailer();
            $data = [
                'toMail' => $po->billing_email,
                'toName' => $po->billing_fname ?? '',
                'customer_name' => $po->billing_fname ?? '',
                'order_number' => $po->order_number,
                'website_title' => $bs->website_title ?? '',
                'templateType' => $templateType,
                'type' => 'foodOrderStatus'
            ];
        }
        $order = $po;
        $mailer->mailFromUser($data, $order, $user);
        Session::flash('success', 'Order status changed!');
        return back();
    }

    public function completed(Request $request) {
        $userId = getRootUser()->id;
        $po = ProductOrder::query()
            ->where('user_id', $userId)
            ->find($request->order_id);
        $po->completed = $request->completed;
        $po->save();
        Session::flash('success', 'Complete status changed!');
        return back();
    }

    public function payment(Request $request) {
        $userId = getRootUser()->id;
        $po = ProductOrder::query()
            ->where('user_id', $userId)
            ->find($request->order_id);
        $po->payment_status = $request->payment_status;
        $po->save();
        Session::flash('success', 'Payment status changed!');
        return back();
    }

    public function details($id)
    {

        $userId = getRootUser()->id;
        $order = ProductOrder::query()
            ->with('orderItems')
            ->where('user_id', $userId)
            ->find($id);
           
        $this->authorize('view',$order);
        return view('user.product.order.details', compact('order'));
    }

    public function bulkOrderDelete(Request $request)
    {
        $ids = $request->ids;
        $userId = getRootUser()->id;
        foreach ($ids as $id) {
            $order = ProductOrder::query()
                ->where('user_id', $userId)
                ->findOrFail($id);
            Uploader::remove(Constant::WEBSITE_PRODUCT_INVOICE,$order->invoice_number);
            Uploader::remove(Constant::WEBSITE_PRODUCT_RECEIPT,$order->receipt);
            foreach ($order->orderitems as $item) {
                $item->delete();
            }
            $order->delete();
        }

        Session::flash('success', 'Orders deleted successfully!');
        return "success";
    }

    public function orderDelete(Request $request)
    {
        $userId = getRootUser()->id;
        $order = ProductOrder::query()
            ->where('user_id', $userId)
            ->findOrFail($request->order_id);
        Uploader::remove(Constant::WEBSITE_PRODUCT_INVOICE,$order->invoice_number);
        foreach ($order->orderitems as $item) {
            $item->delete();
        }
        $order->delete();

        Session::flash('success', 'product order deleted successfully!');
        return back();
    }

    public function qrPrint(Request $request) {
        $userId = getRootUser()->id;
        $bs = BasicSetting::query()->where('user_id', $userId)->first();
        $data = UserPermissionHelper::currentPackageFeatures($userId);
        $order = ProductOrder::find($request->order_id);
        if ($order->method == 'paypal') {
            $url = route('product.paypal.apiRequest', $request->order_id);
        } elseif ($order->method == 'mollie') {
            $url = route('product.mollie.apiRequest', $request->order_id);
        }
        $directory = Constant::WEBSITE_TENANT_PRODUCT_ORDER_QR_IMAGE.'/';
        $qrImage = uniqid() . '.svg';
        if(in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)){
            $qrcode = QrCode::size(150)
                ->color(0,0,0)
                ->format('svg')
                ->generate($url);
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            Storage::disk('s3')->put($directory.$qrImage, $qrcode);
        }else{
            $qrcode = QrCode::size(150)
                ->color(0,0,0)
                ->format('svg');
            $qrcode->generate($url, $directory . $qrImage);
        }
        return !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($directory . $qrImage) ? Storage::disk('s3')->url($directory . $qrImage) : url($directory . $qrImage);
    }

    public function servingMethods() {
        $userId = getRootUser()->id;
        $data['servingMethods'] = ServingMethod::query()
            ->where('user_id', $userId)
            ->get();

        $data['ogateways'] = OfflineGateway::query()
            ->where('user_id', $userId)
            ->where('status', 1)
            ->get();

        return view('user.product.order.serving_methods.index', $data);
    }

    public function servingMethodStatus(Request $request) {
        $userId = getRootUser()->id;
        $website = ServingMethod::query()->where([
            ['website_menu', 1],
            ['user_id', $userId]
        ])->count();
        $qr = ServingMethod::query()->where([
            ['qr_menu', 1],
            ['user_id', $userId]
        ])->count();

        if ($website == 1 && $request->website_menu == 0) {
            Session::flash('warning', 'Minimum 1 serving method must be activated for Website Menu.');
            return back();
        }
        if ($qr == 1 && $request->qr_menu == 0) {
            Session::flash('warning', 'Minimum 1 serving method must be activated for QR Menu.');
            return back();
        }

        $sm = ServingMethod::query()
            ->where('user_id', $userId)
            ->find($request->serving_method);
        $sm->website_menu = $request->has('website_menu') ? $request->website_menu : $sm->website_menu;
        $sm->qr_menu = $request->has('qr_menu') ? $request->qr_menu : $sm->qr_menu;
        $sm->pos = $request->has('pos') ? $request->pos : $sm->pos;
        $sm->save();

        Session::flash('success', 'Status updated successfully!');
        return back();
    }

    public function servingMethodGateways(Request $request) {
        $userId = getRootUser()->id;
        $sm = ServingMethod::query()
            ->where('user_id', $userId)
            ->find($request->serving_method);
        $sm->gateways = json_encode($request->gateways);
        $sm->save();

        Session::flash('success', 'Gateways status updated successfully!');
        return back();
    }

    public function qrPayment(Request $request) {
        $userId = getRootUser()->id;
        $sm = ServingMethod::query()
            ->where('user_id', $userId)
            ->find($request->serving_method);
        $sm->qr_payment = $request->qr_payment;
        $sm->save();

        Session::flash('success', 'QR scan payment status updated successfully!');
        return back();
    }

    public function servingMethodUpdate(Request $request) {
        $userId = getRootUser()->id;
        $sm = ServingMethod::query()
            ->where('user_id', $userId)
            ->find($request->serving_method);
        $sm->serial_number = $request->serial_number;
        $sm->note = $request->note;
        $sm->save();

        Session::flash('success', 'Updated successfully!');
        return back();
    }

    public function ordertime() {
        $userId = getRootUser()->id;
        $data['ordertimes'] = OrderTime::query()
            ->where('user_id', $userId)
            ->get();
        return view('user.product.order.order-time', $data);
    }

    public function updateOrdertime(Request $request) {
        $userId = getRootUser()->id;
        $start = $request->start_time;
        $end = $request->end_time;
        $ots = OrderTime::query()
            ->where('user_id', $userId)
            ->get();

        for ($i=0; $i < count($ots); $i++) {
            $ots[$i]->start_time = $start[$i];
            $ots[$i]->end_time = $end[$i];
            $ots[$i]->save();
        }

        session()->flash('success', 'Order times updated successfully');
        return back();
    }

    public function deliveryTime() {
        return view('user.product.order.delivery_time.index');
    }

    public function timeFrames(Request $request) {
        $userId = getRootUser()->id;

        $data['timeframes'] = TimeFrame::query()
            ->where([
                ['day', $request->day],
                ['user_id', $userId]
            ])
            ->get();

        return view('user.product.order.delivery_time.timeframes', $data);
    }

    public function timeFrameStore(Request $request) 
    {
     
        $rules = [
            'start' => 'required',
            'end' => 'required',
            'max_orders' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $tf = new TimeFrame;
        $tf->day = $request->day;
        $tf->start = $request->start;
        $tf->end = $request->end;
        $tf->max_orders = $request->max_orders;
        $tf->user_id = $userId;
        $tf->save();

        Session::flash('success', 'Time frame added successfully!');
        return "success";
    }

    public function timeFrameUpdate(Request $request) {
        $rules = [
            'start' => 'required',
            'end' => 'required',
            'max_orders' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $tf = TimeFrame::query()
            ->where('user_id', $userId)
            ->find($request->timeframe_id);
        $tf->start = $request->start;
        $tf->end = $request->end;
        $tf->max_orders = $request->max_orders;
        $tf->save();

        Session::flash('success', 'Time frame updated successfully!');
        return "success";
    }

    public function timeFrameDelete(Request $request)
    {
        $userId = getRootUser()->id;
        $tf = TimeFrame::query()
            ->where('user_id', $userId)
            ->findOrFail($request->timeframe_id);
        $tf->delete();

        Session::flash('success', 'Time frame deleted successfully!');
        return back();
    }

    public function deliveryStatus(Request $request) {
        $userId = getRootUser()->id;
        $bes = BasicExtended::query()
            ->where('user_id', $userId)
            ->get();
        foreach ($bes as $be) {
            $be->delivery_date_time_status = $request->delivery_date_time_status;
            $be->delivery_date_time_required = $request->delivery_date_time_required;
            $be->save();
        }

        Session::flash('success', 'Status updated successfully!');
        return back();
    }

    public function orderclose(Request $request) {
        $rules = [
            'order_close' => 'required',
        ];

        $messages = [];

        if ($request->order_close == 1) {
            $rules['order_close_message'] = 'required|max:255';
            $messages['order_close_message.required'] = 'The message field is required';
            $messages['order_close_message.max'] = 'The message field cannot contain more than 255 characters';
        }

        $request->validate($rules, $messages);
        $userId = getRootUser()->id;
        $bes = BasicExtended::query()
            ->where('user_id', $userId)
            ->get();
        foreach ($bes as $be) {
            $be->order_close = $request->order_close;
            if ($request->order_close == 1) {
                $be->order_close_message = $request->order_close_message;
            }
            $be->save();
        }

        Session::flash('success', 'Status updated successfully!');
        return back();
    }


    public function userMail(Request $request)
    {
        $rules = [
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $be = BasicExtended::first();
        $from = $be->from_mail;

        $sub = $request->subject;
        $msg = $request->message;
        $to = $request->email;


        if ($be->is_smtp == 1) {
            try {

                $smtp = [
                    'transport' => 'smtp',
                    'host' => $be->smtp_host,
                    'port' => $be->smtp_port,
                    'encryption' => $be->encryption,
                    'username' => $be->smtp_username,
                    'password' => $be->smtp_password,
                    'timeout' => null,
                    'auth_mode' => null,
                ];
                Config::set('mail.mailers.smtp', $smtp);

                Mail::send([], [], function (Message $message) use ($from, $sub, $to, $msg) {
                    $fromMail = $from;
                    $message->to($to)
                        ->subject($sub)
                        ->from($fromMail)
                        ->html($msg, 'text/html');
                });
                
    
            } catch (\Exception $e) {

            }
        } else {
            try {

                $smtp = [
                    'transport' => 'smtp',
                    'host' => $be->smtp_host,
                    'port' => $be->smtp_port,
                    'encryption' => $be->encryption,
                    'username' => $be->smtp_username,
                    'password' => $be->smtp_password,
                    'timeout' => null,
                    'auth_mode' => null,
                ];
                Config::set('mail.mailers.smtp', $smtp);

                Mail::send([], [], function (Message $message) use ($from, $sub, $to, $msg) {
                    $fromMail = $from;
                    $message->to($to)
                        ->subject($sub)
                        ->from($fromMail)
                        ->html($msg, 'text/html');
                });
            } catch (\Exception $e) {

            }
        }

        Session::flash('success', 'Mail sent successfully!');
        return "success";
    }

}
