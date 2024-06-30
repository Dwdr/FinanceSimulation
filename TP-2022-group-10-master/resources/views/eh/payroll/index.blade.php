{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/payroll/index.title_html'))
@section('page_title', __('eh/payroll/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/payroll/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/payroll/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/payroll/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-PAYROLL-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.payroll.index.panel')
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="btn-group">
                    <a href="{{route('eh.payroll.index').'?year='.($year).'&month='.$month.'&s=0'}}" class="btn @if($status==0) btn-success @else btn-light border @endif">ALL</a>
                    <a href="{{route('eh.payroll.index').'?year='.($year).'&month='.$month.'&s='.config('constants.PAYROLL.STATUS.PENDING')}}" class="btn @if($status==config('constants.PAYROLL.STATUS.PENDING')) btn-success @else btn-light border @endif">Pending</a>
                    <a href="{{route('eh.payroll.index').'?year='.($year).'&month='.$month.'&s='.config('constants.PAYROLL.STATUS.CONFIRMED')}}" class="btn @if($status==config('constants.PAYROLL.STATUS.CONFIRMED')) btn-success @else btn-light border @endif">Confirmed</a>
                </div>
            </div>
        </div>

    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">

            @include('eh.payroll.index_pagination_month')

            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/payroll/index.th_datetime') }}</th>
                    <th>{{ __('eh/payroll/index.th_period') }}</th>
                    <th>{{ __('eh/payroll/index.th_employee') }}</th>
                    <th>{{ __('eh/payroll/index.th_status') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/payroll/index.th_datetime') }}</th>
                    <th>{{ __('eh/payroll/index.th_period') }}</th>
                    <th>{{ __('eh/payroll/index.th_employee') }}</th>
                    <th>{{ __('eh/payroll/index.th_status') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($payrolls as $p)
                    <tr>
                        <td>
                            <a href="{{ route('eh.payroll.show',$p->uuid) }}">
                                {{date('Y-m-d',strtotime($p->created_at))}}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.payroll.show',$p->uuid) }}">
                                {{ $p->generator['s3_period_start'] .' - '.$p->generator['s3_period_end'] }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.payroll.show',$p->uuid) }}">
                                {{ $p->employee->first_name .' '.$p->employee->last_name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.payroll.show',$p->uuid) }}">
                                @switch($p->status)
                                    @case(config('constants.PAYROLL.STATUS.PENDING'))
                                    <span class="badge bg-secondary">Pending</span>
                                    @break
                                    @case(config('constants.PAYROLL.STATUS.CONFIRMED'))
                                    <span class="badge bg-success">Confirmed</span>
                                    @break

                                @endswitch
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-PAYROLL-U"))
                                <a href="{{ route('eh.payroll.edit',$p->uuid) }}"><i class="fas fa-edit"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('control_sidebar')
    @include('eh.payroll.control_sidebar')
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.payroll.index.script_table')
@endpush
