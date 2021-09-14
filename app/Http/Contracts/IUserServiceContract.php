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

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function findById($userId);

    /**
     * @param $parentId
     *
     * @return mixed
     */
    public function getChildrens($parentId);

    /**
     * @param $parentId
     *
     * @return mixed
     */
    public function getChildrensCount($parentId);

    /**
     * @param $array
     *
     * @return mixed
     */
    public function findByClause($array);





}
