<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Filters;

/**
 * Class UserFilter
 *
 * @package App\Http\Filters
 */
class UserFilter extends Filter
{

    /**
     * Username Filter
     */
    public function username()
    {
        $this->query->orWhere(__FUNCTION__, $this->args);
    }

    /**
     * Email Filter
     */
    public function email()
    {
        $this->query->Where(__FUNCTION__, $this->args);
    }

    /**
     * Username Filter
     */
    public function status()
    {
        $this->query->Where(__FUNCTION__, $this->args);
    }

    /**
     * Phone Number Filter
     */
    public function phone_number()
    {
        $this->query->Where(__FUNCTION__, $this->args);
    }

    /**
     * Parent Filter
     */
    public function parent_id()
    {
        $this->query->Where(__FUNCTION__, $this->args);
    }

}
