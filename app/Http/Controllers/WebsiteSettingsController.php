<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{
    function edit()
    {
        $setting = WebsiteSetting::first();
        if (!$setting) {
            $setting = WebsiteSetting::create(["seo_title" => ""]);
        }
        return view('admin.websiteSettings.edit', compact('setting'));
    }
    function update(Request $request)
    {
        $setting = WebsiteSetting::first();
        if (!$setting) {
            return redirect()->route('admin.website-settings.edit')->withErrors(["Ayarlar bulunamadı!"]);
        }
        $setting->update($request->all());
        return redirect()->route('admin.website-settings.edit')->with('success', 'Güncelleme işlemi başarılı.');
    }
}
