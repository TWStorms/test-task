<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Helpers;

/**
 * Interface IUserStatus
 *
 * @package App\Helpers
 */
interface IUserStatus
{
    const ACTIVE = 2;
    const IN_ACTIVE = 1;
    const VERIFIED = 1;
    const NOT_VERIFIED = 0;
}
