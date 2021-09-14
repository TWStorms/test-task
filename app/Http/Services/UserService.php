<?php

namespace App\Http\Services;

use App\Helpers\GeneralHelper;
use App\Helpers\IUserStatus;
use App\Helpers\User;
use Illuminate\Support\Facades\Auth;
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

    /**
     * @param $token
     *
     * @return mixed
     */
    public function findUserByEmailVerificationToken($token)
    {
        return $this->_userRepo->findByClause(['email_verification_code' => $token])->first();
    }

    /**
     * @return mixed
     */
    public function getAwaitingApprovalUsers()
    {
        return $this->_userRepo->findByClause([ 'status' => IUserStatus::IN_ACTIVE ])->paginate(GeneralHelper::PAGINATION_SIZE());
    }

    /**
     * @return mixed
     */
    public function getAwaitingApprovalUsersCount()
    {
        return $this->_userRepo->findByClause([ 'status' => IUserStatus::IN_ACTIVE ])->count();
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function activate($id)
    {
        return $this->_userRepo->findById($id)->update(['status'=> IUserStatus::ACTIVE]);
    }

    /**
     * @param $userId
     *
     * @return object
     */
    public function findById($userId)
    {
        return $this->_userRepo->findById($userId);
    }

    /**
     * @param $parentId
     *
     * @return mixed|void
     */
    public function getChildrens($parentId)
    {
        return $this->_userRepo->findByClause(['parent_id' => $parentId])->paginate(GeneralHelper::PAGINATION_SIZE());
    }

    /**
     * @param $parentId
     *
     * @return mixed|void
     */
    public function getChildrensCount($parentId)
    {
        return $this->_userRepo->findByClause(['parent_id' => $parentId])->count();
    }

    /**
     * @param $array
     *
     * @return mixed|void
     */
    public function findByClause($array)
    {
        return $this->_userRepo->findByClause($array);
    }
}
