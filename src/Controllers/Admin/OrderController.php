<?php

namespace Qihucms\Mart\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Qihucms\Mart\Models\MartOrder;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商城订单管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MartOrder);

        $grid->disableCreateButton();
        $grid->model()->latest();

        $grid->filter(function ($filter) {

            // 在这里添加字段过滤器
            $filter->like('goods.title', __('mart::goods.title'));
            $filter->like('mart.name', __('mart:mart.name'));
            $filter->equal('status', __('mart::order.status.label'))
                ->select(__('mart::order.status.value'));
            $filter->between('price', __('mart::order.price'));
            $filter->between('count', __('mart::order.count'));
            $filter->between('total_money', __('mart::order.total_money'));
            $filter->between('total_commission', __('mart::order.total_commission'));
            $filter->between('created_at', __('admin.created_at'))->date();
        });

        $grid->column('id', __('mart::order.id'));
        $grid->column('mart.name', __('mart::mart.name'));
        $grid->column('mart_goods.title', __('mart::goods.title'));
        $grid->column('price', __('mart::order.price'));
        $grid->column('count', __('mart::order.count'));
        $grid->column('total_money', __('mart::order.total_money'));
        $grid->column('status', __('mart::order.status.label'))
            ->using(__('mart::order.status.value'));
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
        $show = new Show(MartOrder::findOrFail($id));

        $show->field('id', __('mart::order.id'));
        $show->field('user_id', __('mart::order.user_id'))->as(function () {
            return $this->user->username;
        });
        $show->field('user_address_id', __('user_address.address'))
            ->unescape()
            ->as(function () {
                $model = $this->user_address;
                $html = '';
                if ($model) {
                    $html .= '<div>' . __('user_address.uri') . '：' . $model->uri . '</div>';
                    $html .= '<div>' . __('user_address.name') . '：' . $model->name . '</div>';
                    $html .= '<div>' . __('user_address.phone') . '：' . $model->phone . '</div>';
                    $html .= '<div>' . __('user_address.address') . '：' . $model->address . '</div>';
                }
                return $html;
            });
        $show->field('mart_order_express', __('mart::express.table'))
            ->unescape()
            ->as(function () {
                $model = $this->mart_order_express;
                $html = '';
                if ($model) {
                    foreach ($model as $item) {
                        $html .= '<div>' . __('mart::express.type.label') . '：' . __('mart::express.type.value')[$item->type] . '</div>';
                        $html .= '<div>' . __('mart::express.company') . '：' . $item->company . '</div>';
                        $html .= '<div>' . __('mart::express.uri') . '：' . $item->uri . '</div>';
                        $html .= '<hr/>';
                    }
                }
                return $html;
            });
        $show->field('mart_id', __('mart::mart.name'))
            ->as(function () {
                return $this->mart->name;
            });
        $show->field('mart_goods_id', __('mart::goods.title'))->as(function () {
            return $this->mart_goods->title;
        });
        $show->field('price', __('mart::order.price'));
        $show->field('count', __('mart::order.count'));
        $show->field('total_money', __('mart::order.total_money'));
        $show->field('total_commission', __('mart::order.total_commission'));
        $show->field('status', __('mart::order.status.label'))
            ->using(__('mart::order.status.value'));
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
        $form = new Form(new MartOrder);

        $form->select('status', __('mart::order.status.label'))
            ->options(__('mart::order.status.value'));

        return $form;
    }
}
