<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\AutosaveArticle::class,
        Commands\rssFeedUSNews::class,
        Commands\getVolvAppUsers::class,
        Commands\rssFeedWorldNews::class,
        Commands\rssFeedPoliticsNews::class,
        Commands\publishWeekendArticle::class,
        Commands\updateArticleTime::class,
        Commands\SendSilentNotification::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('publish:weekendArticle')
                 ->weekly()->mondays()->at('19:12');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
