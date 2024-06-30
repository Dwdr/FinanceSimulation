@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('Historical Simulator'))
@section('page_title', __('Historical Simulator'))

{{-- Body Main Content --}}

@section('body_main_content')

{{-- Modal for sale changes Start --}}
<div class="modal" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Trade Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modal-message"></p>
            </div>
        </div>
    </div>
</div>
{{-- Modal for sale changes Start --}}

{{-- Order Form Start --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card portfolioCards">
            <div class="card-header tradeCardHeader">
                <h1>Historical Transaction Simulator</h1>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('eh.hs.order') }}" class="tradeFormBody">
                    {{ csrf_field() }}

                    {{-- Input with FormControl For Symbols --}}
                    <div class="row mb-3">
                        <label for="symbol" class="col-md-4 col-form-label text-md-end formLabel">Symbol</label>

                        <div class="col-md-6">
                            <input id="symbol" type="text" class="form-control @error('symbol') is-invalid @enderror" name="symbol" value="{{ old('symbol') }}" required autocomplete="symbol" autofocus>

                            @error('symbol')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Input with FormControl For Quantity --}}
                    <div class="row mb-3">
                        <label for="quantity" class="col-md-4 col-form-label text-md-end formLabel">Quantity</label>

                        <div class="col-md-6">
                            <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" required autocomplete="quantity" autofocus>

                            @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Input with FormControl For Transaction Date --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end formLabel" for="transactionDate">Transaction
                            Date</label>
                        <div class="col-md-6">
                            <input id="transactionDate" type="date" class="form-control @error('transactionDate') is-invalid @enderror" name="transactionDate" value="{{ old('transactionDate') }}" required autocomplete="transactionDate" autofocus>
                            <button type="submit" class="btn btn-success btn-lg">
                                Order
                            </button>
                            @error('transactionDate')
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

{{-- Historical Holdings Data Table Start --}}
<div class="row">
    <div class="card col-lg-12 ">
        <div class="card">
            <div class="card-header tradeCardHeader">
                <h1>Historical Holdings</h1>
            </div>
            <table id="dataTable" class="table no-footer table-striped">
                <thead class="">
                    <tr role="row">
                        <th>Symbol</th>
                        <th>Transaction Date</th>
                        <th>Quantity</th>
                        <th>Order Value</th>
                        <th>Total Order Value</th>
                        <th>Total Value</th>
                        <th>Changes</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($getHistoricalTransaction as $htRow)
                    <tr>
                        <td>{{ $htRow->symbol }}</td>
                        <td>{{ $htRow->transaction_date }}</td>
                        <td>{{ $htRow->quantity }}</td>
                        <td>{{ $htRow->order_value }}</td>
                        <td>{{ $htRow->total_order_value }}</td>
                        <td>{{ $htRow->total_value }}</td>
                        @if ($htRow->changes < 0) <td style="color:red">{{ $htRow->changes }}</td>
                            @else
                            <td style="color:green"> + {{ $htRow->changes }}</td>
                            @endif

                            <td>
                                <form action="{{ route('eh.hs.destroy', $htRow->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    {{-- <button type="submit" class="btn btn-danger"
                                            onclick="showConfirmSell()">SELL</button> --}}

                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $htRow->id }}">Sell</a>
                                </form>
                            </td>
                    </tr>

                    {{-- Sales Confirmation Modal Start --}}
                    <div class="modal fade" id="deleteModal{{ $htRow->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Sales</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('eh.hs.destroy', ['id' => $htRow->id]) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-body">
                                        Are you sure you want to sell this Stock?
                                        <div class="row mb-3">
                                            <label class="col-md-4 col-form-label text-md-end" for="transactionDate">Input Transaction Date</label>
                                            <div class="col-md-6">
                                                <input id="transactionDate" type="date" class="form-control @error('transactionDate') is-invalid @enderror" name="transactionDate" value="{{ old('transactionDate') }}" required autocomplete="transactionDate" autofocus max='{{ $maxDate }}' min='{{ $minDate }}'>
                                                @error('transactionDate')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Sell</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Sales Confirmation Modal Start --}}
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
    {{-- Historical Holdings Data Table Start --}}

    {{-- script to run second modal to show $potential changes --}}

    <script>
        //refresh page twice
        @if(session('refresh'))
        setTimeout(() => {
            location.reload();
        }, 1000);
        setTimeout(() => {
            location.reload();
        }, 1000);
        @endif

        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // Get the message element
        var message = document.getElementById("modal-message");

        // Get the potentialChanges value from the session
        var potentialChanges = "{{ session('potentialChanges') }}";

        // If the potentialChanges value is not empty, display the modal with the message
        if (potentialChanges != "") {
            if (potentialChanges < 0) {
                message.innerHTML = "Potential Loss: " + potentialChanges;
                modal.style.display = "block";
            } else if (potentialChanges > 0) {
                message.innerHTML = "Potential Gain: " + potentialChanges;
                modal.style.display = "block";
            }
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>


    @endsection

    @section('control_sidebar')
    @include('eh.dashboard.control_sidebar')
    @endsection
    {{-- Body End Scripts --}}
    @push('body_end_scripts')
    @include('eh.dashboard.scripts')
    @include('eh.employee.index.script_table')
    @endpush