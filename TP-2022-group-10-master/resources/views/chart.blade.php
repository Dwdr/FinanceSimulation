@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('Live Stock Data'))
@section('page_title', __('Live Stock Data'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/dashboard/index.breadcrumb_level_1') }}</li>
@endsection



{{-- Body Main Content --}}
@section('body_main_content')

    <div class="row mb-2">
        {{-- Search Bar start --}}
        <form class="input-group col-lg-3 col-6 p-0" action="{{ route('eh.chart.index') }}" method="GET">
            <label class="m-2" for="stockSearch">Symbol </label>
            <input style=" width: 250px;" type="text" class="form-control rounded" placeholder="Look up Symbol" id="symbolStockSearch"
                name="symbolStockSearch" />

            {{-- Search Bar  end --}}
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </form>
    </div>

    <div class="row">
        <p>{{ $symbolNotFound }}</p>
    </div>

    

    <div class="tradingview-widget-container col-12">
    <div id="tradingview_d6dc8"></div>
    <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/NASDAQ-AAPL/" rel="noopener"
            target="_blank"><span class="blue-text"> {{ $symbolStockSearch != '' ? '' . $symbolStockSearch : 'AAPL' }}</div>
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <script type="text/javascript">
        const events = {!! json_encode($events) !!};
        new TradingView.widget({
            "width": "100%",
            "symbol": "{{ $symbolStockSearch != '' ? 'NASDAQ:' . $symbolStockSearch : 'NASDAQ:AAPL' }}",
            "interval": "D",
            "timezone": "ET",
            "theme": "dark",
            "style": "1",
            "locale": "en",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "withdateranges": true,
            "allow_symbol_change": true,
            "details": true,
            "withdateranges": true,
            "news":true,
            "container_id": "tradingview_d6dc8",
            // "studies": [
            //     "Moving Average@tv-basicstudies",
            //     "MACD@tv-basicstudies"
            // ],
            "events": events.map(event => ({
                time: event.time * 1000, // Convert to milliseconds
                text: `Sentiment: ${event.sentiment.toFixed(2)}\n${event.headline}`,
                label: event.sentiment > 0 ? 'B' : 'S',
                labelColor: event.sentiment > 0 ? 'rgba(0, 255, 0, 0.8)' : 'rgba(255, 0, 0, 0.8)',
                minSize: 14,
            })),
        });
    </script>
</div>



    {{-- TradingView Widget END --}}
<div class="row">
    <div class="col-4 pl-0">
        <!-- TradingView Widget 1 BEGIN -->
        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/NASDAQ-AAPL/" rel="noopener" target="_blank"><span class="blue-text"></span></a> </div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-profile.js" async>
        {
        "width": "100%",
        "height": "480",
        "colorTheme": "dark",
        "isTransparent": false,
        "symbol": "{{ $symbolStockSearch != '' ? 'NASDAQ:' . $symbolStockSearch : 'NASDAQ:AAPL' }}",
        "locale": "en"
        }
        </script>
        </div>
<!-- TradingView Widget END -->
        <!-- TradingView Widget 1 END -->
    </div>
    <div class="col-4 pl-0">
        <!-- TradingView Widget 2 BEGIN -->
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <div class="tradingview-widget-copyright">
                <a href="https://www.tradingview.com/symbols/NASDAQ-AAPL/financials-overview/" rel="noopener" target="_blank">
                    <span class="blue-text"></span>
                </a>
            </div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-financials.js" async>
            {
            "colorTheme": "dark",
            "isTransparent": false,
            "largeChartUrl": "",
            "displayMode": "regular",
            "width": "100%",
            "height": "480",
            "symbol": "{{ $symbolStockSearch != '' ? 'NASDAQ:' . $symbolStockSearch : 'NASDAQ:AAPL' }}",
            "locale": "en"
            }
            </script>
        </div>
        <!-- TradingView Widget 2 END -->
    </div>
    <div class="col-4 pl-0">
        <!-- TradingView Widget 3 -->
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <div class="tradingview-widget-heading">   
            </div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-events.js" async>
            {
            "colorTheme": "dark",
            "isTransparent": false,
            "width": "100%",
            "height": "448",
            "locale": "en",
            "importanceFilter": "-1,0,1",
            "currencyFilter": "USD"
            }
            </script>
        </div>
    </div>
</div>
</div>

{{-- Sentiment Analysis start --}}
    <div class="row">
        <div class="card col-lg-12 ">
            <table id="sentimentAnalysisDT" class="table no-footer table-striped">

                <thead class="">
                    <tr role="row">
                        <th>News</th>
                        <th>Sentiment</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($sentimentDict as $sentimentDictKey => $sentimentDictValue)
                        <tr>
                            <td>
                                @if ($sentimentDictValue < 0)
                                    <a style="color:red" href="{{ $hrefLinks[$loop->index] }}" target="_blank"
                                        onclick="this.style.color = 'darkblue';">{{ $sentimentDictKey }}</a>
                                @else
                                    <a style="color:green" href="{{ $hrefLinks[$loop->index] }}" target="_blank"
                                        onclick="this.style.color = 'darkblue';">{{ $sentimentDictKey }}</a>
                                @endif

                            </td>
                            @if ($sentimentDictValue < 0)
                                <td style="color:red">{{ $sentimentDictValue }}</td>
                            @else
                                <td style="color:green">{{ $sentimentDictValue }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <form method="get" action="{{ url('eh/chart') }}">
                <input type="hidden" name="max" value="{{ $max + 5 }}">
                <input type="hidden" name="symbolStockSearch" value="{{ $symbolStockSearch }}">
                <input type="hidden" name="stockStartDate" value="{{ $minDate }}">
                <input type="hidden" name="stockEndDate" value="{{ $maxDate }}">
                <button type="submit" class="w-100">Load More <i class="fas fa-arrow-circle-down"></i></button>
            </form>
        </div>
    </div>

    {{-- Sentiment Analysis End --}}



@endsection

@section('control_sidebar')
    @include('eh.dashboard.control_sidebar')
@endsection
{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.dashboard.scripts')
    @include('eh.employee.index.script_table')
@endpush
