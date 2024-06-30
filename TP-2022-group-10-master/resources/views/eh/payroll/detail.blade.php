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
                            <strong>{{__('eh/payroll/detail.lb_monthly_pay_slip')}}</strong><br>
                            {{__('eh/payroll/detail.lb_employee_name')}}: {{$p->employee->first_name .' '.$p->employee->last_name}}<br>
                            {{__('eh/payroll/detail.lb_hkid')}}: {{$p->employee->hkid??'N/A'}}<br>
                            {{__('eh/payroll/detail.lb_staff_id')}}: {{$p->employee->hkid??'N/A'}}<br>
                            {{__('eh/payroll/detail.lb_department')}}: {{$p->employee->department->name??'N/A'}}<br>
                            {{__('eh/payroll/detail.lb_designation')}}: {{$p->employee->designation->name??'N/A'}}<br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <b>{{__('eh/payroll/detail.lb_payroll_period')}}: {{$p->generator['s3_period_start']}} - {{$p->generator['s3_period_end']}}</b><br>
                        <b>{{__('eh/payroll/detail.lb_print_date')}}: </b>{{date('Y-m-d',strtotime($p->created_at))}}<br>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                {{-- Form --}}
                {{-- TODO JL change to livewire--}}
                <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
                      action="{{route('eh.payroll.update', $p->uuid)}}"
                      method="post">
                    {{method_field('put')}}
                    @csrf

                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th colspan="2">{{__('eh/payroll/detail.lb_payroll_calculation')}}</th>
                                    <th>{{__('eh/payroll/detail.lb_adjustment')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{__('eh/payroll/detail.lb_basic_salary')}}</td>
                                    <td style="text-align: right;">${{number_format($p->generator['basic']['total_basic'],2)}}</td>
                                    <td>
                                        <x-inputs.text
                                            label=""
                                            type="number"
                                            name="adjustment[basic][total_basic]"
                                            :value="$p->adjustment['basic']['total_basic']??''"
                                            placeholder="New value"
                                            step="0.01"
                                        />
                                    </td>
                                </tr>
                                {{--                                <tr>--}}
                                {{--                                    <td>Total Salary (i dont think we need this row)</td>--}}
                                {{--                                    <td style="text-align: right;">${{number_format($p->generator['basic']['total_basic'],2)}}</td>--}}
                                {{--                                    <td></td>--}}
                                {{--                                </tr>--}}
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
                                    <th>{{__('eh/payroll/detail.lb_leave_calculation')}}</th>
                                    <th>{{__('eh/payroll/detail.lb_deduction')}}</th>
                                    <th>{{__('eh/payroll/detail.lb_adjustment')}}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(sizeof($p->generator['leave']['selected_array'])>0)
                                    @foreach($p->generator['leave']['selected_array'] as $l)
                                        <tr>
                                            <td>{{$l['leave']->title}}</td>
                                            <td>{{number_format(($l['is_nwd']+$l['is_adj']+$l['is_rse']),2)}}</td>
                                            <td>
                                                <x-inputs.text
                                                    label=""
                                                    type="number"
                                                    name="adjustment[leave][{{$l['leave']->uuid}}]"
                                                    :value="$p->adjustment['leave'][$l['leave']->uuid]??''"
                                                    placeholder="New value"
                                                    step="0.01"
                                                />
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">-</td>
                                    </tr>
                                @endif
                                {{--                                <tr>--}}
                                {{--                                    <td>Total Leave</td>--}}
                                {{--                                    <td style="text-align: right;">${{number_format($p->generator['leave']['total_leave'],2)}}</td>--}}
                                {{--                                    <td></td>--}}
                                {{--                                </tr>--}}
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
                                    <th>{{__('eh/payroll/detail.lb_holiday_calculation')}}</th>
                                    <th>{{__('eh/payroll/detail.lb_deduction')}}</th>
                                    <th>{{__('eh/payroll/detail.lb_adjustment')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(sizeof($p->generator['holiday']['selected_array'])>0)
                                    @foreach($p->generator['holiday']['selected_array'] as $h)
                                        <tr>
                                            <td>{{$h['holiday']->title}}</td>
                                            <td>{{number_format(($h['is_nwd']+$h['is_adj']+$h['is_rse']),2)}}</td>
                                            <td>
                                                <x-inputs.text
                                                    label=""
                                                    type="number"
                                                    name="adjustment[holiday][{{$h['holiday']->id}}]"
                                                    :value="$p->adjustment['holiday'][$h['holiday']->id]??''"
                                                    placeholder="New value"
                                                    step="0.01"
                                                />
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">-</td>
                                    </tr>
                                @endif
                                {{--                                <tr>--}}
                                {{--                                    <td>Total Holiday</td>--}}
                                {{--                                    <td style="text-align: right;">${{number_format($p->generator['holiday']['total_holiday'],2)}}</td>--}}
                                {{--                                    <td></td>--}}
                                {{--                                </tr>--}}
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
                                    <th colspan="2">{{__('eh/payroll/detail.lb_other_adjustment')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--                                TODO only one other item--}}
                                {{--                                @foreach($p->adjustment['other'] as $o)--}}
                                <tr>
                                    <td>
                                        <x-inputs.text
                                            label=""
                                            type="text"
                                            name="adjustment[other][{{0}}][title]"
                                            :value="$p->adjustment['other'][0]['title']??''"
                                            placeholder="New item"
                                        />
                                    </td>
                                    <td>
                                        <x-inputs.text
                                            label=""
                                            type="number"
                                            name="adjustment[other][{{0}}][value]"
                                            :value="$p->adjustment['other'][0]['value']??''"
                                            placeholder="New value"
                                            step="0.01"
                                        />
                                    </td>
                                </tr>
                                {{--                                @endforeach--}}
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
                                    <th colspan="5">{{__('eh/payroll/detail.lb_mpf_calculation')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{__('eh/payroll/detail.lb_employer_contribution')}}</td>
                                    <td>{{__('eh/payroll/detail.lb_adjustment')}}</td>
                                    <td>{{__('eh/payroll/detail.lb_employee_contribution')}}</td>
                                    <td>{{__('eh/payroll/detail.lb_adjustment')}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('eh/payroll/detail.lb_mandatory')}} ${{number_format($p->generator['mpf']['mpf_employer_compulsory'],2)}}</td>
                                    <td>
                                        <x-inputs.text
                                            label=""
                                            type="number"
                                            name="adjustment[mpf][employer_mandatory]"
                                            :value="$p->adjustment['mpf']['employer_mandatory']??''"
                                            placeholder="New value"
                                            step="0.01"
                                        />
                                    </td>
                                    <td>{{__('eh/payroll/detail.lb_mandatory')}} ${{number_format($p->generator['mpf']['mpf_employee_compulsory'],2)}}</td>
                                    <td>
                                        <x-inputs.text
                                            label=""
                                            type="number"
                                            name="adjustment[mpf][employee_mandatory]"
                                            :value="$p->adjustment['mpf']['employee_mandatory']??''"
                                            placeholder="New value"
                                            step="0.01"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('eh/payroll/detail.lb_voluntary')}} ${{number_format($p->generator['mpf']['mpf_employer_voluntary'],2)}}</td>
                                    <td>
                                        <x-inputs.text
                                            label=""
                                            type="number"
                                            name="adjustment[mpf][employer_voluntary]"
                                            :value="$p->adjustment['mpf']['employer_voluntary']??''"
                                            placeholder="New value"
                                            step="0.01"
                                        />
                                    </td>
                                    <td>{{__('eh/payroll/detail.lb_voluntary')}} ${{number_format($p->generator['mpf']['mpf_employee_voluntary'],2)}}</td>
                                    <td>
                                        <x-inputs.text
                                            label=""
                                            type="number"
                                            name="adjustment[mpf][employee_voluntary]"
                                            :value="$p->adjustment['mpf']['employee_voluntary']??''"
                                            placeholder="New value"
                                            step="0.01"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">{{__('eh/payroll/detail.lb_total')}}
                                        ${{number_format(($p->generator['mpf']['mpf_employee_compulsory']+$p->generator['mpf']['mpf_employee_voluntary']),2)}}</td>
                                    <td colspan="2">{{__('eh/payroll/detail.lb_total')}}
                                        ${{number_format(($p->generator['mpf']['mpf_employer_compulsory']+$p->generator['mpf']['mpf_employer_voluntary']),2)}}</td>
                                    {{--                                    <td style="text-align: right;">-(Employee Mandatory + Employee Voluntary)</td>--}}
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
                                    <th>{{__('eh/payroll/detail.lb_net_pay_to_employee')}}</th>
                                    <th style="text-align: right;">${{number_format($p->generator['grand_total'],2)}}</th>
                                    @if(isset($p->adjustment['grand_total']))
                                        <th style="text-align: right;">${{number_format($p->adjustment['grand_total'],2)}}</th>
                                    @endif
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <a href="{{route('eh.payroll.print',$p->uuid)}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                            <button type="submit" class="btn btn-success float-right" style="margin-right: 5px;">Save Adjustment</button>
                            <a href="{{route('eh.payroll.confirm',$p->uuid)}}" class="btn btn-success float-right" style="margin-right: 5px;">Confirm Payroll</a>
                            <a href="#" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-download"></i> Generate PDF
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.invoice -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('control_sidebar')
    @include('eh.payroll.control_sidebar')
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
