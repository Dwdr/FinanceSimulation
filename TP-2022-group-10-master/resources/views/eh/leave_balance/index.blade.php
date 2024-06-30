{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
    <style>
        th, td { white-space: nowrap; }
        div.dataTables_wrapper {
            margin: 0 auto;
        }

        div.container {
            width: 80%;
        }
    </style>
@endsection

{{-- Title --}}
@section('html_title', __('eh/leave_balance/index.title_html'))
@section('page_title', __('eh/leave_balance/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/leave_balance/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/leave_balance/index.breadcrumb_level_2') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/leave_balance/index.th_employee_id') }}</th>
                    <th>{{ __('eh/leave_balance/index.th_employee') }}</th>
                    @foreach($lt as $t)
                        <th>{{ $t->name }}</th>
                    @endforeach
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/leave_balance/index.th_employee_id') }}</th>
                    <th>{{ __('eh/leave_balance/index.th_employee') }}</th>
                    @foreach($lt as $t)
                        <th>{{ $t->name }}</th>
                    @endforeach
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($employees as $e)
                    <tr>
                        <td>
                            <a href="{{ route('eh.leave_balance.show',$e->uuid) }}">
                                {{ $e->employee_id }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.leave_balance.show',$e->uuid) }}">
                                {{ $e->first_name }} {{ $e->last_name }}
                            </a>
                        </td>
                        @foreach($lt as $t)
                            @php
                                $max = $employee_lb[$e->uuid][$t->id][0]->max_balance??$t->default_balance;
                                $using = $employee_lb[$e->uuid][$t->id][0]->using_balance??0;
                                $adjustment = $employee_lb[$e->uuid][$t->id][0]->adjustment??0;
                            @endphp
                            <th>
                                {{($max-$using+$adjustment)<0?0:($max-$using+$adjustment)}}
                            </th>
                        @endforeach
                        <td>
                            @can(config("constants.PERMISSION.EH-EMPLOYEE-U"))
                                <a href="{{ route('eh.leave_balance.edit',$e->uuid) }}"><i class="fas fa-edit"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.leave_balance.index.script_table')
@endpush
