<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ValueDetail extends Model
{
    use HasFactory;
    public $table = "value_details";
    protected $guarded = [];

    function detailable(): MorphTo
    {
        return $this->morphTo();
    }
    function field()
    {
        return $this->belongsTo(Field::class);
    }

}
