<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Controllers\SubAdmin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Helpers\ITransactionMethodTypes;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Http\Contracts\ITransactionHistoryServiceContract;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class WithdrawalRequestController
 *
 * @package App\Http\Controllers
 */
class WithdrawalRequestController extends Controller
{

    # Pages
    const INDEX_PAGE = 'sub-admin.withdrawal-request.index';
    const LISTING_PAGE = 'sub-admin.withdrawal-request.partials._listing';

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
            : $this->_transactionService->getPendingWithdrawalRequests()->appends(request()->all());

        if ($request->ajax())
        {
            $transactions = $transactions->paginate(GeneralHelper::PAGINATION_SIZE())->appends($request->all());
            return response()->json([
                'view' => view(self::LISTING_PAGE, compact('transactions'))->render()
            ]);
        }

        return view(self::INDEX_PAGE, compact('transactions'));
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     */
    public function approveWithdrawalRequest($id)
    {
        $response = $this->_transactionService->update($id, ['withdrawal_request_status' => ITransactionMethodTypes::WITHDRAWAL_REQUEST_APPROVED]);

        if($response)
            return redirect()->back()->with(['message' => "Withdrawal request approved successfully", 'alert_type' => 'success']);
        return redirect()->back()->with(['message' => "Something went wrong", 'alert_type' => 'error']);
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     */
    public function declineWithdrawalRequest($id)
    {
        $response = $this->_transactionService->update($id, ['withdrawal_request_status' => ITransactionMethodTypes::WITHDRAWAL_REQUEST_DECLINED]);

        if($response)
            return redirect()->back()->with(['message' => "Withdrawal request declined successfully", 'alert_type' => 'success']);
        return redirect()->back()->with(['message' => "Something went wrong", 'alert_type' => 'error']);
    }
}
