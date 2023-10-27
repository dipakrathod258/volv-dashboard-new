<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class cronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $title="User Registration";
        $message = "Welcome to Volv Dashboard!";
        $email = 'dipakrathod258@gmail.com';
        $message_data = ["message" => $message, "email"=>$email];
        Mail::send('users.welcome_author_mail', ['title' => $title, 'message_data' => $message_data], function ($message) use($message_data)
        {
            $message->from('connect@volvmedia.com');
            $message->to($message_data['email'])->subject('Welcome to Volv Dashboard');
        });
    }
}
