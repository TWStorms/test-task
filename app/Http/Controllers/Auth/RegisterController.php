<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Controllers\Auth;

use App\Helpers\GeneralHelper;
use App\Helpers\IUserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    # Mail View
    const VERIFICATION_EMAIL = 'mail.verification-email';

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referer_code' => ['required'],
            'phone_number' => ['required']
        ]);
    }

    /**
     * Create a new blogger instance after a valid registration.
     *
     * @param array $data
     *
     * @return JsonResponse|Redirector|RedirectResponse
     */
    protected function create(array $data)
    {

    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function registerUser(Request $request)
    {
        if(\App\Models\User::where('email', $request->email)->first())
        {
            return GeneralHelper::SEND_RESPONSE($request, null,'login', null, "Email already exist");
        }

        $user = \App\Models\User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verified_at' => now()->format('Y-m-d H:i:s'),
            'remember_token' => GeneralHelper::STR_RANDOM(50),
            'email_verification_code' => GeneralHelper::STR_RANDOM(50),
            'verify' => IUserStatus::NOT_VERIFIED,
            'status' => IUserStatus::ACTIVE,
        ]);
        $user->assignRole('blogger');

        GeneralHelper::mail(array('name' => $user->username, 'token' => $user->email_verification_code), $user->username, $user->email, self::VERIFICATION_EMAIL);

        return GeneralHelper::SEND_RESPONSE($request, $user,'login', "We send a verification email to your account.");
    }
}
