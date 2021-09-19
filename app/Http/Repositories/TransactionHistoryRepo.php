<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

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
