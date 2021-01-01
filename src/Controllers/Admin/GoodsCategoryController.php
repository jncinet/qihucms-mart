<?php

namespace Qihucms\Mart\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Qihucms\Mart\Models\MartGoodsCategory;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GoodsCategoryController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '产品分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MartGoodsCategory);

        $grid->model()->orderBy('sort', 'desc');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->like('title', __('mart::category.title'));
        });

        $grid->column('id', __('mart::category.id'));
        $grid->column('title', __('mart::category.title'));
        $grid->column('thumbnail', __('mart::category.thumbnail'))->image('', 66);
        $grid->column('sort', __('mart::category.sort'))->editable();

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
        $show = new Show(MartGoodsCategory::findOrFail($id));

        $show->field('id', __('mart::category.id'));
        $show->field('title', __('mart::category.title'));
        $show->field('thumbnail', __('mart::category.thumbnail'))->image();
        $show->field('sort', __('mart::category.sort'));
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
        $form = new Form(new MartGoodsCategory);

        $form->text('title', __('mart::category.title'))->required();
        $form->image('thumbnail', __('mart::category.thumbnail'))
            ->uniqueName()
            ->removable()
            ->move('mart/category');
        $form->number('sort', __('mart::category.sort'))
            ->default(0)->min(0);

        return $form;
    }
}
