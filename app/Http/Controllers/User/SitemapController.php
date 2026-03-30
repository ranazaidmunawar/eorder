<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\File;
use App\Constants\Constant;
use App\Models\User\Sitemap;
use Illuminate\Http\Request;
use App\Models\User\Language;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Http\Controllers\Controller;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\BasicSetting as AdminBasicSetting;

class SitemapController extends Controller
{
    public function index(){
        $userId = getRootUser()->id;
        $data['langs'] = Language::query()->where('user_id',$userId)->get();
        $data['sitemaps'] = Sitemap::query()
            ->where('user_id',$userId)
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('user.sitemap.index',$data);
    }

    public function store(Request $request)
    {

        $messages = [
            'sitemap_url.required' => 'The sitemap url field is required'
        ];

        $rules = [
            'sitemap_url' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $userId = getRootUser()->id;
        $features = UserPermissionHelper::currentPackageFeatures($userId);
        $bs = AdminBasicSetting::query()
            ->select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();
     
        $data = new Sitemap();
        $input = $request->all();
        $filename = 'sitemap'. uniqid() .'.xml';
        $directory = Constant::WEBSITE_TENANT_SITEMAP_FILE.'/';
        if (!file_exists(public_path($directory))) {
            if (!mkdir(public_path($directory), 0755, true)) {
                die('Failed to create folders...');
            }
        }
        SitemapGenerator::create($request->sitemap_url)->writeToFile(public_path($directory . $filename));
        if (in_array("Amazon AWS s3", $features) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            Storage::disk('s3')->putFileAs($directory, new File(public_path($directory.$filename)), $filename);
            @unlink(public_path($directory.$filename));
        }
        $input['filename']    = $filename;
        $input['user_id']    = $userId;
        $input['sitemap_url'] = $request->sitemap_url;
        $data->fill($input)->save();
        Session::flash('success', 'Sitemap Generate Successfully');
        return "success";
    }

    public function download(Request $request) {
        $userId = getRootUser()->id;
        $pathToFile = Constant::WEBSITE_TENANT_SITEMAP_FILE.'/'.$request->filename;

        $bs = AdminBasicSetting::query()
            ->select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();
            
        if(!is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)){
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            $s3 = Storage::disk('s3');
            if(Storage::disk('s3')->exists($pathToFile)){
                $headers = [
                    'Content-Type'        => 'application/xml',
                    'Content-Disposition' => 'attachment; filename="'. $request->filename .'"',
                ];
                return Response::make($s3->get($pathToFile), 200, $headers);
            }else{
                return response()->download(public_path($pathToFile), $request->filename);
            }
        }else{
            return response()->download(public_path($pathToFile), $request->filename);
        }
    }

    public function update(Request $request)
    {
        $userId = getRootUser()->id;
        $features = UserPermissionHelper::currentPackageFeatures($userId);
        $bs = AdminBasicSetting::query()
            ->select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();

        $data  = Sitemap::query()->where('user_id', $userId)->find($request->id);
        $input = $request->all();
        $filename = 'sitemap'.uniqid().'.xml';
        $directory = Constant::WEBSITE_TENANT_SITEMAP_FILE .'/';
        SitemapGenerator::create($request->sitemap_url)->writeToFile($directory.$filename);
        if (in_array("Amazon AWS s3", $features) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            Storage::disk('s3')->putFileAs($directory, new File($directory.$filename), $filename);
            @unlink($directory.$filename);
        }else{
            @unlink($directory.$data->filename);
        }
        $input['filename']  = $filename;

        $data->update($input);
        Session::flash('success', 'Feed updated successfully!');
        return back();
    }

    public function delete($id) {
        $userId = getRootUser()->id;
        $sitemap = Sitemap::query()->where('user_id',$userId)->find($id);
        Uploader::remove(Constant::WEBSITE_TENANT_SITEMAP_FILE,$sitemap->filename);
        $sitemap->delete();
        Session::flash('success', 'Sitemap file deleted successfully!');
        return back();
    }
}
