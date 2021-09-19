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
    Route::get('/register-user/{username?}', 'Auth\LoginController@registerUser')->name('invitation.username.sign-up');

    Route::post('/create-user', 'Auth\RegisterController@registerUser')->name('create.user');
    Route::post('/sign-up', 'Auth\RegisterController@signUp')->name('signUp');
    Route::post('/sign-up', 'Auth\RegisterController@signUp');
});
    Route::post('/change/password', 'User\UserController@changePassword')->name('user.change-password');


Route::group(['middleware' => ['guest']], static function () {

    Route::get('verify/email/{token}', 'VerifyUserController@verifyUser');

});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/contact-us', 'ContactUsController@page')->name('contact-us');
Route::post('/contact-us/send', 'ContactUsController@send')->name('contact-us.send');
Route::get('/about-us', 'AboutUsController@page')->name('about-us');
Route::get('/term-condition', 'TermConditionController@page')->name('term-condition');
Route::get('/policy', 'PolicyController@page')->name('policy');

// Super Admin Routes
Route::prefix('super-admin')->group(static function () {
    Route::get('/dashboard', 'SuperAdmin\DashboardController@dashboard')->name('super-admin.dashboard');
    Route::get('/profile', 'ProfileController@profile')->name('super-admin.profile');
    Route::get('/transactions', 'SuperAdmin\TransactionController@index')->name('super-admin.transactions');
    Route::get('/users', 'SuperAdmin\UserController@index')->name('super-admin.users');
    Route::get('/map/{username}', 'SuperAdmin\UserController@map')->name('super-admin.map');
});

// Sub Admin Routes
Route::prefix('sub-admin')->group(static function () {
    Route::get('/dashboard', 'SubAdmin\DashboardController@dashboard')->name('sub-admin.dashboard');
    Route::get('/profile', 'ProfileController@profile')->name('sub-admin.profile');
    Route::get('/awaiting-approval', 'SubAdmin\UserController@awaitingApproval')->name('sub-admin.awaiting-approval');
    Route::post('/user/activate', 'SubAdmin\UserController@activateUser')->name('sub-admin.user-activate');
    Route::get('/withdrawal-requests', 'SubAdmin\WithdrawalRequestController@index')->name('sub-admin.withdrawal-requests');
    Route::get('/approve/withdrawal-request/{id}', 'SubAdmin\WithdrawalRequestController@approveWithdrawalRequest')->name('sub-admin.withdrawal-request.approve');
    Route::get('/decline/withdrawal-requests{id}', 'SubAdmin\WithdrawalRequestController@declineWithdrawalRequest')->name('sub-admin.withdrawal-request.decline');
});

// User Routes
Route::prefix('user')->group(static function () {
    Route::get('/dashboard', 'User\DashboardController@dashboard')->name('user.dashboard');
    Route::get('/profile', 'ProfileController@profile')->name('user.profile');
    Route::get('/withdrawal-requests', 'User\WithdrawalRequestController@index')->name('user.withdrawal-requests');
    Route::post('/withdrawal-request', 'User\WithdrawalRequestController@withdrawRequest')->name('user.withdraw-request');
    Route::get('/users', 'User\UserController@index')->name('user.children');
    Route::get('/transactions', 'User\TransactionController@index')->name('user.transactions');
    Route::get('/map/{username}', 'User\UserController@map')->name('user.map');
});
