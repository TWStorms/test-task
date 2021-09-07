<?php

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
use App\Http\Contracts\IUserServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Http\Contracts\ITransactionHistoryServiceContract;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    # Pages
    const INDEX_PAGE = 'sub-admin.awaiting-approval.index';
    const LISTING_PAGE = 'sub-admin.awaiting-approval.partials._listing';

    /**
     * Interface IUserServiceContract
     *
     * @var IUserServiceContract
     */
    private $_userService;

    /**
     * Interface ITransactionHistoryServiceContract
     *
     * @var ITransactionHistoryServiceContract
     */
    private $_transactionService;

    /**
     * DashboardController constructor.
     *
     * @param IUserServiceContract $_userService
     * @param ITransactionHistoryServiceContract $_transactionService
     */
    public function __construct(
        IUserServiceContract $_userService,
        ITransactionHistoryServiceContract $_transactionService
    )
    {
        $this->_userService = $_userService;
        $this->_transactionService = $_transactionService;
    }

    /**
     * Awaiting approval index page
     */
    public function awaitingApproval(Request $request)
    {
        $users = ($request->ajax() && count($request->all()) > 0) ?
            app(\App\Http\Services\SearchService::class)->search(
                new \App\Models\User(),
                \App\Http\Filters\UserFilter::class
            )
            : $this->_userService->getAwaitingApprovalUsers()->appends(request()->all());

        if ($request->ajax())
        {
            $users = $users->paginate(GeneralHelper::PAGINATION_SIZE())->appends($request->all());
            return response()->json([
                'view' => view(self::LISTING_PAGE, compact('users'))->render()
            ]);
        }

        return view(self::INDEX_PAGE, compact('users'));
    }

    /**
     * Activate user
     */
    public function activateUser(Request $request)
    {
        $this->_transactionService->create(['transaction_id' => $request->transaction_id, 'method' => $request->transaction_method, 'amount' => 100, 'user_id' => 1, 'transaction_type' => ITransactionMethodTypes::CREDIT ]);
        $response = $this->_userService->activate($request->userId);
        if($response)
            return GeneralHelper::SEND_RESPONSE($request, $response,GeneralHelper::GET_ROLE(Auth::user()).'.awaiting-approval',"Activate user successfully");
        return GeneralHelper::SEND_RESPONSE($request, null,GeneralHelper::GET_ROLE(Auth::user()).'.awaiting-approval',null ,"Something went wrong");
    }
}
