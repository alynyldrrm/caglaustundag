<?php

use App\Models\ContactSetting;
use App\Models\Form;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Type;
use App\Models\Value;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use League\Glide\Urls\UrlBuilderFactory;
use App\Models\Field;
use App\Models\File;
use App\Models\FormAnswer;
use App\Models\MenuValue;
use App\Models\ValueDetail;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Shuchkin\SimpleXLSXGen;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

/*admin*/

function createAdminMenuList($items)
{
    $list[] = '<ol class="dd-list">';
    foreach ($items as $item) {
        $list[] = "<li class='dd-item dd3-item' data-id='" . $item->id . "'>
                <div class='dd-handle dd3-handle'></div>
                <div class='dd3-content push-left'>
                    " . $item->name  . ($item->is_hidden ? "<small>(Gizli)</small>" : "") . '
                    <div class="list-option d-flex gap-2">
                    ' . ($item->type ? $item->type->multiple_name  : "") .
            ($item->type ? ($item->type->is_hidden ? "<small>(Gizli)</small>" : "") : "")
            . '
                        <a href="' . route('admin.menu.edit', $item->id) . '" class="btn btn-secondary">Düzenle</a>
                        <a href="' . route('admin.menu.destroy', $item->id) . '" onclick="return confirm(\'Silmek istediğinize emin misiniz?\')" class="btn btn-danger">Sil</a>
                    </div>
                </div>
        ';
        if ($item->childsAdmin) {
            $list[] = createAdminMenuList($item->childsAdmin);
        }
        $list[] = '</li>';
    }
    $list[] = '</ol>';
    return implode('', $list);
}
function routeIsActive($route, $type_id = null)
{

    if (Route::currentRouteName() == $route && $type_id == null) {
        return "active";
    }

    $param = Route::current()->parameter('type_id');
    if (!$param) {
        return null;
    }
    if ($param == $type_id) {
        return "active";
    }
}

/*admin son*/
function getLanguageLinks()
{
    try {
        $return = [];
        $url = explode('/', substr($_SERVER["REQUEST_URI"], 1));

        $menuPermalink = isset($url[1]) ? explode("?", $url[1])[0] : false;
        if (trim($menuPermalink) == "") {
            $menuPermalink = false;
        }
        $valuePermalink = isset($url[2]) ? explode("?", $url[2])[0] : false;
        if (trim($valuePermalink) == "") {
            $valuePermalink = false;
        }
        $languages = Language::get();



        if ($valuePermalink) {
            $menu = Menu::where('permalink', $menuPermalink)->first();
            $menus = Menu::where('brother_id', $menu->brother_id)->get();
            $value = Value::where('permalink', $valuePermalink)->first();
            $values = Value::where('brother_id', $value->brother_id)->get();
            foreach ($languages as $l) {
                foreach ($menus as $menu) {
                    foreach ($values as $value) {
                        if ($menu->language_id == $l->id && $value->language_id == $l->id) {
                            $return[$l->key] =  "/" . $l->key . "/" . $menu->permalink . "/" . $value->permalink;
                        }
                    }
                }
            }
        } elseif ($menuPermalink) {
            $menu = Menu::where('permalink', $menuPermalink)->first();
            $menus = Menu::where('brother_id', $menu->brother_id)->get();
            foreach ($languages as $l) {
                foreach ($menus as $menu) {
                    if ($menu->language_id == $l->id) {
                        $return[$l->key] = $menu->url ? $menu->url : "/" . $l->key . "/" . $menu->permalink;
                    }
                }
            }
        } else {
            foreach ($languages as $l) {
                $return[$l->key] = "/" . $l->key;
            }
        }
        return $return;
    } catch (\Throwable $th) {
        foreach ($languages as $l) {
            $return[$l->key] = "/" . $l->key;
        }
        return $return;
    }
}
function getCurrentLanguage()
{
    $lang = Language::where('key', App::getLocale())->first();
    return $lang ? $lang : [];
}
function getWebsiteSettings()
{
    return WebsiteSetting::firstOrCreate([]);
}
function getMenus()
{
    $menus = Menu::with('childs', 'type', 'language')
        ->where('is_hidden', false)
        ->where('parent_id', null)
        ->orderBy('sort', 'ASC')
        ->where('language_id', session('defaultDatas')["currentLanguage"]->id)
        ->get();
    return $menus;
}

function getImageLink($path, $params)
{
    $signKey = "mrWBVTyeHO0Eb#!C@+z+3zK3't]X1{E'PzQ,@1EH_7]1YyQwQC";
    $builder = UrlBuilderFactory::create('/image/', $signKey);
    return $builder->getUrl($path, $params);
}

