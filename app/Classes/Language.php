<?php

namespace App\Classes;

use App\Models\ContactSetting;
use App\Models\Language as LangModel;
use App\Models\Menu;
use App\Models\MenuValue;
use App\Models\Value;
use App\Models\ValueDetail;
use Illuminate\Support\Facades\DB;

class Language
{
    public static function getLanguages()
    {
        return LangModel::get();
    }

    public static function addedLanguageProcess(LangModel $lang)
    {
        $defalutLang = LangModel::where('is_default', true)->first();
        $menus = Menu::with('values.value')->where('language_id', $defalutLang->id);
        $menuIds = $menus->pluck('id');
        $menus = $menus->get();
        foreach ($menus as $menu) {
            $createMenu = [
                "language_id" => $lang->id,
                "brother_id" => $menu->brother_id,
                "parent_id" => null,
                "type_id" => $menu->type_id,
                "name" => $menu->name,
                "description" => null,
                "imagePath" => null,
                "filePath" => null,
                "url" => $menu->url,
                "permalink" => createPermalink(new Menu, "permalink", $menu->name, null),
                "sort" => $menu->sort,
            ];
            Menu::create($createMenu);
        }
        $values = Value::where('language_id', $defalutLang->id)->get();
        foreach ($values as  $value) {
            $createValue = [
                "language_id" => $lang->id,
                "brother_id" => $value->brother_id,
                "type_id" => $value->type_id,
                "name" => $value->name,
                "permalink" => createPermalink(new Value, "permalink", $value->name, null),
                "sort" => $value->sort,
            ];
            Value::create($createValue);
        }
        $menuValues = MenuValue::with('value', 'menu.type')->whereHas('menu')->whereHas('value')->whereIn('menu_id', $menuIds)->get();
        foreach ($menuValues as $mv) {
            if ($mv->menu->type) {
                $nmenu = Menu::where('brother_id', $mv->menu->brother_id)->where('language_id', $lang->id)->first();
                $nvalue = Value::where('brother_id', $mv->value->brother_id)->where('language_id', $lang->id)->first();
                if ($nvalue && $nmenu) {
                    MenuValue::create([
                        "menu_id" => $nmenu->id,
                        "value_id" => $nvalue->id,
                        "type_id" => $mv->menu->type->id,
                    ]);
                }
            }
        }
        $contacts = ContactSetting::where('language_id', LangModel::where('is_default', true)->first()->id)->get();
        foreach ($contacts as  $contact) {
            ContactSetting::create([
                "type_id" => $contact->type_id,
                "language_id" => $lang->id,
                "brother_id" => $contact->id,
                "name" => $lang->text,
                "sort" => 0,
            ]);
        }
        if (!file_exists(lang_path($lang->key . ".json"))) {
            fopen(lang_path($lang->key . ".json"), "w");
            file_put_contents(lang_path($lang->key . ".json"), "[]");
        }
        return true;
    }
    public static function deletedLanguageProcess(LangModel $lang)
    {
        $defalutLang = LangModel::where('is_default', true)->first();
        $menuIds = Menu::where('language_id', $lang->id)->pluck('id');
        MenuValue::whereIn('menu_id', $menuIds)->delete();
        $values = Value::where('language_id', $lang->id)->get();
        foreach ($values as $value) {
            ValueDetail::where('model_id', $value->id)->delete();
            $value->delete();
        }
        Menu::where('language_id', $lang->id)->delete();
        ContactSetting::where('language_id', $lang->id)->delete();
        if (file_exists(lang_path($lang->key . ".json"))) {
            unlink(lang_path($lang->key . ".json"));
        }
        return true;
    }
}
