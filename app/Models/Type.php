<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $guarded = [];

    function fields()
    {
        return $this->hasMany(Field::class, 'type_id', 'id')->orderBy('sort', 'ASC');
    }
    function menus()
    {
        return $this->hasMany(Menu::class, 'type_id', 'id');
    }
}
