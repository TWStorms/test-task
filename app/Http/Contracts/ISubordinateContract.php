<?php

namespace App\Http\Contracts;

/**
 * Interface ISubordinateContract
 *
 * @package App\Http\Contracts
 */
interface ISubordinateContract
{

    /**
     * @param $array
     *
     * @return mixed
     */
    public function insert($array);
}
