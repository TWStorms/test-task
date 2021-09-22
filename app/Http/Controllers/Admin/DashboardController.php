<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Helpers\IUserStatus;
use Illuminate\Contracts\View\Factory;
use App\Http\Contracts\IUserServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{

    # Pages
    const DASHBOARD_PAGE = 'admin.dashboard';

    /**
     * Interface IUserServiceContract
     *
     * @var IUserServiceContract
     */
    private $_userService;

    /**
     * DashboardController constructor.
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
     * Super Admin Dashboard
     */
    public function dashboard()
    {
        $userCount = $this->_userService->getAllCount();
        return view(self::DASHBOARD_PAGE, compact('userCount'));
    }
}
