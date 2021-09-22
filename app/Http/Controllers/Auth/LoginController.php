<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Controllers\Auth;

use App\Helpers\GeneralHelper;
use App\Helpers\IUserStatus;
use App\Helpers\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Traits\HasRoles;
use View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Get Users Roles
     */
    use HasRoles;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectTo()
    {
        if($user = Auth::user())
        {
            if (GeneralHelper::IS_ADMIN()){
                return redirect('/admin/dashboard');
            }
            if (GeneralHelper::IS_SUPERVISOR()){
                return redirect('/supervisor/dashboard');
            }
            if (GeneralHelper::IS_BLOGGER()){
                return redirect('/blogger/dashboard');
            }
        }
    }

    /**
     * @param  Request $request
     *
     * @return RedirectResponse|Redirector
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * The blogger has been authenticated.
     *
     * @param Request $request Request data
     * @param mixed   $user    User object
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $msg = '';
        if ($user->verify == 0) {
            $msg = "Email not verified";
        } elseif ($user->status == 0) {
            $msg = "User is disabled";
        } else {
            return;
        }

        Session::flash('error', $msg);
        Auth::logout();
        return redirect('/');
    }

    /**
     * User Register Form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function registerUser($username = null)
    {
        return view::make('auth.user-register');
    }

    /**
     *
     */
    public function loginUser(Request $request)
    {
        $user = \App\Models\User::where('email', $request["email"])->first();
        if($user)
        {
            if(Hash::check($request["password"], $user->password))
            {
                if($user->verify == IUserStatus::VERIFIED)
                {
                    Auth::loginUsingId($user->id, true);
                    return GeneralHelper::SEND_RESPONSE($request, $user,GeneralHelper::GET_ROLE($user).'.dashboard',"Successfully logged in");
                }else{
                    return GeneralHelper::SEND_RESPONSE($request, null,'login',null, "Verify your email first");
                }
            }else{
                return GeneralHelper::SEND_RESPONSE($request, null,'login',null, "Password is Incorrect");
            }
        }else{
            return GeneralHelper::SEND_RESPONSE($request, null,'login',null, "Something went wrong");
        }
    }
}
