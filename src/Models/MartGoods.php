<?php

namespace Qihucms\Mart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MartGoods extends Model
{
    protected $fillable = [
        'user_id', 'mart_goods_category_id', 'title', 'price', 'stock', 'thumbnail', 'media_list',
        'content', 'is_shelves', 'is_new', 'is_hot', 'link', 'status', 'commission'
    ];

    protected $casts = [
        'media_list' => 'array',
    ];

    /**
     * 是否上架
     *
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeOfShelves($query, $type)
    {
        return $query->where('is_shelves', $type);
    }

    /**
     * 是否最新
     *
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeOfNew($query, $type)
    {
        return $query->where('is_new', $type);
    }

    /**
     * 是否热销
     *
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeOfHot($query, $type)
    {
        return $query->where('is_hot', $type);
    }

    /**
     * 状态
     *
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeOfStatus($query, $type)
    {
        return $query->where('status', $type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mart()
    {
        return $this->belongsTo('Qihucms\Mart\Models\Mart', 'user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mart_goods_category(): BelongsTo
    {
        return $this->belongsTo('Qihucms\Mart\Models\MartGoodsCategory');
    }

    /**
     * 一个商品可以被多个短视频推广
     *
     * @return BelongsToMany
     */
    public function mini_videos(): BelongsToMany
    {
        return $this->belongsToMany(
            'Qihucms\MiniVideo\Models\MiniVideo',
            'mini_video_goods',
            'goods_id',
            'mini_video_id'
        );
    }
}
