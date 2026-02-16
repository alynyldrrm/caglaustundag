<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Classes\Language as LangClass;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller
{
    function index()
    {
        $langs = Language::all();
        return view('admin.languages.index', compact('langs'));
    }
    function create()
    {
        return view('admin.languages.create');
    }
    function store(Request $request)
    {
        $request->validate([
            'key' => ['required'],
            'text' => ['required'],
            'is_default' => ['required']
        ]);
        DB::beginTransaction();
        $is_default = $request->is_default == "on" ? true : false;
        if ($is_default) {
            $defaultedLang = Language::where('is_default', true)->first();
            if ($defaultedLang) {
                $defaultedLang->update([
                    'is_default' => false,
                ]);
            }
        }
        $deletedLang = Language::where('key', $request->key)->withTrashed()->first();
        if ($deletedLang) {
            if ($deletedLang->deleted_at == null) {
                return redirect()->back()->withErrors(["Key alanı başka bir dilde mevcut."])->withInput();
            } else {
                if ($is_default) {
                    $defaultedLang = Language::where('is_default', true)->first();
                    if ($defaultedLang) {
                        $defaultedLang->update([
                            'is_default' => false,
                        ]);
                    }
                }
                $deletedLang->update(['deleted_at' => null, 'text' => $request->text, 'is_default' => $is_default]);
                LangClass::addedLanguageProcess($deletedLang);
                DB::commit();
                return redirect()->route('admin.language.index')->with('success', "Dil Ekleme İşlemi Başarılı");
            }
        }
        $createdLang = Language::create([
            'text' => $request->text,
            'key' => $request->key,
            'is_default' => $is_default
        ]);
        LangClass::addedLanguageProcess($createdLang);
        DB::commit();
        return redirect()->route('admin.language.index')->with('success', "Dil Ekleme İşlemi Başarılı");
    }

    function edit($id)
    {
        $lang = Language::find($id);
        if (!$lang) {
            return redirect()->route('admin.language.index')->withErrors(["Dil bulunamadı!"]);
        }
        return view('admin.languages.edit', compact('lang'));
    }
    function update($id, Request $request)
    {
        $request->validate([
            'key' => ['required', 'unique:languages,key,' . $id . ''],
            'text' => ['required'],
            'is_default' => ['required']
        ]);
        $lang = Language::find($id);
        if (!$lang) {
            return redirect()->route('admin.language.index')->withErrors(["Dil bulunamadı!"]);
        }

        $is_default = $request->is_default == "on" ? true : false;
        if ($is_default && !$lang->is_default) {
            $defaultedLang = Language::where('is_default', true)->first();
            if ($defaultedLang) {
                $defaultedLang->update([
                    'is_default' => false,
                ]);
            }
        }
        if ($lang->key != $request->key) {
            rename(lang_path($lang->key . ".json"), lang_path($request->key . ".json"));
        }
        $lang->update([
            'text' => $request->text,
            'key' => $request->key,
            'is_default' => $is_default
        ]);
        return redirect()->route('admin.language.index')->with('success', "Güncelleme işlemi başarılı.");
    }
    function destroy($id)
    {

        $langs = Language::all();
        if (count($langs) == 1) {
            return redirect()->route('admin.language.index')->withErrors(["En az 1 dil olmalıdır!"]);
        }
        $lang = $langs->find($id);
        if ($lang) {
            if ($lang->is_default) {
                return redirect()->back()->withErrors(["Varsayılan Dil Silinemez!"]);
            } else {
                LangClass::deletedLanguageProcess($lang);
                $lang->delete();
                return redirect()->route('admin.language.index')->with('success', 'Silme İşlemi Başarılı');
            }
        } else {
            return redirect()->route('admin.language.index')->withErrors(["Dil Bulunamadı!"]);
        }
    }
}
