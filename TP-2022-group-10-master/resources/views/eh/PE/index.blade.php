<!-- index.blade.php -->
@extends('layouts.adminlte_3.panel_eh')
@section('html_head_style')
@endsection
{{-- Title --}}
@section('Price to Earnings Ratio')
@endsection
{{-- Content --}}
@section('content')
{{-- Body Main Content --}}
@section('body_main_content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card portfolioCards">
                <div class="card-header tradeCardHeader">
                    <h1>Stock Summary Details</h1>
                </div>
                <div class="card-body">
                    <form method="GET" action="">
                        <div class="form-group row mb-3">
                            <label for="symbol" class="col-md-2 col-form-label text-md-end formLabel">Symbol</label>
                            <div class="col-md-6">
                                <input style=" width: 250px;" type="text" class="form-control rounded" id="symbols" name="symbols" value="{{ $symbols }}">
                                <br>
                                <button style="width: 120px;" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                    @php
                    $peRatio = 0;
                    @endphp
                    @foreach($peRatioText as $key => $value)
                        @if($key == 'PE Ratio (TTM)')
                            @php $peRatio = $value; @endphp
                        @endif
                        @if($key == 'Previous Close')
                            @php $previousClose = $value; @endphp
                        @endif
                        @if($key == '1y Target Est')
                            @php $targetEstimate = $value; @endphp
                        @endif
                    @endforeach
                    <div class="alert {{ $previousClose && $targetEstimate ? ($previousClose > $targetEstimate ? 'alert-danger' : 'alert-success') : 'alert-info' }}" role="alert">
                        @if(isset($previousClose) && isset($targetEstimate))
                            @if($previousClose > $targetEstimate)
                                The price is likely to go down SHORT term due to a lower target estimate.
                            @else
                                The price is likely to go up SHORT term due to higher target estimate.
                            @endif
                        @else
                            No data available.
                        @endif
                    </div>

                    <div class="alert {{ $peRatio !== 'N/A' && $peRatio != 0 ? ($peRatio < 20 ? 'alert-success' : 'alert-danger') : 'alert-info' }}" role="alert">
                        @if($peRatio === 'N/A')
                        The Price-to-Earnings Ratio is not applicable for this stock.
                        @elseif($peRatio != 0)
                        @if($peRatio < 20) The stock is likely to go up LONG term due to a Low Price-to-Earnings Ratio. @else The stock is likely to go down LONG term due to a High Price-to-Earnings Ratio. @endif @else No data available. @endif </div>
                            <table id="sentimentAnalysisDT" class="table no-footer table-striped">
                                <thead class="">
                                    <tr role="row">
                                        <th>Summary</th>
                                        <th>Values</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peRatioText as $key => $value)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>
                                            @if($key == 'PE Ratio (TTM)')
                                            <span class="{{ $peRatio < 20 ? 'text-success' : 'text-danger' }}">{{ $peRatio }}</span>
                                            @elseif($key == 'Previous Close' || $key == '1y Target Est')
                                            <span class="{{ $previousClose && $targetEstimate ? ($previousClose > $targetEstimate ? 'text-danger' : 'text-success') : '' }}">{{ $value }}</span>
                                            @else
                                            {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
            @endsection
            @endsection