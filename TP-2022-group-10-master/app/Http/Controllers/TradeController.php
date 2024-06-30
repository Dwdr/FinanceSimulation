<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock\Holding;
use App\Models\Stock\StockSymbol;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use GuzzleHttp\Client;
use App\Models\Auth\UserProfile;
use App\Models\EH\Employee;

class TradeController extends Controller
{
    public function index(Request $request){

    // Set options for the Guzzle client used to create the API client
    $options = [
        'timeout' => 3.14,
        'headers' => ['User-Agent' => $_SERVER['HTTP_USER_AGENT']],
        'delay' => 1,
    ];

    // Create the Guzzle client and the API client
    $guzzleClient = new Client($options);
    $client = ApiClientFactory::createApiClient($guzzleClient);

    // Get the user ID of the currently logged in user
    $uid = $request->user()->id;

    // Get the holdings, user profile, and employee data for the user
    $getHolding = Holding::select("*")->where([["user_id", $uid]])->get();
    $getUserProfile = UserProfile::select("*")->where([["user_id", $uid]])->first();
    $getEmployee = Employee::select("*")->where([["user_id", $uid]])->first();

    #update total_value and changes upon index page refresh

    // Update the total value and changes for each holding
    foreach($getHolding as $holding){
        // Get the holding symbol, quantity, and total order value
        $holdingSymbol = $holding->symbol;
        $holdingQuantity = $holding->quantity;
        $holdingTotalOrderValue = $holding->total_order_value;

        // Get the current quote for the holding symbol
        $quote = $client->getQuote($holdingSymbol);
        $currentValue = $quote->getregularMarketPrice();
        
        // Calculate the new total value and change amount for the holding
        $holdingNewTotalValue = $currentValue * $holdingQuantity;
        $holdingTotalValue = $holding->total_value;
        $changeAmount = $this->round2dp($holdingTotalValue - $holdingTotalOrderValue) ;

        // Update the holding with the new total value and change amount
        Holding::where([['symbol',$holdingSymbol],['user_id',$uid],['quantity',$holdingQuantity]])->update([
            "total_value" => $holdingNewTotalValue,
            'changes' => $changeAmount,
        ]);   
    }

    // Render the trade index page with the updated data
    return view("eh.trade.index" , compact("getHolding","getUserProfile","getEmployee"));
}

   public function newHolding(Request $request){

    // Get the stock symbol selected by the user and set API request options
    $selectedSymbol = strtoupper(request('symbol'));
    $options = [
        'timeout' => 3.14,
        'headers' => ['User-Agent' => $_SERVER['HTTP_USER_AGENT']],
        'delay' => 1,
    ];

    // Create a new instance of the API client and get the user's profile
    $guzzleClient = new Client($options);
    $client = ApiClientFactory::createApiClient($guzzleClient);
    $uid = $request->user()->id;
    $getUserProfile = UserProfile::select("*")->where([["user_id", $uid]])->first();

    // Check if user input stock symbol exists
    if (StockSymbol::where('symbol', $selectedSymbol)->count() <= 0) {
        return redirect()->route('eh.trade.index')->withErrors(['symbol' => 'Invalid symbol']);
    }

    // Use Yahoo Finance API to get current market value of stock
    $quote = $client->getQuote($selectedSymbol);
    $currentValue = $quote->getregularMarketPrice();
    $quantity = request('quantity');
    $totalValue = $quantity * $currentValue;
    $userId = $request->user()->id;
    $newCredits = ($getUserProfile->credits) - $totalValue;
    $currentUserCredits = $getUserProfile->credits;
    
    // Check if user has enough credits
    if ($currentUserCredits < $totalValue) {
        return redirect()->route('eh.trade.index')->withErrors(['symbol' => 'Insufficient Credits']);
    }

    // Check if already holding order stock (create when does not exist, update when it does)
    if ((Holding::where([['symbol',$selectedSymbol],['user_id',$userId]])->count() <= 0) 
        || (Holding::where([['symbol',$selectedSymbol],['user_id',$userId],['order_value',$currentValue]])->doesntExist())) {
        $holding = Holding::create([
            'user_id' => $userId,
            'symbol' => $selectedSymbol,
            'quantity' => $quantity,
            "order_value" => $currentValue,
            'total_order_value' => $currentValue * $quantity,
            "total_value" => $totalValue,
            'changes' => "+ 0",
        ]);
    } else {
        $selectedStockHolding = Holding::where([['symbol',$selectedSymbol],['user_id',$userId]])->first();
        // Sum of existing values and new values
        $quantity = (int)$quantity +  (int)$selectedStockHolding["quantity"];
        $totalValue = (double)$totalValue + (double)$selectedStockHolding["total_value"];
        // Update existing values
        (Holding::where([['symbol',$selectedSymbol],['user_id',$userId]]))->update([
            'user_id' => $userId,
            'symbol' => $selectedSymbol,
            'quantity' => $quantity,
            "order_value" => $currentValue,
            'total_order_value' => $currentValue * $quantity,
            "total_value" => $totalValue,
            'changes' => "+ 0",
        ]);
    }

    // Update the user's credits
    UserProfile::where([["user_id", $uid]])->update([
        'credits' => $newCredits,
    ]);

    // Redirect the user back to the trade index page with a success
    return redirect()->route('eh.trade.index')->with('message','success!');
}

    #delete specific row in datatable
public function destroy(Request $request,$id){
    # Get the user ID
    $uid = $request->user()->id;
    $deleteHolding = Holding::findOrFail($id);
    $sellingValue = $deleteHolding->total_value;
    $getUserProfile = UserProfile::select("*")->where([["user_id", $uid]])->first();

    $currentUserCredits =  $getUserProfile->credits;

    # Delete the holding
    $deleteHolding->delete();

    # Update the user's credits
    UserProfile::where([["user_id", $uid]])->update([
                    'credits' => $currentUserCredits + $sellingValue,
            ]);

    # Redirect back to the trade index page with a success message
    return redirect()->route('eh.trade.index')->with('success', 'Stock sold successfully!');
}   

# Round a number to 2 decimal places
public function round2dp($number){
    return number_format((float)$number, 2, '.', '');
}
}
