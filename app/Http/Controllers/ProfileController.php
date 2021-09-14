<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Contracts\IUserServiceContract;

/**
 * Class ProfileController
 *
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{

    #Pages
    const PROFILE_PAGE = 'profile';

    /**
     * Interface IUserServiceContract
     *
     * @var IUserServiceContract
     */
    private $_userService;

    /**
     * Sub Nodes Container
     *
     * @var array
     */
    private $_subNodesContainer = [];

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
     * @return mixed
     */
    public function profile()
    {
        $user = $this->_userService->findById(Auth::id());
        return view(self::PROFILE_PAGE, compact('user'));
    }
}
