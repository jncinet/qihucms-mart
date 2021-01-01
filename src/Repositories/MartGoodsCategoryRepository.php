<?php

namespace Qihucms\Mart\Repositories;

use Qihucms\Mart\Models\MartGoodsCategory;

class MartGoodsCategoryRepository
{
    protected $category;

    public function __construct(MartGoodsCategory $category)
    {
        $this->category = $category;
    }

    /**
     * 后台读取产品分类
     *
     * @return mixed
     */
    public function adminSelectCategories()
    {
        return $this->category->select('id', 'title as text')->get();
    }
}