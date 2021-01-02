<h1 align="center">商城管理</h1>

## 安装
```shell
composer require jncinet/qihucms-mart
```

## 开始
### 数据迁移
```shell
$ php artisan migrate
```

### 发布资源
```shell
$ php artisan vendor:publish --provider="Qihucms\Mart\MartServiceProvider"
```

### 后台菜单
+ 店铺：`mart/marts`
+ 商品分类：`mart/goods-categories`
+ 商品：`mart/goods`
+ 订单：`mart/orders`

## 使用

### 路由参数说明
#### 根据店铺ID或店铺名称查询店铺
+ 请求方式 GET
+ 请求地址 mart/mart-select-by-q?q={关键词}
+ 返回值
```
{
    "data: [
        {
            "id": 1,
            "text": "店铺名称"
        },
        ...
    ],
    "meta": {},
    "links": {},
}
```

#### 产品分类选择
+ 请求方式 GET
+ 请求地址 mart/mart-goods-category-select
+ 返回值
```
[
    {
        "id": 1,
        "text": "店铺名称"
    },
    ...
]
```

## 数据库
### 店铺表：marts
| Field             | Type      | Length    | AllowNull | Default   | Comment   |
| :----             | :----     | :----     | :----     | :----     | :----     |
| user_id           | bigint    |           |           |           | 商家ID     |
| name              | varchar   | 255       |           |           | 店铺名称   |
| logo              | varchar   | 255       |           |           | 店铺标志   |
| manager           | varchar   | 255       | Y         | NULL      | 管理员联系方式 |
| service           | varchar   | 255       | Y         | NULL      | 客服联系方式 |
| banner            | varchar   | 255       | Y         | NULL      | 店铺banner |
| about             | text      |           | Y         | NULL      | 店铺介绍    |
| level             | int       |           |           | 0         | 等级      |
| status            | tinyint   |           |           | 0         | 状态      |
| created_at        | timestamp |           | Y         | NULL      | 创建时间   |
| updated_at        | timestamp |           | Y         | NULL      | 更新时间   |

### 商品分类表：mart_goods_categories
| Field             | Type      | Length    | AllowNull | Default   | Comment   |
| :----             | :----     | :----     | :----     | :----     | :----     |
| id                | bigint    |           |           |           |           |
| title             | varchar   | 55        |           |           | 分类标题   |
| thumbnail         | varchar   | 255       | Y         | NULL      | 小图标     |
| sort              | int       |           |           | 0         | 排序       |
| created_at        | timestamp |           | Y         | NULL      | 创建时间   |
| updated_at        | timestamp |           | Y         | NULL      | 更新时间   |

### 商品表：mart_goods
| Field             | Type      | Length    | AllowNull | Default   | Comment   |
| :----             | :----     | :----     | :----     | :----     | :----     |
| id                | bigint    |           |           |           |           |
| user_id           | bigint    |           |           |           | 商家ID     |
| mart_goods_category_id | bigint |         |           |           | 分类ID     |
| title             | varchar   | 255       |           |           | 名称       |
| price             | decimal   |           |           | 0.00      | 本站价格    |
| sc_price          | decimal   |           |           | 0.00      | 市场价格    |
| pt_price          | decimal   |           |           | 0.00      | 拼团价格    |
| commission        | decimal   |           |           | 0.00      | 佣金       |
| stock             | smallint  |           |           | 1         | 库存       |
| thumbnail         | varchar   | 255       | Y         | NULL      | 商品缩略图  |
| media_list        | json      |           | Y         | NULL      | 展示图片列表 |
| content           | longtext  |           |           | NULL      | 产品介绍    |
| is_shelves        | tinyint   |           |           | 0         | 是否上架    |
| is_new            | tinyint   |           |           | 0         | 是否新品    |
| is_hot            | tinyint   |           |           | 0         | 是否热销    |
| is_virtual        | tinyint   |           |           | 0         | 是否虚拟商品 |
| link              | varchar   | 255       | Y         | NULL      | 产品外链   |
| status            | tinyint   |           |           | 0         | 状态      |
| created_at        | timestamp |           | Y         | NULL      | 创建时间   |
| updated_at        | timestamp |           | Y         | NULL      | 更新时间   |

### 订单物流表：mart_order_expresses
| Field             | Type      | Length    | AllowNull | Default   | Comment   |
| :----             | :----     | :----     | :----     | :----     | :----     |
| id                | bigint    |           |           |           |           |
| mart_order_id     | bigint    |           |           |           | 订单ID     |
| company           | varchar   | 66        | Y         | NULL      | 快递公司    |
| uri               | varchar   | 66        | Y         | NULL      | 快递单号    |
| type              | tinyint   |           |           | 1         | 0退货,1发货 |
| created_at        | timestamp |           | Y         | NULL      | 创建时间   |
| updated_at        | timestamp |           | Y         | NULL      | 更新时间   |

### 订单表：mart_orders
| Field             | Type      | Length    | AllowNull | Default   | Comment   |
| :----             | :----     | :----     | :----     | :----     | :----     |
| id                | bigint    |           |           |           |           |
| tg_user_id        | bigint    |           |           |           | 推广员     |
| total_commission  | decimal   | 10,2      |           | 0.00      | 订单佣金    |
| user_id           | bigint    |           |           |           | 会员ID     |
| user_address_id   | bigint    |           |           | 0         | 收货地址   |
| mart_id           | bigint    |           |           |           | 店铺ID     |
| mart_goods_id     | bigint    |           |           |           | 产品ID     |
| mart_order_id     | bigint    |           |           |           | 订单ID     |
| count             | int       |           |           | 0         | 购买数量    |
| price             | decimal   | 10,2      |           | 0.00      | 产品单价    |
| total_money       | decimal   | 10,2      |           | 0.00      | 订单总金额  |
| status            | tinyint   |           |           | 1         | 业务状态   |
| created_at        | timestamp |           | Y         | NULL      | 创建时间   |
| updated_at        | timestamp |           | Y         | NULL      | 更新时间   |
