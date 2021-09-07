<?php

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
    public function active()
    {
        dd($this->args);

        $this->query->orWhere(__FUNCTION__, $this->args);
    }

}
