<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'seo_title',
        'seo_keywords',
        'seo_description',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'gplus',
        'linkedin',
        'pinterest',
        'emails',
    ];
    public $table = "website_settings";
}
