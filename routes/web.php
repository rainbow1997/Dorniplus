<?php

use App\Charts\UsersChart;
use App\Http\Controllers\Auth\Admin\CategoryController;
use App\Http\Controllers\Auth\Admin\CommentManagerController;
use App\Http\Controllers\Auth\Admin\DashboardController;
use App\Http\Controllers\Auth\Admin\LogController;
use App\Http\Controllers\Auth\Admin\PermissionController;
use App\Http\Controllers\Auth\Admin\PostController;
use App\Http\Controllers\Auth\Admin\RegionController;
use App\Http\Controllers\Auth\Admin\RoleController;
use App\Http\Controllers\Auth\Admin\SiteAdminController;
use App\Http\Controllers\Auth\Admin\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Notifications\RegisterNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::get('/setLang/{lang}', function ($lang) {
    request()->session()->put('lang', $lang);
    return Inertia::location(route('homepage'));
    //return Redirect::route('homepage');
})->name('setLang');
Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/posts/{post}/title/{slug}', [HomeController::class, 'showPost'])->name('home.post.show');
Route::post('/sendComment/{post}', [CommentController::class, 'store'])->name('sendNewComment');

Route::get('captcha2', function () {
    return captchaMaking();
})->name('captchaImg');

Route::group([
    'middleware' => 'guest'
], function () {


    Route::get('/captcha', function () {
        return view('helpers/captcha_show');
    });

    Route::get('/information', function () {

        return phpinfo();
        //return $provinces;
    });

    Route::get('/test-mail', function () {
        Notification::route('mail', 'personal@mostafajamali.ir')->notify(new RegisterNotification(Auth::user()));
        return 'Sent';
    });
});
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'auth'
], function () {

    Route::get('code_verification',[AuthenticatedSessionController::class,'code_verification'])
        ->name('code_verification');

    Route::post('checking_verification', [AuthenticatedSessionController::class, 'checkingCode'])
        ->name('checking_verification');
});
Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'admin'
], function () {
    Route::resource('categories', CategoryController::class);//permissions in its controller
    Route::resource('comments', CommentController::class);
    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class);

    Route::get('/reporting/{method}', [UserController::class, 'displayUsersReport'])->name('reporting');
    Route::get('/downloading/{tempFile}', [UserController::class, 'downloading'])->name('downloading');
    Route::post('getReport', [UserController::class, 'getReport'])->name('users.report');
    Route::get('/chart', [UsersChart::class, 'showChart'])->name('chart');
    Route::get('/logs', [LogController::class, 'index'])
        ->name('logs');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/changePassword', [RegisteredUserController::class, 'changePasswordIndex'])
        ->middleware(['password.confirm'])->name('changePassword');

    Route::post('/changePassword', [RegisteredUserController::class, 'changePassword'])
        ->middleware(['password.confirm'])->name('changePassword.save');

    Route::get('/editProfile', [RegisteredUserController::class, 'editProfile'])
        ->name('editProfile');

    Route::put('/storeProfile/{user}', [RegisteredUserController::class, 'storeProfile'])
        ->name('storeProfile');

    Route::get('/regions', [RegionController::class, 'index'])
        ->name('regions.index');
    Route::get('/regions/province/{province}', [RegionController::class, 'showProvince'])
        ->name('regions.province.show');

    Route::get('province/create', [RegionController::class, 'createProvince'])
        ->name('regions.province.create');

    Route::post('/province/storeProvince', [RegionController::class, 'storeProvince'])
        ->name('regions.province.store');

    Route::get('/province/edit/{province}', [RegionController::class, 'editProvince'])
        ->name('regions.province.edit');

    Route::put('/province/update/{province}', [RegionController::class, 'updateProvince'])
        ->name('regions.province.update');

    Route::delete('/province/destroy/{province}', [RegionController::class, 'destroyProvince'])
        ->name('regions.province.destroy');

    Route::get('/city/create/{province}', [RegionController::class, 'createCity'])
        ->name('regions.city.create');

    Route::post('/city/storeCity/{province}', [RegionController::class, 'storeCity'])
        ->name('regions.city.store');
    Route::delete('/city/destroy/{city}', [RegionController::class, 'destroyCity'])
        ->name('regions.city.destroy');


});
Route::group([
    'prefix' => 'admin',
    'middleware' => ['role:Super Admin']
], function () {

    Route::resource('comments', CommentManagerController::class);

    Route::resource('roles', RoleController::class);

    Route::resource('permissions', PermissionController::class);

    Route::get('/addRoleToPermission/{permission}', [PermissionController::class, 'addRole'])
        ->name('addRoleToPermission');
    Route::put('/setRoleToPermission/{permission}', [PermissionController::class, 'setRoleToPermission'])
        ->name('setRoleToPermission');

    Route::delete('/destroyRoleFromPermission/role/{role}/permission/{permission}', [PermissionController::class, 'destroyRoleFromPermission'])
        ->name('destroyRoleFromPermission');
    Route::resource('site_admin', SiteAdminController::class);


});

require __DIR__ . '/auth.php';
