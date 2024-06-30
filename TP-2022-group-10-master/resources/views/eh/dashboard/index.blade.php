{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/dashboard/index.title_html'))
@section('page_title', __('eh/dashboard/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/dashboard/index.breadcrumb_level_1') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Credits</h3>

                    <p>{{ $getUserProfile->credits }} USD</p>
                </div>
                <div class="icon">
                    <i class="ion ion-card"></i>
                </div>
                <a href="{{ route('eh.trade.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Holdings</sup></h3>

                    <p>{{ $holdingCount }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-briefcase"></i>
                </div>
                <a href="{{ route('eh.trade.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>


        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Gain</h3>

                    <p>{{ $positiveChanges }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-arrow-up-a"></i>
                </div>
                <a href="{{ route('eh.trade.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Loss</h3>

                    <p>{{ $negativeChanges }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-arrow-down-a"></i>
                </div>
                <a href="{{ route('eh.trade.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        {{-- Search Bar start --}}
        <form class="input-group col-lg-10 col-6 p-0" action="{{ url('eh/dashboard') }}" method="GET">
            <label class="m-2" for="stockSearch">Symbol </label>
            <input type="text" class="form-control rounded" placeholder="Look up Symbol" id="symbolStockSearch"
                name="symbolStockSearch" />
            {{-- Search Bar  end --}}

            {{-- Date Picker start --}}
            <label class="m-2" for="stockStartDate">Start Date </label>

            <input id="stockStartDate" type="date" class="form-control @error('stockStartDate') is-invalid @enderror"
                name="stockStartDate" value="{{ old('stockStartDate') }}" required autocomplete="stockStartDate" autofocus>

            @error('stockStartDate')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label class="m-2" for="stockEndDate">End Date </label>
            <input id="stockEndDate" type="date" class="form-control @error('stockEndDate') is-invalid @enderror"
                name="stockEndDate" value="{{ old('stockEndDate') }}" required autocomplete="stockEndDate" autofocus>

            @error('stockEndDate')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            {{-- Date Picker end --}}

            <div class="input-group-append">
                <button type="submit" class="btn btn-outline-primary ml-2">Search</button>
                <button type="submit" class="btn btn-outline-secondary ml-2" onclick="clearSearch()">Clear</button>
            </div>
        </form>

    </div>

    <div class="row">
        <p>{{ $symbolNotFound }}</p>
    </div>


    {{-- Date Picker end --}}

    <div class="row">
        {{-- Stock Line Chart start --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header border-0">
                    @if ($symbolStockSearch != '')
                        <h3 class="card-title">{{ $symbolStockSearch }}</h3>
                    @else
                        <h3 class="card-title">AAPl</h3>
                    @endif


                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="myChart"
                            style="min-height: 320px; height: 320px; max-height: 320px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        {{-- Stock Line Chart end --}}

        <div class="card col-lg-4 ">
            <table id="stockHistoricalDataTable" class="table no-footer table-striped">
                <thead class="">
                    <tr role="row">
                        <th>Date</th>
                        <th>Open</th>
                        <th>High</th>
                        <th>Low</th>
                        <th>Close</th>
                        <th>Adj Close</th>
                        <th>Volume</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($stockSearched as $stockRow)
                        <tr>
                            <td>{{ $stockRow->Date }}</td>
                            <td>{{ $stockRow->Open }}</td>
                            <td>{{ $stockRow->High }}</td>
                            <td>{{ $stockRow->Low }}</td>
                            <td>{{ $stockRow->Close }}</td>
                            <td>{{ $stockRow->AdjClose }}</td>
                            <td>{{ $stockRow->Volume }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
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
            <form method="get" action="{{ url('eh/dashboard') }}">
                <input type="hidden" name="max" value="{{ $max + 5 }}">
                <input type="hidden" name="symbolStockSearch" value="{{ $symbolStockSearch }}">
                <input type="hidden" name="stockStartDate" value="{{ $minDate }}">
                <input type="hidden" name="stockEndDate" value="{{ $maxDate }}">
                <button type="submit" class="w-100">Load More <i class="fas fa-arrow-circle-down"></i></button>
            </form>
        </div>
    </div>

    {{-- Sentiment Analysis End --}}


    <script>
        function clearSearch() {
            document.getElementById('symbolStockSearch').value = 'AAPL';

            var prevYearDate = new Date("{{ $prevYearDate }}");
            var maxDate = new Date("{{ $maxDate }}");
            document.getElementById('stockStartDate').value = formatDate(prevYearDate);
            document.getElementById('stockEndDate').value = formatDate(maxDate);
        }

        function formatDate(date) {
            var year = date.getFullYear();
            var month = (date.getMonth() + 1).toString().padStart(2, '0');
            var day = date.getDate().toString().padStart(2, '0');
            return year + '-' + month + '-' + day;
        }
    </script>

@endsection

@section('control_sidebar')
    @include('eh.dashboard.control_sidebar')
@endsection
{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.dashboard.scripts')
    @include('eh.dashboard.chart')
    @include('eh.employee.index.script_table')
@endpush
