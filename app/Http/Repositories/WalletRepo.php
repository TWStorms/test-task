<?php

namespace App\Http\Repositories;

use App\Models\Wallet;

/**
 * Class WalletRepo
 *
 * @package App\Http\Repositories
 */
class WalletRepo extends BaseRepo
{

    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        parent::__construct(Wallet::class);
    }
}
