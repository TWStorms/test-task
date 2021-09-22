<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Controllers\Blogger;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Contracts\IUserServiceContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Helpers\IUserStatus;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\User
 */
class UserController extends Controller
{

    # Pages
    const INDEX_PAGE = 'blogger.blog.index';
    const MAP_PAGE = 'blogger.map';
    const LISTING_PAGE = 'blogger.blog.partials._listing';


    /**
     * Interface IUserServiceContract
     *
     * @var IUserServiceContract
     */
    private $_userService;

    /**
     * UserController constructor.
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

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $user = $this->_userService->findById($request->user_id);
        if($request->new_password == $request->confirm_password)
        {
            if(Hash::check($request->old_password, $user->password))
            {
                $this->_userService->update($request->user_id, ['password' => Hash::make($request->new_password)]);
                return redirect()->back()->with(['message' => "Successfully change password", 'alert_type' => 'success']);
            }else{
                return redirect()->back()->with(['message' => "Invalid old password", 'alert_type' => 'error']);
            }
        }else{
            return redirect()->back()->with(['message' => "Confirm password did not match", 'alert_type' => 'error']);
        }
    }
}
