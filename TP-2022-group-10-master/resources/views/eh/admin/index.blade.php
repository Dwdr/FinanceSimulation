@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('Admin page'))
@section('page_title', __('Admin page'))

{{-- Body Main Content --}}

@section('body_main_content')

    <form method="GET" action="{{ route('populateStockTable') }}">
        @csrf
        <button type="submit" class="btn btn-xxl btn-secondary m-3">Pull Stock Latest Data</button>
    </form>
    <div>

        <div class="row">
            <div class="card col-lg-12 ">
                <div class="card">
                    <div class="card-header tradeCardHeader">
                        <h1>Reset User Credits</h1>
                    </div>
                    <table id="dataTable" class="table no-footer table-striped">
                        <thead class="">
                            <tr role="row">
                                <th>User Id</th>
                                <th>Name</th>
                                <th>Credits</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($usernameAndCredits as $eachUser)
                                <tr>
                                    <td>{{ $eachUser->user_id }}</td>
                                    <td>{{ $eachUser->first_name }}</td>
                                    <td>{{ $eachUser->credits }}</td>

                                    {{--  --}}
                                    <td>
                                        <form action="{{ route('eh.admin.destroy', $eachUser->user_id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            {{-- <button type="submit" class="btn btn-danger"
                                            onclick="showConfirmSell()">SELL</button> --}}

                                            <a href="#" class="btn btn-danger" data-toggle="modal"
                                                data-target="#deleteModal{{ $eachUser->user_id }}">RESET</a>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal{{ $eachUser->user_id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Confirm RESET</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('eh.admin.destroy', ['id' => $eachUser->user_id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <div class="modal-body">
                                                    Are you sure you want to Reset credit of this user?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Reset</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('control_sidebar')
    @include('eh.dashboard.control_sidebar')
@endsection
{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.dashboard.scripts')
    @include('eh.employee.index.script_table')
@endpush
