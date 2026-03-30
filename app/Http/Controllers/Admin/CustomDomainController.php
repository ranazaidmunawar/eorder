<?php

namespace App\Http\Controllers\Admin;

use App\Models\BasicSetting;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use App\Models\BasicExtended;
use App\Http\Helpers\MegaMailer;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\User\UserCustomDomain;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomDomainController extends Controller
{
    public function texts() {
        $data['abe'] = BasicExtended::select('domain_request_success_message', 'cname_record_section_title', 'cname_record_section_text')->first();
        return view('admin.domains.custom-texts', $data);
    }

    public function updateTexts(Request $request) {
        $rules = [
            'success_message' => 'required|max:255',
            'cname_record_section_title' => 'required|max:255',
            'cname_record_section_text' => 'required'
        ];
        $request->validate($rules);

        $be = BasicExtended::first();
        $be->domain_request_success_message = clean($request->success_message);
        $be->cname_record_section_title = $request->cname_record_section_title;
        $be->cname_record_section_text = Purifier::clean($request->cname_record_section_text);
        $be->save();

        $request->session()->flash('success', 'Request Texts updated successfully');
        return back();
    }

    public function index(Request $request) {
        $rcDomains = UserCustomDomain::orderBy('id', 'DESC')
            ->when($request->domain, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('current_domain', 'LIKE', '%' . $request->domain . '%')
                        ->orWhere('requested_domain', 'LIKE', '%' . $request->domain . '%');
                });
            })
            ->when($request->username, function ($query) use ($request) {
                return $query->whereHas('user', function($query) use ($request) {
                    $query->where('username',$request->username);
                });
            });
        if (empty($request->type)) {
            $rcDomains = $rcDomains->paginate(10);
        } elseif ($request->type == 'pending') {
            $rcDomains = $rcDomains->where('status', 0)->paginate(10);
        } elseif ($request->type == 'connected') {
            $rcDomains = $rcDomains->where('status', 1)->paginate(10);
        } elseif ($request->type == 'rejected') {
            $rcDomains = $rcDomains->where('status', 2)->paginate(10);
        } else {
           
            return view('errors.404');
        }
      
        $data['rcDomains'] = $rcDomains;
        return view('admin.domains.custom', $data);
    }

    public function status(Request $request) {
        $rcDomain = UserCustomDomain::findOrFail($request->domain_id);
        $rcDomain->status = $request->status;
        $rcDomain->save();

        // if the requested domain is connected
        if ($request->status == 1) {
            if (!empty($rcDomain->user)) {
                $user = $rcDomain->user;

                $bs = BasicSetting::first();
                $mailer = new MegaMailer();
                $data = [
                    'toMail' => $user->email,
                    'toName' => $user->fname,
                    'username' => $user->username,
                    'requested_domain' => $rcDomain->requested_domain,
                    'previous_domain' => !empty($rcDomain->current_domain) ? $rcDomain->current_domain : 'Not Available',
                    'website_title' => $bs->website_title,
                    'templateType' => 'custom_domain_connected',
                    'type' => 'customDomainConnected'
                ];
                $mailer->mailFromAdmin($data);
            }
        } elseif ($request->status == 2) {
            if (!empty($rcDomain->user)) {
                $user = $rcDomain->user;
                $currDomCount = $user->custom_domains()->where('status', 1)->count();
                if ($currDomCount > 0) {
                    $currDom = $user->custom_domains()->where('status', 1)->orderBy('id', 'DESC')->first()->requested_domain;
                }

                $bs = BasicSetting::first();
                $mailer = new MegaMailer();
                $data = [
                    'toMail' => $user->email,
                    'toName' => $user->fname,
                    'username' => $user->username,
                    'requested_domain' => $rcDomain->requested_domain,
                    'current_domain' => !empty($currDom) ? $currDom : 'Not Available',
                    'website_title' => $bs->website_title,
                    'templateType' => 'custom_domain_rejected',
                    'type' => 'customDomainRejected'
                ];
                $mailer->mailFromAdmin($data);
            }
        }

        $request->session()->flash('success', 'Status updated successfully');
        return back();
    }


    public function mail(Request $request)
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

                //Recipients
                Mail::send([], [], function (Message $message) use ($msg, $sub, $from, $to) {
                    $fromMail = $from;
                    $message->to($to)
                        ->subject($sub)
                        ->from($fromMail)
                        ->html($msg, 'text/html');
                });
            } catch (\Exception $e) {
                dd($e);
            }
        } else {
            try {
                Mail::send([], [], function (Message $message) use ($msg, $sub, $from, $to) {
                    $fromMail = $from;
                    $message->to($to)
                        ->subject($sub)
                        ->from($fromMail)
                        ->html($msg, 'text/html');
                });
            } catch (\Exception $e) {
                dd($e);
            }
        }

        Session::flash('success', 'Mail sent successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        UserCustomDomain::findOrFail($request->domain_id)->delete();
        $request->session()->flash('success', 'Custom domain deleted successfully!');
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            UserCustomDomain::findOrFail($id)->delete();
        }
        $request->session()->flash('success', 'Custom domains deleted successfully!');
        return "success";
    }
}
