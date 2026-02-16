<?php

namespace App\Classes;

use Illuminate\Support\Facades\Artisan;
use Gettext\Scanner\PhpScanner;
use Gettext\Translations;

class CmsTranslation
{
    public static function getTranslableItems()
    {
        Artisan::call("view:cache");
        $phpScanner = new PhpScanner(
            Translations::create('cms'),
        );
        $phpScanner->setDefaultDomain('cms');
        $phpScanner->extractCommentsStartingWith('i18n:', 'Translators:');
        foreach (glob(storage_path("framework/views") . DIRECTORY_SEPARATOR . "*.php") as $file) {
            $phpScanner->scanFile($file);
        }
        $ignoredKeys = [
            "pagination.previous",
            "pagination.next",
            "Pagination Navigation",
            "Showing",
            "to",
            "of",
            "results",
            "Go to page :page",
            "of",
        ];
        $translations = [];
        foreach ($phpScanner->getTranslations()["cms"]->toArray()["translations"] as $t) {
            if (!in_array($t["original"], $ignoredKeys)) {
                $translations[] = $t["original"];
            }
        }
        return $translations;
    }
}
