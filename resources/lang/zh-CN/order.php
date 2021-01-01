<?php

return [
    'id' => '订单号',
    'user_id' => '下单会员',
    'tg_user_id' => '推广员',
    'user_address_id' => '收货地址ID',
    'mart_id' => '店铺ID',
    'mart_goods_id' => '商品ID',
    'price' => '单价',
    'count' => '数量',
    'total_commission' => '订单佣金',
    'total_money' => '订单总额',
    'status' => [
        'label' => '状态',
        'value' => [
            '待付款', '已付款待发货', '已发货待签收', '交易完成',
            '取消订单', '申请退货', '买家删除', '卖家删除', '双方删除'
        ]
    ]
];