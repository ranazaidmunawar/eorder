<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\Gallery;
use App\Models\User\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()
            ->where([
                ['code', $request->language],
                ['user_id', $userId]
            ])->first();
     
        $lang_id = $lang->id;
        $data['galleries'] = Gallery::query()
            ->where([
                ['language_id', $lang_id],
                ['user_id', $userId]
            ])
            ->orderBy('id', 'DESC')
            ->get();
        $data['lang_id'] = $lang_id;
        return view('user.gallery.index', $data);
    }

    public function edit($id)
    {
        $userId = getRootUser()->id;
        $data['gallery'] = Gallery::query()
            ->where('user_id', $userId)
            ->find($id);
        $this->authorize('view', $data['gallery']);   
        return view('user.gallery.edit', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'user_language_id.required' => 'The language field is required',
        ];
        $rules = [
            'user_language_id' => 'required',
            'title' => 'required|max:255',
            'serial_number' => 'required|integer',
            'image' => new ImageMimeTypeRule(),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $gallery = new Gallery;
        if ($request->hasFile('image')) {
            $gallery->image = Uploader::upload_picture(Constant::WEBSITE_GALLERY_IMAGES,$request->file('image'));
        }
        $gallery->language_id = $request->user_language_id;
        $gallery->user_id = $userId;
        $gallery->title = $request->title;
        $gallery->serial_number = $request->serial_number;
        $gallery->save();
        Session::flash('success', 'Image added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'serial_number' => 'required|integer',
            'image' => new ImageMimeTypeRule(),
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $gallery = Gallery::query()
            ->where('user_id', $userId)
            ->findOrFail($request->gallery_id);
        if ($request->hasFile('image')) {
            $gallery->image = Uploader::update_picture(Constant::WEBSITE_GALLERY_IMAGES,$request->file('image'),$gallery->image);
        }
        $gallery->title = $request->title;
        $gallery->serial_number = $request->serial_number;
        $gallery->save();

        Session::flash('success', 'Gallery updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $gallery = Gallery::query()
            ->where('user_id', $userId)
            ->findOrFail($request->gallery_id);
        Uploader::remove(Constant::WEBSITE_GALLERY_IMAGES,$gallery->image);
        $gallery->delete();
        Session::flash('success', 'Image deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $userId = getRootUser()->id;
        $ids = $request->ids;
        foreach ($ids as $id) {
            $gallery = Gallery::query()
                ->where('user_id', $userId)
                ->findOrFail($id);
            Uploader::remove(Constant::WEBSITE_GALLERY_IMAGES,$gallery->image);
            $gallery->delete();
        }
        Session::flash('success', 'Image deleted successfully!');
        return "success";
    }
}
