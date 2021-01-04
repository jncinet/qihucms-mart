<?php

namespace Qihucms\Mart\Controllers\Api;

use App\Http\Controllers\Controller;
use Qihucms\Mart\Repositories\MartGoodsCategoryRepository;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(MartGoodsCategoryRepository $categoryRepository)
    {
        $this->category = $categoryRepository;
    }

    /**
     * 后台选择产品分类
     *
     * @return mixed
     */
    public function adminSelectCategory()
    {
        return $this->category->adminSelectCategories();
    }
}