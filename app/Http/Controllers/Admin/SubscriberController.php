<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscriber;
use App\Models\BasicSetting;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use App\Models\BasicExtended;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class SubscriberController extends Controller
{
    public function index(Request $request): View
    {
      $term = $request->term;
      $data['subscs'] = Subscriber::when($term, function ($query, $term) {
                            return $query->where('email', 'LIKE', '%' . $term . '%');
                        })->orderBy('id', 'DESC')->paginate(10);
      return view('admin.subscribers.index', $data);
    }

    public function mailSubscriber(): View
    {
      return view('admin.subscribers.mail');
    }

    public function subSendMail(Request $request): RedirectResponse
    {
      $request->validate([
        'subject' => 'required',
        'message' => 'required'
      ]);

      $sub = $request->subject;
      $msg = $request->message;

      $subscs = Subscriber::all();
      $settings = BasicSetting::first();
      $from = $settings->contact_mail;

      if($subscs->count() == 0){
        return back()->with('warning', 'Subscriber Not Found');
      }
       
      $be = BasicExtended::first();

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
                dd($e);
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
            } catch (\Exception $e) {
                dd($e);
            }
        }


      Session::flash('success', 'Mail sent successfully!');
      return back();
    }


    public function delete(Request $request)
    {

        $subscriber = Subscriber::findOrFail($request->subscriber_id);
        $subscriber->delete();

        Session::flash('success', 'Subscriber deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $subscriber = Subscriber::findOrFail($id);
            $subscriber->delete();
        }

        Session::flash('success', 'Subscribers deleted successfully!');
        return "success";
    }
}
