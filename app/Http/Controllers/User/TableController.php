<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\LimitCheckerHelper;
use App\Http\Helpers\Uploader;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\User\BasicSetting;
use App\Models\BasicSetting as AdminBs;
use App\Models\User\Table;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class TableController extends Controller
{
    public function index()
    {
        $userId = getRootUser()->id;

        $features = LimitCheckerHelper::getPackageSelectedData($userId, 'features');
        if($features !=null){
            $data['features'] = json_decode($features->features, true);
        }
        else{
            $data['features'] = [];
        }
      
        $data['tables'] = Table::query()
            ->where('user_id', $userId)
            ->orderBy('table_no', 'ASC')
            ->get();
        return view('user.tables.index', $data);
    }

    public function store(Request $request)
    {
        $user = getRootUser();
        $userId = $user->id;
        $rules = [
            'status' => 'required',
            'table_no' => [
                'required',
                'max:255',
                Rule::unique('tables')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                })
            ],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();
        $userbs = BasicSetting::query()->where('user_id', $userId)
            ->select('storage_usage')
            ->first();

        $data = UserPermissionHelper::currentPackageFeatures($userId);
        $table = new Table;
        $table->status = $request->status;
        $table->table_no = $request->table_no;
        $table->user_id = $userId;
        $directory = Constant::WEBSITE_TABLE_IMAGE . '/';
        @mkdir(public_path($directory), 0775, true);
        $qrImage = uniqid() . getQrExtension();
        if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            $qrCode = QrCode::size(250)->errorCorrection('H')
                ->color(0, 0, 0)
                ->format(getQrFormat())
                ->style('square')
                ->eye('square')
                ->generate(url($user->username . '/qr-menu') . '?table=' . $table->table_no);
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            Storage::disk('s3')->put(Constant::WEBSITE_TABLE_IMAGE . '/' . $qrImage, $qrCode);
        } else {
            $qrCode = QrCode::size(250)->errorCorrection('H')
                ->color(0, 0, 0)
                ->format(getQrFormat())
                ->style('square')
                ->eye('square');
            $qrCode->generate(url($user->username . '/qr-menu') . '?table=' . $table->table_no, public_path($directory) . $qrImage);
        }
        $table->qr_image = $qrImage;
        $table->save();
        Session::flash('success', 'Table Qr added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $user = getRootUser();
        $userId = $user->id;
        $rules = [
            'status' => 'required',
            'table_no' => [
                'required',
                'max:255',
                Rule::unique('tables')
                    ->ignore($request->table_id)
                    ->where(function ($query) use ($userId) {
                        return $query->where('user_id', $userId);
                    })
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();
        $userbs = BasicSetting::query()->where('user_id', $userId)
            ->select('storage_usage')
            ->first();
        $data = UserPermissionHelper::currentPackageFeatures($userId);
        $table = Table::query()->findOrFail($request->table_id);
        if ($table->table_no != $request->table_no) {
            Uploader::remove(Constant::WEBSITE_QR_IMAGE, $table->qr_image);
            Uploader::remove(Constant::WEBSITE_TABLE_IMAGE, $table->image);
            $table->delete();
            $table = new Table;
            $table->status = $request->status;
            $table->table_no = $request->table_no;
            $table->user_id = $userId;
            $table->save();
            $directory = Constant::WEBSITE_TABLE_IMAGE . '/';
            @mkdir(public_path($directory), 0775, true);
            $qrImage = uniqid() . getQrExtension();
            if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
                $qrCode = QrCode::size(250)->errorCorrection('H')
                    ->color(0, 0, 0)
                    ->format(getQrFormat())
                    ->style('square')
                    ->eye('square')
                    ->generate(url($user->username . '/qr-menu') . '?table=' . $table->table_no);
                setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
                Storage::disk('s3')->put(Constant::WEBSITE_TABLE_IMAGE . '/' . $qrImage, $qrCode);
            } else {
                $qrCode = QrCode::size(250)->errorCorrection('H')
                    ->color(0, 0, 0)
                    ->format(getQrFormat())
                    ->style('square')
                    ->eye('square');
                $qrCode->generate(url($user->username . '/qr-menu') . '?table=' . $table->table_no, public_path($directory) . $qrImage);
            }
            $table->qr_image = $qrImage;
            $table->save();
        } else {
            $table->status = $request->status;
            $table->table_no = $request->table_no;
            $table->save();
        }
        Session::flash('success', 'Payment Method updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $table = Table::query()
            ->where('user_id', $userId)
            ->findOrFail($request->table_id);
        Uploader::remove(Constant::WEBSITE_QR_IMAGE, $table->qr_image);
        Uploader::remove(Constant::WEBSITE_TABLE_IMAGE, $table->image);
        $table->delete();
        $request->session()->flash('success', 'Table deleted successfully!');
        return back();
    }
    public function qrBuilder($tableId)
    {
        $userId = getRootUser()->id;
        $data['table'] = Table::query()
            ->where('user_id', $userId)
            ->findOrFail($tableId);
        return view('user.tables.qr-builder', $data);
    }

    public function qrGenerate(Request $request)
    {
        $user = getRootUser();
        $userId = $user->id;
        $type = $request->type;
        $table = Table::query()
            ->where('user_id', $userId)
            ->findOrFail($request->table_id);
        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();
        $userbs = BasicSetting::query()->where('user_id', $userId)
            ->select('storage_usage')
            ->first();
        $data = UserPermissionHelper::currentPackageFeatures($userId);
        // set default values for all params of qr image, if there is no value for a param
        $color = hex2rgb($request->color);

        $directory = Constant::WEBSITE_TABLE_IMAGE . '/';
        @mkdir(public_path($directory), 0775, true);
        $qrImage = uniqid() . getQrExtension();

        // remove previous qr image
        Uploader::remove(Constant::WEBSITE_TABLE_IMAGE, $table->qr_image);

        if ($type == 'image' && $request->hasFile('image')) {
            $mergedImage = Uploader::update_picture(Constant::WEBSITE_TABLE_IMAGE, $request->file('image'), $table->image);
            $table->image = $mergedImage;
        }
        // generating & saving the qr code in folder
        if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            $qrcode = QrCode::size($request->size)
                ->errorCorrection('H')
                ->margin($request->margin)
                ->color($color['red'], $color['green'], $color['blue'])
                ->format(getQrFormat())
                ->style($request->style)
                ->eye($request->eye_style)
                ->generate(url($user->username . '/qr-menu') . '?table=' . $table->table_no);
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
            $qrcode->generate(url($user->username . '/qr-menu') . '?table=' . $table->table_no, public_path($directory) . $qrImage);
        }

        // calculate the inserted image size

        $qrSize = $request->size;


        if ($type == 'image' && extension_loaded('imagick')) {
            $imageSize = $request->image_size;
            $insertedImgSize = ($qrSize * $imageSize) / 100;
            // inserting image using Image Intervention & saving the qr code in folder
            if ($request->hasFile('image')) {

                $qr = Image::make(in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id)  && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($directory . $qrImage) ? Storage::disk('s3')->url($directory . $qrImage) : public_path($directory . $qrImage));
                $logo = Image::make(in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($directory . $mergedImage) ? Storage::disk('s3')->url($directory . $mergedImage) : public_path($directory . $mergedImage));
                $logo->resize(null, $insertedImgSize, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $logoWidth = $logo->width();
                $logoHeight = $logo->height();
                $qr->insert($logo, 'top-left', (int) (((($qrSize - $logoWidth) * $request->image_x) / 100)), (int) (((($qrSize - $logoHeight) * $request->image_y) / 100)));
                $qr->save(public_path($directory) . $qrImage);
                if (in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {

                    setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
                    Storage::disk('s3')->putFileAs($directory, new File(public_path($directory . $qrImage)), $qrImage);
                    @unlink($directory . $qrImage);
                }
            } else {

                if (!empty($table->image) && file_exists('./' . asset($directory) . $table->image)) {
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
            if (in_array("Amazon AWS s3", $data)  && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
                setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
                Storage::disk('s3')->putFileAs($directory, new File(public_path($directory . $qrImage)), $qrImage);
                @unlink($directory . $qrImage);
            }
        }

        // store the params in database

        $table->color = $request->color;

        $table->size = $request->size;

        $table->style = $request->style;

        $table->eye_style = $request->eye_style;

        $table->qr_image = $qrImage;

        $table->type = $type;

        if ($type == 'image') {
            $table->image_size = $imageSize;
            $table->image_x = $request->image_x;
            $table->image_y = $request->image_y;
        }

        if ($type == 'text' && !empty($request->text)) {
            $table->text = $request->text;
            $table->text_color = $request->text_color;
            $table->text_size = $request->text_size;
            $table->text_x = $request->text_x;
            $table->text_y = $request->text_y;
        }
        $table->margin = $request->margin;
        $table->save();
        return in_array("Amazon AWS s3", $data) && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($directory . $qrImage) ? Storage::disk('s3')->url($directory . $qrImage) : url($directory . $qrImage);
    }
    public function download($name)
    {
        $userId = getRootUser()->id;
        $bs = AdminBs::select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();
        $userbs = BasicSetting::query()->where('user_id', $userId)
            ->select('storage_usage')
            ->first();

        $data = UserPermissionHelper::currentPackageFeatures($userId);

        $pathToFile = Constant::WEBSITE_TABLE_IMAGE . '/' . $name;
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
