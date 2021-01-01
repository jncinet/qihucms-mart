<?php

namespace Qihucms\Mart\Models;

use Illuminate\Database\Eloquent\Model;

class MartOrder extends Model
{
    protected $fillable = [
        'user_id', 'user_address_id', 'mart_id', 'mart_goods_id', 'price', 'count',
        'total_money', 'total_commission', 'tg_user_id', 'status'
    ];

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
    public function tg_user()
    {
        return $this->belongsTo('App\Models\User', 'tg_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_address()
    {
        return $this->belongsTo('App\Models\UserAddress');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mart()
    {
        return $this->belongsTo('Qihucms\Mart\Models\Mart', 'mart_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mart_goods()
    {
        return $this->belongsTo('Qihucms\Mart\Models\MartGoods');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mart_order_express()
    {
        return $this->hasMany('Qihucms\Mart\Models\MartOrderExpress');
    }
}
