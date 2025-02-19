<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\CattleWeightNotification;
use App\Jobs\OverstayCheckNotification;
use App\Jobs\IsolationNotification;
use App\Models\Isolation;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')->everyMinute();
        $schedule->command('weight:check')->dailyAt('00:00');
        $schedule->command('overstay:check')->dailyAt('00:00');
        $schedule->command('isolation:status')->dailyAt('00:00');
        $schedule->command('compare:weight')->dailyAt('00:00');
        $schedule->job(new CattleWeightNotification)->weekly(2);
        $schedule->job(new OverstayCheckNotification)->when(function () {
            return now()->addDays(90);
        });
        $schedule->job(new IsolationNotification)->when(function () {
            $days = Isolation::select('days')->latest()->value('days');
            return now()->addDays($days);
        });
        

        
        // execute the job after 90 days
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
