<?php

namespace App\Http\Controllers;

use App\Classes\CmsHelper;
use App\Models\ContactSetting;
use App\Models\Field;
use App\Models\File;
use App\Models\Form;
use App\Models\Language;
use App\Models\Menu;
use App\Models\MenuValue;
use App\Models\Type;
use App\Models\Value;
use App\Models\ValueDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ValueController extends Controller
{
    public function index($type_id, Request $request)
    {
        $langs = Language::get();
        $lang_ids = $langs->pluck('id')->toArray();

        $type = Type::find($type_id);
        if (!$type) {
            return redirect()->back()->withErrors(["Tip bulunamadı!"]);
        }
        if ($type->model != "App\Models\Value") {
            if ($type->model == "App\Models\ContactSetting") {
                $values = ContactSetting::where('type_id', $type->id);
            }
            if ($type->model == "App\Models\Form") {
                $values = Form::where('type_id', $type->id);
            }
        } else {
            $values = Value::with('menus.menu')->where('type_id', $type->id);
        }
        if ($request->lang && in_array($request->lang, $lang_ids)) {
            $values = $values->where('language_id', $request->lang);
        } else {
            $values = $values->where('language_id', $this->defLang->id);
        }
        $values = $values->orderBy('sort', 'ASC');
        if ($request->all) {
            $values = $values->paginate(100000);
        } else {
            $values = $values->paginate(25);
        }
        return view('admin.values.index', compact('type', 'values', 'langs'));
    }

    public function create($type_id)
    {
        $type = Type::find($type_id);
        if (!$type) {
            return redirect()->back()->withErrors(["Tip bulunamadı!"]);
        }
        if ($type->model != "App\Models\Value") {
            if ($type->model == "App\Models\ContactSetting") {
                return redirect()->route('admin.contact-settings.create', $type->id);
            }
            if ($type->model == "App\Models\Form") {
                return redirect()->route('admin.form.create', $type->id);
            }
        } else {
            $selectableMenus = Menu::where('type_id', $type->id)->where('language_id', $this->defLang->id)->get();
            $files = Field::where('type_id', $type_id)->whereIn('type', ['input|file|single', 'type', 'input|file|multiple'])->get();
            $editors = Field::where('type_id', $type_id)->where('type', 'textarea|editor')->get();
            return view('admin.values.create', compact('type', 'files', 'editors', 'selectableMenus'));
        }
    }

    public function store($type_id, Request $request)
    {
        $type = Type::with('fields')->where('id', $type_id)->first();
        if (!$type) {
            return redirect()->back()->withErrors(["Tip bulunamadı!"]);
        }
        DB::beginTransaction();
        $brother_id = getBrotherId(new Value, null);
        $created_value_id = null;
        foreach ($this->languages as $lngKey =>  $lang) {
            $sort = Value::where('type_id', $type->id)->orderBy('sort', 'DESC')->where('language_id', $lang->id)->first();
            if ($sort) {
                $sort = ($sort->sort + 1);
            }
            else{
                $sort = 0;
            }
            $value_data = [
                "language_id" => $lang->id,
                "brother_id" => $brother_id,
                "type_id" => $type->id,
                "name" => $request->value_name,
                "permalink" => createPermalink(new Value, "permalink", $request->value_name, null),
                "sort" => $sort
            ];
            $created_value = Value::create($value_data);
            if ($lngKey == 0) {
                $created_value_id = $created_value->id;
            }
            foreach ($type->fields as $field) {
                if (explode('|', $field->type)[1] == "file") {
                    $createdDetail = ValueDetail::create([
                        "field_id" => $field->id,
                        "valueModel" =>  $type->model,
                        "model_id" => $created_value->id,
                        "value" => null
                    ]);
                    if (isset($request->fields[$field->key][$lang->key])) {
                        File::whereIn('id', $request->fields[$field->key][$lang->key])->update([
                            'value_detail_id' => $createdDetail->id
                        ]);
                    }
                } else {
                    ValueDetail::create([
                        "field_id" => $field->id,
                        "valueModel" => $type->model,
                        "model_id" => $created_value->id,
                        "value" => $request->fields[$field->key] ?? null
                    ]);
                }
            }
            if (isset($request->menu_id)) {
                foreach ($request->menu_id as $menu) {
                    $M = Menu::find($menu);
                    $reelMenu = Menu::where('brother_id', $M->brother_id)->where('language_id', $lang->id)->first();
                    if ($reelMenu) {
                        MenuValue::create([
                            "menu_id" => $reelMenu->id,
                            "value_id" => $created_value->id,
                            "type_id" => $type->id,
                        ]);
                    }
                }
            }
        }
        DB::commit();
        return redirect()->route('admin.value.edit', [$created_value_id, $type->id])->with('success', "İşlem başarılı.");
    }
    public function edit(string $id, string $type_id)
    {
        $type = Type::find($type_id);
        if (!$type) {
            return redirect()->back()->withErrors(["Tip bulunamadı!"]);
        }
        if ($type->model != "App\Models\Value") {
            if ($type->model == "App\Models\ContactSetting") {
                $ContactSetting = ContactSetting::find($id);
                if ($ContactSetting) {
                    return redirect()->route('admin.contact-settings.edit', $ContactSetting->id);
                }
            }
            if ($type->model == "App\Models\Form") {
                $Form = Form::find($id);
                if ($Form) {
                    return redirect()->route('admin.form.edit', $Form->id);
                }
            }
            return redirect()->back()->withErrors(["Kayıt bulunamadı!"]);
        } else {
            $value = Value::with('type', 'details.field', 'menus.menu', 'language')->where('id', $id)->first();
            if (!$value) {
                return redirect()->back()->withErrors(["Kayıt bulunamadı!"]);
            }
            $selectableMenus = Menu::where('type_id', $value->type->id)->where('language_id', $value->language->id)->get();
            $detail = getValueDetail($value);
            $files = Field::where('type_id', $value->type->id)->whereIn('type', ['input|file|single', 'type', 'input|file|multiple'])->get();
            $editors = Field::where('type_id', $value->type_id)->where('type', 'textarea|editor')->get();
            $brothers = Value::with('language')->where('brother_id', $value->brother_id)->where('id', '!=', $value->id)->get();
            return view('admin.values.edit', compact('value', 'detail', 'files', 'editors', 'brothers', 'selectableMenus', 'type'));
        }
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            "value_name" => ["required"],
        ]);
        $value = Value::with('type.fields', 'language')->find($id);
        if (!$value) {
            return redirect()->back()->withErrors(["Kayıt bulunamadı!"]);
        }
        DB::beginTransaction();
        $value->update([
            "name" => $request->value_name,
            "permalink" => createPermalink(new Value, "permalink", $request->value_name, $value->id)
        ]);
        foreach ($value->type->fields as $field) {
            $value_detail = ValueDetail::updateOrCreate(
                [
                    "field_id" => $field->id,
                    "valueModel" => $value->type->model,
                    "model_id" => $value->id,
                ],
                [
                    "value" => explode('|', $field->type)[1] == "file" ? null : ($request->fields[$field->key] ?? null)
                ]
            );
            if (explode('|', $field->type)[1] == "file") {
                if (isset($request->fields[$field->key][$value->language->key])) {
                    File::whereIn('id', $request->fields[$field->key][$value->language->key])->update([
                        'value_detail_id' => $value_detail->id
                    ]);
                }
            }
        }
        if ($request->menu_id) {
            MenuValue::where('value_id', $value->id)->whereNotIn('menu_id', $request->menu_id)->delete(); //olmayan menüleri pivot tablodan siliyor
            foreach ($request->menu_id as $m) {
                $data = MenuValue::where('value_id', $value->id)->where('menu_id', $m)->first();
                if (!$data) {
                    MenuValue::create([
                        "menu_id" => $m,
                        "value_id" => $value->id,
                        "type_id" => $value->type->id
                    ]);
                }
            }
        } else {
            MenuValue::where('value_id', $value->id)->where('type_id', $value->type->id)->delete(); //olmayan menüleri pivot tablodan siliyor
        }
        DB::commit();
        return redirect()->route('admin.value.edit', [$value->id, $value->type->id])->with('success', 'Başarıyla Güncellendi.');
    }
    public function destroy(string $id, $type_id)
    {
        $type = Type::find($type_id);
        if (!$type) {
            return redirect()->back()->withErrors(["Tip bulunamadı!"]);
        }
        if ($type->model != "App\Models\Value") {
            if ($type->model == "App\Models\ContactSetting") {
                $ContactSetting = ContactSetting::find($id);
                if ($ContactSetting) {
                    return redirect()->route('admin.contact-settings.destroy', $ContactSetting->id);
                }
                return redirect()->back()->withErrors(["Kayıt bulunamadı!"]);
            }
            if ($type->model == "App\Models\Form") {
                $Form = Form::find($id);
                if ($Form) {
                    return redirect()->route('admin.form.destroy', $Form->id);
                }
                return redirect()->back()->withErrors(["Kayıt bulunamadı!"]);
            }
        } else {
            $value = Value::with('type')->where('id', $id)->first();
            if (!$value) {
                return redirect()->back()->withErrors(["Kayıt bulunamadı!"]);
            }
            $type_id = $value->type->id;
            DB::beginTransaction();
            $Values = Value::where('brother_id', $value->brother_id)->get();
            $valuesIds = $Values->pluck('id');
            MenuValue::whereIn('value_id', $valuesIds)->where('type_id', $value->type->id)->delete(); //olmayan menüleri pivot tablodan siliyor
            $valueDetails = ValueDetail::with('field')->whereIn('model_id', $valuesIds)->where('valueModel', $value->type->model)->get();
            foreach ($valueDetails as $vDetail) {
                if ($vDetail->field->type == "input|file|single" || $vDetail->field->type == "input|file|multiple") {
                    $Files = File::where('value_detail_id', $vDetail->id)->get();
                    foreach ($Files as $file) {
                        if (file_exists(substr($file->path, 1))) {
                            unlink(substr($file->path, 1));
                        }
                        $file->delete();
                    }
                    $vDetail->delete();
                } else {
                    $vDetail->delete();
                }
            }
            foreach ($Values as $v) {
                $v->delete();
            }
            DB::commit();
            return redirect()->route('admin.value.index', $type_id)->with('success', "Silme işlemi başarılı");
        }
    }

    function sort(Request $request, $type_id)
    {
        $type = Type::find($type_id);
        if (!$type) {
            return response()->json("Tip bulunamadı!", 400);
        }
        if ($type->model == "App\Models\Value") {
            foreach ($request->data as $key => $item) {
                Value::where('id', $item)->update(['sort' => $key]);
            }
        } elseif ($type->model == "App\Models\ContactSetting") {
            foreach ($request->data as $key => $item) {
                ContactSetting::where('id', $item)->update(['sort' => $key]);
            }
        } elseif ($type->model == "App\Models\Form") {
            foreach ($request->data as $key => $item) {
                Form::where('id', $item)->update(['sort' => $key]);
            }
        }
    }
}
