<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Services;

use App\Helpers\ITransactionMethodTypes;
use App\Http\Repositories\WalletRepo;
use App\Http\Contracts\IWalletServiceContract;

/**
 * Class WalletService
 *
 * @package App\Http\Services
 */
class WalletService implements IWalletServiceContract
{

    /**
     * @var WalletRepo
     */
    private $_walletRepo;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->_walletRepo = new WalletRepo();
    }

    /**
     * @param $walletId
     *
     * @return object
     */
    public function findById($walletId)
    {
        return $this->_walletRepo->findById($walletId);
    }

    /**
     * @param $array
     *
     * @return mixed|void
     */
    public function findByClause($array)
    {
        return $this->_walletRepo->findByClause($array);
    }

    /**
     * @param $array
     *
     * @return mixed
     */
    public function insert($array)
    {
        return $this->_walletRepo->insert($array);
    }

    /**
     * @param $clause
     * @param $data
     *
     * @return bool
     */
    public function update($clause, $data)
    {
        return $this->_walletRepo->updateByClause($clause, $data);
    }
}
