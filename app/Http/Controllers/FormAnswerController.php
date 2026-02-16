<?php

namespace App\Http\Controllers;

use App\Models\FormAnswer;
use Illuminate\Http\Request;

class FormAnswerController extends Controller
{
    function check($id)
    {
        $formAnswer = FormAnswer::find($id);
        if (!$formAnswer) {
            return redirect()->back()->withErrors(['Kayıt bulunamadı!']);
        }
        if ($formAnswer->checked) {
            $formAnswer->update(["checked" => false]);
        } else {
            $formAnswer->update(["checked" => true]);
        }
        return redirect()->back()->with('success', "Güncelleme işlemi başarılı.");
    }

    function destroy($id)
    {
        $formAnswer = FormAnswer::find($id);
        if (!$formAnswer) {
            return redirect()->back()->withErrors(['Kayıt bulunamadı!']);
        }
        $formAnswer->delete();
        return redirect()->back()->with('success', "Silme işlemi başarılı.");
    }
}
