<?php

namespace App\Http\Controllers;

use App\Models\VRResources;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VRUploadController extends Controller
{
    public function upload(UploadedFile $file, $id)
    {
        $data =
            [
                "size" => $file->getSize(),
                "mime_type" => $file->getMimeType(),
                "path" => $file->getPath(),
            ];

        $path = 'upload/' . date ("Y/m/d/");

        $fileName = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();

        $file->move(public_path($path), $fileName);

        $data["path"] = $path . $fileName;



        if($id == null)
        {
            return VRResources::create($data);

        } elseif($id != null){

            $record = VRResources::find($id);

            $record->update($data);

            return $record;
        }

    }
}