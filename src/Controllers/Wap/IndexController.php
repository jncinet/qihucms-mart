<?php

namespace Qihucms\Mall\Controllers\Wap;

use App\Http\Controllers\Controller;
use Qihucms\Mart\Repositories\MartRepository;

class IndexController extends Controller
{
    protected $mall;

    public function __construct(MartRepository $mall)
    {
        $this->mall = $mall;
    }

    public function index()
    {
        // 产品分类
//        $categories = $this->mall->categories();
        // 商城广告
//        $ads = $this->ad->findAdByCategoryId(1);
        // 产品列表
//        $goods = $this->mall->goods([], 16, true);

        return view('mall.wap.index', compact('categories', 'ads', 'goods'));
    }
}