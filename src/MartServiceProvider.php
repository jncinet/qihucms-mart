<?php

namespace Qihucms\Mart;

use Illuminate\Support\ServiceProvider;
use Qihucms\Mart\Commands\CopyDatabaseCommand;
use Qihucms\Mart\Commands\CopyGoodsCommand;
use Qihucms\Mart\Commands\CopyOrdersCommand;
use Qihucms\Mart\Commands\InstallCommand;
use Qihucms\Mart\Commands\UninstallCommand;
use Qihucms\Mart\Commands\UpgradeCommand;

class MartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                UninstallCommand::class,
                UpgradeCommand::class,
                // 将原商城数据复制到新表中
                CopyOrdersCommand::class,
                CopyDatabaseCommand::class,
                CopyGoodsCommand::class
            ]);
        }

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'mart');

        $this->loadRoutesFrom(__DIR__ . '/../routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/mart'),
        ]);
    }
}
