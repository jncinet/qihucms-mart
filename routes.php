<?php

use Illuminate\Routing\Router;

// 电脑端
Route::group([
    'domain' => config('qihu.pc_domain'),
    'prefix' => config('qihu.mart_prefix', 'mart'),
    // 控制器命名空间
    'namespace' => 'Qihucms\Mart\Controllers\Pc',
    'middleware' => ['web']
], function (Router $router) {
//    $router->resource('articles', 'ArticlesController');
    // 商城首页
//    $router->get('/', 'IndexController@index');
});

// 接口
Route::group([
    // 页面URL前缀
    'prefix' => config('qihu.mart_prefix', 'mart'),
    'namespace' => 'Qihucms\Mart\Controllers\Api',
    'middleware' => ['api'],
    'as' => 'api.'
], function (Router $router) {
    // 选择店铺
    $router->get('mart-select-by-q', 'MartController@adminGetMartByQ')->name('mart-select-by-q');
    // 选择商品分类
    $router->get('mart-goods-category-select', 'CategoryController@adminSelectCategory')
        ->name('mart-goods-category-select');
    // 店铺管理
    $router->apiResource('marts', 'MartController');
});

// 后台
Route::group([
    'prefix' => config('admin.route.prefix') . '/mart',
    'namespace' => 'Qihucms\Mart\Controllers\Admin',
    'middleware' => config('admin.route.middleware'),
    'as' => 'admin.'
], function (Router $router) {
    $router->resource('marts', 'MartController');
    $router->resource('goods-categories', 'GoodsCategoryController');
    $router->resource('goods', 'GoodsController');
    $router->resource('orders', 'OrderController');
});