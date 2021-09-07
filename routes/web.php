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


Route::group(['middleware' => ['web', 'check-user-login']], static function () {
    Auth::routes(['login' => false]);
    Auth::routes(['logout' => false]);
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
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// Super Admin Routes
Route::prefix('super-admin')->group(static function () {
    Route::get('/dashboard', 'SuperAdmin\DashboardController@dashboard')->name('super-admin.dashboard');
});

// Sub Admin Routes
Route::prefix('sub-admin')->group(static function () {
    Route::get('/dashboard', 'SubAdmin\DashboardController@dashboard')->name('sub-admin.dashboard');
    Route::get('/awaiting-approval', 'SubAdmin\UserController@awaitingApproval')->name('sub-admin.awaiting-approval');
    Route::post('/user/activate', 'SubAdmin\UserController@activateUser')->name('sub-admin.user-activate');
    Route::get('/withdrawal-requests', 'SubAdmin\WithdrawalRequestController@index')->name('sub-admin.withdrawal-requests');
    Route::get('/approve/withdrawal-request/{id}', 'SubAdmin\WithdrawalRequestController@approveWithdrawalRequest')->name('sub-admin.withdrawal-request.approve');
    Route::get('/decline/withdrawal-requests{id}', 'SubAdmin\WithdrawalRequestController@declineWithdrawalRequest')->name('sub-admin.withdrawal-request.decline');
});

// User Routes
Route::prefix('user')->group(static function () {
    Route::get('/dashboard', 'User\DashboardController@dashboard')->name('user.dashboard');
    Route::get('/withdrawal-requests', 'User\WithdrawalRequestController@index')->name('user.withdrawal-requests');
    Route::post('/withdrawal-request', 'User\WithdrawalRequestController@withdrawRequest')->name('user.withdraw-request');
});


