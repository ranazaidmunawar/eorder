<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Language;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;


class PageController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::query()
            ->where('code', $request->language)
            ->first();
        $lang_id = $lang->id;
        $data['apages'] = Page::query()
            ->where('language_id', $lang_id)
            ->orderBy('id', 'DESC')
            ->get();
        $data['lang_id'] = $lang_id;
        return view('admin.page.index', $data);
    }

    public function create()
    {
        $data['tpages'] = Page::query()->where('language_id', 0)->get();
        return view('admin.page.create', $data);
    }

    public function store(Request $request): JsonResponse|string
    {
        $messages = [
            'language_id.required' => 'The language field is required',
        ];
        $rules = [
            'language_id' => 'required',
            'name' => 'required',
            'title' => 'required',
            'body' => 'required',
            'status' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $page = new Page;
        $page->language_id = $request->language_id;
        $page->name = $request->name;
        $page->title = $request->title;
        $page->slug = strtolower(make_slug($request->name));;
        $page->body = Purifier::clean($request->body, 'youtube');
        $page->status = $request->status;
        $page->meta_keywords = $request->meta_keywords;
        $page->meta_description = $request->meta_description;
        $page->save();

        Session::flash('success', 'Page created successfully!');
        return "success";
    }

    public function edit($pageId)
    {
        $data['page'] = Page::query()->findOrFail($pageId);
        return view('admin.page.edit', $data);
    }

    public function update(Request $request): JsonResponse|string
    {
        $rules = [
            'name' => 'required',
            'title' => 'required',
            'body' => 'required',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $pageId = $request->page_id;

        $page = Page::query()->findOrFail($pageId);
        $page->name = $request->name;
        $page->title = $request->title;
        $page->slug = strtolower(make_slug($request->name));;
        $page->body = Purifier::clean($request->body, 'youtube');
        $page->status = $request->status;
        $page->meta_keywords = $request->meta_keywords;
        $page->meta_description = $request->meta_description;
        $page->save();

        Session::flash('success', 'Page updated successfully!');
        return "success";
    }

    public function delete(Request $request): RedirectResponse
    {
        $pageId = $request->page_id;
        $page = Page::query()->findOrFail($pageId);
        $page->delete();
        Session::flash('success', 'Page deleted successfully!');
        return redirect()->back();
    }

    public function bulkDelete(Request $request): string
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $page = Page::query()->findOrFail($id);
            $page->delete();
        }
        Session::flash('success', 'Pages bulk deleted successfully!');
        return "success";
    }

}
