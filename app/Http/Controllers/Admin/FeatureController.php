<?php

namespace App\Http\Controllers\Admin;

use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Feature;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FeatureController extends Controller
{
    protected string $path;

    public function __construct()
    {
        $this->path  = 'assets/front/img/features';
    }

    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['features'] = Feature::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();
        $data['lang_id'] = $lang_id;
        return view('admin.home.feature.index', $data);
    }

    public function edit($id)
    {
        $data['feature'] = Feature::query()->findOrFail($id);
        return view('admin.home.feature.edit', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'title' => 'required|max:50',
            'text' => 'required|max:255',
            'serial_number' => 'required|integer',
            'image' => ['required',new ImageMimeTypeRule()],
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        if ($request->hasFile('image')) {
            $image = upload_picture($this->path,$request->file('image'));
        }else{
            $image = null;
        }
        $feature = new Feature;
        $feature->image = $image;
        $feature->language_id = $request->language_id;
        $feature->title = $request->title;
        $feature->text = $request->text;
        $feature->serial_number = $request->serial_number;
        $feature->save();

        Session::flash('success', 'Feature added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'text' => 'required|max:255',
            'serial_number' => 'required|integer',
            'image' => new ImageMimeTypeRule(),
        ]);
        $feature = Feature::findOrFail($request->feature_id);

        if ($request->hasFile('image')) {
            $main_image = update_picture($this->path,$request->file('image'),$feature->image);
        }

        $feature->title = $request->title;
        $feature->text = $request->text;
        $feature->serial_number = $request->serial_number;
        $feature->image = $request->hasFile('image') ? $main_image : $feature->image;

        $feature->save();

        Session::flash('success', 'Feature updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $feature = Feature::query()->findOrFail($request->feature_id);
        deleteFile($this->path,$feature->image);
        $feature->delete();
        Session::flash('success', 'Feature deleted successfully!');
        return back();
    }
}
