<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'language_id',
        'type_id',
        'brother_id',
        'name',
        'city',
        'town',
        'phone',
        'email',
        'address',
        'iframe_code',
        'sort',
    ];
    public $table = "contact_settings";

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
    function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }
}
