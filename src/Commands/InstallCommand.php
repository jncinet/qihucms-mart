<?php

namespace Qihucms\Mart\Commands;

use App\Plugins\Plugin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class InstallCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mart:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install mart plugin';

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
     * @return mixed
     */
    public function handle()
    {
        $plugin = new Plugin();

        if ($this->installed()) {
            $this->info('Plugin table already exists');
        } else {
            // 数据库迁移
            $this->call('migrate');

            // 创建管理菜单
            $plugin->createPluginAdminMenu('商城管理 v2', [
                ['title' => '商家管理', 'uri' => 'mart/marts'],
                ['title' => '商品管理', 'uri' => 'mart/goods'],
                ['title' => '订单管理', 'uri' => 'mart/orders'],
                ['title' => '商城配置', 'uri' => 'mart/config'],
            ]);

            // 缓存版本
            $plugin->setPluginVersion('mart', 100);

            $this->info('Install success');
        }
    }

    // 是否安装过
    protected function installed()
    {
        $plugin = new Plugin();
        // 验证表是否存在
        return \Schema::hasTable('marts')
            && \Schema::hasTable('mart_goods')
            && \Schema::hasTable('mart_goods_categories')
            && \Schema::hasTable('mart_orders')
            && \Schema::hasTable('mart_order_expresses')
            && $plugin->getPluginVersion('mart') == 100;
    }
}
