<?php

namespace Qihucms\Mart\Commands;

use Illuminate\Console\Command;

class CopyGoodsCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mart:copy-goods';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'copy mall\'s goods to mart goods table.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function handle()
    {
        \DB::table('goods')->orderBy('id')->chunk(100, function ($old_goods) {
            foreach ($old_goods as $goods) {
                \DB::table('mart_goods')->insert([
                    'id' => $goods->id,
                    'user_id' => $goods->user_id,
                    'mart_goods_category_id' => $goods->goods_category_id,
                    'title' => $goods->title,
                    'price' => $goods->price,
                    'commission' => $goods->commission,
                    'stock' => $goods->stock,
                    'thumbnail' => $goods->thumbnail,
                    'media_list' => $goods->media_list,
                    'content' => $goods->content,
                    'is_shelves' => $goods->is_shelves == '是',
                    'is_new' => $goods->is_new == '是',
                    'is_hot' => $goods->is_hot == '是',
                    'status' => $goods->status,
                    'link' => $goods->link,
                    'created_at' => $goods->created_at,
                    'updated_at' => $goods->updated_at
                ]);
            }
        });

        $this->info('copy success');
    }
}
