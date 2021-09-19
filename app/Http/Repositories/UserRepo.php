<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Repositories;

use App\Models\User;

/**
 * Class UserRepo
 *
 * @package App\Http\Repositories
 */
class UserRepo extends BaseRepo
{

    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        parent::__construct(User::class);
    }
}
