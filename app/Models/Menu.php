<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $guarded = [];

   function Allchilds()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->orderBy('sort', 'ASC');
    }

    function childs()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->where('is_hidden', false)->with('childs')->orderBy('sort', 'ASC');
    }
    function childsAdmin()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->with('childsAdmin')->orderBy('sort', 'ASC');
    }
    function childsOne()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->orderBy('sort', 'ASC');
    }
    function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
    function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }
    function parent()
    {
        return $this->hasOne(Menu::class, 'id', 'parent_id');
    }
    function values()
    {
        return $this->hasMany(MenuValue::class, 'menu_id', 'id');
    }
}