function getValue($fieldKey, $item)
{
    $value = "";
    if (isset($item["fields"][$fieldKey])) {
        $value = $item["fields"][$fieldKey];
    }
    return $value;
}

function getTypeValues($type_permalink, $take = 5, $orderBy = "sort", $order = "ASC")
{
    $type = Type::where('permalink', $type_permalink)->first();
    if (!$type) {
        return [];
    }
    $return = [];
    $values = Value::where('type_id', $type->id)
        ->where('language_id', session('defaultDatas')["currentLanguage"]->id)
        ->take($take)
        ->orderBy($orderBy, $order)
        ->get();
    foreach ($values as $value) {
        $return[] = getValueDetail($value);
    }
    return $return;
}

function getContact()
{
    $contact = ContactSetting::where('language_id', session('defaultDatas')["currentLanguage"]->id)->get();
    if (count($contact) == 0) {
        return false;
    }
    return $contact;
}

function getSelectedMenus()
{
    $return = [];
    $query = explode('/', $_SERVER["REQUEST_URI"]);
    unset($query[0]);
    $query[count($query)] = explode("?", $query[count($query)])[0];

    foreach ($query as $q) {
        $menu = Menu::with('parent')->where('permalink', $q)->first();
        if ($menu) {
            if ($menu->parent) {
                $return[] =  $menu->parent;
            }
            $return[] =  $menu;
        }
    }
    return collect($return);
}
function getForms()
{
    return Form::where('language_id', session('defaultDatas')["currentLanguage"]->id)->get();
}

function createMenus($menus)
{
    $list = [];

    foreach ($menus as $menu) {
        $href = $menu['url'] == ''
            ? route('showPage', [App::getLocale(), $menu['permalink']])
            : $menu['url'];

        // Eğer alt menü varsa
        if (!empty($menu->childs) && count($menu->childs) > 0) {

            // Mega menu kontrolü
            if (count($menu->childs) > 10) {
                $list[] = '<li class="dropdown dropdown-mega">';
                $list[] = '<a href="#" class="dropdown-item dropdown-toggle">' . $menu->name . '</a>';
                $list[] = '<ul class="dropdown-menu">';
            } else {
                $list[] = '<li class="dropdown">';
                $list[] = '<a href="#" class="dropdown-item dropdown-toggle">' . $menu->name . '</a>';
                $list[] = '<ul class="dropdown-menu">';
            }

            // Alt menüleri tek seviye olarak yazdır
            foreach ($menu->childs as $child) {
                $childHref = $child['url'] == ''
                    ? route('showPage', [App::getLocale(), $child['permalink']])
                    : $child['url'];

                $list[] = '<li><a href="' . $childHref . '" class="dropdown-item">' . $child->name . '</a></li>';
            }

            $list[] = '</ul>';
            $list[] = '</li>';
        } else {
            // Normal link
            $list[] = '<li><a href="' . $href . '" class="dropdown-item">' . $menu->name . '</a></li>';
        }
    }

    return implode('', $list);
}



function createPermalink(Model $model, $filterColumn = "", $text = "", $id = null)
{
    $slug = Str::slug($text, '-');
    $control = $model::where($filterColumn, $slug);
    if ($id) {
        $control = $control->where('id', '!=', $id);
    }
    $control = $control->first();
    if ($control) {
        $slugLast = substr($slug, -1);
        if (containsOnlyNumbers($slugLast)) {
            $slug = substr($slug, 0, -1) . ($slugLast + 1);
            $slug = createPermalink($model, $filterColumn, $slug, $id);
        } else {
            $slug = $slug . '-1';
            $slug = createPermalink($model, $filterColumn, $slug, $id);
        }
    }
    return $slug;
}


function containsOnlyNumbers($value)
{
    if (preg_match('#[0-9]#', $value)) {
        return true;
    } else {
        return false;
    }
}

function getBrotherId(Model $model, $id = null)
{
    if ($id) {
        $x = $model::find($id);
        return $x->brother_id;
    }
    $lastId = $model::select('id', 'brother_id')->orderBy('brother_id', 'DESC')->first();
    if (!$lastId) {
        return 0;
    }
    return intval($lastId->brother_id) + 1;
}

function saveFile($file, $destination = "")
{
    $fileName = md5(date('d.m.y H:i:s')) . uniqid() . "." . $file->getClientOriginalExtension();
    move_uploaded_file($file, $destination . "/" .  $fileName);
    return $fileName;
}
function getBrotherMenuWithLanguage($menu_id, $language_id)
{
    $menu = Menu::find($menu_id);
    if (!$menu) {
        return null;
    }
    $brotherMenu = Menu::where('brother_id', $menu->brother_id)->where('language_id', $language_id)->first();
    if (!$brotherMenu) {
        return null;
    }
    return $brotherMenu->id;
}
function menuSort($items, $parent = null)
{
    $i = 1;
    foreach ($items as $item) {
        $i++;
        Menu::where('id', $item["id"])->update(['parent_id' => $parent, 'sort' => $i]);
        if (isset($item["children"])) {
            menuSort($item["children"], $item["id"]);
        }
    }
}

