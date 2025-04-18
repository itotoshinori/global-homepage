<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\ImageUpController;
use App\Http\Controllers\InfoController;
use App\lib\My_func;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('internal/infos', InfoController::class)->middleware('auth');
Route::post('/internal/infos/download/{id}', [InfoController::class, 'download'])->name('infos.download')->middleware('auth');
Route::post('/internal/infos/send_mail/{id}', [InfoController::class, 'send_mail'])->name('infos.send_mail')->middleware('auth');
Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
Route::resource('articles', ArticleController::class)->only(['show', 'create', 'edit']);
Route::resource('articles', ArticleController::class)->except(['index', 'show'])->middleware('auth');
Route::resource('/users', UserController::class)->only(['index', 'update', 'destroy'])->middleware('auth');
Route::post('/users/pw_change/{id}', [UserController::class, 'pw_change'])->name('users.pw_change')->middleware('auth');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::post('/adoption', [AdoptionController::class, 'send'])->name('adoption.send');
Route::get('/googleff047b634a403ed8.html', function () {
    return \File::get(public_path() . '/googleff047b634a403ed8.html');
});
Route::resource('imageup', ImageUpController::class)->only(['index', 'create', 'store',])->middleware('auth');
$my_func = new My_func();
$urls = $my_func->urls();
foreach ($urls as $url) {
    Route::get('/' . $url, [ArticleController::class, 'show']);
}
require __DIR__ . '/auth.php';