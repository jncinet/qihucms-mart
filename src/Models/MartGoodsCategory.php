<?php

namespace Qihucms\Mart\Models;

use Illuminate\Database\Eloquent\Model;

class MartGoodsCategory extends Model
{
    protected $fillable = [
        'title', 'thumbnail', 'sort'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mart_goods()
    {
        return $this->hasMany('Qihucms\Mart\Models\MartGoods');
    }
}