<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Value extends Model
{
    use HasFactory;
    protected $guarded = [];

    function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
    function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }
    function details(): MorphMany
    {
        return $this->morphMany(ValueDetail::class, 'detailable', "valueModel", "model_id");
    }
    function files(): HasManyThrough
    {
        return $this->hasManyThrough(File::class, ValueDetail::class, 'model_id');
    }
    function menus()
    {
        return $this->hasMany(MenuValue::class, 'value_id', 'id');
    }
}
