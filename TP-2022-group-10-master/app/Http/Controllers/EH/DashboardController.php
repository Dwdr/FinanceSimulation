<?php
/*
 * Kamphora CONFIDENTIAL
 * Copyright (c) 2020.
 * ------------------------------------
 * [2002] - [2020] Kamphora Limited (Hong Kong)
 *  All Rights Reserved.
 *
 *  NOTICE:  All information contained herein is, and remains
 *  the property of Kamphora Limited (Hong Kong) and its affiliated parties,
 *  if any. The intellectual and technical concepts contained
 *  herein are proprietary to Kamphora Limited (Hong Kong)
 *  and its affiliated parties and may be covered by U.S. and Foreign Patents,
 *  patents in process, and are protected by trade secret or copyright law.
 *  Dissemination of this information or reproduction of this material
 *  is strictly forbidden unless prior written permission is obtained
 *  from Kamphora Limited (Hong Kong).
 *
 * 
 *  This file is subject to the terms and conditions defined in
 *  file 'LICENSE.txt', which is part of this source code package.
 *
 *  Should you require any further information,
 *  please contact info@Kamphora.com
 */

namespace App\Http\Controllers\EH;

use App\Http\Controllers\Controller;
use App\Models\EH\Configurations\Department;
use App\Models\EH\Employee;
use App\Models\EH\Employee\EmployeePersonnelChange;
use App\Models\EH\GuidelineType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use stock model
use App\Models\Stock\Stock;
use App\Models\Stock\StockSymbol;
// to handle date and time more easily
use Carbon\Carbon;
//crawler
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
Use Sentiment\Analyzer;
use Illuminate\Http\Request;
use App\Models\Auth\UserProfile;
use App\Models\Stock\Holding;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Lang;




class DashboardController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    }

    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        // Get the user ID of the current user
    $uid = $request->user()->id;
    
    // Get the user profile of the current user
    $getUserProfile = UserProfile::select("*")->where([["user_id", $uid]])->first();
    
    // Get the count of holdings for the current user
    $holdingCount = Holding::select("*")->where([["user_id", $uid]])->count();
    
    // Get the symbol to search for in the stock search bar
    $symbolStockSearch = request()->query("symbolStockSearch");
    
    // Get the start date for the stock search
    $stockStartDate = request()->query("stockStartDate");
    
    // Get the end date for the stock search
    $stockEndDate = request()->query("stockEndDate");
    
    // Set the symbol not found message to an empty string
    $symbolNotFound = "";
    
    // Initialize arrays for the stock search results
    $stockSearched = array();
    $stockLineChartLabel = array();
    $stockLineChartData = array();

    // Get the minimum and maximum date values for the stocks
    $minDate = Stock::whereNotNull("Date")->min("Date");
    $maxDate = Stock::whereNotNull("Date")->max("Date");

    //get previous year date from maxDate
    $prevYearDate = Carbon::parse($maxDate)->subYear();

    // Get the change value for the user's holdings
    $getHolding = Holding::where('user_id', $uid)->get();
    $positiveChanges = 0;
    $negativeChanges = 0;

    // Loop through each holding to get the total positive and negative changes
    foreach ($getHolding as $holding)
    {
        if($holding->changes > 0)
        {
            $positiveChanges += $holding->changes;
        }
        else
        {
            $negativeChanges += $holding->changes;
        }
    }

        //if search bar is being used
        if($symbolStockSearch){
            //allow user to input in lowercase
            $symbolStockSearch = strtoupper($symbolStockSearch);
            $url = 'https://www.marketwatch.com/investing/stock/' . $symbolStockSearch;
            //check if user input stock symbol exist
            if (StockSymbol::where('symbol',$symbolStockSearch)->count() > 0) {
            // get $stockLineChartLabel,$stockLineChartData from getStockDb() function
            $stockSearched = $this->getStockDB($symbolStockSearch,$stockStartDate,$stockEndDate);
            }
            else{
                $symbolNotFound = $symbolStockSearch . " is not found";
            }
        }
        else{
        //default chart == "AAPL"
        $stockSearched = $this->getStockDB("AAPL",$prevYearDate,$maxDate);
        $url = 'https://www.marketwatch.com/investing/stock/AAPL';
        }

        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);        
        $contentElements = $crawler->filter('.article__content');
        $contents = [];
        $sentiments = [];
        $hrefLinks=[];
        $counter = 0;
        $max = request()->query('max', 5);
        foreach ($contentElements as $contentElement) {
            if ($counter == $max) {
                break;
            }
            $contentCrawler = new Crawler($contentElement);
            $contents[] = $contentElement->nodeValue;
            $analyzer = new Analyzer(); 
            $sentiment = $analyzer->getSentiment($contentElement->nodeValue);
            $sentiments[] = end($sentiment);
            $anchorCrawler = $contentCrawler->filterXPath('//a[@href]');
            $hrefLinks[] = $anchorCrawler->getNode(0)->getAttribute('href');

            $counter++;
        }
        // $content = implode("\n", $contents);
        // $sentimentString = implode(" ", $sentiments);
        // $escapedString = htmlspecialchars($sentimentString);
    
        $sentimentDict = array_combine($contents, $sentiments);
        // $test = Stock::select("*")->where([["Symbol", 'AAPL']])->get();
        // print($test);
                
        return view('eh.dashboard.index', compact('minDate', 'maxDate', 'max', 'counter', 'symbolStockSearch', 'symbolNotFound', 'stockSearched', 'sentimentDict', 'getUserProfile',
         'holdingCount', 'hrefLinks','positiveChanges','negativeChanges','prevYearDate'));

    }

    
    public function showPE()
{
    return view('eh.dashboard.pe');
}



    // get historical stock data from db
    private function getStockDB($symbolStockSearch,$stockStartDate,$stockEndDate){
        
        //working date between query
        $stockSearched = Stock::select("*")->where([["Symbol", $symbolStockSearch],["Date",">=",date($stockStartDate)],["Date","<=",date($stockEndDate)]])->get();
       
        return $stockSearched;
    }
    
    // clear stocks_holder table
    private function clearStocksHolderTable(){
        DB::table('stocks_holder')->truncate();
    }

}
