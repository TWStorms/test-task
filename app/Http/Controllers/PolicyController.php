<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class PolicyController
 *
 * @package App\Http\Controllers
 */
class PolicyController extends Controller
{

    #Pages
    const POLICY_PAGE = 'policy';

    /**
     * @return Application|Factory|View
     */
    public function page()
    {
        return view(self::POLICY_PAGE);
    }
}
