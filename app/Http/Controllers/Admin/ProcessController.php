<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProcessController extends Controller
{
    protected string $path ;

    public function __construct()
    {
        $this->path = 'assets/front/img/process';
    }

    public function index(Request $request)
    {
        $lang = Language::query()
            ->where('code', $request->language)
            ->first();
        $lang_id = $lang->id;
        $data['processes'] = Process::query()
            ->where('language_id', $lang_id)
            ->orderBy('id', 'DESC')
            ->get();
        $data['lang_id'] = $lang_id;
        return view('admin.home.process.index', $data);
    }

    public function edit($id)
    {
        $data['process'] = Process::query()->findOrFail($id);
        return view('admin.home.process.edit', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'icon' => 'required',
            'title' => 'required|max:100',
            'text' => 'required|max:255',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $process = new Process;
        $process->icon = $request->icon;
        $process->language_id = $request->language_id;
        $process->title = $request->title;
        $process->text = $request->text;
        $process->serial_number = $request->serial_number;
        $process->save();

        Session::flash('success', 'Process added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'title' => 'required|max:100',
            'text' => 'required|max:255',
            'icon' => 'required',
            'serial_number' => 'required|integer',
        ];
        $request->validate($rules);
        $process = Process::query()->findOrFail($request->process_id);
        $process->title = $request->title;
        $process->icon = $request->icon;
        $process->text = $request->text;
        $process->serial_number = $request->serial_number;
        $process->save();

        Session::flash('success', 'Process updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        Process::query()->findOrFail($request->process_id)->delete();
        Session::flash('success', 'Process deleted successfully!');
        return back();
    }

    public function removeImage(Request $request) {
        $type = $request->type;
        $featId = $request->process_id;
        $process = Process::query()->findOrFail($featId);
        if ($type == "process") {
            deleteFile($this->path,$process->image);
            $process->image = NULL;
            $process->save();
        }
        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }
}
