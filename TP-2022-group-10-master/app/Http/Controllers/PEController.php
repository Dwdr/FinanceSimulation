<?php

// PEController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class PEController extends Controller
{
    public function index(Request $request)
{
    $symbols = $request->input('symbols', 'AAPL');
    $client = new Client(HttpClient::create(['timeout' => 60]));
    $crawler = $client->request('GET', 'https://finance.yahoo.com/quote/' . $symbols);

    $peRatios = $crawler->filter('div#quote-summary');

    if ($peRatios->count() > 0) {
        $peRatioText = $peRatios->first()->filter('tr')->each(function (Crawler $node, $i) {
            return [
                $node->filter('td')->eq(0)->text() => $node->filter('td')->eq(1)->text()
            ];
        });
        $peRatioText = call_user_func_array('array_merge', $peRatioText);
    } else {
        $peRatioText = 'N/A';
    }

    return view('eh.PE.index', compact('symbols', 'peRatioText'));
}


}
