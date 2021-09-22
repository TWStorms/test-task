<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Controllers\Supervisor;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
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
    const INDEX_PAGE = 'supervisor.blogger.index';
    const EDIT_PAGE = 'supervisor.blogger.edit';

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
    public function bloggers(Request $request)
    {
        $users = [];
        foreach (auth()->user()->subordinate as $blogger)
        {
            $user = $this->_userService->findById($blogger->blogger_id);
            array_push($users, $user);
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

    /**
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $user = $this->_userService->findById($id);
        return view(self::EDIT_PAGE, compact('user'));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(Request $request)
    {
        $response  = $this->_userService->update($request->id, ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email]);
        return GeneralHelper::SEND_RESPONSE($request, $response,GeneralHelper::GET_ROLE(Auth::user()).'.bloggers',"Edit user successfully");
    }
}
