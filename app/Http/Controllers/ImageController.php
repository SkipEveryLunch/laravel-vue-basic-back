<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\imageUploadRequest;

class ImageController extends Controller
{
    public function upload(imageUploadRequest $req){
        $file = $req->file("image");
        $name = Str::random(10);
        $url = \Storage::putFileAs("images",$file,
        $name . "." . $file->extension());
        return ["url" => 
        env("APP_URL") . "/" . $url];
    }
}
