<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Value;
use App\Models\ValueDetail;
use Illuminate\Http\Request;

class FileController extends Controller
{
    function saveFiles(Request $request)
    {

        $returnArray = [
            "selector" => $request->selector
        ];
        $editMode = $request->header('edit_mode') == "true" ? true : false;
        $files = $request->file('file');
        $destination = public_path('files/media');
        if ($editMode) {
            $value_id = $request->header('value_id');
            $value = Value::with('language')->find($value_id);
            foreach ($files as $key =>  $file) {
                $fileSize = $file->getSize();
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = md5($key . $value->language->id) . date('YmdHis') . "." . $extension;
                $tmpname = $file->getPathName();
                //$file->move($destination, $fileName);
                copy($tmpname, $destination . "/" . $fileName);
                $createdFile = File::create([
                    "language_id" => $value->language->id,
                    "value_detail_id" => null,
                    "original_name" => $originalName,
                    "extension" => $extension,
                    "size" => $fileSize,
                    "path" => "/files/media/" . $fileName,
                    "sort" => 0
                ]);
                $returnArray["files"][] = $createdFile;
            }
        } else {
            foreach ($files as $key =>  $file) {
                foreach ($this->languages as $lang) {
                    $fileSize = $file->getSize();
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $fileName = md5($key . $lang->id) . date('YmdHis') . "." . $extension;
                    $tmpname = $file->getPathName();
                    //$file->move($destination, $fileName);
                    copy($tmpname, $destination . "/" . $fileName);
                    $createdFile = File::create([
                        "language_id" => $lang->id,
                        "value_detail_id" => null,
                        "original_name" => $originalName,
                        "extension" => $extension,
                        "size" => $fileSize,
                        "path" => "/files/media/" . $fileName,
                        "sort" => 0
                    ]);
                    $returnArray["files"][] = $createdFile;
                }
            }
        }
        return response()->json($returnArray);
    }


    function removeFile($id = null)
    {
        if (!$id) {
            return response()->json("Dosya bulunamadı.", 400);
        }
        $file = File::find($id);
        if (!$file) {
            return response()->json("Dosya bulunamadı.", 400);
        }
        if (file_exists(substr($file->path, 1))) {
            unlink(substr($file->path, 1));
        }
        $file->delete();
        return response()->json("İşlem başarılı.");
    }

    function sort(Request $request)
    {
        foreach ($request->data as $key => $item) {
            File::where('id', $item)->update(['sort' => $key]);
        }
    }
}
