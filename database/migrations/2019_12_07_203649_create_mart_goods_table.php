<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMartGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mart_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('商家ID');
            $table->unsignedBigInteger('mart_goods_category_id')->index()
                ->comment('产品分类ID');
            $table->string('title')->comment('产品名称');
            $table->unsignedDecimal('price', 10, 2)->default(0)
                ->comment('本站价格');
            $table->unsignedDecimal('commission', 10, 2)->default(0)
                ->comment('商品佣金');
            $table->unsignedSmallInteger('stock')->default(1)->comment('库存');
            $table->string('thumbnail')->nullable()->comment('商品缩略图');
            $table->json('media_list')->nullable()->comment('展示图片列表');
            $table->longText('content')->nullable()->comment('产品介绍');
            $table->boolean('is_shelves')->default(0)->comment('是否上架');
            $table->boolean('is_new')->default(0)->comment('是否新品');
            $table->boolean('is_hot')->default(0)->comment('是否热销');
            $table->string('link')->nullable()->comment('产品外链');
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
        Schema::dropIfExists('mart_goods');
    }
}
