<?php

namespace App\Http\Contracts;

/**
 * Interface IWalletServiceContract
 *
 * @package App\Http\Contracts
 */
interface IWalletServiceContract
{

    /**
     * @param $walletId
     *
     * @return mixed
     */
    public function findById($walletId);

    /**
     * @param $array
     *
     * @return mixed
     */
    public function findByClause($array);

    /**
     * @param $array
     *
     * @return mixed
     */
    public function insert($array);

    /**
     * @param $clause
     * @param $data
     *
     * @return mixed
     */
    public function update($clause, $data);
}
