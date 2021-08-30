<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Request;
use App\Http\Contracts\IUserServiceContract;
use Illuminate\Support\Facades\Auth;

/**
 * Class VerifyUserController
 *
 * @package App\Http\Controllers
 */
class VerifyUserController extends Controller
{

    /**
     * Interface IUserServiceContract
     *
     * @var IUserServiceContract
     */
    private $_userService;

    /**
     * DashboardController constructor.
     *
     * @param IUserServiceContract $_userService
     */
    public function __construct(
        IUserServiceContract $_userService
    )
    {
        $this->_userService = $_userService;
    }

    public function verifyUser($token, Request $request)
    {
        if($user = $this->_userService->findUserByEmailVerificationToken($token))
        {
            $user->email_verification_code = null;
            $user->verify = 1;
            $user->save();
            if(Auth::loginUsingId($user->id, true))
            {
                return GeneralHelper::SEND_RESPONSE($request, $user,'home', "You have successfully log in.");
            }
        }

    }
}
