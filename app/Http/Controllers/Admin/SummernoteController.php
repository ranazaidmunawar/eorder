<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SummernoteController extends Controller
{
    protected string $path ;

    public function __construct()
    {
        $this->path = 'assets/front/img/summernote';
    }

    public function upload(Request $request): string
    {
        $filename = upload_picture($this->path,$request->file('image'));
        return url('/') . public_path("/assets/front/img/summernote/") . $filename;
    }
}
