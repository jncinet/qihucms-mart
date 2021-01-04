<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary()->comment('商家ID');
            $table->string('name')->comment('店铺名称');
            $table->string('logo')->nullable()->comment('店铺标志');
            $table->string('banner')->nullable()->comment('banner');
            $table->string('return_name')->nullable()->comment('退货收货人');
            $table->string('return_phone')->nullable()->comment('退货收货电话');
            $table->string('return_address')->nullable()->comment('退货收货地址');
            $table->text('about')->nullable()->comment('店铺介绍');
            $table->unsignedInteger('exp')->default(0)->comment('经验');
            $table->boolean('status')->default(0)->comment('状态');
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
        Schema::dropIfExists('marts');
    }
}
