<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMartOrderExpressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mart_order_expresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mart_order_id')->comment('订单ID');
            $table->string('company', 66)->nullable()->comment('快递公司');
            $table->string('uri', 66)->nullable()->comment('快递单号');
            $table->boolean('type')->default(1)->comment('[0退货、1发货]');
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
        Schema::dropIfExists('mart_order_expresses');
    }
}
