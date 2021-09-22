<?php

namespace App\Http\Contracts;

/**
 * Class IBlogContract
 *
 * @package App\Http\Contracts
 */
interface IBlogContract
{

    /**
     * @param $user
     *
     * @return mixed
     */
    public function getSpecificBlogs($user);

    /**
     * @param $array
     * @return mixed
     */
    public function create($array);

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @return mixed
     */
    public function update($id, $array);

    /**
     * @return mixed
     */
    public function paginate();


}
