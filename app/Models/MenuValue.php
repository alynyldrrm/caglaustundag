<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuValue extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "menu_id",
        "value_id",
        "type_id",
    ];
    public $table = "menu_values";

    function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id');
    }
    function value()
    {
        return $this->hasOne(Value::class, 'id', 'value_id');
    }
    function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }
    function form()
    {
        return $this->hasOne(Form::class, 'id', 'value_id');
    }
}
