<?php

namespace App\Http\Controllers\User;

use App\Helpers\IMMPConfig;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Contracts\IUserServiceContract;
use Illuminate\View\View;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\User
 */
class UserController extends Controller
{

    # Pages
    const INDEX_PAGE = 'user.children.index';
    const MAP_PAGE = 'user.map';
    const LISTING_PAGE = 'user.children.partials._listing';


    /**
     * Interface IUserServiceContract
     *
     * @var IUserServiceContract
     */
    private $_userService;

    /**
     * Nodes Counter
     *
     * @var int
     */
    private $_node = 0;

    /**
     * Sigma Data Collection <Build>
     *
     * @var array
     */
    private $_sigmaDataCollection = [];

    /**
     * Edge Counter
     *
     * @var int
     */
    private $_edge = 0;

    /**
     * Nodes Container
     *
     * @var array
     */
    private $_nodesCollection = [];

    /**
     * Edges Container
     *
     * @var array
     */
    private $_edgesCollection = [];

    /**
     * Sub Nodes Container
     *
     * @var array
     */
    private $_subNodesContainer = [];

    /**
     * TransactionController constructor.
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
     * Users index page
     */
    public function index(Request $request)
    {
        if($request->ajax() && count($request->all()) > 0)
            $request->request->add(['parent_id' => Auth::id()]);

        $users = ($request->ajax() && count($request->all()) > 0) ?
            app(\App\Http\Services\SearchService::class)->search(
                new \App\Models\User(),
                \App\Http\Filters\UserFilter::class
            )
            :
            $this->_userService->getChildrens(Auth::id())->appends(request()->all());

        if ($request->ajax())
        {
            $users = $users->paginate(GeneralHelper::PAGINATION_SIZE())->appends($request->all());
            return response()->json([
                'view' => view(self::LISTING_PAGE, compact('users'))->render()
            ]);
        }

        return view(self::INDEX_PAGE, compact('users'));
    }

    /**
     * @param $username
     *
     * @return Application|Factory|View
     */
    public function map($username)
    {
        $user = $this->_userService->findByClause(['username' => $username])->first();
        $nodes = $this->getSigmaDataNodes($user);
        return view(self::MAP_PAGE, compact('nodes', 'username'));
    }

    /**
     * Create Node
     *
     * @param $id
     * @param $name
     * @param null $data
     *
     * @return array
     */
    private function _node($id, $name, $data = null): array
    {
        return [
            'id'      => $id,
            'label'    => $name,
            'size'    => IMMPConfig::NODE['size'],
            'type'    => IMMPConfig::NODE['type'],
            'user_id' => $data,
        ];
    }

    /**
     * Create Edge
     *
     * @param $id
     * @param $source
     * @param $target
     *
     * @return array
     */
    private function _edge($id, $source, $target): array
    {
        return [
            'id'     => $id,
            'source' => $source,
            'target' => $target,
            'size'   => IMMPConfig::EDGE['size']
        ];
    }

    /**
     * Create Sigma Data Nodes <Initializer>
     *
     * @return false|string
     */
    public function getSigmaDataNodes($user)
    {
        $data = $user->childrens;

        $this->_compileNetwork($data->toArray());

        return json_encode($this->_sigmaDataCollection);
    }

    /**
     * Node Id Generator
     *
     * @return string
     */
    private function _nodeId(): string
    {
        $newId = sprintf("%s_%s_%s", IMMPConfig::MMP_ID, IMMPConfig::NODE['prefix'], $this->_node);
        $this->_node ++;
        return $newId;
    }

    /**
     * Edge Id Generator
     *
     * @return string
     */
    private function _edgeId(): string
    {
        $newId = sprintf("%s_%s_%s", IMMPConfig::MMP_ID, IMMPConfig::EDGE['prefix'], $this->_edge);
        $this->_edge ++;
        return $newId;
    }

    /**
     * Compile Sigma Network
     *
     * @param $users
     * @param false $recursive
     */
    private function _compileNetwork($users, $recursive = false)
    {
        foreach ($users as $key => $user)
        {
            $nodeId = $this->_nodeId();
            array_push($this->_nodesCollection, $this->_node($nodeId, $user["username"], $user["id"]));

//            if ($users = $this->_hasMoreNodes($user))
//                array_push($this->_subNodesContainer, [$nodeId => $users]);
        }

        $this->_sigmaDataCollection = array_merge(
            [
                'nodes' => $this->_nodesCollection
            ],
            [
                'edges' => $this->_edgesCollection
            ]
        );
    }
}
