<?php

namespace App\Http\Contracts;

/**
 * Interface IUserServiceContract
 *
 * @package App\Http\Contracts
 */
interface IUserServiceContract
{

    /**
     * @param $token
     *
     * @return mixed
     */
    public function findUserByEmailVerificationToken($token);

    /**
     * @return mixed
     */
    public function getAwaitingApprovalUsers();

    /**
     * @return mixed
     */
    public function getAwaitingApprovalUsersCount();

    /**
     * @param $id
     *
     * @return mixed
     */
    public function activate($id);

}
