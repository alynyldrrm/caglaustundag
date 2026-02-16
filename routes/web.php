<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactSettingsController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormAnswerController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValueController;
use App\Http\Controllers\WebsiteSettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('admin', function () {
    return redirect()->route('admin.menu.index');
});

/* Dil prefix'siz direkt erişim - Yönlendirmeler */
Route::get('/iletisim', function () {
    return redirect('/tr/iletisim', 301);
});
Route::get('/communication', function () {
    return redirect('/en/communication', 301);
});

Route::middleware(['setLanguage', 'defaultDatas'])->group(function () {
    /* Dil prefix'i olmayan URL'leri /tr/ ile yönlendir */
    Route::get('/{permalink}', function ($permalink) {
        // Eğer permalink bir dil kodu değilse, TR'ye yönlendir
        $languages = ['tr', 'en'];
        if (!in_array($permalink, $languages)) {
            return redirect('/tr/' . $permalink, 301);
        }
        // Eğer dil koduysa, ClientController@index'e git
        return app()->make(ClientController::class)->index();
    })->where('permalink', '[a-zA-Z0-9-]+');

    Route::middleware("defaultDatas")->group(function () {
        /* Admin Rotaları */
        Route::middleware('AuthCheck:admin')->prefix('admin')->group(function () {
            Route::withoutMiddleware("AuthCheck:admin")->prefix('Auth')->group(function () {
                Route::get('/login', [AuthController::class, 'index'])->name('login.get');
                Route::post('/login', [AuthController::class, 'login'])->name('login.post');
            });
            Route::middleware('can:Dil Yönetimi')->prefix('languages')->group(function () {
                Route::get('index', [LanguageController::class, 'index'])->name('admin.language.index');
                Route::get('create', [LanguageController::class, 'create'])->name('admin.language.create');
                Route::post('store', [LanguageController::class, 'store'])->name('admin.language.store');
                Route::get('edit/{id}', [LanguageController::class, 'edit'])->name('admin.language.edit');
                Route::post('update/{id}', [LanguageController::class, 'update'])->name('admin.language.update');
                Route::get('destroy/{id}', [LanguageController::class, 'destroy'])->name('admin.language.destroy');
            });
            Route::/*middleware('can:Menü Yönetimi')->*/prefix('menus')->group(function () {
                Route::get('index', [MenuController::class, 'index'])->name('admin.menu.index');
                Route::get('create', [MenuController::class, 'create'])->name('admin.menu.create');
                Route::post('store', [MenuController::class, 'store'])->name('admin.menu.store');
                Route::get('edit/{id}', [MenuController::class, 'edit'])->name('admin.menu.edit');
                Route::post('update/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
                Route::get('destroy/{id}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');

                Route::get('destroyFile/{type}/{id}', [MenuController::class, 'destroyFile'])->name('admin.menu.destroyFile');
                Route::get('sort', [MenuController::class, 'sort'])->name('admin.menu.sort');
            });
            Route::middleware('can:Rol Yönetimi')->prefix('permissions')->group(function () {
                Route::get('index', [PermissionController::class, 'index'])->name('admin.permissions.index');
                Route::post('store', [PermissionController::class, 'store'])->name('admin.permissions.store');
                Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
                Route::post('update/{id}', [PermissionController::class, 'update'])->name('admin.permissions.update');
                Route::get('destroy/{id}', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');
            });
            Route::middleware('can:Kullanıcı Yönetimi')->prefix('users')->group(function () {
                Route::get('index', [UserController::class, 'index'])->name('admin.user.index');
                Route::get('create', [UserController::class, 'create'])->name('admin.user.create');
                Route::post('store', [UserController::class, 'store'])->name('admin.user.store');
                Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
                Route::post('update/{id}', [UserController::class, 'update'])->name('admin.user.update');
                Route::get('destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
            });
            Route::middleware('can:Tip Yönetimi')->prefix('types')->group(function () {
                Route::get('index', [TypeController::class, 'index'])->name('admin.type.index');
                Route::get('create', [TypeController::class, 'create'])->name('admin.type.create');
                Route::post('store', [TypeController::class, 'store'])->name('admin.type.store');
                Route::get('edit/{id}', [TypeController::class, 'edit'])->name('admin.type.edit');
                Route::post('update/{id}', [TypeController::class, 'update'])->name('admin.type.update');
                Route::get('destroy/{id}', [TypeController::class, 'destroy'])->name('admin.type.destroy');

                Route::get('sort', [TypeController::class, 'sort'])->name('admin.type.sort');
                Route::get('field-sort', [TypeController::class, 'field_sort'])->name('admin.field.sort');
            });
            Route::middleware('can:İçerik Yönetimi')->prefix('values')->group(function () {
                Route::get('/index/{type_id}', [ValueController::class, 'index'])->name('admin.value.index');
                Route::get('/create/{type_id}', [ValueController::class, 'create'])->name('admin.value.create');
                Route::post('/store/{type_id}', [ValueController::class, 'store'])->name('admin.value.store');
                Route::get('/edit/{value_id}/{type_id}', [ValueController::class, 'edit'])->name('admin.value.edit');
                Route::post('/update/{value_id}', [ValueController::class, 'update'])->name('admin.value.update');
                Route::get('/destroy/{value_id}/{type_id}', [ValueController::class, 'destroy'])->name('admin.value.destroy');

                Route::get('sort/{type_id}', [ValueController::class, 'sort'])->name('admin.value.sort');

                Route::post('saveFiles', [FileController::class, 'saveFiles'])->name('admin.saveFiles');
                Route::get('removeFile/{id?}', [FileController::class, 'removeFile'])->name('admin.removeFile');
                Route::get('fileSort', [FileController::class, 'sort'])->name('admin.file.sort');
            });
            Route::middleware('can:İçerik Yönetimi')->prefix('website-settings')->group(function () {
                Route::get('edit', [WebsiteSettingsController::class, 'edit'])->name('admin.website-settings.edit');
                Route::post('update', [WebsiteSettingsController::class, 'update'])->name('admin.website-settings.update');
            });
            Route::middleware('can:İçerik Yönetimi')->prefix('contact-settings')->group(function () {
                Route::get('create/{type_id}', [ContactSettingsController::class, 'create'])->name('admin.contact-settings.create');
                Route::post('store/{type_id}', [ContactSettingsController::class, 'store'])->name('admin.contact-settings.store');
                Route::get('edit/{id}', [ContactSettingsController::class, 'edit'])->name('admin.contact-settings.edit');
                Route::post('update/{id}', [ContactSettingsController::class, 'update'])->name('admin.contact-settings.update');
                Route::get('destroy/{id}', [ContactSettingsController::class, 'destroy'])->name('admin.contact-settings.destroy');
            });
            Route::middleware('can:Çeviri Yönetimi')->prefix('translations')->group(function () {
                Route::get('index', [TranslationController::class, 'index'])->name('admin.translation.index');
                Route::get('scan', [TranslationController::class, 'scan'])->name('admin.translation.scan');
                Route::post('update', [TranslationController::class, 'update'])->name('admin.translation.update');
            });
            Route::middleware('can:Form Yönetimi')->prefix('forms')->group(function () {
                Route::get('show/{id}', [FormController::class, 'show'])->name('admin.form.show');
                Route::get('create/{type_id}', [FormController::class, 'create'])->name('admin.form.create');
                Route::post('store/{type_id}', [FormController::class, 'store'])->name('admin.form.store');
                Route::get('edit/{id}', [FormController::class, 'edit'])->name('admin.form.edit');
                Route::post('update/{id}', [FormController::class, 'update'])->name('admin.form.update');
                Route::get('destroy/{id}', [FormController::class, 'destroy'])->name('admin.form.destroy');
                Route::get('exportExcel/{id}', [FormController::class, 'exportExcel'])->name('admin.form.export-excel');

                Route::get('sort/{form_id}', [FormController::class, 'sort'])->name('admin.form.sort');
            });
            Route::middleware('can:Form Yönetimi')->prefix('form-answers')->group(function () {
                Route::get('check/{id}', [FormAnswerController::class, 'check'])->name('admin.form-answer.check');
                Route::get('destroy/{id}', [FormAnswerController::class, 'destroy'])->name('admin.form-answer.destroy');
            });
        });
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        /* Client Rotaları */
        Route::get('{language_key?}', [ClientController::class, 'index'])->name('clientHome');
        Route::get('{language_key?}/{menu_permalink?}/{value_permalink?}', [ClientController::class, 'showPage'])->name('showPage');
        /* İletişim Formu Rotası */
        Route::post('{language_key}/iletisim', [ClientController::class, 'sendContact'])->name('contact.send');
    });
});
/*Resimleri getiren rota*/
Route::get('image{path}', function (League\Glide\Server $server, $path, Request $request) {
    parse_str(parse_url(getImageLink($path, $request->all()), PHP_URL_QUERY), $safeUrlQueryParams);
    if ($safeUrlQueryParams["s"] != $request->s) {
        abort(404);
    }
    die($server->outputImage($path, $_GET));
})->name('getImage')->where('path', '.*');

Route::post('form/{id}', function ($id, Request $request) {
    return saveFormFromUser($id, $request);
 })->name("form");//->middleware('recaptcha');
