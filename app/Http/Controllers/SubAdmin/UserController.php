<?php

namespace App\Http\Controllers\SubAdmin;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\View\View;
use App\Helpers\IUserStatus;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ITransactionMethodTypes;
use App\Http\Contracts\IUserServiceContract;
use App\Http\Contracts\IWalletServiceContract;
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
     * Interface IWalletServiceContract
     *
     * @var IWalletServiceContract
     */
    private $_walletService;

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
     * @param IWalletServiceContract $_walletService
     */
    public function __construct(
        IUserServiceContract $_userService,
        ITransactionHistoryServiceContract $_transactionService,
        IWalletServiceContract $_walletService
    )
    {
        $this->_userService = $_userService;
        $this->_walletService = $_walletService;
        $this->_transactionService = $_transactionService;
    }

    /**
     * Awaiting approval index page
     */
    public function awaitingApproval(Request $request)
    {
        if($request->ajax() && count($request->all()))
            $request->request->add(['status' => IUserStatus::IN_ACTIVE]);

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
        $response = $this->_userService->activate($request->userId);
        if($wallet = $this->_walletService->findByClause(['user_id' => 1])->first())
        {
            $wallet->amount += 1000;
            $wallet->save();
        }else{
            $this->_walletService->insert(['user_id' => 1, 'amount' => 1000]);
        }
        $this->_transactionService->create(['transaction_id' => $request->transaction_id, 'method' => $request->transaction_method, 'amount' => 1000, 'user_id' => 1, 'transaction_type' => ITransactionMethodTypes::CREDIT ]);
        $this->updateParent($request->userId);
        if($response)
            return GeneralHelper::SEND_RESPONSE($request, $response,GeneralHelper::GET_ROLE(Auth::user()).'.awaiting-approval',"Activate user successfully");
        return GeneralHelper::SEND_RESPONSE($request, null,GeneralHelper::GET_ROLE(Auth::user()).'.awaiting-approval',null ,"Something went wrong");
    }

    /**
     *
     */
    public function updateParent($userId)
    {
        $user = $this->_userService->findById($userId);
        $parent = $user->parent;
        $parent->child_count += 1;
        $parent->save();
        while($parent = $user->parent)
        {
            if($parent->level_completed != IUserStatus::LEVEL_SEVEN)
                $this->auditUserWallet($parent->id);

            $user = $parent;
        }
    }

    /**
     * @param $userId
     */
    public function auditUserWallet($userId)
    {
        $parent = $this->_userService->findById($userId);
        $childs1 = $parent->childrens;

        $Level3Array = [];
        $Level4Array = [];
        $Level5Array = [];
        $Level6Array = [];
        $Level7Array = [];
        $Level8Array = [];
        if($childs1 && count($childs1) == IUserStatus::LEVEL_ONE_USER)
        {
            if($parent->level_completed < IUserStatus::LEVEL_ONE)
            {
                $parent->level_completed = IUserStatus::LEVEL_ONE;
                $parent->save();
                if(!GeneralHelper::IS_SUPER_ADMIN($parent))
                {
                    $price = (IUserStatus::LEVEL_ONE_PRICE / 10);
                    if($user = $this->_walletService->findByClause(['user_id' => $parent->id])->first())
                    {
                        $user->amount += $price;
                        $user->save();
                    }else{
                        $this->_walletService->insert(['user_id' => $parent->id, 'amount' => $price]);
                    }
                    $admin = $this->_walletService->findByClause(['user_id' => 1])->first();
                    $admin->amount -= $price;
                    $admin->save();

                    $this->updateTransactionHistory($parent->id, $price);
                }
            }
            $levelFlag = true;
            foreach($childs1 as $key => $child)
            {
                if(!$child->childrens || count($child->childrens) != IUserStatus::LEVEL_ONE_USER)
                    $levelFlag = false;

                $Level3Array = array_merge($Level3Array,$child->childrens->toArray());
            }

            if($levelFlag)
            {
                if($parent->level_completed < IUserStatus::LEVEL_TWO)
                {
                    $parent->level_completed = IUserStatus::LEVEL_TWO;
                    $parent->save();
                    if(!GeneralHelper::IS_SUPER_ADMIN($parent))
                    {
                        $price = (IUserStatus::LEVEL_TWO_PRICE / 10);
                        if($user = $this->_walletService->findByClause(['user_id' => $parent->id])->first())
                        {
                            $user->amount += $price;
                            $user->save();
                        }else{
                            $this->_walletService->insert(['user_id' => $parent->id, 'amount' => $price]);
                        }
                        $admin = $this->_walletService->findByClause(['user_id' => 1])->first();
                        $admin->amount -= $price;
                        $admin->save();

                        $this->updateTransactionHistory($parent->id, $price);
                    }
                }
                $levelFlag = true;
                foreach($Level3Array as $item)
                {
                    if(!$item->childrens || count($item->childrens) != IUserStatus::LEVEL_ONE_USER)
                        $levelFlag = false;

                    $Level4Array = array_merge($Level4Array,$item->childrens->toArray());
                }

                if($levelFlag) {
                    if ($parent->level_completed < IUserStatus::LEVEL_THREE) {
                        $parent->level_completed = IUserStatus::LEVEL_THREE;
                        $parent->save();
                        if (!GeneralHelper::IS_SUPER_ADMIN($parent)) {
                            $price = (IUserStatus::LEVEL_THREE_PRICE / 10);
                            if($user = $this->_walletService->findByClause(['user_id' => $parent->id])->first())
                            {
                                $user->amount += $price;
                                $user->save();
                            }else{
                                $this->_walletService->insert(['user_id' => $parent->id, 'amount' => $price]);
                            }
                            $admin = $this->_walletService->findByClause(['user_id' => 1])->first();
                            $admin->amount -= $price;
                            $admin->save();

                            $this->updateTransactionHistory($parent->id, $price);
                        }
                    }

                    $levelFlag = true;
                    foreach($Level4Array as $item)
                    {
                        if(!$item->childrens || count($item->childrens) != IUserStatus::LEVEL_ONE_USER)
                            $levelFlag = false;

                        $Level5Array = array_merge($Level5Array,$item->childrens->toArray());
                    }

                    if($levelFlag) {
                        if ($parent->level_completed < IUserStatus::LEVEL_FOUR) {
                            $parent->level_completed = IUserStatus::LEVEL_FOUR;
                            $parent->save();
                            if (!GeneralHelper::IS_SUPER_ADMIN($parent)) {
                                $price = (IUserStatus::LEVEL_FOUR_PRICE / 10);
                                if($user = $this->_walletService->findByClause(['user_id' => $parent->id])->first())
                                {
                                    $user->amount += $price;
                                    $user->save();
                                }else{
                                    $this->_walletService->insert(['user_id' => $parent->id, 'amount' => $price]);
                                }
                                $admin = $this->_walletService->findByClause(['user_id' => 1])->first();
                                $admin->amount -= $price;
                                $admin->save();

                                $this->updateTransactionHistory($parent->id, $price);
                            }
                        }
                        $levelFlag = true;
                        foreach($Level5Array as $item)
                        {
                            if(!$item->childrens || count($item->childrens) != IUserStatus::LEVEL_ONE_USER)
                                $levelFlag = false;

                            $Level6Array = array_merge($Level6Array,$item->childrens->toArray());
                        }
                        if($levelFlag) {
                            if ($parent->level_completed < IUserStatus::LEVEL_FIVE) {
                                $parent->level_completed = IUserStatus::LEVEL_FIVE;
                                $parent->save();
                                if (!GeneralHelper::IS_SUPER_ADMIN($parent)) {
                                    $price = (IUserStatus::LEVEL_FIVE_PRICE / 10);
                                    if($user = $this->_walletService->findByClause(['user_id' => $parent->id])->first())
                                    {
                                        $user->amount += $price;
                                        $user->save();
                                    }else{
                                        $this->_walletService->insert(['user_id' => $parent->id, 'amount' => $price]);
                                    }
                                    $admin = $this->_walletService->findByClause(['user_id' => 1])->first();
                                    $admin->amount -= $price;
                                    $admin->save();

                                    $this->updateTransactionHistory($parent->id, $price);
                                }
                            }

                            $levelFlag = true;
                            foreach($Level6Array as $item)
                            {
                                if(!$item->childrens || count($item->childrens) != IUserStatus::LEVEL_ONE_USER)
                                    $levelFlag = false;

                                $Level7Array = array_merge($Level7Array,$item->childrens->toArray());
                            }
                            if($levelFlag) {
                                if ($parent->level_completed < IUserStatus::LEVEL_SIX) {
                                    $parent->level_completed = IUserStatus::LEVEL_SIX;
                                    $parent->save();
                                    if (!GeneralHelper::IS_SUPER_ADMIN($parent)) {
                                        $price = (IUserStatus::LEVEL_SIX_PRICE / 10);
                                        if($user = $this->_walletService->findByClause(['user_id' => $parent->id])->first())
                                        {
                                            $user->amount += $price;
                                            $user->save();
                                        }else{
                                            $this->_walletService->insert(['user_id' => $parent->id, 'amount' => $price]);
                                        }
                                        $admin = $this->_walletService->findByClause(['user_id' => 1])->first();
                                        $admin->amount -= $price;
                                        $admin->save();

                                        $this->updateTransactionHistory($parent->id, $price);
                                    }
                                }
                                $levelFlag = true;
                                foreach($Level7Array as $item)
                                {
                                    if(!$item->childrens || count($item->childrens) != IUserStatus::LEVEL_ONE_USER)
                                        $levelFlag = false;
                                }
                                if($levelFlag) {
                                    if ($parent->level_completed < IUserStatus::LEVEL_SEVEN) {
                                        $parent->level_completed = IUserStatus::LEVEL_SEVEN;
                                        $parent->save();
                                        if (!GeneralHelper::IS_SUPER_ADMIN($parent)) {
                                            $price = (IUserStatus::LEVEL_SEVEN_PRICE / 10);
                                            if($user = $this->_walletService->findByClause(['user_id' => $parent->id])->first())
                                            {
                                                $user->amount += $price;
                                                $user->save();
                                            }else{
                                                $this->_walletService->insert(['user_id' => $parent->id, 'amount' => $price]);
                                            }
                                            $admin = $this->_walletService->findByClause(['user_id' => 1])->first();
                                            $admin->amount -= $price;
                                            $admin->save();

                                            $this->updateTransactionHistory($parent->id, $price);
                                        }
                                    }
                                }else{
                                    return;
                                }
                            }else{
                                return;
                            }
                        }else{
                            return;
                        }
                    }else{
                        return;
                    }
                }else{
                    return;
                }
            }else{
                return;
            }
        }else{
            return;
        }
    }

    /**
     *
     */
    public function updateTransactionHistory($userId, $amount)
    {
        $user = $this->_userService->findById($userId);
        $this->_transactionService->create(['user_id' => $userId, 'amount' => $amount, 'phone_number' =>  $user->phone_number, 'transaction_type' => ITransactionMethodTypes::CREDIT ]);
        $this->_transactionService->create(['user_id' => 1, 'amount' => $amount, 'phone_number' =>  $user->phone_number, 'transaction_type' => ITransactionMethodTypes::DEBIT ]);
    }
}
