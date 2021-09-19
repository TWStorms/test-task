<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Contracts\ITransactionHistoryServiceContract;

/**
 * Class TransactionController
 *
 * @package App\Http\Controllers\User
 */
class TransactionController extends Controller
{

    # Pages
    const INDEX_PAGE = 'user.transaction.index';
    const LISTING_PAGE = 'user.transaction.partials._listing';

    /**
     * Interface ITransactionHistoryServiceContract
     *
     * @var ITransactionHistoryServiceContract
     */
    private $_transactionService;

    /**
     * TransactionController constructor.
     *
     * @param ITransactionHistoryServiceContract $_transactionService
     */
    public function __construct(
        ITransactionHistoryServiceContract $_transactionService
    )
    {
        $this->_transactionService = $_transactionService;
    }

    /**
     * Transaction index page
     */
    public function index(Request $request)
    {
        $transactions = ($request->ajax() && count($request->all()) > 0) ?
            app(\App\Http\Services\SearchService::class)->search(
                new \App\Models\TransactionHistory(),
                \App\Http\Filters\TransactionHistoryFilter::class
            )
            : $this->_transactionService->getTransactionForSpecificUser(['user_id' => Auth::id(), 'withdrawal_request_status' => null])->appends(request()->all());

        if ($request->ajax())
        {
            $transactions = $transactions->paginate(GeneralHelper::PAGINATION_SIZE())->appends($request->all());
            return response()->json([
                'view' => view(self::LISTING_PAGE, compact('transactions'))->render()
            ]);
        }

        return view(self::INDEX_PAGE, compact('transactions'));
    }
}
