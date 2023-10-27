<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendSilentNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:silent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Silent Push Notification for Volv App Users.';

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
        // dd("we");

        $headers = [
          'Content-Type' => 'application/json',
          'Content-Length' => 1
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/silentNotification");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  
    }
}
