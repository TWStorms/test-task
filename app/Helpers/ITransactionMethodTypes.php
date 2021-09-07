<?php

namespace App\Helpers;

/**
 * Interface ITransactionMethodTypes
 *
 * @package App\Http\Contracts
 */
interface ITransactionMethodTypes
{

    const JAZZCASH = 1;
    const EASYPAISA = 2;

    const CREDIT = 1;
    const DEBIT = 2;

    const WITHDRAWAL_REQUEST_PENDING = 1;
    const WITHDRAWAL_REQUEST_APPROVED = 2;
    const WITHDRAWAL_REQUEST_DECLINED = 3;
}
