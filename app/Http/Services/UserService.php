<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Services;

use App\Helpers\GeneralHelper;
use Illuminate\Support\Carbon;
use App\Helpers\IUserStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
     * @return mixed|void
     */
    public function getAllUser()
    {
        return $this->_userRepo->paginate(GeneralHelper::PAGINATION_SIZE());
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
     * @return mixed|void
     */
    public function getAllCount()
    {
        return $this->_userRepo->count();
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

    /**
     * @param $id
     * @param $array
     *
     * @return bool
     */
    public function update($id, $array)
    {
        return $this->_userRepo->update($id, $array);
    }

    /**
     * @param $request
     *
     * @return object
     */
    public function create($request)
    {
        return $this->_userRepo->create(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'password' => Hash::make($request->password), 'verify' => IUserStatus::VERIFIED, 'status' => IUserStatus::ACTIVE, 'verified_at' => Carbon::now()->format('Y-m-d H:i:s'), 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
