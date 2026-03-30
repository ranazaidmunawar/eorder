<?php

namespace App\Http\Helpers;

use App\Exceptions\StorageLimitExceed;
use App\Models\User\BasicSetting;
use App\Models\BasicSetting as AdminBs;
use getID3;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Uploader
{
    public static function upload_picture($directory, $img, $user_id = null): string
    {
        $user_id = $user_id ?? getRootUser()->id;
        $data = UserPermissionHelper::currentPackageFeatures($user_id);
        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();

        $file_name = sha1(time() . rand());
        $ext = $img->getClientOriginalExtension();
        $newFileName = $file_name . "." . $ext;
        if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {

            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            $storagePath = Storage::disk('s3')->putFileAs($directory, $img, $newFileName);
            return basename($storagePath);
        } else {

            if (!file_exists(public_path($directory))) {
                if (!mkdir(public_path($directory), 0755, true)) {
                    die('Failed to create folders...');
                }
            }
            $limit = LimitCheckerHelper::storageLimit($user_id);
            if ($limit > 0) {
                $bss = BasicSetting::query()->where('user_id', $user_id)->select('storage_usage')->first();
                $usage = (float)round($bss->storage_usage + ($img->getSize() / 1048576), 2);
                if ($usage < $limit) {
                    BasicSetting::where('user_id', $user_id)->update(['storage_usage' => $usage]);
                } else {
                    throw new StorageLimitExceed('Your storage limit has been exceeded');
                }
            }
            $img->move(public_path($directory), $newFileName);
            return $newFileName;
        }
    }

    public static function update_picture($directory, $img, $old_img, $user_id = null): string
    {

        $user_id = $user_id ?? getRootUser()->id;
        $data = UserPermissionHelper::currentPackageFeatures($user_id);
        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();
        $userbs = BasicSetting::query()->where('user_id', $user_id)
            ->select('storage_usage')
            ->first();

        $file_name = sha1(time() . rand());
        $ext = $img->getClientOriginalExtension();
        $newFileName = $file_name . "." . $ext;
        $oldImgPath = $directory . '/' . $old_img;

        // if 'amazon s3' is in current package & tenant has setup s3 credentials
        if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            $s3 = Storage::disk('s3');
            // if the image is present in s3, then unlink it
            if ($s3->exists($oldImgPath)) {
                $s3->delete($oldImgPath);
            }
            // if the image is not present in s3, then unlink it from 'local server' & recalculate the 'storage usage' for this tenant
            else {
                if (!is_null($old_img) && file_exists(public_path($oldImgPath))) {
                    $oldImageSize = filesize(public_path($oldImgPath)) / 1048576;
                    if ($userbs->storage_usage > 0) {
                        $usage = (float)round($userbs->storage_usage - $oldImageSize, 2);
                        if ($usage < 0) {
                            $usage = 0;
                        }
                    } else {
                        $usage = 0;
                    }
                    BasicSetting::where('user_id', $user_id)->update(['storage_usage' => $usage]);
                    @unlink(public_path($oldImgPath));
                }
            }
        }
        // if 'amazon s3' is not in current package OR tenant has not setup s3 credentials, then unlink it from 'local server' & recalculate the 'storage usage' for this tenant
        else {
            if (!is_null($old_img) && file_exists(public_path($oldImgPath))) {
                $oldImageSize = filesize(public_path($oldImgPath)) / 1048576;
                if ($userbs->storage_usage > 0) {
                    $usage = (float)round($userbs->storage_usage - $oldImageSize, 2);
                    if ($usage < 0) {
                        $usage = 0;
                    }
                } else {
                    $usage = 0;
                }
                BasicSetting::where('user_id', $user_id)->update(['storage_usage' => $usage]);
                @unlink(public_path($oldImgPath));
            }
        }

        // if 'amazon s3' is in current package & tenant has set up s3 credentials, then upload the image in Amazon s3
        if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            $s3 = Storage::disk('s3');
            $storagePath = $s3->putFileAs($directory, $img, $newFileName);
            return basename($storagePath);
        }
        // if 'amazon s3' is not in current package OR tenant has not setup s3 credentials, then upload the image in local server & recalculate the storage usage
        else {
            if (!file_exists(public_path($directory))) {
                if (!mkdir((public_path($directory)), 0755, true)) {
                    die('Failed to create folders...');
                }
            }
            $limit = LimitCheckerHelper::storageLimit($user_id);
            if ($limit > 0) {
                $bss = BasicSetting::query()->where('user_id', $user_id)->select('storage_usage')->first();
                $usage = (float)round($bss->storage_usage + ($img->getSize() / 1048576), 2);
                if ($usage < $limit) {
                    BasicSetting::where('user_id', $user_id)->update(['storage_usage' => $usage]);
                } else {
                    throw new StorageLimitExceed('Your storage limit has been exceeded');
                }
            }
            $img->move(public_path($directory), $newFileName);
            return $newFileName;
        }
    }

    public static function upload_file($directory, $file, $user_id = null)
    {
        $user_id = $user_id ?? getRootUser()->id;
        $data = UserPermissionHelper::currentPackageFeatures($user_id);
        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();

        $file_name = sha1(time() . rand());
        $originalName = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $newFileName = $file_name . "." . $ext;
        if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            $s3 =  Storage::disk('s3');
            $storagePath = $s3->putFileAs($directory, $file, $newFileName);
            return [
                'originalName' => $originalName,
                'uniqueName' => basename($storagePath)
            ];
        } else {
            if (!file_exists(public_path($directory))) {
                if (!mkdir(public_path($directory), 0755, true)) {
                    die('Failed to create folders...');
                }
            }
            $limit = LimitCheckerHelper::storageLimit($user_id);
            if ($limit > 0) {
                $bss = BasicSetting::query()->where('user_id', $user_id)->select('storage_usage')->first();
                $usage = (float)round($bss->storage_usage + ($file->getSize() / 1048576), 2);
                if ($usage < $limit) {
                    BasicSetting::where('user_id', $user_id)->update(['storage_usage' => $usage]);
                } else {
                    throw new StorageLimitExceed('Your storage limit has been exceeded');
                }
            }
            $file->move(public_path($directory), $newFileName);
            return [
                'originalName' => $originalName,
                'uniqueName' => $newFileName
            ];
        }
    }

    public static function upload_video($directory, $file, $user_id = null)
    {
        $user_id = $user_id ?? getRootUser()->id;
        $data = UserPermissionHelper::currentPackageFeatures($user_id);
        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();

        $file_name = sha1(time() . rand());
        $originalName = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $newFileName = $file_name . "." . $ext;
        if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            $s3 = Storage::disk('s3');
            $storagePath = $s3->putFileAs($directory, $file, $newFileName);
            // get video duration after the video upload
            $getID3 = new getID3;
            $fileInfo = $getID3->analyze($file);
            $duration = gmdate('H:i:s', $fileInfo['playtime_seconds']);
            return [
                'originalName' => $originalName,
                'uniqueName' => basename($storagePath),
                'duration' => $duration
            ];
        } else {
            if (!file_exists(public_path($directory))) {
                if (!mkdir(public_path($directory), 0755, true)) {
                    die('Failed to create folders...');
                }
            }
            $limit = LimitCheckerHelper::storageLimit($user_id);
            if ($limit > 0) {
                $bss = BasicSetting::query()->where('user_id', $user_id)->select('storage_usage')->first();
                $usage = (float)round($bss->storage_usage + ($file->getSize() / 1048576), 2);
                if ($usage < $limit) {
                    BasicSetting::query()->where('user_id', $user_id)->update(['storage_usage' => $usage]);
                } else {
                    throw new StorageLimitExceed('Your storage limit has been exceeded');
                }
            }
            $file->move(public_path($directory), $newFileName);
            // get video duration after the video upload
            $getID3 = new getID3;
            $fileInfo = $getID3->analyze(public_path($directory) . '/' . $newFileName);
            $duration = gmdate('H:i:s', $fileInfo['playtime_seconds']);
            return [
                'originalName' => $originalName,
                'uniqueName' => $newFileName,
                'duration' => $duration
            ];
        }
    }

    public static function getImageUrl($directory, $img, $bs, $defaultUrl = ''): string
    {
        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();
        if (Session::has('user')) {
            $user = Session::get('user');
            $user_id =  $user->id;;
        } else {
            $user_id =  getRootUser()->id ?? getUser()->id;
        }
        $data = UserPermissionHelper::currentPackageFeatures($user_id);

        $url = $directory . '/' . $img;
        if (!is_null($img)) {
            if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
                setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
                $s3 = Storage::disk('s3');

                if ($s3->exists($url)) {
                    return $s3->url($url);
                } else {
                    return asset($url);
                }
            } else {
                return asset($url);
            }
        } else {

            return asset($defaultUrl);
        }
    }

    public static function downloadFile($directory, $file_unique_name, $originalName, $bs)
    {

        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();

        $user_id = $user_id ?? getRootUser()->id;
        $data = UserPermissionHelper::currentPackageFeatures($user_id);

        $pathToFile = $directory . '/' . $file_unique_name;
        if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            $s3 = Storage::disk('s3');
            if (Storage::disk('s3')->exists($pathToFile)) {
                $headers = [
                    'Content-Type'        => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $originalName . '"',
                ];
                return Response::make($s3->get($pathToFile), 200, $headers);
            } else {
                return response()->download($pathToFile, $originalName);
            }
        } else {
            return response()->download(public_path($pathToFile), $originalName);
        }
    }

    public static function remove($directory, $filename, $bs = null, $userId = null): void
    {

        $user_id = $userId ?? getRootUser()->id;
        $data = UserPermissionHelper::currentPackageFeatures($user_id);

        if (is_null($bs)) {

            $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
                ->first();

            $userbs = BasicSetting::query()
                ->where('user_id', $userId)
                ->select('storage_usage')
                ->first();
        }
        $pathToFile = $directory . '/' . $filename;
        $pathToFileLocal = public_path($directory) . '/' . $filename;

        if (in_array("Amazon AWS s3", $data) && !is_null($bs?->aws_access_key_id) && !is_null($bs?->aws_secret_access_key) && !is_null($bs?->aws_default_region) && !is_null($bs?->aws_bucket)) {

            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            $s3 = Storage::disk('s3');
            if ($s3->exists($pathToFile)) {
                $s3->delete($pathToFile);
            } else {

                if (file_exists($pathToFileLocal)) {
                    $oldImageSize = filesize($pathToFileLocal) / 1048576;
                    if ($userbs?->storage_usage > 0) {
                        $usage = (float)round($userbs->storage_usage - $oldImageSize, 2);
                        if ($usage < 0) {
                            $usage = 0;
                        }
                    } else {
                        $usage = 0;
                    }
                    BasicSetting::where('user_id', $userId)->update(['storage_usage' => $usage]);
                    @unlink($pathToFile);
                }
            }
        } else {

            if (file_exists($pathToFileLocal)) {
                $oldImageSize = filesize($pathToFileLocal) / 1048576;
                if ($userbs?->storage_usage > 0) {
                    $usage = (float)round($userbs->storage_usage - $oldImageSize, 2);
                    if ($usage < 0) {
                        $usage = 0;
                    }
                } else {
                    $usage = 0;
                }
                BasicSetting::query()->where('user_id', $userId)->update(['storage_usage' => $usage]);
                @unlink(public_path($pathToFile));
            }
        }
    }
}
