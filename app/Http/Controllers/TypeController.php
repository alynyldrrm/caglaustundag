<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\File;
use App\Models\Menu;
use App\Models\MenuValue;
use App\Models\Type;
use App\Models\Value;
use App\Models\ValueDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{

    public function index()
    {
        $types = Type::orderBy("sort", "ASC")->get();
        return view('admin.types.index', compact('types'));
    }


    public function create()
    {
        return view('admin.types.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            "single_name" => ["required", "string"],
            "multiple_name" => ["required", "string"],
            "model" => ["required", "string"],
            "rendered_view" => ["nullable", "string"],
            "is_hidden" => ["required", "in:true,false"]
        ]);
        $is_hidden = $request->is_hidden == "true" ? true : false;
        $typeData = [
            "single_name" => $request->single_name,
            "multiple_name" => $request->multiple_name,
            "model" => $request->model,
            "is_hidden" => $is_hidden,
            "rendered_view" => $request->rendered_view,
            "sort" => 0,
            "permalink" => createPermalink(new Type, "permalink", $request->multiple_name, null),
        ];
        DB::beginTransaction();
        $createdType = Type::create($typeData);
        if (isset($request->key)) {
            foreach ($request->key as $key => $item) {
                $fieldData = [
                    "type_id" => $createdType->id,
                    "sort" => 0,
                ];
                if (isset($item) && $item != null) {
                    $fieldData["key"] = $item;
                    $fieldData["name"] = isset($request->name) ? (isset($request->name[$key]) ? $request->name[$key] : null) : null;
                    $fieldData["type"] = isset($request->type) ? (isset($request->type[$key]) ? $request->type[$key] : null) : null;
                    $fieldData["attr"] = isset($request->attr) ? (isset($request->attr[$key]) ? $request->attr[$key] : null) : null;
                    $fieldData["values"] = isset($request->values) ? (isset($request->values[$key]) ? $request->values[$key] : null) : null;
                    Field::create($fieldData);
                }
            }
        }
        DB::commit();
        return response()->json(["status" => "success", "redirect" => route('admin.type.edit', $createdType->id)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $type = Type::with("fields")->where('id', $id)->first();
        if (!$type) {
            return redirect()->route('admin.type.index')->withErrors(["Tip bulunamadı!"]);
        }
        return view('admin.types.edit', compact('type'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            "single_name" => ["required", "string"],
            "multiple_name" => ["required", "string"],
            "model" => ["required", "string"],
            "rendered_view" => ["nullable", "string"],
            "is_hidden" => ["required", "in:true,false"]
        ]);
        $type = Type::where('id', $id)->with("fields")->first();
        if (!$type) {
            return response()->json(["Kayıt bulunamadı!"], 400);
        }
        $is_hidden = $request->is_hidden == "true" ? true : false;
        $typeData = [
            "single_name" => $request->single_name,
            "multiple_name" => $request->multiple_name,
            "model" => $request->model,
            "is_hidden" => $is_hidden,
            "rendered_view" => $request->rendered_view,
            "sort" => 0,
            "permalink" => createPermalink(new Type, "permalink", $request->multiple_name, $type->id),
        ];
        DB::beginTransaction();
        $type->update($typeData);
        if (isset($request->fieldIds)) {
            $deletedFields = Field::where('type_id', $type->id)->whereNotIn('id', $request->fieldIds)->get(); //Silinen fieldları siliyor
            $deletedFieldIds = $deletedFields->pluck('id');
            $deletedValueDetails = ValueDetail::with('field')->whereIn('field_id', $deletedFieldIds)->get();
            foreach ($deletedValueDetails as $deletedVdetail) {
                if ($deletedVdetail->field->type == "input|file|single" || $deletedVdetail->field->type == "input|file|multiple") {
                    $deletedFiles = File::where('value_detail_id', $deletedVdetail->id)->get();
                    foreach ($deletedFiles as $deletedFile) {
                        if (file_exists(substr($deletedFile->path, 1))) {
                            unlink(substr($deletedFile->path, 1));
                        }
                        $deletedFile->delete();
                    }
                    $deletedVdetail->delete();
                } else {
                    $deletedVdetail->delete();
                }
            }
            foreach ($request->fieldIds as $key => $f) {
                if ($f != null) {
                    //Mevcut fieldları güncelliyor
                    $field = Field::find($f);
                    if ($field) {
                        $fieldData = [];
                        if (isset($request->key) && isset($request->key[$key]) && $request->key[$key] != null) {
                            $fieldData["key"] = $request->key[$key];
                            $fieldData["name"] = isset($request->name) ? (isset($request->name[$key]) ? $request->name[$key] : null) : null;
                            $fieldData["type"] = isset($request->type) ? (isset($request->type[$key]) ? $request->type[$key] : null) : null;
                            $fieldData["attr"] = isset($request->attr) ? (isset($request->attr[$key]) ? $request->attr[$key] : null) : null;
                            $fieldData["values"] = isset($request->values) ? (isset($request->values[$key]) ? $request->values[$key] : null) : null;
                            $field->update($fieldData);
                        }
                    }
                } else {
                    //yeni fieldları ekliyor
                    $fieldData = [
                        "type_id" => $type->id,
                        "sort" => 0,
                    ];
                    if (isset($request->key[$key]) && $request->key[$key] != null) {
                        $fieldData["key"] = $request->key[$key];
                        $fieldData["name"] = isset($request->name) ? (isset($request->name[$key]) ? $request->name[$key] : null) : null;
                        $fieldData["type"] = isset($request->type) ? (isset($request->type[$key]) ? $request->type[$key] : null) : null;
                        $fieldData["attr"] = isset($request->attr) ? (isset($request->attr[$key]) ? $request->attr[$key] : null) : null;
                        $fieldData["values"] = isset($request->values) ? (isset($request->values[$key]) ? $request->values[$key] : null) : null;
                        Field::create($fieldData);
                    }
                }
            }
            foreach ($deletedFields as $df) {
                $df->delete();
            }
        } else {
            Field::where('type_id', $type->id)->delete();
        }

        DB::commit();
        return response()->json([
            "status" => "success",
            "redirect" => route('admin.type.index'),
        ]);
    }


    public function destroy(string $id)
    {
        $type = Type::find($id);
        if (!$type) {
            return redirect()->route('admin.type.index')->withErrors(["Tip Bulunamadı."]);
        }
        DB::beginTransaction();
        Value::where('type_id', $type->id)->delete();
        $fields = Field::where('type_id', $type->id)->get();
        foreach ($fields as $field) {
            if ($field->type == "input|file|single" || $field->type == "input|file|multiple") {
                $valueDetails = ValueDetail::where('field_id', $field->id)->get();
                foreach ($valueDetails as $vDetail) {
                    $files = File::where('value_detail_id', $vDetail->id)->get();
                    foreach ($files as $file) {
                        if (file_exists(substr($file->path, 1))) {
                            unlink(substr($file->path, 1));
                        }
                        $file->delete();
                    }
                    $vDetail->delete();
                }
            } else {
                ValueDetail::where('field_id', $field->id)->delete();
            }
            $field->delete();
        }
        MenuValue::where('type_id', $type->id)->delete();
        Menu::where('type_id', $type->id)->update(["type_id" => null]);
        $type->delete();
        DB::commit();
        return redirect()->route('admin.type.index')->with('success', "İşlem başarılı.");
    }

    function sort(Request $request)
    {
        foreach ($request->data as $key => $item) {
            Type::where('id', $item)->update(["sort" => $key]);
        }

        return true;
    }

    function field_sort(Request $request)
    {
        foreach ($request->data as $key => $item) {
            Field::where('id', $item)->update(["sort" => $key]);
        }

        return true;
    }
}
