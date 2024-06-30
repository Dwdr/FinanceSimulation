<?php

namespace App\Http\EH\Controllers;

use Illuminate\Http\Request;
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
use App\Models\Auth\UserProfile;
use App\Models\Stock\Holding;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Lang;


class ChartController extends Controller
{
    public function index(){
        return view("chart");
    }
}

