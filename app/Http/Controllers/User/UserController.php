<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Contracts\IUserServiceContract;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\User
 */
class UserController extends Controller
{

    # Pages
    const INDEX_PAGE = 'user.children.index';
    const LISTING_PAGE = 'user.children.partials._listing';

    /**
     * Interface IUserServiceContract
     *
     * @var IUserServiceContract
     */
    private $_userService;

    /**
     * TransactionController constructor.
     *
     * @param IUserServiceContract $_userService
     */
    public function __construct(
        IUserServiceContract $_userService
    )
    {
        $this->_userService = $_userService;
    }

    /**
     * Users index page
     */
    public function index(Request $request)
    {
        if($request->ajax() && count($request->all()) > 0)
            $request->request->add(['parent_id' => Auth::id()]);

        $users = ($request->ajax() && count($request->all()) > 0) ?
            app(\App\Http\Services\SearchService::class)->search(
                new \App\Models\User(),
                \App\Http\Filters\UserFilter::class
            )
            :
            $this->_userService->getChildrens(Auth::id())->appends(request()->all());

        if ($request->ajax())
        {
            $users = $users->paginate(GeneralHelper::PAGINATION_SIZE())->appends($request->all());
            return response()->json([
                'view' => view(self::LISTING_PAGE, compact('users'))->render()
            ]);
        }

        return view(self::INDEX_PAGE, compact('users'));
    }
}
