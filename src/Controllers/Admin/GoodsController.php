<?php

namespace Qihucms\Mart\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Qihucms\Mart\Models\MartGoods;
use Qihucms\Mart\Models\Mart;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GoodsController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '产品管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MartGoods);

        $grid->model()->latest();

        $grid->filter(function ($filter) {

            // 在这里添加字段过滤器
            $filter->like('title', __('mart::goods.title'));
            $filter->like('mart.name', __('mart::mart.name'));
            $filter->equal('mart_goods_category.title', __('mart::category.title'))
                ->select(route('api.mart-goods-category-select'));
            $filter->equal('is_new', __('mart::goods.is_new.label'))
                ->select(__('mart::goods.is_new.value'));
            $filter->equal('is_hot', __('mart::goods.is_hot.label'))
                ->select(__('mart::goods.is_hot.value'));
            $filter->equal('is_virtual', __('mart::goods.is_virtual.label'))
                ->select(__('mart::goods.is_virtual.value'));
            $filter->equal('status', __('mart::goods.status.label'))
                ->select(__('mart::goods.status.value'));
        });

        $grid->column('thumbnail', __('mart::goods.thumbnail'))->image('', 66);
        $grid->column('mart.name', __('mart::goods.user_id'))->limit(16);
        $grid->column('title', __('mart::goods.title'))->limit(36);
        $grid->column('price', __('mart::goods.price'));
        $grid->column('pt_price', __('mart::goods.pt_price'));
        $grid->column('is_shelves', __('mart::goods.is_shelves.label'))
            ->select(__('mart::goods.is_shelves.value'));
        $grid->column('is_new', __('mart::goods.is_new.label'))
            ->select(__('mart::goods.is_new.value'));
        $grid->column('is_hot', __('mart::goods.is_hot.label'))
            ->select(__('mart::goods.is_hot.value'));
        $grid->column('status', __('mart::goods.status.label'))
            ->select(__('mart::goods.status.value'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(MartGoods::findOrFail($id));

        $show->field('id', __('mart::goods.id'));
        $show->field('user_id', __('mart::goods.user_id'));
        $show->field('goods_category_id', __('mart::goods.goods_category_id'));
        $show->field('title', __('mart::goods.title'));
        $show->field('price', __('mart::goods.price'));
        $show->field('sc_price', __('mart::goods.sc_price'));
        $show->field('pt_price', __('mart::goods.pt_price'));
        $show->field('commission', __('mart::goods.commission'));
        $show->field('stock', __('mart::goods.stock'));
        $show->field('thumbnail', __('mart::goods.thumbnail'))->image();
        $show->field('media_list', __('mart::goods.media_list'))->carousel();
        $show->field('content', __('mart::goods.content'))->unescape();
        $show->field('is_shelves', __('mart::goods.is_shelves.label'))
            ->using(__('mart::goods.is_shelves.value'));
        $show->field('is_new', __('mart::goods.is_new.label'))
            ->using(__('mart::goods.is_new.value'));
        $show->field('is_hot', __('mart::goods.is_hot.label'))
            ->using(__('mart::goods.is_hot.value'));
        $show->field('is_virtual', __('mart::goods.is_virtual.label'))
            ->using(__('mart::goods.is_virtual.value'));
        $show->field('link', __('mart::goods.link'))->link();
        $show->field('status', __('mart::goods.status.label'))
            ->using(__('mart::goods.status.value'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MartGoods);

        $form->select('user_id', __('mart::goods.user_id'))
            ->options(function ($user_id) {
                $model = Mart::findOrFail($user_id);
                if ($model) {
                    return [$model->user_id => $model->name];
                }
            })
            ->ajax(route('api.mart-select-by-q'));
        $form->select('mart_goods_category_id', __('mart::goods.mart_goods_category_id'))
            ->options(route('api.mart-goods-category-select'));
        $form->text('title', __('mart::goods.title'))->required();
        $form->currency('price', __('mart::goods.price'))
            ->symbol(config('qihu.currency_symbol', '¥'))->default(0.00);
        $form->currency('sc_price', __('mart::goods.sc_price'))
            ->symbol(config('qihu.currency_symbol', '¥'))->default(0.00);
        $form->currency('pt_price', __('mart::goods.pt_price'))
            ->symbol(config('qihu.currency_symbol', '¥'))->default(0.00);
        $form->currency('commission', __('mart::goods.commission'))
            ->symbol(config('qihu.currency_symbol', '¥'))->default(0.00);
        $form->number('stock', __('mart::goods.stock'))->min(0)->default(1);
        $form->image('thumbnail', __('mart::goods.thumbnail'))
            ->uniqueName()
            ->removable()
            ->move('mall/thumbnail');
        $form->multipleImage('media_list', __('mart::goods.media_list'))
            ->uniqueName()
            ->removable()
            ->move('mart/carousel');
        $form->UEditor('content', __('mart::goods.content'));
        $form->select('is_shelves', __('mart::goods.is_shelves.label'))
            ->default(0)->options(__('mart::goods.is_shelves.value'));
        $form->select('is_new', __('mart::goods.is_new.label'))
            ->default(0)->options(__('mart::goods.is_new.value'));
        $form->select('is_hot', __('mart::goods.is_hot.label'))
            ->default(0)->options(__('mart::goods.is_hot.value'));
        $form->select('is_virtual', __('mart::goods.is_virtual.label'))
            ->default(0)->options(__('mart::goods.is_hot.value'));
        $form->text('link', __('mart::goods.link'));
        $form->select('status', __('mart::goods.status.label'))
            ->options(__('mart::goods.status.value'));

        return $form;
    }
}