function getValueDetail(Value $value)
{
    $language = Language::where('id', $value->language_id)->first()->toArray();
    $menu = MenuValue::with('menu')->where('value_id', $value->id)->first();
    if ($menu) {
        $menu = $menu->toArray();
        $menu = $menu["menu"];
    } else {
        $menu = null;
    }
    $data = [
        "id" => $value->id,
        "name" => $value->name,
        "language" => $language,
        "menu" => $menu,
        "permalink" => $value->permalink,
        "created_at" => Carbon::parse($value->created_at)->format('d.m.Y H:i:s'),
        "updated_at" => Carbon::parse($value->updated_at)->format('d.m.Y H:i:s'),
        "fields" => []
    ];
    $fields = Field::where('type_id', $value->type_id)->select('key', 'type')->get();
    $valueDetails = ValueDetail::with('field')->where('valueModel', $value->type->model)->where('model_id', $value->id)->get();

    foreach ($fields as $field) {
        if (!isset($data["fields"][$field->key])) {
            $data["fields"][$field->key] = "";
        }
        foreach ($valueDetails as $v) {
            if ($v->field->type == "input|file|single" || $v->field->type == "input|file|multiple") {
                $files = File::where('value_detail_id', $v->id)->with('language')->orderBy('sort', "ASC")->get()->toArray();
                $data["fields"][$v->field->key] = $files;
            } else {
                $data["fields"][$v->field->key] = $v->value;
            }
        }
    }
    return $data;
}

//MenuValue tablosundaki tip form tipi ise viewa  $list değişkeni ile gönderilen formları getiren fonksiyon getValueDetail'in form için olan hali
function getFormDetail($form_id)
{
    $form = Form::find($form_id);
    if (!$form) {
        return null;
    }
    return $form;
}
function getValueList(Menu $menu)
{
    $pivot = MenuValue::join('values', 'menu_values.value_id', 'values.id')
        ->with(['value', 'type'])
        ->where('menu_id', $menu->id)
        ->orderBy("values.sort")
        ->get();
    $data = [];
    foreach ($pivot as $item) {
        if ($item->type->model == "App\Models\Form") {
            $data[] = getFormDetail($item->value_id);
        } else {
            $data[] = getValueDetail($item->value);
        }
    }
    return $data;
}
//eklenme tarihinden itibaren 1 gün geçmiş ve herhangi bir girdiye bağlanmamış olan resimleri veritabanı ve kayıtlı olduğu klasörden siliyor!
function removeUnusedFiles()
{
    $beforeDay = Carbon::now();
    $beforeDay->addDays(-1);
    $beforeDay->format('Y-m-d H:i:s');
    $removedFiles = File::whereNull('value_detail_id')->whereDate('created_at', '<', $beforeDay)->get();
    foreach ($removedFiles as $file) {
        if (file_exists(substr($file->path, 1))) {
            unlink(substr($file->path, 1));
        }
        $file->delete();
    }
}

  // function sendEmail($params)
  // {
    // $name = $params["name"];
    // $email = $params["email"];
    // $subject = $params["subject"];
    // $message = $params["message"];
    // $websiteSetting = WebsiteSetting::first();
    // $emails = ContactSetting::where('language_id', session('defaultDatas')["currentLanguage"]->id)->pluck('email')->toArray();
    // $data = [
    //     'name' => $name,
    //     'email' => $email,
    //     'subject' => $subject,
    //     'message' => $message,
    // ];
    // try {
    //     Mail::send("mailLayouts.contact", ['data' => $data], function ($message) use ($emails, $websiteSetting, $data) {
    //         foreach ($emails as $email) {
    //             $message->to($email);
    //         }
    //         $message->subject($websiteSetting->seo_title . " İletişim Formu")->from(env('MAIL_FROM_ADDRESS'), $websiteSetting->seo_title);
    //     });
    //     return redirect()->back()->with('userSuccess', "Mesajınız başarıyla gönderildi.");
    // } catch (Throwable $e) {
    //     return redirect()->back()->with('userError', 'Mesajınız gönderilirken bir hata oluştu daha sonra tekrar deneyiniz');
    // }


  // }
