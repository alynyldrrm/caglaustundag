<?php

use App\Http\Controllers\UyeController;
use App\Models\City;
use App\Models\Town;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('iller', function () {
    return response()->json(City::all()->toArray());
});
Route::get('ilceler/{city_id}', function ($id) {
    return response()->json(Town::where('city_id', $id)->get()->toArray());
});
