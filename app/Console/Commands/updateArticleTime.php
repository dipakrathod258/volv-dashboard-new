<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class updateArticleTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:articleTime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Article update periodically';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $updated_time = date('Y-m-d H:i:s', time());
        
        DB::table('articles')
        ->where('id',  4572)
        ->update(['updated_at' => $updated_time]);

        DB::table('articles')
        ->where('id',  4571)
        ->update(['updated_at' => $updated_time]);

        DB::table('articles')
        ->where('id',  4570)
        ->update(['updated_at' => $updated_time]);

        DB::table('articles')
        ->where('id',  4569)
        ->update(['updated_at' => $updated_time]);

        DB::table('articles')
        ->where('id',  4568)
        ->update(['updated_at' => $updated_time]);
        
    }
}
