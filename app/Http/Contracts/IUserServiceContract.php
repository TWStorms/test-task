<?php

namespace App\Http\Contracts;

/**
 * Interface IUserServiceContract
 *
 * @package App\Http\Contracts
 */
interface IUserServiceContract
{

    public function findUserByEmailVerificationToken($token);
}
