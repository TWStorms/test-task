<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

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

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['web', 'check-blogger-login']], static function () {
    Auth::routes(['login' => false]);
    Auth::routes(['logout' => false]);
    Route::get('/login', function () {
        return redirect('/');
    })->name('login');

    Route::post('/login-blogger', 'Auth\LoginController@loginUser')->name('login.blogger');

    Route::get('password/reset/{id}/{token}', 'Auth\ResetPasswordController@showResetForm')
        ->name('password.reset');
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('/register-user', 'Auth\LoginController@registerUser')->name('invitation.username.sign-up');

    Route::post('/create-blogger', 'Auth\RegisterController@registerUser')->name('create.blogger');
    Route::post('/sign-up', 'Auth\RegisterController@signUp')->name('signUp');
});
    Route::post('blogger/change-password', 'Blogger\UserController@changePassword')->name('blogger.change-password');
    Route::post('supervisor/change-password', 'Supervisor\UserController@changePassword')->name('supervisor.change-password');
    Route::post('admin/change-password', 'Admin\UserController@changePassword')->name('admin.change-password');


Route::group(['middleware' => ['guest']], static function () {

    Route::get('verify/email/{token}', 'VerifyUserController@verifyUser');

});
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// Admin Routes
Route::prefix('admin')->group(static function () {
    Route::get('/dashboard', 'Admin\DashboardController@dashboard')->name('admin.dashboard');
    Route::get('/profile', 'ProfileController@profile')->name('admin.profile');
    Route::post('/create-supervisor', 'Admin\UserController@createSupervisor')->name('admin.supervisor.create');
    Route::get('/users', 'Admin\UserController@index')->name('admin.users');
    Route::get('/edit-user/{id}', 'Admin\UserController@edit')->name('admin.user.edit');
    Route::post('/update-user', 'Admin\UserController@update')->name('admin.user.update');
    Route::get('/blog', 'Admin\BlogController@index')->name('admin.blog');
    Route::post('/blog-create', 'Admin\BlogController@create')->name('admin.blog.create');
    Route::get('/blog-edit/{id}', 'Admin\BlogController@edit')->name('admin.blog.edit');
    Route::post('/blog-update', 'Admin\BlogController@update')->name('admin.blog.update');
});

// Supervisor Routes
Route::prefix('supervisor')->group(static function () {
    Route::get('/dashboard', 'Supervisor\DashboardController@dashboard')->name('supervisor.dashboard');
    Route::get('/profile', 'ProfileController@profile')->name('supervisor.profile');
    Route::get('/bloggers', 'Supervisor\UserController@bloggers')->name('supervisor.bloggers');
    Route::get('/edit-blogger/{id}', 'Supervisor\UserController@edit')->name('supervisor.blogger.edit');
    Route::post('/update-blogger', 'Supervisor\UserController@update')->name('supervisor.blogger.update');
    Route::get('/blog', 'Supervisor\BlogController@index')->name('supervisor.blog');
    Route::post('/blog-create', 'Supervisor\BlogController@create')->name('supervisor.blog.create');
    Route::get('/blog-edit/{id}', 'Supervisor\BlogController@edit')->name('supervisor.blog.edit');
    Route::post('/blog-update', 'Supervisor\BlogController@update')->name('supervisor.blog.update');
});

// blogger Routes
Route::prefix('blogger')->group(static function () {
    Route::get('/dashboard', 'Blogger\DashboardController@dashboard')->name('blogger.dashboard');
    Route::get('/profile', 'ProfileController@profile')->name('blogger.profile');
    Route::get('/blog', 'Blogger\BlogController@index')->name('blogger.blog');
    Route::post('/blog-create', 'Blogger\BlogController@create')->name('blogger.blog.create');
    Route::get('/blog-edit/{id}', 'Blogger\BlogController@edit')->name('blogger.blog.edit');
    Route::post('/blog-update', 'Blogger\BlogController@update')->name('blogger.blog.update');
});
