<?php

namespace Qihucms\Mart\Repositories;

use Qihucms\Mart\Models\Mart;

class MartRepository
{
    protected $mart;

    public function __construct(Mart $mart)
    {
        $this->mart = $mart;
    }

    /**
     * 根据用户ID（店铺ID）获取店铺详细
     *
     * @param int $user_id
     * @return mixed
     */
    public function findMartByUserId(int $user_id)
    {
        return $this->mart->findOrFail($user_id);
    }

    /**
     * 后台查询店铺
     *
     * @param string $keyword 店铺ID或店铺名称
     * @return mixed
     */
    public function adminGetMartPaginate($keyword = '')
    {
        return $this->mart->where('user_id', $keyword)
            ->orWhere('name', 'like', '%' . $keyword . '%')
            ->select('user_id as id', 'name as text')
            ->paginate();
    }
}