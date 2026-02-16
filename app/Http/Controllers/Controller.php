<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public $defLang = null;
    public $languages = null;
    function __construct()
    {
        $this->defLang = Language::where('is_default', true)->first();
        $this->languages = Language::get();
    }
}
