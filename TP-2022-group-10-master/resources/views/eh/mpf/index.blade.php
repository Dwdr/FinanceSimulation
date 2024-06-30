{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/mpf/index.title_html'))
@section('page_title', __('eh/mpf/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/mpf/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/mpf/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/mpf/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{--    @can(config("constants.PERMISSION.EH-PAYROLL-C"))--}}
    {{--        <div class="card">--}}
    {{--            <div class="card-body">--}}
    {{--                @include('eh.mpf.index_panel')--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    @endcan--}}

    {{-- Table --}}
    <div class="card">
        <div class="card-body">

            @include('eh.mpf.index_pagination_month')

            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{__('eh/mpf/index.th_employee')}}</th>
                    <th>{{ __('eh/mpf/index.th_period') }}</th>
                    <th>{{__('eh/mpf/index.th_company_compulsory')}}</th>
                    <th>{{__('eh/mpf/index.th_company_voluntary')}}</th>
                    <th>{{__('eh/mpf/index.th_staff_compulsory')}}</th>
                    <th>{{__('eh/mpf/index.th_staff_voluntary')}}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{__('eh/mpf/index.th_employee')}}</th>
                    <th>{{ __('eh/mpf/index.th_period') }}</th>
                    <th>{{__('eh/mpf/index.th_company_compulsory')}}</th>
                    <th>{{__('eh/mpf/index.th_company_voluntary')}}</th>
                    <th>{{__('eh/mpf/index.th_staff_compulsory')}}</th>
                    <th>{{__('eh/mpf/index.th_staff_voluntary')}}</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($payrolls as $p)
                    <tr>
                        <td>
                            <a href="{{ route('eh.payroll.show',$p->uuid) }}">
                                {{ $p->employee->first_name .' '.$p->employee->last_name }}
                            </a>
                        </td>
                        <td>
                            {{ $p->generator['s3_period_start'] .' - '.$p->generator['s3_period_end'] }}
                        </td>
                        <td>
                            $ {{number_format($p->generator['mpf']['mpf_employer_compulsory'],2)}}
                        </td>
                        <td>
                            $ {{number_format($p->generator['mpf']['mpf_employer_voluntary'],2)}}
                        </td>
                        <td>
                            $ {{number_format($p->generator['mpf']['mpf_employee_compulsory'],2)}}
                        </td>
                        <td>
                            $ {{number_format($p->generator['mpf']['mpf_employee_voluntary'],2)}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('control_sidebar')
    @include('eh.mpf.control_sidebar')
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.mpf.index_script_table')
@endpush
