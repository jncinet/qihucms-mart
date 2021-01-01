<?php

namespace Qihucms\Mart\Commands;

use App\Plugins\Plugin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UninstallCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mart:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade mart plugin';

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
        // 清除插件缓存
        (new Plugin())->clearPluginCache('mart');

        // 删除配置缓存信息
        $configs =  [

        ];

        foreach ($configs as $config) {
            Cache::forget($config);
        }

        $this->info('Uninstall successful.');
    }
}
