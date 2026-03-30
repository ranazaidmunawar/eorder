<?php

namespace App\Http\Controllers\User\Journal;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Requests\Blog\StoreRequest;
use App\Http\Requests\Blog\UpdateRequest;
use App\Models\User\Journal\Blog;
use App\Models\User\Journal\BlogInformation;
use App\Models\User\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        $userId = getRootUser()->id;
        $information['langs'] = Language::query()->where('user_id', $userId)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['blogs'] = DB::table('user_blogs')
            ->join('user_blog_informations', 'user_blogs.id', '=', 'user_blog_informations.blog_id')
            ->join('user_blog_categories', 'user_blog_categories.id', '=', 'user_blog_informations.blog_category_id')
            ->where('user_blog_informations.language_id', '=', $information['language']->id)
            ->where('user_blog_informations.user_id', '=', $userId)
            ->select('user_blogs.id', 'user_blogs.serial_number', 'user_blogs.created_at', 'user_blog_informations.title', 'user_blog_informations.slug', 'user_blog_informations.author', 'user_blog_categories.name AS categoryName')
            ->orderByDesc('user_blogs.id')
            ->get();
        return view('user.journal.blog.index', $information);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        // get all the languages from db
        $userId = getRootUser()->id;
        $information['languages'] = Language::query()
            ->where('user_id', $userId)
            ->get();
        $information['defaultLang'] = $information['languages']->where('is_default', 1)->first();
        return view('user.journal.blog.create', $information);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return
     */
    public function store(StoreRequest $request)
    {
     
        // store image in storage
        $imgName = Uploader::upload_picture(Constant::WEBSITE_BLOG_IMAGE, $request->file('image'));
        $userId = getRootUser()->id;
        // store data in db
        $blog = Blog::create($request->except('image', 'user_id') + [
                'image' => $imgName,
                'user_id' => $userId
            ]);

        $languages = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();

        foreach ($languages as $language) {
            $blogInformation = new BlogInformation();
            $blogInformation->language_id = $language->id;
            $blogInformation->user_id = $userId;
            $blogInformation->blog_category_id = $request[$language->code . '_category_id'];
            $blogInformation->blog_id = $blog->id;
            $blogInformation->title = $request[$language->code . '_title'];
            $blogInformation->slug = make_slug($request[$language->code . '_title']);
            $blogInformation->author = $request[$language->code . '_author'];
            $blogInformation->content = Purifier::clean($request[$language->code . '_content'], 'youtube');
            $blogInformation->meta_keywords = $request[$language->code . '_meta_keywords'];
            $blogInformation->meta_description = $request[$language->code . '_meta_description'];
            $blogInformation->save();
        }

        $request->session()->flash('success', 'New blog added successfully!');
        return "success";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return
     */
    public function edit($id)
    {
        
        $userId = getRootUser()->id;
        $information['blog'] = Blog::query()->where('user_id', $userId)->find($id);  
        
        $this->authorize('view', $information['blog']);
        $information['languages'] = Language::query()->where('user_id', $userId)->get();
        $information['defaultLang'] = $information['languages']->where('is_default', 1)->first();
        return view('user.journal.blog.edit', $information);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return
     */
    public function update(UpdateRequest $request, $id)
    {
        $userId = getRootUser()->id;
        $blog = Blog::query()->where('user_id', $userId)->find($id);
        $this->authorize('view', $blog);
        // store new image in storage
        if ($request->hasFile('image')) {
            $imgName = Uploader::update_picture(Constant::WEBSITE_BLOG_IMAGE, $request->file('image'), $blog->image);
        }
        // update data in db
        $blog->update($request->except('image') + [
                'image' => $request->hasFile('image') ? $imgName : $blog->image
        ]);

        $languages = Language::query()
            ->where('user_id', $userId)
            ->get();

        foreach ($languages as $language) {
            BlogInformation::query()->updateOrCreate([
                'blog_id' => $id,
                'user_id' => $userId,
                'language_id' => $language->id
            ],[
                'blog_category_id' => $request[$language->code . '_category_id'],
                'title' => $request[$language->code . '_title'],
                'slug' => make_slug($request[$language->code . '_title']),
                'author' => $request[$language->code . '_author'],
                'content' => Purifier::clean($request[$language->code . '_content'], 'youtube'),
                'user_id' => $userId,
                'language_id' => $language->id,
                'meta_keywords' => $request[$language->code . '_meta_keywords'],
                'meta_description' => $request[$language->code . '_meta_description']
            ]);
        }
        $request->session()->flash('success', 'Blog updated successfully!');
        return "success";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return
     */
    public function destroy($id)
    {
        $userId = getRootUser()->id;
        $blog = Blog::query()->where('user_id', $userId)->find($id);
        // first, delete the image
        Uploader::remove(Constant::WEBSITE_BLOG_IMAGE,$blog->image);
        $blogInformations = BlogInformation::query()
            ->where('blog_id', $blog->id)
            ->where('user_id', $userId)
            ->get();
        foreach ($blogInformations as $blogInformation) {
            $blogInformation->delete();
        }
        $blog->delete();
        return redirect()->back()->with('success', 'Blog deleted successfully!');
    }

    /**
     * Remove the selected or all resources from storage.
     *
     * @param Request $request
     * @return
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;
        $userId = getRootUser()->id;
        foreach ($ids as $id) {
            $blog = Blog::query()->where('user_id', $userId)->find($id);
            // first, delete the image
            Uploader::remove(Constant::WEBSITE_BLOG_IMAGE,$blog->image);
            $blogInformations = BlogInformation::query()
                ->where('blog_id', $blog->id)
                ->where('user_id', $userId)
                ->get();
            foreach ($blogInformations as $blogInformation) {
                $blogInformation->delete();
            }
            $blog->delete();
        }
        $request->session()->flash('success', 'Blogs deleted successfully!');
        return "success";
    }
}
