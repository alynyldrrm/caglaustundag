<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $table = "forms";


    function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }
    function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
    function answers()
    {
        return $this->hasMany(FormAnswer::class, 'form_id', 'id');
    }
}
