<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use App\Models\BasicExtended;
use App\Models\User\Subscriber;
use App\Models\User\BasicSetting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $term = $request->term;
        $data['subscs'] = Subscriber::where('user_id', $userId)
            ->when($term, function ($query, $term) {
                return $query->where('email', 'LIKE', '%' . $term . '%');
            })->orderBy('id', 'DESC')->paginate(10);
        return view('user.subscribers.index', $data);
    }

    public function store(Request $request, $domain)
    {
        $user = getUser();
        $request->validate([
            'email' => ['required',
                function ($attribute, $value, $fail) use ($user) {
                    $subscriber = Subscriber::where([
                        ['email', $value],
                        ['user_id', $user->id]
                    ])->get();
                    if ($subscriber->count() > 0) {
                        Session::flash('error', 'This email is already subscribed');
                        $fail(':attribute already subscribed for this user');
                    }
                },
            ],
        ]);
        $request['user_id'] = $user->id;
        Subscriber::create($request->all());
        return Response::json([
            'success' => 'You have successfully subscribed to our newsletter.'
        ]);
    }

    public function mailSubscriber()
    {
        return view('user.subscribers.mail');
    }

    public function subsSendMail(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required'
        ]);

        $sub = $request->subject;
        $msg = $request->message;
        $user = getRootUser();
        $userId =$user->id;
        $subscs = Subscriber::query()
            ->where('user_id', $userId)
            ->get();
        if($subscs->count() == 0){
            return back()->with('warning', 'Subscriber not Found');
        }    
        $info = BasicSetting::query()
            ->where('user_id', $userId)
            ->select('email', 'from_name')
            ->first();
        $email = $info->email ?? $user->email;
        $name = $info->from_name ?? $user->username;

        $be = BasicExtended::query()->first();
       

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


        if ($be->is_smtp == 1) {
            try {
                //Server settings
                Mail::send([], [], function (Message $message) use ($be, $msg, $sub, $subscs) {
                    $fromMail = $be->from_mail;
                    $fromName = $be->from_name;

                    // Add BCC recipients
                    foreach ($subscs as $recipient) {

                        $message->subject($sub);
                        $message->from($fromMail, $fromName);
                        $message->html($msg, 'text/html');
                        $message->bcc($recipient->email);
                    }
                });
            } catch (\Exception $e) {

            }
        } else {
            try {
                //Recipients
                Mail::send([], [], function (Message $message) use ($be, $msg, $sub, $subscs) {
                    $fromMail = $be->from_mail;
                    $fromName = $be->from_name;

                    // Add BCC recipients
                    foreach ($subscs as $recipient) {

                        $message->subject($sub);
                        $message->from($fromMail, $fromName);
                        $message->html($msg, 'text/html');
                        $message->bcc($recipient->email);
                    }
                });
            } catch (Exception $e) {

            }
        }

        Session::flash('success', 'Mail sent successfully!');
        return back();
    }


    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        Subscriber::query()
            ->where('user_id',$userId)
            ->findOrFail($request->subscriber_id)
            ->delete();
        Session::flash('success', 'Subscriber deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $userId = getRootUser()->id;
        $ids = $request->ids;
        foreach ($ids as $id) {
            Subscriber::query()
                ->where('user_id',$userId)
                ->findOrFail($id)
                ->delete();
        }
        Session::flash('success', 'Subscribers deleted successfully!');
        return "success";
    }
}
