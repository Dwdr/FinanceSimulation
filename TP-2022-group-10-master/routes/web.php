<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\Common\FileController;
use App\Http\Controllers\Common\EntryController;
use App\Http\Controllers\EH\DashboardController as EHDashboardController;
use App\Http\Controllers\SSC\DashboardController as SSCDashboardController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\Chart1Controller;
use App\Http\Controllers\ScrapeController;
use App\Http\Controllers\StockScrapeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HistoricalSimController;
use App\Http\Controllers\PEController;
use App\Http\Controllers\HistoryController;

Route::get('/chart',[ChartController::class,'index']);
Route::get('/chart1',[Chart1Controller::class,'index']);

//Route for scraper
Route::get('scraper', [ScrapeController::class, 'scraper'])->name('scraper');
//Route for stock scraper
Route::get('scraper', [ScrapeController::class, 'scraper'])->name('scraper');
Route::get('/stockScraperClear', [StockScrapeController::class, 'clearTempStocksTable'])->name('clear_stocks');
Route::get('/getStockViaApi', [StockScrapeController::class, 'populateStockTable'])->name('populateStockTable');

//register page
Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'registerNewUser'])->name('register.done');

// Forgot Password routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// TODO: Reset Password Forms
// Reset Password routes
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

//Level 0: entry route will get locale from default setting
Route::get('/', function(){
    return redirect('entry-selector');
});

// //stock-history for alphavantage
// Route::get('/history', [HistoryController::class, 'index'])->name('stock-history');


//Level 1: config locale
Route::prefix(LaravelLocalization::setLocale())
    ->group(function(){
        //Level 2.1: no authentication needed
        //Level 2.2: if authenticated and if active = true
        Route::middleware(['auth:user', 'check_user_is_active'])
            ->group(function(){
                //Level 3.1: Common Domain, Single file download
                //Entry selector
                Route::get('entry-selector', [EntryController::class, 'selector'])->name('entry-selector');
                //File Download
                Route::get('files', [FileController::class, 'grab_file'])->name('files');
                //Account Profile
                Route::put('profile/password', [UserController::class, 'updatePassword'])->name('profile.password.update');

                //Level 3.2: SSC domain modules
                Route::name('ssc.')
                    ->prefix('ssc')
                    ->middleware(['check_role_is_user','check_user_permission'])
                    ->group(function (){
                        Route::get('/', [SSCDashboardController::class, 'index']);
                        Route::get('dashboard', [SSCDashboardController::class, 'index'])->name('dashboard.index');
                        Route::get('profile', [UserController::class, 'employee'])->name('profile.index');
                        Route::get('profile/password', [UserController::class, 'password'])->name('profile.password.index');
                    });

                //Level 3.3: EH domain modules
                Route::name('eh.')
                    ->prefix('eh')
                    ->middleware(['check_role_is_admin','check_user_permission'])
                    ->group(function (){
                        //Dashboard
                        Route::get('/', [EHDashboardController::class, 'index']);
                        // //HistoricalChart
                        // Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
                        //Chart
                        Route::get('/chart',[ChartController::class,'index'])->name('chart.index');
                        //PE
                        Route::get('/PE', [PEController::class, 'index'])->name('PE.index');
                        Route::get('dashboard', [EHDashboardController::class, 'index'])->name('dashboard.index');
                        //Trade
                        Route::get('trade', [TradeController::class, 'index'])->name('trade.index');
                        Route::post('trade', [TradeController::class, 'newHolding'])->name('trade.order');
                        Route::post('trade/delete/{id}', [TradeController::class, 'destroy'])->name('trade.destroy');
                        //admin
                        Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
                        Route::post('admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
                        //historical sim
                        Route::get('historical_sim', [HistoricalSimController::class, 'index'])->name('hs.index');
                        Route::post('historical_sim', [HistoricalSimController::class, 'newTransactionHolding'])->name('hs.order');
                        Route::post('historical_sim/delete/{id}', [HistoricalSimController::class, 'destroy'])->name('hs.destroy');
                    });
            });

        //Level 2.3: authentication
        Route::name('auth.')
            ->prefix('auth')
            ->group(function () {
                Auth::routes();
            });
    });