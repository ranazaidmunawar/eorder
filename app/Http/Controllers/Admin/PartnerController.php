<?php

namespace App\Http\Controllers\Admin;

use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Language;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class PartnerController extends Controller
{
    protected string $path;

    public function __construct()
    {
        $this->path  = 'assets/front/img/partners';
    }

    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['partners'] = Partner::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();

        $data['lang_id'] = $lang_id;
        return view('admin.home.partner.index', $data);
    }

    public function edit($id)
    {
        $data['partner'] = Partner::findOrFail($id);
        return view('admin.home.partner.edit', $data);
    }

    public function upload(Request $request)
    {
        $rules = [
            'file' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'partner']);
        }

        $filename = upload_picture($this->path,$request->file('file'));
        $request->session()->put('partner_image', $filename);
        return response()->json(['status' => "session_put", "image" => "partner_image", 'filename' => $filename]);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required',
            'image.required' => 'The image field is required',
            'url.required' => 'The URL field is required',
            'serial_number.required' => 'The Serial number field is required',
        ];

        $rules = [
            'language_id' => 'required',
            'image' => ['required', new ImageMimeTypeRule()],
            'url' => 'required|max:255',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $filename = null;
        if($request->hasFile('image')){
            $filename = upload_picture($this->path,$request->file('image'));
        }
        $partner = new Partner;
        $partner->language_id = $request->language_id;
        $partner->url = $request->url;
        $partner->image = $filename;
        $partner->serial_number = $request->serial_number;
        $partner->save();

        Session::flash('success', 'Partner added successfully!');
        return "success";
    }

    public function uploadUpdate(Request $request, $id)
    {
        $rules = [
            'file' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'partner']);
        }

        $partner = Partner::findOrFail($id);
        if ($request->hasFile('file')) {
            $partner->image = update_picture($this->path,$request->file('file'),$partner->image);
        }
        $partner->save();
        return response()->json(['status' => "success", "image" => "Partner", 'partner' => $partner]);
    }

    public function update(Request $request)
    {
        $rules = [
            'url' => 'required|max:255',
            'serial_number' => 'required|integer',
            'image' => new ImageMimeTypeRule()
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $partner = Partner::query()->findOrFail($request->partner_id);
        if ($request->hasFile('image')) {
            $partner->image = update_picture($this->path,$request->file('image'),$partner->image);
        }
        $partner->url = $request->url;
        $partner->serial_number = $request->serial_number;
        $partner->save();

        Session::flash('success', 'Partner updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $partner = Partner::findOrFail($request->partner_id);
        deleteFile($this->path,$partner->image);
        $partner->delete();
        Session::flash('success', 'Partner deleted successfully!');
        return back();
    }
}
