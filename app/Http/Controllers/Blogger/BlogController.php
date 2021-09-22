<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Controllers\Blogger;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use App\Helpers\IUserStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
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
    const INDEX_PAGE = 'blogger.blog.index';
    const BLOG_EDIT_PAGE = 'blogger.blog.edit';

    /**
     * Interface IBlogContract
     *
     * @var IBlogContract
     */
    private $_blogService;

    /**
     * TransactionController constructor.
     *
     * @param IBlogContract $_blogService
     */
    public function __construct(
        IBlogContract $_blogService
    )
    {
        $this->_blogService = $_blogService;
    }

    public function index(Request $request)
    {
        $blogs = $this->_blogService->getSpecificBlogs(Auth::user());
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
