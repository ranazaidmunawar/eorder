<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Faq;
use App\Models\User\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang= Language::query()
            ->where([
                ['code', $request->language],
                ['user_id', $userId]
            ])->first();
        
        $data['lang_id'] = Language::query()
            ->where([
                ['code', $request->language],
                ['user_id', $userId]
            ])
            ->first()
            ->id;
          
        $data['faqs'] = Faq::query()->where([
            ['language_id', $data['lang_id']],
            ['user_id', $userId]
        ])
        ->orderBy('id', 'DESC')
        ->get();
        return view('user.faq.index', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'user_language_id.required' => 'The language field is required'
        ];

        $rules = [
            'user_language_id' => 'required',
            'question' => 'required|max:255',
            'answer' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $faq = new Faq;
        $faq->language_id = $request->user_language_id;
        $faq->user_id = $userId;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->serial_number = $request->serial_number;
        $faq->save();

        Session::flash('success', 'Faq added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'question' => 'required|max:255',
            'answer' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $faq = Faq::query()->findOrFail($request->faq_id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->serial_number = $request->serial_number;
        $faq->save();

        Session::flash('success', 'Faq updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $faq = Faq::query()
            ->where('user_id', $userId)
            ->findOrFail($request->faq_id);
        $faq->delete();
        Session::flash('success', 'Faq deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        $userId = getRootUser()->id;
        foreach ($ids as $id) {
            $faq = Faq::query()
                ->where('user_id', $userId)
                ->findOrFail($id);
            $faq->delete();
        }
        Session::flash('success', 'FAQs deleted successfully!');
        return "success";
    }
}
