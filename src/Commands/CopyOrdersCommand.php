<?php

namespace Qihucms\Mart\Commands;

use Illuminate\Console\Command;

class CopyOrdersCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mart:copy-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'copy mall\'s orders to mart orders table.';

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
        \DB::table('goods_orders')->orderBy('id')->chunk(100, function ($orders) {
            foreach ($orders as $order) {
                \DB::table('mart_orders')->insert([
                    'id' => $order->id,
                    'tg_user_id' => $order->tg_user_id,
                    'total_commission' => $order->total_commission,
                    'user_id' => $order->user_id,
                    'user_address_id' => $order->user_address_id,
                    'mart_id' => $order->mall_id,
                    'mart_goods_id' => $order->goods_id,
                    'count' => $order->count,
                    'price' => $order->price,
                    'total_money' => $order->total_money,
                    'status' => $order->status,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at
                ]);

                // 发货单
                if ($order->user_express_company && $order->user_express_no) {
                    \DB::table('mart_order_expresses')->insert([
                        'mart_order_id' => $order->id,
                        'company' => $order->user_express_company,
                        'uri' => $order->user_express_no,
                        'type' => 1,
                    ]);
                }

                // 退货单
                if ($order->refunds_express_company && $order->refunds_express_no) {
                    \DB::table('mart_order_expresses')->insert([
                        'mart_order_id' => $order->id,
                        'company' => $order->refunds_express_company,
                        'uri' => $order->refunds_express_no,
                        'type' => 0,
                    ]);
                }
            }
        });

        $this->info('copy success');
    }
}
