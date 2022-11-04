<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\ResisterProtectController;
use PHPUnit\Framework\MockObject\Rule\InvokedAtIndex;

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

//Route::get('/', function () {
//return view('welcome');
//});
Route::resource('/', ArticleController::class)->only(['index']);
Route::resource('articles', ArticleController::class)->only(['index','show','create','edit']);
Route::resource('articles', ArticleController::class)->except(['index','show'])->middleware('auth');
Route::resource('/users', UserController::class)->only(['index','destroy'])->middleware('auth');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/contact', [ContactController::class,'send'])->name('contact.send');
Route::post('/adoption', [AdoptionController::class,'send'])->name('adoption.send');
//URL::forceScheme('https');
Route::get('/', function () {
    return \File::get(public_path() . '/googleff047b634a403ed8.html');
});
require __DIR__.'/auth.php';
