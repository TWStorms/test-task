<?php

namespace App\Http\Repositories;

use App\Models\TransactionHistory;

/**
 * Class TransactionHistoryRepo
 *
 * @package App\Http\Repositories
 */
class TransactionHistoryRepo extends BaseRepo
{

    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        parent::__construct(TransactionHistory::class);
    }
}
