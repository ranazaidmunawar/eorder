<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User\MailTemplate;
use App\Models\User\BasicExtended;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
   

    public function mailToAdmin() {
        $data['abe'] = BasicExtended::first();
        return view('user.basic.email.mail_to_admin', $data);
    }

    public function updateMailToAdmin(Request $request) {
        $messages = [
            'to_mail.required' => 'Mail Address is required.'
        ];

        $request->validate([
            'to_mail' => 'required',
        ], $messages);

        $bes = BasicExtended::all();
        foreach ($bes as $key => $be) {
            $be->to_mail = $request->to_mail;
            $be->save();
        }

        Session::flash('success', 'Mail address updated successfully!');
        return back();
    }

    public function templates() {
        $userId = getRootUser()->id;
        $data['templates'] = MailTemplate::query()
            ->where('user_id',$userId)
            ->orderBy('id', 'DESC')
            ->get();
        return view('user.basic.email.templates.index', $data);
    }

    public function editTemplate($id) {
        $userId = getRootUser()->id;
        $data['template'] = MailTemplate::query()
            ->where('user_id',$userId)
            ->find($id);
        $this->authorize('view',$data['template']);
        
        return view('user.basic.email.templates.edit', $data);
    }

    public function templateUpdate(Request $request, $id) {

      
        $rules = [
            'mail_subject' => 'required',
            'mail_body' => 'required',
            'mail_type'=> 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        
        $userId = getRootUser()->id;
        $template = MailTemplate::query()
            ->where('user_id',$userId)
            ->find($id);
        $template->mail_subject = $request->mail_subject;
        $template->mail_body = $request->mail_body;
        $template->save();
        Session::flash('success', 'Email Template updated successfully!');
        return "success";
    }
}
