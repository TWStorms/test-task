<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Services;

use App\Helpers\GeneralHelper;
use App\Http\Contracts\ISubordinateContract;
use App\Http\Repositories\SubordinateRepo;
use Illuminate\Support\Carbon;
use App\Helpers\IUserStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Repositories\UserRepo;
use Illuminate\Support\Facades\Validator;
use App\Http\Contracts\IUserServiceContract;

/**
 * Class SubordinateService
 *
 * @package App\Http\Services
 */
class SubordinateService implements ISubordinateContract
{

    /**
     * @var SubordinateRepo
     */
    private $_subordinateRepo;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->_subordinateRepo = new SubordinateRepo();
    }

    /**
     * @param $array
     *
     * @return mixed
     */
    public function insert($array)
    {
        return $this->_subordinateRepo->insert($array);
    }

}
