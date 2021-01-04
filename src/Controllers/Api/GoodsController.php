<?php

namespace Qihucms\Mart\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Qihucms\Mart\Repositories\MartRepository;

class GoodsController extends Controller
{
    protected $mart;

    public function __construct(MartRepository $martRepository)
    {
        $this->mart = $martRepository;
    }

    /**
     * 后台AJAX查询店铺
     *
     * @param Request $request
     * @return mixed
     */
    public function adminGetMartByQ(Request $request)
    {
        $keyword = $request->get('q', '');

        return $this->mart->adminGetMartPaginate($keyword);
    }
}