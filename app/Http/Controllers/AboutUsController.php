<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class AboutUsController
 *
 * @package App\Http\Controllers
 */
class AboutUsController extends Controller
{

    #Pages
    const ABOUT_US_PAGE = 'about-us';

    /**
     * @return Application|Factory|View
     */
    public function page()
    {
        return view(self::ABOUT_US_PAGE);
    }
}
