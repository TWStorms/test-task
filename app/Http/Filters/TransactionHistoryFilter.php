<?php

namespace App\Http\Filters;

/**
 * Class TransactionHistoryFilter
 *
 * @package App\Http\Filters
 */
class TransactionHistoryFilter extends Filter
{

    /**
     * transaction_id Filter
     */
    public function transaction_id()
    {
        $this->query->Where(__FUNCTION__, $this->args);
    }

    /**
     * method Filter
     */
    public function method()
    {
        $this->query->Where(__FUNCTION__, $this->args);
    }

    /**
     * type Filter
     */
    public function transaction_type()
    {
        $this->query->Where(__FUNCTION__, $this->args);
    }

    /**
     * withdrawal_request_status Filter
     */
    public function withdrawal_request_status()
    {
        $this->query->Where(__FUNCTION__, $this->args);
    }
}
