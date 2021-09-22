<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Controllers\Supervisor;

use App\Http\Contracts\IUserServiceContract;
use App\Http\Controllers\ProfileController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use App\Helpers\IUserStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Contracts\IBlogContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Class BlogController
 *
 * @package App\Http\Controllers\Blogger
 */
class BlogController extends Controller
{

    # Pages
    const INDEX_PAGE = 'supervisor.blog.index';
    const BLOG_EDIT_PAGE = 'supervisor.blog.edit';


    /**
     * Interface IBlogContract
     *
     * @var IBlogContract
     */
    private $_blogService;

    /**
     * Interface IUserServiceContract
     *
     * @var IUserServiceContract
     */
    private $_userService;

    /**
     * TransactionController constructor.
     *
     * @param IBlogContract $_blogService
     * @param IUserServiceContract $_userService
     */
    public function __construct(
        IBlogContract $_blogService,
        IUserServiceContract $_userService
    )
    {
        $this->_blogService = $_blogService;
        $this->_userService = $_userService;
    }

    public function index()
    {
        $subordinates = auth()->user()->subordinate;
        $blogs = [];
        foreach (auth()->user()->blogs as $blog)
        {
            array_push($blogs, $blog);
        }
        foreach ($subordinates as $item)
        {
            $user = $this->_userService->findById($item->blogger_id);
            if($user->blogs)
            {
                foreach ($user->blogs as $blog)
                {
                    array_push($blogs, $blog);
                }
            }
        }
        return view(self::INDEX_PAGE, compact('blogs'));
    }

    public function create(Request $request)
    {
        $response= $this->_blogService->create(['user_id' => auth()->id(), 'name' => $request->name, 'description' => $request->description]);
        return GeneralHelper::SEND_RESPONSE($request, $response,GeneralHelper::GET_ROLE(Auth::user()).'.blog',"Blog created successfully");
    }

    /**
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $blog = $this->_blogService->findById($id);
        return view(self::BLOG_EDIT_PAGE, compact('blog'));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(Request $request)
    {
        $response  = $this->_blogService->update($request->id, ['name' => $request->name, 'description' => $request->description]);
        return GeneralHelper::SEND_RESPONSE($request, $response,GeneralHelper::GET_ROLE(Auth::user()).'.blog',"Edit Blog successfully");
    }
}
