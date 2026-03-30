<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BasicExtended;
use App\Models\User\UserCustomDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class DomainController extends Controller
{
    public function domains() {
        $userId = getRootUser()->id;
        $rcDomain = UserCustomDomain::query()
            ->where('status', '<>', 2)
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->first();
        $data['rcDomain'] = $rcDomain;
        return view('user.domains', $data);
    }

    public function isValidDomain($domain_name) {
        return (preg_match("/^([a-zd](-*[a-zd])*)(.([a-zd](-*[a-zd])*))*$/i", $domain_name) //valid characters check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^.]{1,63}(.[^.]{1,63})*$/", $domain_name) ); //length of every label
    }


    public function domainRequest(Request $request) {
        $be = BasicExtended::query()->select('domain_request_success_message', 'cname_record_section_title')->first();
        $user = getRootUser();
        $rules = [
            'custom_domain' => [
                'required',
                function ($attribute, $value, $fail) use ($be,$user) {
                    // if user request the current domain
                    if (getCdomain($user) == $value) {
                        $fail('You cannot request your current domain.');
                    }
                }
            ]
        ];

        $request->validate($rules);

        $cdomain = new UserCustomDomain;
        $cdomain->user_id = $user->id;
        $cdomain->requested_domain = $request->custom_domain;
        $cdomain->current_domain = getCdomain($user);
        $cdomain->status = 0;
        $cdomain->save();

        $request->session()->flash('domain-success', $be->domain_request_success_message);
        return back();
    }
}
