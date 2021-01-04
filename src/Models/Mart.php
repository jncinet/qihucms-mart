<?php

namespace Qihucms\Mart\Models;

use Illuminate\Database\Eloquent\Model;

class Mart extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id', 'name', 'logo', 'banner', 'return_name', 'return_phone', 'return_address',
        'about', 'level', 'status'
    ];

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
}
