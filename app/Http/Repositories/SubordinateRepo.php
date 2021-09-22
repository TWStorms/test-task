<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Repositories;

use App\Models\Subordinate;
use Hamcrest\Core\SampleBaseClass;

/**
 * Class SubordinateRepo
 *
 * @package App\Http\Repositories
 */
class SubordinateRepo extends BaseRepo
{

    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        parent::__construct(Subordinate::class);
    }
}
