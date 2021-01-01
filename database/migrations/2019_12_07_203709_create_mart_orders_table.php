<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMartOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mart_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tg_user_id')->default(0)->comment('推广员');
            $table->unsignedDecimal('total_commission', 10, 2)->default(0)
                ->comment('订单佣金');
            $table->unsignedBigInteger('user_id')->comment('会员ID');
            $table->unsignedBigInteger('user_address_id')->default(0)
                ->comment('收货地址');
            $table->unsignedBigInteger('mart_id')->comment('店铺ID');
            $table->unsignedBigInteger('mart_goods_id')->comment('产品ID');
            $table->unsignedInteger('count')->default(0)->comment('购买数量');
            $table->unsignedDecimal('price')->default(0)->comment('产品单价');
            $table->unsignedDecimal('total_money', 10, 2)->default(0)
                ->comment('订单总金额');
            $table->boolean('status')->default(0)
                ->comment('[待付款、已付款、待发货、已发货、签收|退货、完成|取消]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mart_orders');
    }
}
