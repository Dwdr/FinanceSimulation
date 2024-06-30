<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Stock\HistoricalTransaction;
use App\Models\Stock\Stock;
use App\Models\Stock\StockSymbol;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client;

class HistoricalSimController extends Controller
{
     public function index(Request $request){

    // Get user ID
    $uid = $request->user()->id;

    // Get user's historical transactions
    $getHistoricalTransaction = HistoricalTransaction::select("*")->where([["user_id", $uid]])->get();

    // Set options for Guzzle HTTP client
    $options = [
        'timeout' => 3.14,
        'headers' => ['User-Agent' => $_SERVER['HTTP_USER_AGENT']],
        'delay' => 1,
    ];

    // Create a new Guzzle HTTP client and API client
    $guzzleClient = new Client($options);
    $client = ApiClientFactory::createApiClient($guzzleClient);

    // Update total_value and changes for each historical transaction
    foreach($getHistoricalTransaction as $ht){
        $htSymbol = $ht->symbol;
        $htQuantity = $ht->quantity;
        $htTotalOrderValue = $ht->total_order_value;

        // Get current stock price for the symbol
        $quote = $client->getQuote($htSymbol);
        $currentValue = $quote->getregularMarketPrice();
        $htNewTotalValue = $currentValue * $htQuantity;

        // Calculate changes in value for the transaction
        $htTotalValue = $ht->total_value;
        $changeAmount = $this->round2dp($htTotalValue - $htTotalOrderValue);

        // Update the historical transaction in the database
        HistoricalTransaction::where([
            ['symbol',$htSymbol],
            ['user_id',$uid],
            ['quantity',$htQuantity]
        ])->update([
            "total_value" => $htNewTotalValue,
            'changes' => $changeAmount,
        ]);
    }

    // Get the minimum and maximum date values of stocks
    $minDate = Stock::whereNotNull("Date")->min("Date");
    $maxDate = Stock::whereNotNull("Date")->max("Date");

    // Get all available dates for stocks
    $availableDates = Stock::pluck('Date')->toArray();

    // Return the view with relevant data
    return view("eh.historicalSim.index", compact("getHistoricalTransaction","minDate","maxDate","availableDates"));
}

public function newTransactionHolding(Request $request){

    //get user input values
    $selectedSymbol = strtoupper(request('symbol'));
    $quantity = request('quantity');

    $availableDates = Stock::pluck('Date')->toArray();

    $transactionDate = $request->validate([
        'transactionDate' => [
            'required',
            'date',
            Rule::in($availableDates)
        ]
    ])['transactionDate'];

    // Check if user input stock symbol exists
    if (StockSymbol::where('symbol', $selectedSymbol)->count() <= 0) {
        return redirect()->route('eh.trade.index')->withErrors(['symbol' => 'Invalid symbol']);
    }

    $transactionDate = Carbon::createFromFormat('Y-m-d', $transactionDate)->format('Y-m-d');

    //get current userId
    $uid = $request->user()->id;
    //get adjclose value based on user input date and symbol
    $quote = Stock::select('AdjClose')->where([['Date',$transactionDate],['Symbol',$selectedSymbol]])->first()->AdjClose;
    $quote = $this->round2dp((float)$quote);

    // order values calculation
    $totalValue = $quantity * $quote;
    $userId = $uid;

    // check if already holding order stock (create when does not exist, update when it does)
    if ((HistoricalTransaction::where([['symbol',$selectedSymbol],['user_id',$userId]])->count() <= 0) 
    || (HistoricalTransaction::where([['symbol',$selectedSymbol],['user_id',$userId],['order_value',$quote],['transaction_date',$transactionDate]])->doesntExist())){
        $historicalTransaction = HistoricalTransaction::create([
        'user_id' => $userId,
        'symbol' => $selectedSymbol,
        'quantity' => $quantity,
        "order_value" => $quote,
        'total_order_value' => $totalValue,
        "total_value" => $totalValue,
        'changes' => "+ 0",
        'transaction_date' => $transactionDate,
        ]);
    }
    // order stock already exist
    else{
        $selectedStockHolding = HistoricalTransaction::where([['symbol',$selectedSymbol],['user_id',$userId]])->first();
        // sum of existing values and new values
        $quantity = (int)$quantity +  (int)$selectedStockHolding["quantity"];
        $totalValue = (double)$totalValue + (double)$selectedStockHolding["total_value"];
        // update existing values
        (HistoricalTransaction::where([['symbol',$selectedSymbol],['user_id',$userId]]))->update([
            'user_id' => $userId,
            'symbol' => $selectedSymbol,
            'quantity' => $quantity,
            "order_value" => $quote,
            'total_order_value' => $totalValue,
            "total_value" => $totalValue,
            'changes' => "+ 0",
            'transaction_date' => $transactionDate,
        ]);
    }

    return redirect()->route('eh.hs.index')->with('message', 'success!')->with('refresh', true);
}

    // sell hitorical stock
    public function destroy(Request $request,$id){

        //get user input transaction date
        $transactionDate = $request->input('transactionDate');

         //get current userId
        $uid = $request->user()->id;

        // current stock that is being sold
        $item = HistoricalTransaction::findOrFail($id);
        $itemSymbol = ($item->symbol);
        $itemOrderValue = ($item->total_order_value);
        $itemQuantity = ($item->quantity);

        // print($transactionDate);
        $stockAtSellingDate = Stock::where([['symbol',$itemSymbol],['Date',$transactionDate]])->first();
        $stockAtSellingDatePrice = $stockAtSellingDate->AdjClose;

        //potential lost or gain
        $potentialChanges =  ($stockAtSellingDatePrice*$itemQuantity) - $itemOrderValue;
        // print($potentialChanges);
        $item->delete();
        

        return redirect()->back()->with('potentialChanges', $potentialChanges);

    }


    public function round2dp($number){
        return number_format((float)$number, 2, '.', '');
    }
}
