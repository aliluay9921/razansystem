<?php

namespace App\Console;

use App\Console\Commands\discountflight;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\expier_flightplan;
use App\Console\Commands\expiration;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        expiration::class,
        expier_flightplan::class,
        discountflight::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('order:expire')->daily();
        $schedule->command('flightplanexpire:expire')->hourly();
        $schedule->command('discount:expier')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
