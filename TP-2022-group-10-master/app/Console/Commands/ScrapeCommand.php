<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
Use Sentiment\Analyzer;

class ScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command to crawl new header';

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
    public function index()
    {
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', 'https://www.cnbc.com/stocks/');

        // Get the latest post in this category and display the titles

        // $crawler->filter('.Card-title')->each(function ($node) {
        //     print $node->text()."\n";
        //     $analyzer = new Analyzer(); 
        //     $sentiment = $analyzer->getSentiment($node->text()."\n");
        //     print_r($sentiment);
        // });

        $content = $crawler->filter('.Card-title')->text();
        $sentiment = Analyzer::getSentiment($content);

        // // Use sentiment to analyze the sentiment of the article
        // $analyzer = new Analyzer(); 
        // $sentiment = $analyzer->getSentiment($crawler->filter('.Card-title')->text()."\n");

        // print_r($sentiment);

    }
}
