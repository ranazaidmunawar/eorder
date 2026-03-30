<?php

namespace App\Http\Controllers\User;

use App\Models\User\Job;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Models\User\Jcategory;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()
            ->where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();
        $this->authorize('view',$lang);
        $data['jobs'] = Job::query()->where([
            ['language_id', $lang->id],
            ['user_id', $userId]
        ])
        ->orderBy('id', 'DESC')
        ->get();

        return view('user.job.job.index', $data);
    }

    public function edit($id)
    {
        $userId = getRootUser()->id;
        $data['job'] = Job::query()
            ->where('user_id', $userId)
            ->find($id);
        $this->authorize('view', $data['job'])  ;  
        $data['jcats'] = Jcategory::query()
            ->where('status', 1)
            ->where('language_id', $data['job']->language_id)
            ->get();
        return view('user.job.job.edit', $data);
    }

    public function create()
    {
        $userId = getRootUser()->id;
        $data['jcats'] = Jcategory::query()
            ->where('user_id', $userId)
            ->get();

        return view('user.job.job.create', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'jcategory_id.required' => 'The category field is required',
            'user_language_id.required' => 'The language field is required'
        ];

        $rules = [
            'user_language_id' => 'required',
            'deadline' => 'required|date',
            'experience' => 'required',
            'jcategory_id' => 'required',
            'title' => 'required|max:255',
            'vacancy' => 'required|integer',
            'employment_status' => 'required|max:255',
            'job_responsibilities' => 'required',
            'educational_requirements' => 'required',
            'experience_requirements' => 'required',
            'additional_requirements' => 'nullable',
            'job_location' => 'required|max:255',
            'salary' => 'required',
            'email' => 'required|email|max:255',
            'benefits' => 'nullable',
            'read_before_apply' => 'nullable',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $in = $request->all();
        $in['language_id'] = $request->user_language_id;
        $in['slug'] = make_slug($request->title);
        $in['user_id'] = $userId;
        $in['job_responsibilities'] = Purifier::clean($request->job_responsibilities,'youtube');
        $in['educational_requirements'] = Purifier::clean($request->educational_requirements,'youtube') ;
        $in['experience_requirements'] = Purifier::clean($request->experience_requirements,'youtube') ;
        $in['additional_requirements'] = Purifier::clean($request->additional_requirements,'youtube');
        $in['salary'] = $request->salary;
        $in['benefits'] = $request->benefits;
        $in['read_before_apply'] = $request->read_before_apply;
        Job::create($in);

        Session::flash('success', 'Job posted successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $messages = [
            'jcategory_id.required' => 'The category field is required'
        ];
        $rules = [
            'deadline' => 'required|date',
            'experience' => 'required',
            'jcategory_id' => 'required',
            'title' => 'required|max:255',
            'vacancy' => 'required|integer',
            'employment_status' => 'required|max:255',
            'job_responsibilities' => 'required',
            'educational_requirements' => 'required',
            'experience_requirements' => 'required',
            'additional_requirements' => 'nullable',
            'job_location' => 'required|max:255',
            'salary' => 'required',
            'email' => 'required|email|max:255',
            'benefits' => 'nullable',
            'read_before_apply' => 'nullable',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $job = Job::query()
            ->where('user_id', $userId)
            ->findOrFail($request->job_id);
        $in = $request->all();
        $in['slug'] = make_slug($request->title);
        $in['job_responsibilities'] = Purifier::clean($request->job_responsibilities,'youtube') ;
        $in['educational_requirements'] = Purifier::clean($request->educational_requirements,'youtube') ;
        $in['experience_requirements'] = Purifier::clean($request->experience_requirements,'youtube') ;
        $in['additional_requirements'] = Purifier::clean($request->additional_requirements,'youtube') ;
        $in['salary'] = $request->salary;
        $in['benefits'] = $request->benefits;
        $in['read_before_apply'] = $request->read_before_apply;
        $job->fill($in)->save();

        Session::flash('success', 'Job details updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $job = Job::query()
            ->where('user_id', $userId)
            ->findOrFail($request->job_id);
        $job->delete();

        Session::flash('success', 'Job deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $userId = getRootUser()->id;
        $ids = $request->ids;
        foreach ($ids as $id) {
            $job = Job::query()
                ->where('user_id', $userId)
                ->findOrFail($id);
            $job->delete();
        }

        Session::flash('success', 'Jobs deleted successfully!');
        return "success";
    }

    public function getcats($langid)
    {
        $userId = getRootUser()->id;
        return Jcategory::query()->where([
            ['language_id', $langid],
            ['user_id', $userId]
        ])->get();
    }
}
