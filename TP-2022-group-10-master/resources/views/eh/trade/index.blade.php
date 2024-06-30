@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('Trade Tracker And Portfolio'))
@section('page_title', __('Trade Tracker And Portfolio'))

{{-- Body Main Content --}}

@section('body_main_content')
    <div class="row">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>Username</h3>
                    <p>{{ $getEmployee->first_name }}
                        {{ $getEmployee->last_name }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>Credits Value:</h3>
                    <p>{{ $getUserProfile->credits }} USD</p>
                </div>
                <div class="icon">
                    <i class="ion ion-card"></i>
                </div>
            </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>Number of holdings:</h3>
                    <p>{{ $getHolding->count() }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-briefcase"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Form Start --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card portfolioCards">
                <div class="card-header tradeCardHeader">
                    <h1>Trade</h1>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('eh.trade.order') }}" class="tradeFormBody">
                        {{ csrf_field() }}

                        {{-- Input with FormControl For Symbols --}}
                        <div class="form-group row mb-3">
                            <label for="symbol" class="col-md-4 col-form-label text-md-end formLabel">Symbol</label>
                            <div class="col-md-6">
                                <input id="symbol" type="text"
                                    class="form-control @error('symbol') is-invalid @enderror" name="symbol"
                                    value="{{ old('symbol') }}" required autocomplete="symbol" autofocus>

                                @error('symbol')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Input with FormControl For Quantity --}}
                        <div class="form-group row mb-3">
                            <label for="quantity" class="col-md-4 col-form-label text-md-end formLabel">Quantity</label>
                            <div class="col-md-6">
                                <input id="quantity" type="number"
                                    class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                    value="{{ old('quantity') }}" required autocomplete="quantity" autofocus>
                                    <button type="submit" class="btn btn-success btn-lg">Order</button>
                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Form End --}}

    {{-- Holding Data Table Start --}}
    <div class="row">
        <div class="card col-lg-12 ">
            <div class="card">
                <div class="card-header tradeCardHeader">
                    <h1>Holdings</h1>
                </div>
                <table id="dataTable" class="table no-footer table-striped">
                    <thead class="">
                        <tr role="row">
                            <th>Symbol</th>
                            <th>Quantity</th>
                            <th>Order Value</th>
                            <th>Total Order Value</th>
                            <th>Total Value</th>
                            <th>Changes</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($getHolding as $holdingRow)
                            <tr>
                                <td>{{ $holdingRow->symbol }}</td>
                                <td>{{ $holdingRow->quantity }}</td>
                                <td>{{ $holdingRow->order_value }}</td>
                                <td>{{ $holdingRow->total_order_value }}</td>
                                <td>{{ $holdingRow->total_value }}</td>
                                {{-- Depict changes in different color based on its value --}}
                                @if ($holdingRow->changes < 0)
                                    <td style="color:red">{{ $holdingRow->changes }}</td>
                                @else
                                    <td style="color:green"> + {{ $holdingRow->changes }}</td>
                                @endif
                                {{-- POST method to SELL stock based on it's id --}}
                                <td>
                                    <form action="{{ route('eh.trade.destroy', $holdingRow->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        {{-- Toggle Sales Confirmation Modal onClick --}}
                                        <a href="#" class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal{{ $holdingRow->id }}">SELL</a>
                                    </form>
                                </td>
                            </tr>

                            {{-- Sales Confirmation Modal Start --}}
                            <div class="modal fade" id="deleteModal{{ $holdingRow->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Sales</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        {{-- POST method to SELL stock based on it's id --}}
                                        <form action="{{ route('eh.trade.destroy', ['id' => $holdingRow->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('POST')
                                            <div class="modal-body">
                                                Are you sure you want to sell this Stock?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Sell</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Sales Confirmation Modal End --}}
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        {{-- Holding Data Table End --}}
    @endsection

    @section('control_sidebar')
        @include('eh.dashboard.control_sidebar')
    @endsection
    {{-- Body End Scripts --}}
    @push('body_end_scripts')
        @include('eh.dashboard.scripts')
        @include('eh.employee.index.script_table')
    @endpush
