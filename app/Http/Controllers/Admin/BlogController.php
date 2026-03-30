<?php

namespace App\Http\Controllers\Admin;

use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Bcategory;
use App\Models\Language;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;


class BlogController extends Controller
{
    protected string $path ;

    public function __construct()
    {
        $this->path = 'assets/front/img/blogs';
    }

    public function index(Request $request)
    {
        $lang = Language::query()->where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['lang_id'] = $lang_id;
        $data['blogs'] = Blog::query()
            ->where('language_id', $lang_id)
            ->orderBy('id', 'DESC')
            ->get();
        $data['bcats'] = Bcategory::query()
            ->where('language_id', $lang_id)
            ->where('status', 1)
            ->get();

        return view('admin.blog.blog.index', $data);
    }

    public function edit($id)
    {
        $data['blog'] = Blog::query()->findOrFail($id);
        $data['bcats'] = Bcategory::query()
            ->where('language_id', $data['blog']->language_id)
            ->where('status', 1)
            ->get();
        return view('admin.blog.blog.edit', $data);
    }


    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required',
            'blog_content.required' => 'The content field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'title' => 'required|max:255',
            'category' => 'required',
            'blog_content' => 'required',
            'serial_number' => 'required|integer',
            'image' => new ImageMimeTypeRule(),
            ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }


        $input = $request->all();

        $input['bcategory_id'] = $request->category;
        $input['slug'] = make_slug($request->title);

        if($request->hasFile('image')){
            $input['main_image'] = upload_picture($this->path,$request->file('image'));
            $request->session()->put('blog_image', $input['main_image']);
        }
        $input['content'] = Purifier::clean($request->blog_content, 'youtube');

        $blog = new Blog;

        $blog->create($input);

        Session::flash('success', 'Blog added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $messages = [
            'blog_content.required' => 'The content field is required'
        ];
        $rules = [
            'title' => 'required|max:255',
            'category' => 'required',
            'blog_content' => 'required',
            'serial_number' => 'required|integer',
            'image' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $input = $request->all();
        $blog = Blog::query()->findOrFail($request->blog_id);

        $input['bcategory_id'] = $request->category;
        $input['slug'] = make_slug($request->title);

        if ($request->hasFile('image')) {
            $input['main_image'] = update_picture($this->path,$request->file('image'),$blog->main_image);
        }
        $input['content'] = Purifier::clean($request->blog_content, 'youtube');
        $blog->update($input);
        Session::flash('success', 'Blog updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $blog = Blog::query()->findOrFail($request->blog_id);
        deleteFile($this->path,$blog->main_image);
        $blog->delete();

        Session::flash('success', 'Blog deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $blog = Blog::query()->findOrFail($id);
            deleteFile($this->path,$blog->main_image);
            $blog->delete();
        }
        Session::flash('success', 'Blogs deleted successfully!');
        return "success";
    }

    public function getcats($langId)
    {
        return Bcategory::query()->where('language_id', $langId)->where('status', 1)->get();
    }
}
