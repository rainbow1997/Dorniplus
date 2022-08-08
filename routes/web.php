<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\User;
use App\Models\Post;
use App\Models\Province;
use App\Http\Controllers\Auth\Admin\RegionController;
use App\Http\Controllers\Auth\Admin\RoleController;
use App\Http\Controllers\Auth\Admin\UserController;
use App\Http\Controllers\Auth\Admin\LogController;
use App\Http\Controllers\Auth\Admin\PostController;
use App\Charts\UsersChart;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegisterNotification;
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
        'posts' => Post::with(['category','writerPerson'])->paginate(5) //for test *
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
    ->middleware(['auth', 'verified'])->name('editProfile');

Route::put('/storeProfile/{user}',[RegisteredUserController::class,'storeProfile'])
    ->middleware(['auth', 'verified'])->name('storeProfile');

Route::get('/regions',[RegionController::class,'index'])
    ->middleware(['auth','verified'])->name('regions.index');
Route::get('/regions/province/{province}',[RegionController::class,'showProvince'])
    ->middleware(['auth','verified'])->name('regions.province.show');

Route::get('province/create',[RegionController::class,'createProvince'])
    ->middleware(['auth','verified'])->name('regions.province.create');

Route::post('/province/storeProvince',[RegionController::class,'storeProvince'])
    ->middleware(['auth','verified'])->name('regions.province.store');

Route::get('/province/edit/{province}',[RegionController::class,'editProvince'])
    ->middleware(['auth','verified'])->name('regions.province.edit');

Route::put('/province/update/{province}',[RegionController::class,'updateProvince'])
    ->middleware(['auth','verified'])->name('regions.province.update');

Route::delete('/province/destroy/{province}',[RegionController::class,'destroyProvince'])
    ->middleware(['auth','verified'])->name('regions.province.destroy');

Route::get('/city/create/{province}',[RegionController::class,'createCity'])
    ->middleware(['auth','verified'])->name('regions.city.create');

Route::post('/city/storeCity/{province}',[RegionController::class,'storeCity'])
    ->middleware(['auth','verified'])->name('regions.city.store');
Route::delete('/city/destroy/{city}',[RegionController::class,'destroyCity'])
    ->middleware(['auth','verified'])->name('regions.city.destroy');

Route::get('/posts/edit/{post}',[PostController::class,'edit'])
    ->middleware(['auth','verified'])->name('posts.edit');

Route::put('/posts/update/{post}',[PostController::class,'update'])
    ->middleware(['auth','verified'])->name('posts.update');

Route::group(['middleware' => ['auth','verified','role:Admin']], function() {
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('posts',PostController::class);
        Route::get('/reporting/{method}',[UserController::class,'displayUsersReport'])->name('reporting');
        Route::get('/chart',[UsersChart::class,'showChart'])->name('chart');
        Route::get('/logs',[LogController::class,'index'])
            ->name('logs');


    });
Route::get('/captcha',function(){
    return view('helpers/captcha_show');
});
Route::get('/captcha2',function(){
    return captchaMaking();
});
Route::get('/information',function(){

    return phpinfo();
    //return $provinces;
});

Route::get('/test-mail', function (){
    Notification::route('mail', 'personal@mostafajamali.ir')->notify(new RegisterNotification(Auth::user()));
    return 'Sent';
});
require __DIR__.'/auth.php';
