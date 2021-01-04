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
    public function findMartById(int $user_id)
    {
        return $this->mart->find($user_id);
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

    /**
     * 开通店铺
     *
     * @param array $data
     * @return mixed
     */
    public function createMart($data = [])
    {
        return $this->mart->create($data);
    }

    /**
     * @param string $keyword
     * @param array $orderBy
     * @param int $limit
     * @return mixed
     */
    public function getMartPaginate($keyword = null, $orderBy = [], $limit = 15)
    {
        $model = $this->mart->where('status', 1);

        if (!empty($keyword)) {
            $keyword = preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);

            if (count($keyword) > 0) {
                $model = $model->where(function ($query) use ($keyword){
                    foreach ($keyword as $value) {
                        $query->orWhere('name', 'like', '%' . $value . '%');
                    }
                });
            }
        }


        if (count($orderBy) > 0) {
            foreach ($orderBy as $key => $value) {
                $model = $model->orderBy($key, $value);
            }
        }

        return $model->paginate($limit);
    }

    /**
     * 注销店铺（修改店铺状态为2）
     *
     * @param $id
     * @return mixed
     */
    public function cancelMart($id)
    {
        return $this->mart->where('user_id', $id)->update(['status' => 2]);
    }

    public function updateMart()
    {

    }
}