<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMartGoodsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mart_goods_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 55)->comment('分类标题');
            $table->string('thumbnail')->nullable()->comment('小图标');
            $table->unsignedBigInteger('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('mart_goods_categories');
    }
}
