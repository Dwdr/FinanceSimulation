<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

$extractData = array();

class ScrapeStockCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stockCrawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl Yahoo Finance Historical Data';

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
     * @return int
     */
    public function handle()
    {
        $month = array("Jan", "Feb ", "Mar ", "Apr ", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
        $flag = false;
        

        #http setting
        $client = new Client(HttpClient::create(['timeout' => 60]));
        #website to crawl
        $crawler = $client->request('GET', 'https://finance.yahoo.com/quote/AAPL/history?p=AAPL');
        #pull span class data from yahoo finance historical data
        $crawler->filter('span')->each(function ($node) {
        $extractedSpan = $node->text()."\n";
        
        // print $extractedSpan;
        // print gettype($extractedSpan);

        // if($extractedSpan == "Volume"){
        //     print "found";
        //     $flag = true;
        //     if($flag == true){
        //         array_push($extractData,"test");
        //     }
        // }       
        // array_push($extractData,$extractedSpan);
        print $extractedSpan;
        
        
});
        // print_r($extractData);
        return 0;
    }
}
