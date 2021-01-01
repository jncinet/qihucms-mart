<?php

namespace Qihucms\Mart\Repositories;

use Qihucms\Mart\Models\MartGoods;

class MartGoodsRepository
{
    protected $goods;

    public function __construct(MartGoods $goods)
    {
        $this->goods = $goods;
    }

    /**
     * 读取产品详细
     *
     * @param int $id
     * @return mixed
     */
    public function findGoodsById(int $id)
    {
        return $this->goods->findOrFail($id);
    }

    public function goodsPaginate()
    {
        
    }
}