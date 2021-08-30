<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
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


}
