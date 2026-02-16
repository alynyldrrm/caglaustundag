<?php

namespace App\Http\Controllers;

use App\Classes\CmsTranslation;
use Illuminate\Http\Request;



class TranslationController extends Controller
{
    public function index()
    {
        $data = [];
        $tKeys = CmsTranslation::getTranslableItems();
        foreach ($this->languages as $language) {
            if (!isset($data[$language->key])) {
                $data[$language->key] = json_decode(file_get_contents(lang_path($language->key . ".json")), true);
            }
        }
        return view('admin.translations.index', compact('data'));
    }
    function scan()
    {
        $translations = CmsTranslation::getTranslableItems();
        foreach ($this->languages as $language) {
            $file = lang_path($language->key . ".json");
            $json = json_decode(file_get_contents($file), true);
            $newJson = json_decode(file_get_contents($file), true);
            foreach ($translations as $t) {
                $a[] = $t;
                if (!isset($json[$t])) {
                    $newJson[$t] = "";
                }
            }
            foreach ($json as $Jkey => $Jvalue) {
                if (!in_array($Jkey, $translations)) {
                    unset($newJson[$Jkey]);
                }
            }
            file_put_contents($file, json_encode($newJson));
        }

        return redirect()->route('admin.translation.index')->with('success', 'Tarama işlemi başarılı');
    }
    public function create()
    {
    }

    public function update(Request $request)
    {
        foreach ($this->languages as $language) {
            $file = lang_path($language->key . ".json");
            $json = json_decode(file_get_contents($file), true);
            $newJson = [];
            foreach ($json as $jkey => $jvalue) {
                $newJson[$jkey] = isset($request[$language->key][$jkey]) ? ($request[$language->key][$jkey] != null ? $request[$language->key][$jkey] : "")  : "";
            }
            file_put_contents($file, json_encode($newJson));
        }
        return redirect()->route('admin.translation.index')->with('success', 'Güncelleme işlemi başarılı');
    }
}
