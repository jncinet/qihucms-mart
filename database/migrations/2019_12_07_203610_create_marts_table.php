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
            $table->string('logo')->comment('店铺标志');
            $table->string('manager')->nullable()->comment('店铺管理员联系方式');
            $table->string('service')->nullable()->comment('客服联系方式');
            $table->string('banner')->nullable()->comment('店铺banner');
            $table->text('about')->nullable()->comment('店铺介绍');
            $table->unsignedInteger('level')->default(0)->comment('等级');
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
