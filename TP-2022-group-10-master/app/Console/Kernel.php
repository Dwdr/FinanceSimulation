<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
// in app/Console/Kernel.php
use Spatie\SiteSearch\Commands\CrawlCommand;

use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Facades\DB;

use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Http\Controllers\StockScrapeController;


class Kernel extends ConsoleKernel
{
        
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //\App\Console\Commands\Inspire::class,

        // add the MySqlDump command here
//        \App\Console\Commands\MySqlDump::class,
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
        $stockScrapeController = app()->make(StockScrapeController::class);
        $stockScrapeController->populateStockTable();
        })->dailyAt('07:00');
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
