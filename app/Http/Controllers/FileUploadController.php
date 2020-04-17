<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    //
    public function uploadFile(Request $request)
    {
        $milliseconds = round(microtime(true) * 1000);
        if ($request->has('photo')) {
            $file_name = $milliseconds . '.jpg';
            $path = $request->file('photo')->move(public_path("/images"), $file_name);
            $photo_url = url('/images/' . $file_name);
            echo $file_name;
//            return response()->json([
//                'code' => Response::HTTP_OK, 'message' => "false", 'url' => $file_name
//                ,
//            ], Response::HTTP_OK);
        } else if ($request->has('video')) {
            $file_name = $milliseconds . '.mp4';
            $path = $request->file('video')->move(public_path("/videos"), $file_name);
            $photo_url = url('/videos/' . $file_name);
            echo $file_name;
//            return response()->json([
//                'code' => Response::HTTP_OK, 'message' => "false", 'url' => $file_name
//                ,
//            ], Response::HTTP_OK);
        } else if ($request->has('audio')) {
            $file_name = $milliseconds . '.mp3';
            $path = $request->file('audio')->move(public_path("/audio"), $file_name);
            $photo_url = url('/audio/' . $file_name);
            echo $file_name;
//            return response()->json([
//                'code' => Response::HTTP_OK, 'message' => "false", 'url' => $file_name
//                ,
//            ], Response::HTTP_OK);
        } else if ($request->has('document')) {
            $file_name = $milliseconds . $request->extension;

            $path = $request->file('document')->move(public_path("/document"), $file_name);
            $photo_url = url('/document/' . $file_name);
            echo $file_name;

        } else {
            return response()->json([
                'code' => 401, 'message' => "false", 'url' => "sdfsdfsd"
                ,
            ], 401);

        }

    }
}
