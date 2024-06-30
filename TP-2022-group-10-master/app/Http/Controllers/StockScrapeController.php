<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Facades\DB;

use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


use App\Models\Stock\StockSymbol;

class StockScrapeController extends Controller
{
    ##ensure table is empty
    public function clearStocksTable(){
        // DB::table('stocks_holder')->truncate();
        DB::table('stocks')->truncate();
    }
    
    public function populateStockTable()
{
    Log::info('populateStockTable: Started');

    $this->clearStocksTable();
    set_time_limit(0);

    $nasdaqSymbol = StockSymbol::get("symbol");
    Log::info('Number of symbols: ' . sizeof($nasdaqSymbol));

    for ($i = 0; $i < sizeof($nasdaqSymbol); $i++) {
        // if symbol is delisted skip 
        try {
            $this->getStockYahooFinApi($nasdaqSymbol[$i]->symbol);
        } catch (\Exception $e) {
            Log::error('Error fetching data for symbol ' . $nasdaqSymbol[$i]->symbol . ': ' . $e->getMessage());
            continue;
        }
    }

    Log::info('populateStockTable: Completed');
     return redirect()->route('eh.admin.index');
}

    #get Data 
    public function getStockYahooFinApi($symbol){
        // Create a new client from the factory
        // $client = ApiClientFactory::createApiClient();

        $options = ['timeout' => 3.14,
                    'headers' => ['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36'],
                    'delay' => 1,];

        $guzzleClient = new Client($options);
        $client = ApiClientFactory::createApiClient($guzzleClient);
      

        // Returns an array of Scheb\YahooFinanceApi\Results\HistoricalData
        $historicalData = $client->getHistoricalQuoteData(
            $symbol,
            ApiClient::INTERVAL_1_DAY,
            new \DateTime("-10 years"),
            // new \DateTime("-365 days"),
            new \DateTime("today"),
        );
        

        //pull from datetime Object and convert to y-m-d format
       for($i = 0; $i < sizeof($historicalData); $i++){
       $dateFromApi = $historicalData[$i]->getdate();

       $openFromApi = $this->round2dp($historicalData[$i]->getopen());
       $highFromApi = $this->round2dp($historicalData[$i]->gethigh());
       $lowFromApi = $this->round2dp($historicalData[$i]->getlow());
       $closeFromApi = $this->round2dp($historicalData[$i]->getclose());
       $adjCloseFromApi = $this->round2dp($historicalData[$i]->getadjClose());
       $volumeFromApi = $this->convert2String($historicalData[$i]->getVolume());


       //populate db
       DB::table("stocks")->insert([
                    "Date"=> $dateFromApi,
                    "Open"=> $openFromApi,
                    "High"=> $highFromApi,
                    "Low"=> $lowFromApi,
                    "Close"=> $closeFromApi,
                    "AdjClose"=> $adjCloseFromApi,
                    "Volume"=> $volumeFromApi,
                    "Symbol"=>$symbol,
                ]);
       }        
       
    }

    public function round2dp($number){
        return number_format((float)$number, 2, '.', '');
    }

    public function convert2String($var){
        return json_encode($var);
    }

}
