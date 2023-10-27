<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;

class NotifyMayur extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:mayur';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify Mayur about notification';

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
        $title="Send Notification";
        $message = "Bhai notification";
        $email = 'shannon@benefactory.in';
        $message_data = ["message" => $message, "email"=>$email];
        Mail::send('test', ['title' => $title, 'message_data' => $message_data], function ($message) use($message_data)
        {
            $message->from('connect@volvmedia.com');
            $message->to($message_data['email'])->subject('Bro! Send Notification');
        }); 
    }
}


