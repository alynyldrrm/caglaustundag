<?php

namespace App\Http\Controllers;

use App\Models\ContactSetting;
use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Facades\DB;

class ContactSettingsController extends Controller
{

    function create($type_id)
    {
        $type = Type::find($type_id);
        if (!$type) {
            return redirect()->back()->withErrors(['Tip bulunamadı!']);
        }
        return view('admin.contactSettings.create', compact('type'));
    }
    function store($type_id, Request $request)
    {
        $type = Type::find($type_id);
        if (!$type) {
            return redirect()->back()->withErrors(['Tip bulunamadı!']);
        }
        DB::beginTransaction();
        $brother_id = getBrotherId(new ContactSetting, null);
        foreach ($this->languages as $language) {
            $data = [
                "name" => $request->name,
                "city" => $request->city,
                "town" => $request->town,
                "phone" => $request->phone,
                "email" => $request->email,
                "address" => $request->address,
                "iframe_code" => $request->iframe_code,
                "type_id" => $type->id,
                "language_id" => $language->id,
                "brother_id" => $brother_id,
                "sort" => 0,
            ];
            ContactSetting::create($data);
        }
        DB::commit();
        return redirect()->route('admin.value.index', $type->id);
    }
    function edit($id = 0)
    {
        $setting = ContactSetting::with('language', 'type')->where('id', $id)->first();
        if (!$setting) {
            return redirect()->back()->withErrors(['Kayıt Bulunamadı!']);
        }
        $type = $setting->type;
        $brothers = ContactSetting::where('brother_id', $setting->brother_id)->where('id', '!=', $setting->id)->get();
        return view('admin.contactSettings.edit', compact('setting', 'brothers', 'type'));
    }
    function update($id = 0, Request $request)
    {
        $data = ContactSetting::with('type')->find($id);
        if (!$data) {
            return redirect()->back()->withErrors(['Kayıt Bulunamadı!']);
        }
        $data->update($request->all());
        return redirect()->route('admin.value.index', $data->type->id);
    }

    function destroy($id)
    {
        $setting = ContactSetting::with('type')->find($id);
        if (!$setting) {
            return redirect()->back()->withErrors(['Kayıt Bulunamadı!']);
        }
        $type_id = $setting->type->id;
        ContactSetting::where('brother_id', $setting->brother_id)->delete();
        return redirect()->route('admin.value.index', $type_id)->with('success', 'Güncelleme işlemi başarılı.');
    }
}
