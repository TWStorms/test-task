<?php

namespace App\Http\Contracts;

/**
 * Interface ITransactionHistoryServiceContract
 *
 * @package App\Http\Contracts
 */
interface ITransactionHistoryServiceContract
{

    /**
     * @return mixed
     */
    public function create($array);

    /**
     * @return mixed
     */
    public function getPendingWithdrawalRequests();

    /**
     * @param $id
     * @param $array
     *
     * @return mixed
     */
    public function update($id, $array);

    /**
     * @return mixed
     */
    public function getWithdrawalRequestsForSpecificUser($id);

    /**
     * @param $array
     *
     * @return mixed
     */
    public function sendWithdrawRequest($array);
}
