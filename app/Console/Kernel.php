<?php

namespace App\Console;

use App\Console\Commands\BlockIoIPN;
use App\Console\Commands\Cron;
use App\Models\Gateway;
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
        BlockIoIPN::class,
        Cron::class
        
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
  
   protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $inactiveDaysThreshold = 15;

        // Auto-ban inactive users
        User::where('updated_at', '<', Carbon::now()->subDays($inactiveDaysThreshold))
            ->where('status', 1)
            ->update(['status' => 0]);
    })->daily(); // Runs daily

    // Run blockIo:ipn every 30 minutes if gateway conditions are met
    $blockIoGateway = Gateway::where(['code' => 'blockio', 'status' => 1])->count();
    if ($blockIoGateway == 1) {
        $schedule->command('blockIo:ipn')->everyThirtyMinutes();
    }

    // Run cron:status every hour
    $schedule->command('cron:status')->hourly();



    // Delete manual recharge records older than 24 hours
    $schedule->call(function () {
        \App\Models\Recharge::whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket'])
            ->where('created_at', '<', now()->subDay())
            ->delete();
    })->daily();    // Clear sessions every 30 minutes
    $schedule->command('session:prune')->everyThirtyMinutes();
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
