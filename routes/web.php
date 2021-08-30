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

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['web']], static function () {
    Auth::routes(['login' => false]);
    Route::get('/login', function () {
        return redirect('/');
    })->name('login');

    Route::post('/login-user', 'Auth\LoginController@loginUser')->name('login.user');

    Route::get('password/reset/{id}/{token}', 'Auth\ResetPasswordController@showResetForm')
        ->name('password.reset');
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('/register-user', 'Auth\LoginController@registerUser');

    Route::post('/create-user', 'Auth\RegisterController@registerUser')->name('create.user');
    Route::post('/sign-up', 'Auth\RegisterController@signUp')->name('signUp');
});

Route::group(['middleware' => ['guest']], static function () {

    Route::get('verify/email/{token}', 'VerifyUserController@verifyUser');

});
Route::get('/home', 'HomeController@index')->name('home');


