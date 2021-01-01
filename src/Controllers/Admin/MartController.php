<?php

namespace Qihucms\Mart\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Qihucms\Mart\Models\Mart;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MartController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '店铺管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Mart);
        $grid->disableCreateButton();
        $grid->model()->latest();

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('name', __('mart::mart.name'));
            $filter->equal('status', __('mart::mart.status.label'))->select(__('mart::mart.status.value'));
            $filter->between('created_at', __('admin.created_at'))->date();
        });

        $grid->column('user.username', __('user.username'));
        $grid->column('user_id', __('mart::mart.user_id'));
        $grid->column('name', __('mart::mart.name'));
        $grid->column('logo', __('mart::mart.logo'))->image('', 66);
        $grid->column('level', __('mart::mart.level'));
        $grid->column('status', __('mart::mart.status.label'))
            ->using(__('mart::mart.status.value'));
        $grid->column('created_at', __('admin.created_at'));
        $grid->column('updated_at', __('admin.updated_at'));

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
        $show = new Show(Mart::findOrFail($id));

        $show->field('user_id', __('mart::mart.user_id'));
        $show->field('name', __('mart::mart.name'));
        $show->field('logo', __('mart::mart.logo'))->image();
        $show->field('service', __('mart::mart.service'));
        $show->field('banner', __('mart::mart.banner'))->image();
        $show->field('about', __('mart::mart.about'))->unescape();
        $show->field('level', __('mart::mart.level'));
        $show->field('manager_phone', __('mart::mart.manager_phone'));
        $show->field('status', __('mart::mart.status.label'))
            ->using(__('mart::mart.status.value'));
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
        $form = new Form(new Mart);

        $form->number('user_id', __('mart::mart.id'))
            ->help('请填写没有开通过店铺的会员ID');
        $form->text('name', __('mart::mart.name'));
        $form->text('manager_phone', __('mart::mart.manager_phone'));
        $form->image('logo', __('mart::mart.logo'))
            ->uniqueName()
            ->removable()
            ->move('mart/logo');
        $form->textarea('service', __('mart::mart.service'));
        $form->image('banner', __('mart::mart.banner'))
            ->uniqueName()
            ->removable()
            ->move('mart/banner');
        $form->UEditor('about', __('mart::mart.about'));
        $form->number('level', __('mart::mart.level'))
            ->min(0)
            ->default(0);
        $form->select('status', __('mart::mart.status.label'))
            ->default(1)
            ->options(__('mart::mart.status.value'));

        return $form;
    }
}