<?php

namespace App\Http\Controllers\Admin;

use App\Models\BasicSetting;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Testimonial;
use App\Models\BasicSetting as BS;
use App\Models\BasicExtended;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    protected string $path ;
    protected string $bPath ;

    public function __construct()
    {
        $this->path  = 'assets/front/img/testimonials';
        $this->bPath  = 'assets/front/img';
    }

    public function index(Request $request)
    {
        $lang = Language::query()->where('code', $request->language)->first();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;
        $data['testimonials'] = Testimonial::query()->where('language_id', $data['lang_id'])->orderBy('id', 'DESC')->get();

        return view('admin.home.testimonial.index', $data);
    }

    public function edit($id)
    {
        $data['testimonial'] = Testimonial::query()->findOrFail($id);
        return view('admin.home.testimonial.edit', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'language_id' => 'required',
            'comment' => 'required',
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'serial_number' => 'required|integer',
            'image' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $input = $request->all();

        if ($request->hasFile('image')) {
            $input['image'] = upload_picture($this->path,$request->file('image'));
        }
        $testimonial = new Testimonial;
        $testimonial->create($input);
        Session::flash('success', 'Testimonial added successfully!');
        return "success";
    }

    public function sideImageStore(Request $request)
    {
        $rules = [
            'image' => [
                'required',
                new ImageMimeTypeRule()
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $input = $request->all();
        if ($request->hasFile('image')) {
            $input['image'] = upload_picture($this->path,$request->file('image'));
        }
        $count= BasicExtended::count();
        if($count > 0) BasicExtended::query()->update(['testimonial_img' => $input['image']]);

        Session::flash('success', 'Testimonial added successfully!');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $rules = [
            'comment' => 'required',
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'serial_number' => 'required|integer',
            'image' => new ImageMimeTypeRule(),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $input = $request->all();

        $testimonial = Testimonial::findOrFail($request->testimonial_id);
        if ($request->hasFile('image')) {
            $input['image'] = update_picture($this->path,$request->file('image'),$testimonial->image);
        }
        $testimonial->update($input);
        Session::flash('success', 'Testimonial updated successfully!');
        return "success";
    }

    public function textupdate(Request $request, $langid)
    {
        $request->validate([
            'testimonial_section_title' => 'required|max:25'
        ]);

        $bs = BS::query()->where('language_id', $langid)->first();
        $bs->testimonial_title = $request->testimonial_section_title;

        if ($request->hasFile('testimonial_bg_img')) {
            $be = BasicExtended::query()->where('language_id', $langid)->first();
            $filename = update_picture($this->bPath,$request->file('testimonial_bg_img'),$be->testimonial_bg_img);
            $be->testimonial_bg_img = $filename;
            $be->save();
        }

        $bs->save();

        Session::flash('success', 'Text updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $testimonial = Testimonial::findOrFail($request->testimonial_id);
        deleteFile($this->path,$testimonial->image);
        $testimonial->delete();

        Session::flash('success', 'Testimonial deleted successfully!');
        return back();
    }
}
