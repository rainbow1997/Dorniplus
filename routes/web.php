<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/captcha',function(){
    return view('helpers/captcha_show');
});
Route::get('/captcha2',function(){
    return captchaMaking();
});
Route::get('/information',function(){
    return phpinfo();
});

require __DIR__.'/auth.php';//By Starter kit.
