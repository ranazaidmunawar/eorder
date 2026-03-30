<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\User\BasicExtra;
use App\Notifications\PushDemo;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;


class PushController extends Controller
{
    protected string $path ;

    public function __construct()
    {
        $this->path = 'assets/front/img';
    }

    public function settings() {
        $userId = getRootUser()->id;
        $data['bE'] = BasicExtra::query()->where('user_id', $userId)->first();
        return view('user.pushnotification.settings',$data);
    }

    public function updateSettings(Request $request) {
        $userId = getRootUser()->id;
        $rules =[
            'file' => new ImageMimeTypeRule()
        ];
        $request->validate($rules);
        $bE = BasicExtra::query()->where('user_id', $userId)->first();
        if ($request->hasFile('file')) {
            $bE->push_notification_icon = update_picture($this->path,$request->file('file'),$bE->push_notification_icon);
        }
        $bE->VAPID_PUBLIC_KEY = $request->VAPID_PUBLIC_KEY ?? $bE->VAPID_PUBLIC_KEY;
        $bE->VAPID_PRIVATE_KEY = $request->VAPID_PRIVATE_KEY ?? $bE->VAPID_PRIVATE_KEY;
        $bE->save();
        session()->flash('success', 'Push notification data updated!');
        return back();
    }

    public function send() {
        return view('user.pushnotification.send');
    }

    public function push(Request $request){
        $request->validate([
            'title' => 'required',
            'button_url' => 'required',
            'button_text' => 'required'
        ]);

        $title = $request->title;
        $message = $request->message;
        $buttonText = $request->button_text;
        $buttonURL = $request->button_url;
        $userId = getRootUser()->id;
        $bE = BasicExtra::query()->where('user_id', $userId)->first();
        config([
            // in case you would like to overwrite values inside config/webpush.php
            'webpush.vapid.public_key' => $bE->VAPID_PUBLIC_KEY,
            'webpush.vapid.private_key' => $bE->VAPID_PRIVATE_KEY,
        ]);
        Notification::send(Guest::query()->where('user_id', $userId)->get(),new PushDemo($title, $message, $buttonText, $buttonURL,$this->path.'/'.$bE->push_notification_icon));

        $request->session()->flash('success', 'Push notification sent');
        return redirect()->route('user.pushnotification.send');
    }
}
