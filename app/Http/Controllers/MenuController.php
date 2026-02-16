<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Menu;
use App\Models\MenuValue;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\fileExists;

class MenuController extends Controller
{

    public function index(Request $request)
    {
        $langs = Language::get();
        $lang_ids = $langs->pluck('id')->toArray();
        $menus = Menu::with('childsAdmin', 'type')
            ->where('parent_id', null)
            ->orderBy('sort', 'ASC');
        if ($request->lang && in_array($request->lang, $lang_ids)) {
            $menus = $menus->where('language_id', $request->lang);
        } else {
            $menus = $menus->where('language_id', $this->defLang->id);
        }
        $menus = $menus->get();
        return view('admin.menu.index', compact('menus', 'langs'));
    }
    public function create()
    {
        $types = Type::get();
        $menus = Menu::with('type')->where('language_id', $this->defLang->id)->get();
        return view('admin.menu.create', compact('menus', 'types'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'imagePath' => ['nullable', 'mimes:png,jpg', 'max:10240', 'image'],
            'filePath' => ['nullable', 'max:2048', 'file'],
            "is_hidden" => ["required", "in:true,false"]
        ]);
        $is_hidden = $request->is_hidden == "true" ? true : false;
        $langs = Language::get();
        $permalink = createPermalink(new Menu, "permalink", $request->name, null);
        $brother_id = getBrotherId(new Menu, null);
        $filePath = null;
        $imagePath = null;
        if ($file = $request->file('imagePath')) {
            $imagePath = saveFile($file, "files/menuImages");
        }
        if ($file = $request->file('filePath')) {
            $filePath = saveFile($file, "files/menuFiles");
        }
        foreach ($langs as $lang) {
            $parent_id = $request->parent_id != "false" ? $request->parent_id : null;
            $type_id = $request->type_id != "false" ? $request->type_id : null;
            if ($parent_id) {
                if ($this->defLang->id == $lang->id) {
                    $parent_id = $request->parent_id;
                } else {
                    $parent_id = getBrotherMenuWithLanguage($request->parent_id, $lang->id);
                }
            }
            $data = [
                'name' => $request->name,
                'language_id' => $lang->id,
                'permalink' => $permalink,
                'description' => $request->description,
                'url' => $request->url,
                'parent_id' => $parent_id,
                'type_id' => $type_id,
                'brother_id' => $brother_id,
                'filePath' => $this->defLang->id == $lang->id ? $filePath : null,
                'imagePath' => $this->defLang->id == $lang->id ? $imagePath : null,
                "is_hidden" => $is_hidden,
            ];
            Menu::create($data);
        }

        return redirect()->route('admin.menu.index')->with('success', 'Menü ekleme başarılı.');
    }
    public function edit(string $id)
    {
        $types = Type::get();
        $menu = Menu::with('language', 'type')->where('id', $id)->first();
        $menus = Menu::where('language_id', $menu->language_id)->where('id', '!=', $menu->id)->get();
        if (!$menu) {
            return redirect()->route('admin.menu.index')->withErrors(["Menü bulunamadı!"]);
        }
        $brothers = Menu::with('language')->where('brother_id', $menu->brother_id)->where('id', '!=', $menu->id)->get();
        return view('admin.menu.edit', compact('menu', 'brothers', 'menus', 'types'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required'],
            'imagePath' => ['nullable', 'mimes:png,jpg', 'max:10240', 'image'],
            'filePath' => ['nullable', 'max:2048', 'file'],
            "is_hidden" => ["required", "in:true,false"]
        ]);
        $menu = Menu::with('language')->where('id', $id)->first();
        if (!$menu) {
            return redirect()->route('admin.menu.index')->withErrors(["Menü bulunamadı!"]);
        }
        $is_hidden = $request->is_hidden == "true" ? true : false;
        $filePath = $menu->filePath;
        $imagePath = $menu->imagePath;
        if ($file = $request->file('imagePath')) {
            $imagePath = saveFile($file, "files/menuImages");
        }
        if ($file = $request->file('filePath')) {
            $filePath = saveFile($file, "files/menuFiles");
        }
        $type_id = $request->type_id != "false" ? $request->type_id : null;
        if ($menu->type_id != $type_id) {
            MenuValue::where('type_id', $menu->type_id)->where('menu_id', $menu->id)->delete();
        }
        $data = [
            'name' => $request->name,
            'permalink' => createPermalink(new Menu, "permalink", $request->name, $menu->id),
            'description' => $request->description,
            'url' => $request->url,
            'parent_id' => $request->parent_id != "false" ? $request->parent_id : null,
            'type_id' => $type_id,
            'filePath' => $filePath,
            'imagePath' => $imagePath,
            "is_hidden" => $is_hidden,
        ];
        $menu->update($data);
        return redirect()->route('admin.menu.edit', $menu->id)->with('success', 'Güncelleme işlemi başarılı.');
    }
    public function destroy($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('admin.menu.index')->withErrors(["Menü bulunamadı!"]);
        }
        $menus = Menu::with('childsOne')->where('brother_id', $menu->brother_id)->get();
        DB::beginTransaction();
        foreach ($menus as $item) {
            foreach ($menu->childsOne as $cmenu) {
                $cmenu->update(["parent_id" => null]);
            }
            $item->delete();
        }
        DB::commit();
        return redirect()->route('admin.menu.index')->with('success', 'Silme işlemi başarılı');
    }
    function destroyFile($type, $id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('admin.menu.index')->withErrors(["Menü bulunamadı!"]);
        }
        if (!in_array($type, ["image", "file"])) {
            return redirect()->route('admin.menu.index')->withErrors(["Menü bulunamadı!"]);
        }
        if ($type == "file") {
            $path = "files/menuFiles/" . $menu->filePath;
            if (fileExists($path)) {
                unlink($path);
            }
            $menu->update(['filePath' => null]);
            return redirect()->route('admin.menu.edit', $menu->id)->with('success', 'İşlem başarılı');
        } elseif ($type == "image") {
            $path = "files/menuImages/" . $menu->imagePath;
            if (fileExists($path)) {
                unlink($path);
            }
            $menu->update(['imagePath' => null]);
            return redirect()->route('admin.menu.edit', $menu->id)->with('success', 'İşlem başarılı');
        } else {
            return redirect()->route('admin.menu.index')->withErrors(["Menü bulunamadı!"]);
        }
    }
    function sort(Request $request)
    {
        $data = json_decode($request->data, true);
        menuSort($data);
        return true;
    }
}
