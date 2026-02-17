<?php

namespace App\Classes;

use App\Models\ContactSetting;
use App\Models\Field;
use App\Models\File;
use App\Models\Form;
use App\Models\FormAnswer;
use App\Models\Language;
use App\Models\Menu;
use App\Models\MenuValue;
use App\Models\Value;
use App\Models\ValueDetail;
use App\Models\WebsiteSetting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Static_;
use Illuminate\Support\Facades\Mail;
use Shuchkin\SimpleXLSXGen;
use Throwable;


class CmsHelper
{
    public static function createPermalink(Model $model, $filterColumn = "", $text = "", $id = null)
    {
        $slug = Str::slug($text, '-');
        $control = $model::where($filterColumn, $slug);
        if ($id) {
            $control = $control->where('id', '!=', $id);
        }
        $control = $control->first();
        if ($control) {
            $slugLast = substr($slug, -1);
            if (CmsHelper::containsOnlyNumbers($slugLast)) {
                $slug = substr($slug, 0, -1) . ($slugLast + 1);
                $slug = CmsHelper::createPermalink($model, $filterColumn, $slug, $id);
            } else {
                $slug = $slug . '-1';
                $slug = CmsHelper::createPermalink($model, $filterColumn, $slug, $id);
            }
        }
        return $slug;
    }


    public static function containsOnlyNumbers($value)
    {
        if (preg_match('#[0-9]#', $value)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getBrotherId(Model $model, $id = null)
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

    public static function saveFile($file, $destination = "")
    {
        $fileName = md5(date('d.m.y H:i:s')) . uniqid() . "." . $file->getClientOriginalExtension();
        move_uploaded_file($file, $destination . "/" .  $fileName);
        return $fileName;
    }
    public static function getBrotherMenuWithLanguage($menu_id, $language_id)
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
    public static function menuSort($items, $parent = null)
    {
        $i = 1;
        foreach ($items as $item) {
            $i++;
            Menu::where('id', $item["id"])->update(['parent_id' => $parent, 'sort' => $i]);
            if (isset($item["children"])) {
                CmsHelper::menuSort($item["children"], $item["id"]);
            }
        }
    }

    public static function getValueDetail(Value $value)
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
    public static function getFormDetail($form_id)
    {
        $form = Form::find($form_id);
        if (!$form) {
            return null;
        }
        return $form;
    }
    public static function getValueList(Menu $menu)
    {
        $data = [];
        
        // Ana menüye bağlı value'ları getir
        $pivot = MenuValue::join('values', 'menu_values.value_id', 'values.id')
            ->with(['value', 'type'])
            ->where('menu_id', $menu->id)
            ->orderBy("values.sort")
            ->get();
        
        foreach ($pivot as $item) {
            if ($item->type->model == "App\Models\Form") {
                $data[] = CmsHelper::getFormDetail($item->value_id);
            } else {
                $data[] = CmsHelper::getValueDetail($item->value);
            }
        }
        
        // Alt menülerdeki value'ları recursive olarak getir
        $childMenus = Menu::where('parent_id', $menu->id)->get();
        foreach ($childMenus as $childMenu) {
            $childData = CmsHelper::getValueList($childMenu);
            $data = array_merge($data, $childData);
        }
        
        return $data;
    }
    //eklenme tarihinden itibaren 1 gün geçmiş ve herhangi bir girdiye bağlanmamış olan resimleri veritabanı ve kayıtlı olduğu klasörden siliyor!
    public static function removeUnusedFiles()
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

    public static function sendEmail($params)
    {
        $name = $params["name"];
        $email = $params["email"];
        $subject = $params["subject"];
        $message = $params["message"];
        $websiteSetting = WebsiteSetting::first();
        $emails = ContactSetting::where('language_id', session('defaultDatas')["currentLanguage"]->id)->pluck('email')->toArray();
        $data = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ];
        try {
            Mail::send("mailLayouts.contact", ['data' => $data], function ($message) use ($emails, $websiteSetting, $data) {
                foreach ($emails as $email) {
                    $message->to($email);
                }
                $message->subject($websiteSetting->seo_title . " İletişim Formu")->from(env('MAIL_FROM_ADDRESS'), $websiteSetting->seo_title);
            });
            return redirect()->back()->with('userSuccess', "Mesajınız başarıyla gönderildi.");
        } catch (Throwable $e) {
            return redirect()->back()->with('userError', 'Mesajınız gönderilirken bir hata oluştu daha sonra tekrar deneyiniz');
        }
    }
    public static function saveFormFromUser($form_id, Request $request)
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
                        $fileName = CmsHelper::saveFile($request->file($requestName), "files/formFiles/");
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

    public static function exportExcelFromForm(Form $form)
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
}
