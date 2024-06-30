{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/payroll/detail.title_html'))
@section('page_title', __('eh/payroll/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/payroll/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('eh.payroll.index') }}">{{ __('eh/payroll/detail.breadcrumb_level_2') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/payroll/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $p->uuid }} {{ $p->uuid }}</li>
            <li class="breadcrumb-item active">{{ __('eh/payroll/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    <div class="row">
        <div class="col-12">

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h4>
                            {{$p->organization->name??''}}
                        </h4>
                        <p>{{$p->organization->default['address']??''}}</p>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <strong>Monthly Pay Slip</strong><br>
                            Employee name: {{$p->employee->first_name .' '.$p->employee->last_name}}<br>
                            HKID: {{$p->employee->hkid??'N/A'}}<br>
                            Staff ID: {{$p->employee->hkid??'N/A'}}<br>
                            Department: {{$p->employee->department->name??'N/A'}}<br>
                            Designation: {{$p->employee->designation->name??'N/A'}}<br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <b>Payroll Period: {{$p->generator['s3_period_start']}} - {{$p->generator['s3_period_end']}}</b><br>
                        <b>Print date:</b> {{date('Y-m-d',strtotime($p->created_at))}}<br>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="2">Payroll Calculation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Basic Salary</td>
                                <td style="text-align: right;">${{number_format($p->generator['basic']['total_basic'],2)}}</td>
                            </tr>
                            <tr>
                                <td>Adjustment</td>
                                <td style="text-align: right;">${{number_format($p->adjustment['basic']['total_basic'],2)}}</td>
                            </tr>
                            <tr>
                                <td>Total Salary</td>
                                <td style="text-align: right;">${{number_format(($p->generator['basic']['total_basic']+$p->adjustment['basic']['total_basic']),2)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="2">Leave Calculation</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($p->generator['leave']['selected_array'] as $l)
                                <tr>
                                    <td>{{$l->title}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>Total Leave</td>
                                <td style="text-align: right;">${{number_format($p->generator['leave']['total_leave'],2)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>


                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="2">Holiday Calculation</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($p->generator['holiday']['selected_array'] as $h)
                                <tr>
                                    <td>{{$h->title}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>Total Holiday</td>
                                <td style="text-align: right;">${{number_format($p->generator['holiday']['total_holiday'],2)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>


                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="5">MPF Calculation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Employee Contribution</td>
                                <td>Employer Contribution</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Mandatory ${{number_format($p->generator['mpf']['mpf_employee_compulsory'],2)}}</td>
                                <td>Mandatory ${{number_format($p->generator['mpf']['mpf_employer_compulsory'],2)}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Voluntary ${{number_format($p->generator['mpf']['mpf_employee_voluntary'],2)}}</td>
                                <td>Voluntary ${{number_format($p->generator['mpf']['mpf_employer_voluntary'],2)}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Total ${{number_format(($p->generator['mpf']['mpf_employee_compulsory']+$p->generator['mpf']['mpf_employee_voluntary']),2)}}</td>
                                <td>Total ${{number_format(($p->generator['mpf']['mpf_employer_compulsory']+$p->generator['mpf']['mpf_employer_voluntary']),2)}}</td>
                                <td style="text-align: right;">Some figures here (dont know what is it)</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Net Pat To Employee (HKD)</th>
                                <th style="text-align: right;">${{number_format($p->generator['grand_total'],2)}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-12">
                        <a href="{{route('eh.payroll.print','demo')}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                            Payment
                        </button>
                        <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generate PDF
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.invoice -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('control_sidebar')
    @include('eh.mpf.control_sidebar')
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
