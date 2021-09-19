<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

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
