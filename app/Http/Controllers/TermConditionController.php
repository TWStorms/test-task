<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class TermConditionController
 *
 * @package App\Http\Controllers
 */
class TermConditionController extends Controller
{

    #Pages
    const TERM_CONDITION_PAGE = 'term-condition';

    /**
     * @return Application|Factory|View
     */
    public function page()
    {
        return view(self::TERM_CONDITION_PAGE);
    }
}
