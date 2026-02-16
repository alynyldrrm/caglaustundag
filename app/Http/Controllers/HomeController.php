<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    function index()
    {
        removeUnusedFiles();
        return redirect()->route('admin.menu.index');
    }
}
