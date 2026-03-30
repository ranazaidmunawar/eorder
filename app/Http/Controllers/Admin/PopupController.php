<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Popup;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class PopupController extends Controller
{
    protected string $path;

    public function __construct()
    {
        $this->path  = 'assets/front/img/popups';
    }

    public function index(Request $request)
    {
        $data['langs'] = Language::all();
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['adminpopups'] = Popup::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();
        $data['lang'] = $lang;
        return view('admin.popups.index', $data);
    }

    public function types()
    {
        return view('admin.popups.types');
    }

    public function create()
    {
        $data['langs'] = Language::all();
        return view('admin.popups.create', $data);
    }

    public function edit($id)
    {
        $data['popup'] = Popup::query()->findOrFail($id);
        $data['language'] = Language::query()->findOrFail($data['popup']->language_id);
        return view('admin.popups.edit', $data);
    }

    public function store(Request $request)
    {
        $type = $request->type;

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'name' => 'required',
            'language_id' => 'required',
            'serial_number' => 'required|integer',
            'delay' => 'required|integer',
        ];

        if ($type == 1 || $type == 4 || $type == 5 || $type == 7) {
            $rules['image'] = [
                'required',
                new ImageMimeTypeRule()
            ];
        }

        if ($type == 2 || $type == 3 || $type == 6) {
            $rules['background_image'] = [
                'required',
                new ImageMimeTypeRule()
            ];
        }

        if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7) {
            $rules['title'] = 'nullable';
            $rules['text'] = 'nullable';
            $rules['button_text'] = 'nullable';
            $rules['button_color'] = 'nullable';
        }

        if ($type == 2 || $type == 3) {
            $rules['background_color'] = 'required';
            $rules['background_opacity'] = 'required|numeric|max:1|min:0';
        }

        if ($type == 7) {
            $rules['background_color'] = 'required';
        }

        if ($type == 6 || $type == 7) {
            $rules['end_date'] = 'required';
            $rules['end_time'] = 'required';
        }

        if ($type == 2 || $type == 4 || $type == 6 || $type == 7) {
            $rules['button_url'] = 'nullable';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $popup = new Popup;
        $popup->name = $request->name;
        $popup->language_id = $request->language_id;
        $popup->serial_number = $request->serial_number;
        $popup->delay = $request->delay;
        $popup->type = $type;

        if ($type == 1 || $type == 4 || $type == 5 || $type == 7) {
            if ($request->hasFile('image')) {
                $popup->image = upload_picture($this->path, $request->file('image'));
            }
        }

        if ($type == 2 || $type == 3 || $type == 6) {
            if ($request->hasFile('background_image')) {
                $popup->background_image = upload_picture($this->path, $request->file('background_image'));
            }
        }

        if ($type == 2 || $type == 3) {
            $popup->background_color = $request->background_color;
            $popup->background_opacity = $request->background_opacity;
        }

        if ($type == 7) {
            $popup->background_color = $request->background_color;
        }

        if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7) {
            $popup->button_text = $request->button_text;
            $popup->button_color = $request->button_color;
        }

        if ($type == 2 || $type == 4 || $type == 6 || $type == 7) {
            $popup->button_url = $request->button_url;
        }

        if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7) {
            $popup->title = $request->title;
            $popup->text = $request->text;
        }

        if ($type == 6 || $type == 7) {
            $popup->end_date = $request->end_date;
            $popup->end_time = $request->end_time;
        }

        $popup->save();

        Session::flash('success', 'Popup added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $type = $request->type;

        $rules = [
            'name' => 'required',
            'serial_number' => 'required|integer',
            'delay' => 'required|integer',
        ];

        if ($type == 1 || $type == 4 || $type == 5 || $type == 7) {
            if ($request->hasFile('image')) {
                $rules['image'] = new ImageMimeTypeRule();
            }
        }

        if ($type == 2 || $type == 3 || $type == 6) {
            if ($request->hasFile('background_image')) {
                $rules['background_image'] = new ImageMimeTypeRule();
            }
        }

        if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7) {
            $rules['title'] = 'nullable';
            $rules['text'] = 'nullable';
            $rules['button_text'] = 'nullable';
            $rules['button_color'] = 'nullable';
        }

        if ($type == 2 || $type == 3) {
            $rules['background_color'] = 'required';
            $rules['background_opacity'] = 'required|numeric|max:1|min:0';
        }

        if ($type == 7) {
            $rules['background_color'] = 'required';
        }

        if ($type == 6 || $type == 7) {
            $rules['end_date'] = 'required';
            $rules['end_time'] = 'required';
        }

        if ($type == 2 || $type == 4 || $type == 6 || $type == 7) {
            $rules['button_url'] = 'nullable';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $popup = Popup::findOrFail($request->popup_id);
        $popup->name = $request->name;
        $popup->serial_number = $request->serial_number;
        $popup->delay = $request->delay;

        if ($type == 1 || $type == 4 || $type == 5 || $type == 7) {
            if ($request->hasFile('image')) {
                $popup->image = update_picture($this->path, $request->file('image'), $popup->image);
            }
        }

        if ($type == 2 || $type == 3 || $type == 6) {
            if ($request->hasFile('background_image')) {
                $popup->background_image = update_picture($this->path, $request->file('background_image'), $popup->image);
            }
        }

        if ($type == 2 || $type == 3) {
            $popup->background_color = $request->background_color;
            $popup->background_opacity = $request->background_opacity;
        }

        if ($type == 7) {
            $popup->background_color = $request->background_color;
        }

        if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7) {
            $popup->button_text = $request->button_text;
            $popup->button_color = $request->button_color;
        }

        if ($type == 2 || $type == 4 || $type == 6 || $type == 7) {
            $popup->button_url = $request->button_url;
        }

        if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7) {
            $popup->title = $request->title;
            $popup->text = $request->text;
        }

        if ($type == 6 || $type == 7) {
            $popup->end_date = $request->end_date;
            $popup->end_time = $request->end_time;
        }

        $popup->save();

        Session::flash('success', 'Popup updated successfully!');
        return "success";
    }


    public function delete(Request $request)
    {

        $popup = Popup::findOrFail($request->popup_id);
        deleteFile($this->path, $popup->image);
        deleteFile($this->path, $popup->background_image);
        $popup->delete();
        Session::flash('success', 'Popup deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {

        $ids = $request->ids;
        foreach ($ids as $id) {
            $popup = Popup::findOrFail($id);
            deleteFile($this->path, $popup->image);
            deleteFile($this->path, $popup->background_image);
            $popup->delete();
        }
        Session::flash('success', 'Popups deleted successfully!');
        return "success";
    }

    public function status(Request $request)
    {
        $po = Popup::find($request->popup_id);

        $po->status = $request->status;
        $po->save();
        Session::flash('success', 'Status changed!');
        return back();
    }
}
