<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\VolvAppUser;
use DB;

class getVolvAppUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:volvappusers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the Volv App users from api.volvmedia.com website';

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

        DB::select("truncate table volv_app_users;");

        $data = file_get_contents("https://api.volvmedia.com/api/getVolvAppUserList");
        $data = json_decode($data);
        foreach($data as $d) {
            $user = new VolvAppUser();
            $user->name = $d->name;
            $user->email = $d->email;
            $user->fcm_token = $d->fcm_token;
            $user->date_of_registration = $d->created_at;
            $user->save();
        }

    }
}
