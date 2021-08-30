<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return JsonResponse|Redirector|RedirectResponse
     */
    protected function create(array $data)
    {

        if($parent = \App\Models\User::where('referer_code', $data['referer_code'])->first()) {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone_number' => $data['phone_number'],
                'parent_id' => $parent->id,
                'level_completed' => 0,
                'child_count' => 0,
                'verified_at' => now()->format('Y-m-d H:i:s'),
                'referer_code' => GeneralHelper::STR_RANDOM(16),
                'registration_code' => GeneralHelper::STR_RANDOM(16),
                'remember_token' => GeneralHelper::STR_RANDOM(10),
                'email_verification_code' => GeneralHelper::STR_RANDOM(10),
                'verify' => 0,
                'status' => 0,
            ]);
            $user->assignRole('user');

            $parent->child_count += 1;
            $parent->save();

            return $user;
        }
    }

    public function registerUser(Request $request)
    {
        if($parent = \App\Models\User::where('referer_code', $request->referer_code)->first()) {
            $user = \App\Models\User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'parent_id' => $parent->id,
                'level_completed' => 0,
                'child_count' => 0,
                'verified_at' => now()->format('Y-m-d H:i:s'),
                'referer_code' => GeneralHelper::STR_RANDOM(50),
                'registration_code' => GeneralHelper::STR_RANDOM(50),
                'remember_token' => GeneralHelper::STR_RANDOM(50),
                'email_verification_code' => GeneralHelper::STR_RANDOM(50),
                'verify' => 0,
                'status' => 0,
            ]);
            $user->assignRole('user');

            $parent->child_count += 1;
            $parent->save();

            GeneralHelper::mail(array('name' => $user->username, 'token' => $user->email_verification_code), $user->username, $user->email, self::VERIFICATION_EMAIL);

            return GeneralHelper::SEND_RESPONSE($request, $user,'login', "We send a verification email to your account.");
        }
        return GeneralHelper::SEND_RESPONSE($request, null,'login', null, "Something went wrong");
    }
}
