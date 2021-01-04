<?php

namespace Qihucms\Mart\Controllers\Admin;

use App\Admin\Controllers\Controller;
use App\Models\User;
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

        $grid->model()->latest();

        $grid->filter(function($filter){
            // 在这里添加字段过滤器
            $filter->like('name', __('mart::mart.name'));
            $filter->equal('status', __('mart::mart.status.label'))
                ->select(__('mart::mart.status.value'));
            $filter->between('exp', __('mart::mart.exp'));
            $filter->between('created_at', __('admin.created_at'))->date();
        });

        $grid->column('user.username', __('user.username'));
        $grid->column('user_id', __('mart::mart.user_id'));
        $grid->column('name', __('mart::mart.name'));
        $grid->column('logo', __('mart::mart.logo'))->image('', 66);
        $grid->column('exp', __('mart::mart.exp'));
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
        $show->field('banner', __('mart::mart.banner'))->image();
        $show->field('return_name', __('mart::mart.return_name'));
        $show->field('return_phone', __('mart::mart.return_phone'));
        $show->field('return_address', __('mart::mart.return_address'));
        $show->field('about', __('mart::mart.about'))->unescape();
        $show->field('exp', __('mart::mart.exp'));
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

        $form->select('user_id', __('mart::mart.user_id'))
            ->options(function ($id) {
                $user = User::find($id);
                if ($user) {
                    return [$user->id => $user->username];
                }
            })
            ->ajax(route('admin.select.user'))
            ->help(__('mart::mart.user_id_help'))
            ->creationRules(['required', 'unique:marts'])
            ->updateRules(['required', "unique:marts,user_id,{{user_id}}"]);
        $form->text('name', __('mart::mart.name'));
        $form->image('logo', __('mart::mart.logo'))
            ->uniqueName()
            ->removable()
            ->move('mart/logo');
        $form->image('banner', __('mart::mart.banner'))
            ->uniqueName()
            ->removable()
            ->move('mart/banner');
        $form->text('return_name', __('mart::mart.return_name'));
        $form->text('return_phone', __('mart::mart.return_phone'));
        $form->text('return_address', __('mart::mart.return_address'));
        $form->UEditor('about', __('mart::mart.about'));
        $form->number('exp', __('mart::mart.exp'))
            ->min(0)
            ->default(0);
        $form->select('status', __('mart::mart.status.label'))
            ->default(1)
            ->options(__('mart::mart.status.value'));

        return $form;
    }
}