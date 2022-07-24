<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\User;
use App\Models\Post;
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
   
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'posts' => Post::with(['category','writerPerson'])->get() //for test *
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/code_verification',function(){
    return view('auth/code_verification');
})->name('code_verification');
Route::post('/checking_verification',[VerifyEmailController::class,'checkingCode'])
->name('checking_verification')
->withoutMiddleware(['auth']);

Route::get('/changePassword',[RegisteredUserController::class,'changePasswordIndex'])
    ->middleware(['auth', 'verified','password.confirm'])->name('changePassword');

Route::post('/changePassword',[RegisteredUserController::class,'changePassword'])
    ->middleware(['auth', 'verified','password.confirm'])->name('changePassword.save');

Route::get('/editProfile',[RegisteredUserController::class,'editProfile'])
    ->middleware(['auth', 'verified','can:see-edit-profile-page'])->name('editProfile');

Route::put('/storeProfile/{id}',[RegisteredUserController::class,'storeProfile'])
    ->middleware(['auth', 'verified','can:see-edit-profile-page'])->name('storeProfile');


Route::get('/captcha',function(){
    return view('helpers/captcha_show');
});
Route::get('/captcha2',function(){
    return captchaMaking();
});
Route::get('/information',function(){
    return phpinfo();
});
require __DIR__.'/auth.php';
