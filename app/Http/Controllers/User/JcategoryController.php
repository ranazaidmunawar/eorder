<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Jcategory;
use App\Models\User\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class JcategoryController extends Controller
{
    public function index(Request $request) {
        $userId = getRootUser()->id;
        $lang = Language::query()->where([
            ['code', $request->language],
            ['user_id', $userId]
        ])->first();
        $this->authorize('view',$lang);
        $data['jcategorys'] = Jcategory::query()
            ->where([
                ['language_id', $lang->id],
                ['user_id', $userId]
            ])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('user.job.jcategory.index', $data);
    }

    public function edit($id) {
        $userId = getRootUser()->id;
        $data['jcategory'] = Jcategory::query()
            ->where('user_id', $userId)
            ->findOrFail($id);
        return view('user.job.jcategory.edit', $data);
    }

    public function store(Request $request) {
        $messages = [
            'user_language_id.required' => 'The language field is required',
        ];

        $rules = [
            'user_language_id' => 'required',
            'name' => 'required|max:255',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $jcategory = new Jcategory;
        $jcategory->language_id = $request->user_language_id;
        $jcategory->user_id = $userId;
        $jcategory->name = $request->name;
        $jcategory->status = $request->status;
        $jcategory->serial_number = $request->serial_number;
        $jcategory->save();

        Session::flash('success', 'Category added successfully!');
        return "success";
    }

    public function update(Request $request) {
        $rules = [
            'name' => 'required|max:255',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $jcategory = Jcategory::query()
            ->where('user_id', $userId)
            ->findOrFail($request->jcategory_id);
        $jcategory->name = $request->name;
        $jcategory->status = $request->status;
        $jcategory->serial_number = $request->serial_number;
        $jcategory->save();

        Session::flash('success', 'Category updated successfully!');
        return "success";
    }

    public function delete(Request $request) {
        $userId = getRootUser()->id;
        $jcategory = Jcategory::query()
            ->where('user_id', $userId)
            ->findOrFail($request->jcategory_id);
        if ($jcategory->jobs()->count() > 0) {
            Session::flash('warning', 'First, delete all the jobs under this category!');
            return back();
        }
        $jcategory->delete();

        Session::flash('success', 'Category deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        $userId = getRootUser()->id;
        foreach ($ids as $id) {
            $jcategory = Jcategory::query()
                ->where('user_id', $userId)
                ->findOrFail($id);
            if ($jcategory->jobs()->count() > 0) {
                Session::flash('warning', 'First, delete all the jobs under the selected categories!');
                return "success";
            }
        }
        Session::flash('success', 'Job categories deleted successfully!');
        return "success";
    }
}
