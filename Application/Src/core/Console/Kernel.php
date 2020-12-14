<?php

namespace Application\Src\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];


    private function getFileTime($fileName)
    {
        return @filemtime(storage_path() . '/schedule/' . $fileName);
    }

    private function isTimeToRun($minutes, $fileName)
    {
        $fileTime = $this->getFileTime($fileName);
        if ($fileTime < time() - ($minutes * 60)) {
            return true;
        }
        return false;
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Zero Because we will run cron job every 5 minutes

        if ($this->isTimeToRun(5, 'scheduled-articles.log')) {
            $schedule->command('scheduled:articles')->appendOutputTo(storage_path() . '/schedule/scheduled-articles.log')->withoutOverlapping();
        }


        // check and update authorized or not authorized securities to switch
        if ($this->isTimeToRun(1440, 'check-unauthorized-securities-status.log')) {
            $schedule->command('scheduled:check:unauthorized:securities:status:to:switch')->appendOutputTo(storage_path() . '/schedule/check-unauthorized-securities-status.log')->withoutOverlapping();
        }

        // cache authorized stock securities
        if ($this->isTimeToRun(10, 'cache-authorized-securities.log')) {
            $schedule->command('scheduled:cache:active:securities')->appendOutputTo(storage_path() . '/schedule/cache-authorized-securities.log');
        }
    }
}
