<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

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
     * @return mixed
     */
    public function getAllUser();

    /**
     * @return mixed
     */
    public function getAllCount();

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

    /**
     * @return mixed
     */
    public function update($id, $array);

    /**
     * @return mixed
     */
    public function create($request);





}
