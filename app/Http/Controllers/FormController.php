<?php

namespace App\Http\Controllers;
use App\Models\Form;
use App\Models\FormAnswer;
use App\Models\Menu;
use App\Models\MenuValue;
use App\Models\Type;
use Illuminate\Http\Request;

class FormController extends Controller
{
    function show($id)
    {
        $form = Form::with('type', 'language', 'answers')->find($id);
        if (!$form) {
            return redirect()->back()->withErrors(['Form bulunamadı!']);
        }
        $brothers = Form::where('brother_id', $form->brother_id)->where('id', '!=', $form->id)->get();

        return view('admin.forms.show', compact('form', 'brothers'));
    }
    function create($type_id)
    {
        $type = Type::find($type_id);
        if (!$type) {
            return redirect()->back()->withErrors(['Tip bulunamadı!']);
        }
        $selectableMenus = Menu::where('type_id', $type->id)->where('language_id', $this->defLang->id)->get();
        return view('admin.forms.create', compact('type', 'selectableMenus'));
    }
    function store($type_id, Request $request)
    {
        $request->validate([
            "form_name" => ["required"],
        ]);

        $type = Type::find($type_id);
        if (!$type) {
            return redirect()->back()->withErrors(['Tip bulunamadı!']);
        }
        $data = [];
        if (isset($request->name)) {
            $names = $request->name;
            $types = $request->type;
            $attrs = $request->attr;
            $values = $request->values;
            foreach ($names as $key => $name) {
                if (trim($name) != "" && $name != null) {
                    $pushArray = [
                        "id" => uniqid(),
                        "name" => $name,
                        "field" => isset($types[$key]) ? $types[$key] : null,
                        "attr" => isset($attrs[$key]) ? $attrs[$key] : null,
                        "values" => isset($values[$key]) ? $values[$key] : null,
                    ];
                    array_push($data, $pushArray);
                }
            }
        }

        $questions = json_encode($data);
        $brother_id = getBrotherId(new Form, null);
        foreach ($this->languages as $lang) {
            $created_value = Form::create([
                "language_id" => $lang->id,
                "brother_id"  => $brother_id,
                "type_id" => $type->id,
                "name" => $request->form_name,
                "questions" => $questions,
                "success_message" => $request->success_message,
                "error_message" => $request->error_message,
                "permalink" => createPermalink(new Form, "permalink", $request->form_name, null),
                "sort" => 0
            ]);
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

        return redirect()->route('admin.value.index', $type->id)->with('success', "Form başarıyla oluşturuldu.");
    }
    function edit($id)
    {
        $form = Form::with('type', 'language')->find($id);
        if (!$form) {
            return redirect()->back()->withErrors(['Form bulunamadı!']);
        }
        $selectableMenus = Menu::where('type_id', $form->type->id)->where('language_id', $form->language->id)->get();
        $selectedMenus = [];
        $selectedMenusQuery = MenuValue::whereHas('form', function ($q) use ($form) {
            return $q->where('id', $form->id);
        })->where('type_id', $form->type->id)->get();
        foreach ($selectedMenusQuery as $sMenu) {
            array_push($selectedMenus, $sMenu->menu_id);
        }
        $questions = json_decode($form->questions, true);
        $brothers = Form::where('brother_id', $form->brother_id)->where('id', '!=', $form->id)->get();
        $type = $form->type;
        return view('admin.forms.edit', compact('form', 'questions', 'brothers', 'type', 'selectableMenus', 'selectedMenus'));
    }
    function update($id, Request $request)
    {
        $form = Form::with('type')->find($id);
        if (!$form) {
            return redirect()->back()->withErrors(['Form bulunamadı!']);
        }
        $names = $request->name;
        $types = $request->type;
        $attrs = $request->attr;
        $values = $request->values;
        $data = [];
        if ($names) {
            foreach ($names as $key => $name) {
                if (trim($name) != "" && $name != null) {
                    $pushArray = [
                        "id" => uniqid(),
                        "name" => $name,
                        "field" => isset($types[$key]) ? $types[$key] : null,
                        "attr" => isset($attrs[$key]) ? $attrs[$key] : null,
                        "values" => isset($values[$key]) ? $values[$key] : null,
                    ];
                    array_push($data, $pushArray);
                }
            }

            $form->update([
                "name" => $request->form_name,
                "permalink" => createPermalink(new Form, "permalink", $request->form_name, $form->id),
                "success_message" => $request->success_message,
                "error_message" => $request->error_message,
                "questions" => json_encode($data),
            ]);
        } else {
            $form->update([
                "name" => $request->form_name,
                "permalink" => createPermalink(new Form, "permalink", $request->form_name, $form->id),
                "success_message" => $request->success_message,
                "error_message" => $request->error_message,
                "questions" => null,
            ]);
        }
        if ($request->menu_id) {
            MenuValue::where('value_id', $form->id)->whereNotIn('menu_id', $request->menu_id)->where('type_id', $form->type->id)->delete(); //olmayan menüleri pivot tablodan siliyor
            foreach ($request->menu_id as $m) {
                $data = MenuValue::where('value_id', $form->id)->where('menu_id', $m)->where('type_id', $form->type->id)->first();
                if (!$data) {
                    MenuValue::create([
                        "menu_id" => $m,
                        "value_id" => $form->id,
                        "type_id" => $form->type->id
                    ]);
                }
            }
        } else {
            MenuValue::where('value_id', $form->id)->where('type_id', $form->type->id)->delete(); //olmayan menüleri pivot tablodan siliyor
        }
        return redirect()->route('admin.form.edit', $form->id)->with('success', "Form başarıyla güncelledi.");
    }
    function destroy($id)
    {
        $form = Form::with('type')->find($id);
        if (!$form) {
            return redirect()->back()->withErrors(['Form bulunamadı!']);
        }
        $formIds = Form::where('brother_id', $form->brother_id)->pluck('id')->toArray();
        Form::whereIn('id', $formIds)->delete();
        FormAnswer::whereIn('form_id', $formIds)->forceDelete();
        MenuValue::whereIn('value_id', $formIds)->where('type_id', $form->type->id)->delete(); //olmayan menüleri pivot tablodan siliyor
        return redirect()->route('admin.value.index', $form->type->id)->with('success', "Silme işlemi başarılı.");
    }
    function sort($form_id, Request $request)
    {
        $form = Form::find($form_id);
        if (!$form) {
            return response()->json("Form Bulunamadı!", 400);
        }
        $newArr = [];
        $questions = json_decode($form->questions, true);
        foreach ($request->data as $uniqid) {
            $item = array_search($uniqid, array_column($questions, "id"));
            array_push($newArr, $questions[$item]);
        }
        if (count($newArr) == count($questions)) {
            $form->update(["questions" => json_encode($newArr)]);
        }
        return true;
    }

    function exportExcel($id)
    {
        $form = Form::with('type', 'language', 'answers')->find($id);
        if (!$form) {
            return redirect()->back()->withErrors(['Form bulunamadı!']);
        }
        exportExcelFromForm($form);
        return redirect()->back()->with('success', "Excel başarıyla indirildi.");
    }
}
