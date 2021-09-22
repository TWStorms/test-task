<?php


namespace App\Http\Services;

use App\Helpers\GeneralHelper;
use App\Http\Contracts\IBlogContract;
use App\Http\Repositories\BlogRepo;
use App\Helpers\IUserStatus;

class BlogService implements IBlogContract
{

    /**
     * @var BlogRepo
     */
    private $_blogRepo;

    /**
     * BlogService constructor.
     */
    public function __construct()
    {
        $this->_blogRepo = new blogRepo();
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getSpecificBlogs($user)
    {
        return $user->blogs;
    }

    /**
     * @param $array
     * @return mixed
     */
    public function create($array)
    {
        return $this->_blogRepo->create($array);
    }

    /**
     * @param $id
     * @return mixed|object
     */
    public function findById($id)
    {
        return $this->_blogRepo->findById($id);
    }

    /**
     * @param $id
     * @param $array
     *
     * @return bool
     */
    public function update($id, $array)
    {
        return $this->_blogRepo->update($id, $array);
    }

    /**
     * @return mixed|void
     */
    public function paginate()
    {
        return $this->_blogRepo->paginate(GeneralHelper::PAGINATION_SIZE());
    }
}
