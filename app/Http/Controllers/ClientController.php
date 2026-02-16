<?php

namespace App\Http\Controllers;

use App\Classes\CmsHelper;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Value;
use GatewayClient\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
     function index()
    {
    //     Mail::to('serdal04sero@gmail.com')
    //         ->subject('Gateway\'den Merhaba')
    //         ->html('<p>Bu bir test e-postasıdır</p>')
    //         ->send();

       return view('client.home');
     }
    function showPage($language_key = null, $menu_permalink = null, $value_permalink = null)
    {
        $language = Language::where('key', $language_key)->firstOrFail();
        $menu = Menu::with('type')
            ->where('permalink', $menu_permalink)
            ->where('language_id', $language->id)
            ->first();
        if (!$menu) {
            abort(404);
            return redirect()->route('clientHome', App::getLocale());
        }
        $view = "";
        if ($menu->type) {
            if ($menu->type->rendered_view) {
                $view = $menu->type->rendered_view;
            } else {
                $view = $menu->type->permalink;
            }
        } else {
            abort(404);
        }
        $view = "client." . $view;
        $data = [
            "list" => false,
            "detail" => false,
        ];
        if ($value_permalink) {
            $value = Value::where('permalink', $value_permalink)->firstOrFail();
            $data["detail"] = getValueDetail($value);
        } else {
            $data["list"] = getValueList($menu);
        }
        $list = $data["list"];
        $detail = $data["detail"];
        return view($view, compact('list', 'detail', 'menu'));
    }

    /**
     * İletişim formundan gelen mesajı işle
     */
    function sendContact(Request $request)
    {
        // Validasyon
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'captcha' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Captcha doğrulama
        if (strtoupper($request->captcha) !== strtoupper(Session::get('captcha_code'))) {
            return redirect()->back()->withErrors(['captcha' => __('Güvenlik kodu hatalı.')])->withInput();
        }

        // Var olan sendEmail fonksiyonunu kullan
        return sendEmail($request->all());
    }

    /**
     * Captcha kodu üret
     */
    public static function generateCaptcha()
    {
        $code = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6);
        Session::put('captcha_code', $code);
        return $code;
    }
}
