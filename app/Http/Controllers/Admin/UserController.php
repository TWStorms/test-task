<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use App\Helpers\IUserStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use App\Http\Contracts\IUserServiceContract;
use App\Http\Contracts\ISubordinateContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\SuperAdmin
 */
class UserController extends Controller
{

    # Pages
    const INDEX_PAGE = 'admin.user.index';
    const EDIT_PAGE = 'admin.user.edit';

    /**
     * Interface IUserServiceContract
     *
     * @var IUserServiceContract
     */
    private $_userService;

    /**
     * Interface ISubordinateContract
     *
     * @var ISubordinateContract
     */
    private $_subordinateService;

    /**
     * TransactionController constructor.
     *
     * @param IUserServiceContract $_userService
     * @param ISubordinateContract $_subordinateService
     */
    public function __construct(
        IUserServiceContract $_userService,
        ISubordinateContract $_subordinateService
    )
    {
        $this->_userService = $_userService;
        $this->_subordinateService = $_subordinateService;
    }

    /**
     * Users index page
     */
    public function index(Request $request)
    {

        $users = $this->_userService->getAllUser()->appends(request()->all());

        return view(self::INDEX_PAGE, compact('users'));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function createSupervisor(Request $request)
    {
        $supervisor = $this->_userService->create($request);
        $supervisor->assignRole('supervisor');
        $data = [];
        foreach ($request->bloggers as $blogger)
        {
            array_push($data, ['user_id' => $supervisor->id, 'blogger_id' => $blogger]);
        }
        $response = $this->_subordinateService->insert($data);
        return GeneralHelper::SEND_RESPONSE($request, $response,GeneralHelper::GET_ROLE(Auth::user()).'.users',"Supervisor created successfully");
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
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
        return GeneralHelper::SEND_RESPONSE($request, $response,GeneralHelper::GET_ROLE(Auth::user()).'.users',"Edit user successfully");
    }
}
