<?php

namespace App\Helpers;

use App\Classes\CmsHelper;
use App\Models\ContactSetting;
use App\Models\Form;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Type;
use App\Models\Value;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use League\Glide\Urls\UrlBuilderFactory;

class CmsBladeHelper
{
    /*admin*/

    public static function createAdminMenuList($items)
    {
        $list[] = '<ol class="dd-list">';
        foreach ($items as $item) {
            $list[] = "<li class='dd-item dd3-item' data-id='" . $item->id . "'>
                <div class='dd-handle dd3-handle'></div>
                <div class='dd3-content push-left'>
                    " . $item->name  . ($item->is_hidden ? "<small>(Gizli)</small>" : "") . '
                    <div class="list-option d-flex gap-2">
                    ' . ($item->type ? $item->type->multiple_name  : "") .
                ($item->type ? ($item->type->is_hidden ? "<small>(Gizli)</small>" : "") : "")
                . '
                        <a href="' . route('admin.menu.edit', $item->id) . '" class="btn btn-secondary">Düzenle</a>
                        <a href="' . route('admin.menu.destroy', $item->id) . '" onclick="return confirm(\'Silmek istediğinize emin misiniz?\')" class="btn btn-danger">Sil</a>
                    </div>
                </div>
        ';
            if ($item->childsAdmin) {
                $list[] = CmsBladeHelper::createAdminMenuList($item->childsAdmin);
            }
            $list[] = '</li>';
        }
        $list[] = '</ol>';
        return implode('', $list);
    }
    public static function routeIsActive($route, $type_id = null)
    {

        if (Route::currentRouteName() == $route && $type_id == null) {
            return "active";
        }

        $param = Route::current()->parameter('type_id');
        if (!$param) {
            return null;
        }
        if ($param == $type_id) {
            return "active";
        }
    }

    /*admin son*/
    public static function getLanguageLinks()
    {
        try {
            $return = [];
            $url = explode('/', substr($_SERVER["REQUEST_URI"], 1));

            $menuPermalink = isset($url[1]) ? explode("?", $url[1])[0] : false;
            if (trim($menuPermalink) == "") {
                $menuPermalink = false;
            }
            $valuePermalink = isset($url[2]) ? explode("?", $url[2])[0] : false;
            if (trim($valuePermalink) == "") {
                $valuePermalink = false;
            }
            $languages = Language::get();



            if ($valuePermalink) {
                $menu = Menu::where('permalink', $menuPermalink)->first();
                $menus = Menu::where('brother_id', $menu->brother_id)->get();
                $value = Value::where('permalink', $valuePermalink)->first();
                $values = Value::where('brother_id', $value->brother_id)->get();
                foreach ($languages as $l) {
                    foreach ($menus as $menu) {
                        foreach ($values as $value) {
                            if ($menu->language_id == $l->id && $value->language_id == $l->id) {
                                $return[$l->key] =  "/" . $l->key . "/" . $menu->permalink . "/" . $value->permalink;
                            }
                        }
                    }
                }
            } elseif ($menuPermalink) {
                $menu = Menu::where('permalink', $menuPermalink)->first();
                $menus = Menu::where('brother_id', $menu->brother_id)->get();
                foreach ($languages as $l) {
                    foreach ($menus as $menu) {
                        if ($menu->language_id == $l->id) {
                            $return[$l->key] = $menu->url ? $menu->url : "/" . $l->key . "/" . $menu->permalink;
                        }
                    }
                }
            } else {
                foreach ($languages as $l) {
                    $return[$l->key] = "/" . $l->key;
                }
            }
            return $return;
        } catch (\Throwable $th) {
            foreach ($languages as $l) {
                $return[$l->key] = "/" . $l->key;
            }
            return $return;
        }
    }
    public static function getCurrentLanguage()
    {
        $lang = Language::where('key', App::getLocale())->first();
        return $lang ? $lang : [];
    }
    public static function getWebsiteSettings()
    {
        return WebsiteSetting::firstOrCreate([]);
    }
    public static function getMenus()
    {
        $menus = Menu::with('childs', 'type', 'language')
            ->where('is_hidden', false)
            ->where('parent_id', null)
            ->orderBy('sort', 'ASC')
            ->where('language_id', session('defaultDatas')["currentLanguage"]->id)
            ->get();
        return $menus;
    }

    public static function getImageLink($path, $params)
    {
        $signKey = "mrWBVTyeHO0Eb#!C@+z+3zK3't]X1{E'PzQ,@1EH_7]1YyQwQC";
        $builder = UrlBuilderFactory::create('/image/', $signKey);
        return $builder->getUrl($path, $params);
    }

    public static function getValue($fieldKey, $item)
    {
        $value = "";
        if (isset($item["fields"][$fieldKey])) {
            $value = $item["fields"][$fieldKey];
        }
        return $value;
    }

    public static function getTypeValues($type_permalink, $take = 5, $orderBy = "sort", $order = "ASC")
    {
        $type = Type::where('permalink', $type_permalink)->first();
        if (!$type) {
            return [];
        }
        $return = [];
        $values = Value::where('type_id', $type->id)
            ->where('language_id', session('defaultDatas')["currentLanguage"]->id)
            ->take($take)
            ->orderBy($orderBy, $order)
            ->get();
        foreach ($values as $value) {
            $return[] = CmsHelper::getValueDetail($value);
        }
        return $return;
    }

    public static function getContact()
    {
        $contact = ContactSetting::where('language_id', session('defaultDatas')["currentLanguage"]->id)->get();
        if (count($contact) == 0) {
            return false;
        }
        return $contact;
    }

    public static function getSelectedMenus()
    {
        $return = [];
        $query = explode('/', $_SERVER["REQUEST_URI"]);
        unset($query[0]);
        $query[count($query)] = explode("?", $query[count($query)])[0];

        foreach ($query as $q) {
            $menu = Menu::with('parent')->where('permalink', $q)->first();
            if ($menu) {
                if ($menu->parent) {
                    $return[] =  $menu->parent;
                }
                $return[] =  $menu;
            }
        }
        return collect($return);
    }
    public static function getForms()
    {
        return Form::where('language_id', session('defaultDatas')["currentLanguage"]->id)->get();
    }
}
