<?php

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

    //Levels
    const LEVEL_ZERO = 0;
    const LEVEL_ONE = 1;
    const LEVEL_TWO = 2;
    const LEVEL_THREE = 3;
    const LEVEL_FOUR = 4;
    const LEVEL_FIVE = 5;
    const LEVEL_SIX = 6;
    const LEVEL_SEVEN = 7;

    //Level users
    const LEVEL_ZERO_USER = 0;
    const LEVEL_ONE_USER = 7;
    const LEVEL_TWO_USER = 49;
    const LEVEL_THREE_USER = 343;
    const LEVEL_FOUR_USER = 2401;
    const LEVEL_FIVE_USER = 16807;
    const LEVEL_SIX_USER = 117649;
    const LEVEL_SEVEN_USER = 823543;

    //Level prices
    const LEVEL_ZERO_PRICE = 0;
    const LEVEL_ONE_PRICE = 7000;
    const LEVEL_TWO_PRICE = 49000;
    const LEVEL_THREE_PRICE = 343000;
    const LEVEL_FOUR_PRICE = 2401000;
    const LEVEL_FIVE_PRICE = 16807000;
    const LEVEL_SIX_PRICE = 117649000;
    const LEVEL_SEVEN_PRICE = 823543000;
}
