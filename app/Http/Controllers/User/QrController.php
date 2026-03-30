<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\File;
use App\Constants\Constant;
use Illuminate\Http\Request;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Models\User\BasicExtended;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Models\BasicSetting as AdminBs;
use Illuminate\Support\Facades\Storage;
use App\Http\Helpers\UserPermissionHelper;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function qrCode()
    {
        $user = getRootUser();
        $userId = $user->id;
        $abe = BasicExtended::query()->where('user_id', $userId)->first();

        if (empty($abe->qr_image)) {
            $directory = Constant::WEBSITE_QR_IMAGE . '/';
            @mkdir(public_path($directory), 0775, true);
            $qrImage = uniqid() . getQrExtension();
            $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
                ->first();

            $data = UserPermissionHelper::currentPackageFeatures($userId);

            if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
                $qrCode = QrCode::size(250)->errorCorrection('H')
                    ->color(0, 0, 0)
                    ->format(getQrFormat())
                    ->style('square')
                    ->eye('square')
                    ->generate(url($user->username . '/qr-menu'));
                setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
                Storage::disk('s3')->put(Constant::WEBSITE_QR_IMAGE . '/' . $qrImage, $qrCode);
            } else {
                $qrCode = QrCode::size(250)->errorCorrection('H')
                    ->color(0, 0, 0)
                    ->format(getQrFormat())
                    ->style('square')
                    ->eye('square');
                $qrCode->generate(url($user->username . '/qr-menu'), public_path($directory) . $qrImage);
            }
            $extendeds = BasicExtended::query()->where('user_id', $userId)->get();
            foreach ($extendeds as $extended) {
                $extended->qr_image = $qrImage;
                $extended->save();
            }
        }
        $data['abe'] = $abe;
        return view('user.qr-code', $data);
    }

    public function generate(Request $request)
    {
        $user = getRootUser();
        $userId = $user->id;
        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();

        $data = UserPermissionHelper::currentPackageFeatures($userId);
        $type = $request->type;
        $abe = BasicExtended::query()
            ->where('user_id', $userId)
            ->first();

        // set default values for all params of qr image, if there is no value for a param
        $color = hex2rgb($request->color);

        $directory = Constant::WEBSITE_QR_IMAGE . '/';
      
        $qrImage = uniqid() . getQrExtension();
        // remove previous qr image
        Uploader::remove(Constant::WEBSITE_QR_IMAGE, $abe->qr_image);

        if ($type == 'image' && $request->hasFile('image')) {

            $mergedImage = Uploader::update_picture(Constant::WEBSITE_QR_IMAGE, $request->file('image'), $abe->qr_inserted_image);
        }
        // new QR code init
        // generating & saving the qr code in folder
        if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {

            $qrcode = QrCode::size($request->size)
                ->errorCorrection('H')
                ->margin($request->margin)
                ->color($color['red'], $color['green'], $color['blue'])
                ->format(getQrFormat())
                ->style($request->style)
                ->eye($request->eye_style)
                ->generate(url($user->username . '/qr-menu'));
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            Storage::disk('s3')->put($directory . $qrImage, $qrcode);
        } else {

            $qrcode = QrCode::size($request->size)
                ->errorCorrection('H')
                ->margin($request->margin)
                ->color($color['red'], $color['green'], $color['blue'])
                ->format(getQrFormat())
                ->style($request->style)
                ->eye($request->eye_style);
            $qrcode->generate(url($user->username . '/qr-menu'), public_path($directory) . $qrImage);
        }

        // calculate the inserted image size
        $qrSize = $request->size;

        if ($type == 'image' && extension_loaded('imagick')) {
            $imageSize = $request->image_size;
            $insertedImgSize = ($qrSize * $imageSize) / 100;
            // inserting image using Image Intervention & saving the qr code in folder
            if ($request->hasFile('image')) {
                $qr = Image::make(in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($directory . $qrImage) ? Storage::disk('s3')->url($directory . $qrImage) : public_path($directory . $qrImage));
                $logo = Image::make(in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($directory . $mergedImage) ? Storage::disk('s3')->url($directory . $mergedImage) : public_path($directory . $mergedImage));
                $logo->resize(null, $insertedImgSize, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $logoWidth = $logo->width();
                $logoHeight = $logo->height();
                $qr->insert($logo, 'top-left', (int) (((($qrSize - $logoWidth) * $request->image_x) / 100)), (int) (((($qrSize - $logoHeight) * $request->image_y) / 100)));
                $qr->save(public_path($directory . $qrImage));
                if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
                    setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
                    Storage::disk('s3')->putFileAs($directory, new File(public_path($directory . $qrImage)), $qrImage);
                    @unlink($directory . $qrImage);
                }
            } else {
                if (!empty($table->image) && file_exists('./' . $directory . $table->image)) {
                    $qr = Image::make(in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($directory . $qrImage) ? Storage::disk('s3')->url($directory . $qrImage) : public_path($directory . $qrImage));
                    $logo = Image::make(in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($directory . $table->image) ? Storage::disk('s3')->url($directory . $table->image) : public_path($directory . $table->image));
                    $logo->resize(null, $insertedImgSize, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $logoWidth = $logo->width();
                    $logoHeight = $logo->height();

                    $qr->insert($logo, 'top-left', (int) (((($qrSize - $logoWidth) * $request->image_x) / 100)), (int) (((($qrSize - $logoHeight) * $request->image_y) / 100)));
                    $qr->save($directory . $qrImage);
                    if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
                        setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
                        Storage::disk('s3')->putFileAs($directory, new File(public_path($directory . $qrImage)), $qrImage);
                        @unlink($directory . $qrImage);
                    }
                }
            }
        }

        if ($type == 'text' && extension_loaded('imagick')) {
            $imageSize = $request->text_size;
            $insertedImgSize = ($qrSize * $imageSize) / 100;

            $logo = Image::canvas($request->text_width, $insertedImgSize, "#ffffff")->text($request->text, 0, 0, function ($font) use ($request, $insertedImgSize) {
                $font->file(public_path('assets/admin/fonts/Lato-Regular.ttf'));
                $font->size($insertedImgSize);
                $font->color('#' . $request->text_color);
                $font->align('left');
                $font->valign('top');
            });

            $logoWidth = $logo->width();
            $logoHeight = $logo->height();

            $qr = Image::make(in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($directory . $qrImage) ? Storage::disk('s3')->url($directory . $qrImage) : public_path($directory . $qrImage));

            // use callback to define details
            $qr->insert($logo, 'top-left', (int) (((($qrSize - $logoWidth) * $request->text_x) / 100)), (int) (((($qrSize - $logoHeight) * $request->text_y) / 100)));
            $qr->save(public_path($directory . $qrImage));
            if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
                setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
                Storage::disk('s3')->putFileAs($directory, new File(public_path($directory . $qrImage)), $qrImage);
                @unlink($directory . $qrImage);
            }
        }

        $extendeds = BasicExtended::query()->where('user_id', $userId)->get();
        // store the params in database
        foreach ($extendeds as $extended) {
            $extended->qr_color = $request->color;
            $extended->qr_size = $request->size;
            $extended->qr_style = $request->style;
            $extended->qr_eye_style = $request->eye_style;
            $extended->qr_image = $qrImage;
            $extended->qr_type = $type;

            if ($type == 'image') {
                if ($request->hasFile('image')) {
                    $extended->qr_inserted_image = $mergedImage;
                }
                $extended->qr_inserted_image_size = $imageSize;
                $extended->qr_inserted_image_x = $request->image_x;
                $extended->qr_inserted_image_y = $request->image_y;
            }

            if ($type == 'text' && !empty($request->text)) {
                $extended->qr_text = $request->text;
                $extended->qr_text_color = $request->text_color;
                $extended->qr_text_size = $request->text_size;
                $extended->qr_text_x = $request->text_x;
                $extended->qr_text_y = $request->text_y;
            }

            $extended->qr_margin = $request->margin;
            $extended->save();
        }
        return in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($directory . $qrImage) ? Storage::disk('s3')->url($directory . $qrImage) : url($directory . $qrImage);
    }
    public function download($name)
    {
        $userId = getRootUser()->id;
        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();
        $data = UserPermissionHelper::currentPackageFeatures($userId);
        $pathToFile = Constant::WEBSITE_QR_IMAGE . '/' . $name;
        if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            if (Storage::disk('s3')->exists($pathToFile)) {
                $headers = [
                    'Content-Type'        => extension_loaded('imagick') ? 'image/png' : 'image/svg+xml',
                    'Content-Disposition' => 'attachment; filename="' . $name . '"',
                ];
                return \Response::make(Storage::disk('s3')->get($pathToFile), 200, $headers);
            } else {
                return response()->download(public_path($pathToFile), $name);
            }
        } else {
            return response()->download(public_path($pathToFile), $name);
        }
    }
}
