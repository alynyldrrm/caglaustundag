<?php

namespace App\Helpers;


class CmsCustomHelper
{
    public static function createMenus($menus, $index = 0)
    {
        $list[] = '';
        foreach ($menus as $menu) {
            $href = $menu['url'] == '' ? route('showPage', [\App::getLocale(), $menu['permalink']]) : $menu['url'];
            if (count($menu->childs) > 0) {
                $list[] = '<li class="' . ($index > 0 ? "" : "mega-menu-item") . '">
                <a href="#" class="mega-menu-link">' . $menu->name . '</a>
                <ul class="mega-submenu">';
                if ($index > 0) {
                    $list[] = CmsCustomHelper::createMenus($menu->childs, $index + 1);
                } else {
                    $list[] = CmsCustomHelper::createMenus($menu->childs, $index + 1);
                }
                $list[] = '</ul></li>';
            } else {
                $list[] = '<li><a href="' . $href . '">' . $menu->name . '</a></li>';
            }
        }
        return implode('', $list);
    }
}
