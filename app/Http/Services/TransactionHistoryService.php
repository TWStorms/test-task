<?php

namespace App\Http\Services;

use App\Helpers\ITransactionMethodTypes;
use App\Helpers\IUserStatus;
use App\Helpers\GeneralHelper;
use App\Http\Repositories\TransactionHistoryRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Repositories\UserRepo;
use Illuminate\Support\Facades\Validator;
use App\Http\Contracts\IUserServiceContract;
use App\Http\Contracts\ITransactionHistoryServiceContract;

/**
 * Class TransactionHistoryService
 *
 * @package App\Http\Services
 */
class TransactionHistoryService implements ITransactionHistoryServiceContract
{

    /**
     * @var TransactionHistoryRepo
     */
    private $_transactionHistoryRepo;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->_transactionHistoryRepo = new TransactionHistoryRepo();
    }

    /**
     * @param $array
     * @param $id
     *
     * @return mixed|void
     */
    public function create($array)
    {
        return $this->_transactionHistoryRepo->create($array);
    }

    /**
     * @return mixed
     */
    public function getPendingWithdrawalRequests()
    {
        return $this->_transactionHistoryRepo->findByClause([ 'withdrawal_request_status' => ITransactionMethodTypes::WITHDRAWAL_REQUEST_PENDING ])->paginate(GeneralHelper::PAGINATION_SIZE());
    }

    /**
     * @return mixed|void
     */
    public function getWithdrawalRequestsForSpecificUser($id)
    {
        return $this->_transactionHistoryRepo->findByClause([ 'user_id' => $id ])->whereNotNull('withdrawal_request_status')->paginate(GeneralHelper::PAGINATION_SIZE());
    }

    /**
     * @param $id
     * @param $array
     *
     * @return mixed|void
     */
    public function update($id, $array)
    {
        return $this->_transactionHistoryRepo->update($id, $array);
    }

    /**
     * @param $array
     *
     * @return mixed|void
     */
    public function sendWithdrawRequest($array)
    {
        return $this->_transactionHistoryRepo->insert($array);
    }

}
