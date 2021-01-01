<?php

namespace Qihucms\Mart\Commands;

use Illuminate\Console\Command;

class CopyDatabaseCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mart:copy-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'copy mall\'s database to mart.';

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
        $this->copy_category();

        $this->copy_mart();

        $this->info('copy success');
    }

    protected function copy_category()
    {
        \DB::table('goods_categories')->orderBy('id')->chunk(100, function ($categories) {
            foreach ($categories as $category) {
                \DB::table('mart_goods_categories')->insert([
                    'id' => $category->id,
                    'title' => $category->title,
                    'thumbnail' => $category->thumbnail,
                    'sort' => $category->sort,
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at
                ]);
            }
        });
    }

    protected function copy_mart() {
        \DB::table('malls')->orderBy('user_id')->chunk(100, function ($malls) {
            foreach ($malls as $mall) {
                \DB::table('marts')->insert([
                    'user_id' => $mall->user_id,
                    'name' => $mall->name,
                    'logo' => $mall->logo,
                    'manager' => null,
                    'service' => $mall->service,
                    'banner' => $mall->banner,
                    'about' => $mall->about,
                    'level' => $mall->level,
                    'status' => $mall->status,
                    'created_at' => $mall->created_at,
                    'updated_at' => $mall->updated_at
                ]);
            }
        });
    }
}
