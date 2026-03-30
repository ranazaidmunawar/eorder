<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Illuminate\Contracts\View\View;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class MailTemplateController extends Controller
{
    public function mailTemplates(): View
    {
        $templates = EmailTemplate::all();

        return view('admin.basic.email.mail_templates', compact('templates'));
    }

    public function editMailTemplate($id): View
    {
        $templateInfo = EmailTemplate::findOrFail($id);

        return view('admin.basic.email.edit_mail_template', compact('templateInfo'));
    }

    public function updateMailTemplate(Request $request, $id): RedirectResponse
    {
        $rules = [
            'email_subject' => 'required',
            'email_body' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        EmailTemplate::findOrFail($id)->update($request->except('email_type', 'email_body') + [
                'email_body' => Purifier::clean($request->email_body, 'youtube')
            ]);

        $request->session()->flash('success', 'Mail template updated successfully!');

        return redirect()->back();
    }
}
