<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        "language_id",
        "value_detail_id",
        "original_name",
        "extension",
        "size",
        "path",
        "sort"
    ];
    public $table = "files";

    function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
    function details(): MorphMany
    {
        return $this->morphMany(ValueDetail::class, 'detailable');
    }
}
