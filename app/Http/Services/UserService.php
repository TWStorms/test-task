<?php

namespace App\Http\Services;

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Log;
use App\Http\Repositories\UserRepo;
use Illuminate\Support\Facades\Validator;
use App\Http\Contracts\IUserServiceContract;

/**
 * Class UserService
 *
 * @package App\Http\Services
 */
class UserService implements IUserServiceContract
{

    /**
     * @var UserRepo
     */
    private $_userRepo;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->_userRepo = new UserRepo();
    }

    public function findUserByEmailVerificationToken($token)
    {
        return $this->_userRepo->findByClause(['email_verification_code' => $token])->first();
    }
}