function sendEmail($params)
{
    $name = $params["name"];
    $email = $params["email"];
    $subject = $params["subject"];
    $message = $params["message"];

    $websiteSetting = WebsiteSetting::first();
    $contactEmail = ContactSetting::where('language_id', session('defaultDatas')["currentLanguage"]->id)->whereNotNull('email')->first();

    $toEmail = $contactEmail ? $contactEmail->email : 'info@example.com';

    $mail = new PHPMailer(true);

    try {
        // SMTP ayarları
        $mail->isSMTP();
        $mail->Host = 'smtp.yandex.com.tr';
        $mail->SMTPAuth = true;
        $mail->Username = 'aleyna@godeva.com.tr';
        $mail->Password = 'srtxjyhzglqxqskb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Gönderici ve alıcı
        $mail->setFrom('aleyna@godeva.com.tr', $websiteSetting->seo_title);
        $mail->addAddress($toEmail);
        $mail->addReplyTo($email, $name);

        // İçerik
        $mail->isHTML(true);
        $mail->Subject = $websiteSetting->seo_title . " - İletişim Formu: " . $subject;
        $mail->Body = "
            <h2>İletişim Formu Mesajı</h2>
            <p><strong>Gönderen:</strong> {$name}</p>
            <p><strong>E-Posta:</strong> {$email}</p>
            <p><strong>Konu:</strong> {$subject}</p>
            <p><strong>Mesaj:</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
            <hr>
            <p><small>Gönderim Tarihi: " . date('d.m.Y H:i') . "</small></p>
        ";

        $mail->send();
        return redirect()->back()->with('userSuccess', "Mesajınız başarıyla gönderildi.");
    } catch (PHPMailerException $e) {
        return redirect()->back()->with('userError', 'Mesajınız gönderilirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.');
    }
}

function saveFormFromUser($form_id, Request $request)
{
    $form = Form::find($form_id);
    if (!$form) {
        abort(404);
    }
    try {
        $savedArray = [];
        $formQuestions = json_decode($form->questions, true);
        foreach ($formQuestions as $question) {
            $requestName = str_replace(' ', '_', $question["name"]);
            if ($question["field"] == "input|checkbox") {
                if (isset($request->$requestName)) {
                    $arr = [
                        "question" => $question["name"],
                        "answer" => json_encode($request->$requestName),
                        "type" => $question["field"],
                        "values" => $question["values"] != null ? $question["values"] : "",
                    ];
                    array_push($savedArray, $arr);
                } else {
                    $arr = [
                        "question" => $question["name"],
                        "answer" => "",
                        "type" => $question["field"],
                        "values" => $question["values"] != null ? $question["values"] : "",
                    ];
                    array_push($savedArray, $arr);
                }
            } elseif ($question["field"] == "input|file") {
                if (isset($request->$requestName)) {
                    $fileName = saveFile($request->file($requestName), "files/formFiles/");
                    $arr = [
                        "question" => $question["name"],
                        "answer" => "/files/formFiles/" . $fileName,
                        "type" => $question["field"],
                        "values" => $question["values"] != null ? $question["values"] : "",
                    ];
                    array_push($savedArray, $arr);
                } else {
                    $arr = [
                        "question" => $question["name"],
                        "answer" => "",
                        "type" => $question["field"],
                        "values" => $question["values"] != null ? $question["values"] : "",
                    ];
                    array_push($savedArray, $arr);
                }
            } else {
                if (isset($request->$requestName)) {
                    $arr = [
                        "question" => $question["name"],
                        "answer" => $request->$requestName,
                        "type" => $question["field"],
                        "values" => $question["values"] != null ? $question["values"] : "",
                    ];
                    array_push($savedArray, $arr);
                } else {
                    $arr = [
                        "question" => $question["name"],
                        "answer" => "",
                        "type" => $question["field"],
                        "values" => $question["values"] != null ? $question["values"] : "",
                    ];
                    array_push($savedArray, $arr);
                }
            }
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        FormAnswer::create([
            "form_id" => $form->id,
            "answer" => json_encode($savedArray),
            "ip" => $ip,
            "checked" => false
        ]);
        return redirect()->back()->with('userSuccess', $form->success_message);
    } catch (\Throwable $th) {
        return redirect()->back()->with('userError', $form->error_message);
    }
}

function exportExcelFromForm(Form $form)
{
    $excelData = [];
    $headers = [];
    $headers[] = "Tarih";
    foreach (json_decode($form->questions, true) as $q) {
        $headers[] = $q["name"];
    }
    $excelData[] = $headers;
    $answers = FormAnswer::where('form_id', $form->id)->get();
    foreach ($answers as $answer) {
        $addedArray = [];
        $addedArray[] = Carbon::parse($answer->created_at)->format('d.m.Y');
        foreach (json_decode($answer->answer, true) as $a) {
            $addedArray[] = $a["answer"];
        }
        $excelData[] = $addedArray;
    }
    SimpleXLSXGen::fromArray($excelData)
        ->downloadAs(now()->format('d.m.Y H:i:s') . '.xlsx');
}
