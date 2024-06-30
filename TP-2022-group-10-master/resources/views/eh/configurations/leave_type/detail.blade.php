{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
    <style>
        .form-control-sm {
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            border: 1px solid #ced4da;
        }

        [class*=icheck-] > input:first-child:disabled + input[type=hidden] + label, [class*=icheck-] > input:first-child:disabled + input[type=hidden] + label::before, [class*=icheck-] > input:first-child:disabled + label, [class*=icheck-] > input:first-child:disabled + label::before {
            opacity: 1 !important;
        }
    </style>

@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/leave_type/detail.title_html'))
@section('page_title', __('eh/configurations/leave_type/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/leave_type/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/leave_type/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a
            href="{{ route('eh.configurations.leave_type.index') }}">{{ __('eh/configurations/leave_type/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/leave_type/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $lt->name }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/leave_type/detail.breadcrumb_edit') }}</li>
        @else
            <li class="breadcrumb-item active">{{ $lt->name }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.leave_type.detail_panel')
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
          action="@if(!$mode['isModeEdit']){{route('eh.configurations.leave_type.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.leave_type.update', $lt->id)}}@endif"
          method="post">
        @if($mode['isModeEdit'])
            {{method_field('put')}}
        @endif

        <div class="card">
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/configurations/leave_type/detail.lb_name')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->name ?? ''}}"
                    name="name"
                    required="true"
                />

                <x-inputs.text
                    :label="__('eh/configurations/leave_type/detail.lb_code')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->code ?? ''}}"
                    name="code"
                    required="true"
                />

{{--                <x-inputs.select2--}}
{{--                    :label="__('eh/configurations/leave_type/detail.lb_type')"--}}
{{--                    :isReadonly="$mode['isModeShow']"--}}
{{--                    name="type"--}}
{{--                    required="true"--}}
{{--                >--}}
{{--                    @foreach(config('constants.LEAVE_TYPE.TYPE') as $key => $value)--}}
{{--                        <option--}}
{{--                            value="{{ $value }}"--}}
{{--                            @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])--}}
{{--                            @if($value==$lt->type)--}}
{{--                            selected="selected"--}}
{{--                            @endif--}}
{{--                            @endif--}}
{{--                        >{{ __('eh/configurations/leave_type/detail.config_constants_LEAVE_TYPE_TYPE_'.$key) }}</option>--}}
{{--                    @endforeach--}}
{{--                </x-inputs.select2>--}}

                <x-inputs.text
                    :label="__('eh/configurations/leave_type/detail.lb_title_template')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->title_template ?? ''}}"
                    name="title_template"
                />

{{--                <x-inputs.textarea--}}
{{--                    :label="__('eh/configurations/leave_type/detail.lb_content_template')"--}}
{{--                    :isReadonly="$mode['isModeShow']"--}}
{{--                    value="{{$lt->content_template ?? ''}}"--}}
{{--                    name="content_template"--}}
{{--                />--}}

                {{--                <x-inputs.select2--}}
                {{--                    :label="__('eh/configurations/leave_type/detail.lb_min_unit')"--}}
                {{--                    :isReadonly="$mode['isModeShow']"--}}
                {{--                    name="min_unit"--}}
                {{--                    required="true"--}}
                {{--                >--}}
                {{--                    @foreach(config('constants.LEAVE_TYPE.MIN_UNIT') as $key => $value)--}}
                {{--                        <option--}}
                {{--                            value="{{ $value }}"--}}
                {{--                            @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])--}}
                {{--                            @if($value===$lt->min_unit)--}}
                {{--                            selected="selected"--}}
                {{--                            @endif--}}
                {{--                            @endif--}}
                {{--                        >{{ __('eh/configurations/leave_type/detail.config_constants_LEAVE_TYPE_MIN_UNIT_'.$key) }}</option>--}}
                {{--                    @endforeach--}}
                {{--                </x-inputs.select2>--}}

                <x-inputs.radio
                    :label="__('eh/configurations/leave_type/detail.lb_duration_calculation_type')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->duration_calculation_type ?? ''}}"
                    name="duration_calculation_type"
                    lang="eh/configurations/leave_type/detail"
                    :option="config('constants.LEAVE_TYPE.DURATION_CALCULATION_TYPE')"
                    required="true"
                />

                <x-inputs.text
                    type="number"
                    :label="__('eh/configurations/leave_type/detail.lb_setting_join_date_allow_application')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->configurations['join_date_allow_application'] ?? 0}}"
                    name="setting_join_date_allow_application"
                    required="true"
                    min="0"
                    step="1"
                />

                <x-inputs.radio
                    :label="__('eh/configurations/leave_type/detail.lb_visible_range_type')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->visible_range_type ?? ''}}"
                    lang="eh/configurations/leave_type/detail"
                    name="visible_range_type"
                    :option="config('constants.LEAVE_TYPE.VISIBLE_RANGE_TYPE')"
                    required="true"
                />

                <x-inputs.select2
                    label=""
                    :isReadonly="$mode['isModeShow']"
                    name="visible_range_type_id[]"
                    multiple="true"
                    hidden="{{$mode['isModeCreate'] || (!$mode['isModeCreate'] && $lt->visible_range_type == 1)}}"
                >
                    @if($mode['isModeShow'])

                        @if(sizeof($lt->visibleUser)+sizeof($lt->visibleDepartment)+sizeof($lt->visibleDesignation)+sizeof($lt->visibleEmployeeType)>0)
                            @foreach($lt->visibleUser as $vu)
                                <span class="badge bg-info">{{$vu->employee->first_name.' '.$vu->employee->last_name}}</span>
                            @endforeach
                            @foreach($lt->visibleDepartment as $vdp)
                                <span class="badge bg-info">{{$vdp->name}}</span>
                            @endforeach
                            @foreach($lt->visibleDesignation as $vds)
                                <span class="badge bg-info">{{$vds->name}}</span>
                            @endforeach
                            @foreach($lt->visibleEmployeeType as $vet)
                                <span class="badge bg-info">{{$vet->name}}</span>
                            @endforeach
                        @else
                            -
                        @endif

                    @else

                        @if(sizeof($employees)>0)
                            <optgroup label="Employees">
                                @foreach($employees as $e)
                                    <option
                                        value="user_{{ $e->user->id }}"
                                        @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                        @foreach($lt->visibleUser as $vu)
                                        @if($e->user->id===$vu->id)
                                        selected="selected"
                                        @endif
                                        @endforeach
                                        @endif
                                    >{{ $e->first_name.' '.$e->last_name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(sizeof($departments)>0)
                            <optgroup label="Departments">
                                @foreach($departments as $dp)
                                    <option
                                        value="department_{{ $dp->id }}"
                                        @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                        @foreach($lt->visibleDepartment as $vdp)
                                        @if($dp->id===$vdp->id)
                                        selected="selected"
                                        @endif
                                        @endforeach
                                        @endif
                                    >{{ $dp->name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(sizeof($designations)>0)
                            <optgroup label="Designations">
                                @foreach($designations as $ds)
                                    <option
                                        value="designation_{{ $ds->id }}"
                                        @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                        @foreach($lt->visibleDesignation as $vds)
                                        @if($ds->id===$vds->id)
                                        selected="selected"
                                        @endif
                                        @endforeach
                                        @endif
                                    >{{ $ds->name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(sizeof($employee_types)>0)
                            <optgroup label="Employee Types">
                                @foreach($employee_types as $et)
                                    <option
                                        value="employee_type_{{ $et->id }}"
                                        @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                        @foreach($lt->visibleEmployeeType as $vet)
                                        @if($et->id===$vet->id)
                                        selected="selected"
                                        @endif
                                        @endforeach
                                        @endif
                                    >{{ $et->name }}</option>
                                @endforeach
                            </optgroup>
                        @endif

                    @endif
                </x-inputs.select2>

                <x-inputs.radio
                    :label="__('eh/configurations/leave_type/detail.lb_approval_flow_type')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->approval_flow_type ?? ''}}"
                    lang="eh/configurations/leave_type/detail"
                    name="approval_flow_type"
                    :option="config('constants.LEAVE_TYPE.APPROVAL_FLOW_TYPE')"
                    required="true"
                />

                <x-inputs.select2
                    :label="__('eh/configurations/leave_type/detail.lb_default_reviewers')"
                    :isReadonly="$mode['isModeShow']"
                    name="default_reviewers_id[]"
                    value="TODO"
                    multiple="true"
                >

                    @if($mode['isModeShow'])
                        @if(sizeof($lt->reviewer)>0)
                            @foreach($lt->reviewer as $vu)
                                <span class="badge bg-primary">{{$vu->employee->first_name.' '.$vu->employee->last_name}}</span>
                            @endforeach
                        @else
                            -
                        @endif
                    @else
                        @if(sizeof($employees)>0)
                            <optgroup label="Employees">
                                @foreach($employees as $e)
                                    <option
                                        value="user_{{ $e->user->id }}"
                                        @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                        @foreach($lt->reviewer as $vu)
                                        @if($e->user->id===$vu->id)
                                        selected="selected"
                                        @endif
                                        @endforeach
                                        @endif
                                    >{{ $e->first_name.' '.$e->last_name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                    @endif

                </x-inputs.select2>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                {{__('eh/configurations/leave_type/detail.card_header_config')}}
            </div>
            <div class="card-body">

{{--                @if(!$mode['isModeShow'])--}}
{{--                    <i><p id="config_description">{{__('eh/configurations/leave_type/detail.p_config_description_please_choose_leave_type')}}</p>--}}
{{--                    </i>--}}
{{--                @endif--}}

{{--                <div id="leave_type_config_box" class="d-none">--}}

{{--                    <x-inputs.text--}}
{{--                        type="number"--}}
{{--                        :label="__('eh/configurations/leave_type/detail.lb_setting_default_max_balance')"--}}
{{--                        :isReadonly="$mode['isModeShow']"--}}
{{--                        value="{{$lt->configurations['default_max_balance'] ?? '20'}}"--}}
{{--                        name="setting_default_max_balance"--}}
{{--                        required="true"--}}
{{--                        min="0"--}}
{{--                        step="1"--}}
{{--                    />--}}

{{--                    <x-inputs.select2--}}
{{--                        :label="__('eh/configurations/leave_type/detail.lb_setting_billing_cycle')"--}}
{{--                        :isReadonly="$mode['isModeShow']"--}}
{{--                        name="setting_billing_cycle"--}}
{{--                        required="true"--}}
{{--                    >--}}
{{--                        @foreach(config('constants.LEAVE_TYPE.BILLING_CYCLE') as $key => $value)--}}
{{--                            <option--}}
{{--                                value="{{ $value }}"--}}
{{--                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])--}}
{{--                                @if($value==($lt->configurations['billing_cycle']??config('constants.LEAVE_TYPE.BILLING_CYCLE.NOT_APPLICABLE')))--}}
{{--                                selected="selected"--}}
{{--                                @endif--}}
{{--                                @endif--}}
{{--                            >{{ __('eh/configurations/leave_type/detail.config_constants_LEAVE_TYPE_BILLING_CYCLE_'.$key) }}</option>--}}
{{--                        @endforeach--}}
{{--                    </x-inputs.select2>--}}

{{--                    <div id="billing_cycle_box" class="d-none">--}}

{{--                        <x-inputs.radio--}}
{{--                            :label="__('eh/configurations/leave_type/detail.lb_setting_cycle_start_day')"--}}
{{--                            :isReadonly="$mode['isModeShow']"--}}
{{--                            value="{{$lt->configurations['cycle_start_day'] ?? ''}}"--}}
{{--                            name="setting_cycle_start_day"--}}
{{--                            lang="eh/configurations/leave_type/detail"--}}
{{--                            :option="config('constants.LEAVE_TYPE.CYCLE_START_DAY')"--}}
{{--                            required="true"--}}
{{--                        />--}}

{{--                        <x-inputs.radio--}}
{{--                            :label="__('eh/configurations/leave_type/detail.lb_setting_cycle_cal_day')"--}}
{{--                            :isReadonly="$mode['isModeShow']"--}}
{{--                            value="{{$lt->configurations['cycle_cal_day'] ?? ''}}"--}}
{{--                            name="setting_cycle_cal_day"--}}
{{--                            lang="eh/configurations/leave_type/detail"--}}
{{--                            :option="config('constants.LEAVE_TYPE.CYCLE_CAL_DAY')"--}}
{{--                            required="true"--}}
{{--                        />--}}

{{--                        <div class="form-group">--}}
{{--                            <label class="form-control-label">{{__('eh/configurations/leave_type/detail.lb_setting_cycle_add_label')}}</label>--}}
{{--                            <br/>--}}
{{--                            <label for="setting_cycle_add_each"--}}
{{--                                   class="font-weight-normal">{{__('eh/configurations/leave_type/detail.lb_setting_cycle_add_each')}}</label>--}}
{{--                            @if(!$mode['isModeShow'])--}}
{{--                                <input class="form-control-sm" style="width: 45px;padding-left:10px;"--}}
{{--                                       type="number" min="0" step="1"--}}
{{--                                       name="setting_cycle_add_each" id="setting_cycle_add_each"--}}
{{--                                       value="{{$lt->configurations['cycle_add_each'] ?? 0}}"--}}
{{--                                       required--}}
{{--                                />--}}
{{--                            @else--}}
{{--                                <span class="badge badge-info" style="font-size: 1em">{{$lt->configurations['cycle_add_each'] ?? 0}}</span>--}}
{{--                            @endif--}}
{{--                            <label for="setting_cycle_add_day"--}}
{{--                                   class="font-weight-normal">{{__('eh/configurations/leave_type/detail.lb_setting_cycle_add')}}</label>--}}
{{--                            @if(!$mode['isModeShow'])--}}
{{--                                <input class="form-control-sm" style="width: 45px;padding-left:10px;"--}}
{{--                                       type="number" min="0" step="1"--}}
{{--                                       name="setting_cycle_add_day" id="setting_cycle_add_day"--}}
{{--                                       value="{{$lt->configurations['cycle_add_day'] ?? 0}}"--}}
{{--                                       required--}}
{{--                                />--}}
{{--                            @else--}}
{{--                                <span class="badge badge-info" style="font-size: 1em">{{$lt->configurations['cycle_add_day'] ?? 0}}</span>--}}
{{--                            @endif--}}
{{--                            <span>{{__('eh/configurations/leave_type/detail.lb_setting_cycle_add_day')}}</span>--}}
{{--                        </div>--}}

{{--                        <x-inputs.text--}}
{{--                            type="number"--}}
{{--                            :label="__('eh/configurations/leave_type/detail.lb_setting_cycle_add_max')"--}}
{{--                            :isReadonly="$mode['isModeShow']"--}}
{{--                            value="{{$lt->configurations['cycle_add_max'] ?? '0'}}"--}}
{{--                            name="setting_cycle_add_max"--}}
{{--                            required="true"--}}
{{--                            min="0"--}}
{{--                            step="1"--}}
{{--                            :hints="__('eh/configurations/leave_type/detail.lb_setting_cycle_add_max_hints')"--}}
{{--                        />--}}

{{--                        <x-inputs.text--}}
{{--                            type="number"--}}
{{--                            :label="__('eh/configurations/leave_type/detail.lb_setting_cycle_keep_balance')"--}}
{{--                            :isReadonly="$mode['isModeShow']"--}}
{{--                            value="{{$lt->configurations['cycle_keep_balance'] ?? '0'}}"--}}
{{--                            name="setting_cycle_keep_balance"--}}
{{--                            required="true"--}}
{{--                            min="0"--}}
{{--                            step="1"--}}
{{--                            :hints="__('eh/configurations/leave_type/detail.lb_setting_cycle_keep_balance_hints')"--}}
{{--                        />--}}

{{--                    </div>--}}

{{--                    <x-inputs.switch2--}}
{{--                        label="{{ __('eh/configurations/leave_type/detail.lb_is_leave_paid') }}"--}}
{{--                        :isReadonly="$mode['isModeShow']"--}}
{{--                        value="{{$lt->is_leave_paid ?? false}}"--}}
{{--                        name="is_leave_paid"--}}
{{--                        onText="{{ __('eh/configurations/leave_type/detail.select_option_yes') }}"--}}
{{--                        offText="{{ __('eh/configurations/leave_type/detail.select_option_no') }}"--}}
{{--                    />--}}

{{--                </div>--}}

                <x-inputs.switch2
                    label="{{ __('eh/configurations/leave_type/detail.lb_is_nwd') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->is_nwd ?? false}}"
                    name="is_nwd"
                    onText="{{ __('eh/configurations/leave_type/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/leave_type/detail.select_option_no') }}"
                />
                <x-inputs.switch2
                    label="{{ __('eh/configurations/leave_type/detail.lb_is_adj') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->is_adj ?? false}}"
                    name="is_adj"
                    onText="{{ __('eh/configurations/leave_type/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/leave_type/detail.select_option_no') }}"
                />
                <x-inputs.switch2
                    label="{{ __('eh/configurations/leave_type/detail.lb_is_rse') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->is_rse ?? false}}"
                    name="is_rse"
                    onText="{{ __('eh/configurations/leave_type/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/leave_type/detail.select_option_no') }}"
                />
                <x-inputs.text
                    type="number"
                    :label="__('eh/configurations/leave_type/detail.lb_percentage')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->percentage ?? 0}}"
                    name="percentage"
                    required="true"
                    min="0"
                />

                <x-inputs.switch2
                    label="{{ __('eh/configurations/leave_type/detail.lb_is_show_payroll') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->is_show_payroll ?? false}}"
                    name="is_show_payroll"
                    onText="{{ __('eh/configurations/leave_type/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/leave_type/detail.select_option_no') }}"
                />

                <hr>

                <x-inputs.checkbox
                    :label="__('eh/configurations/leave_type/detail.lb_setting_allow_over_max_leave_limit')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->configurations['allow_over_max_leave_limit'] ?? false}}"
                    name="setting_allow_over_max_leave_limit"
                />

                <x-inputs.checkbox
                    :label="__('eh/configurations/leave_type/detail.lb_setting_allow_select_reviewers')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->configurations['allow_select_reviewers'] ?? true}}"
                    name="setting_allow_select_reviewers"
                />

                <x-inputs.checkbox
                    :label="__('eh/configurations/leave_type/detail.lb_setting_request_notify_reviewers')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->configurations['request_notify_reviewers'] ?? true}}"
                    name="setting_request_notify_reviewers"
                />

                <x-inputs.checkbox
                    :label="__('eh/configurations/leave_type/detail.lb_setting_approval_notify_reviewers')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->configurations['approval_notify_reviewers'] ?? true}}"
                    name="setting_approval_notify_reviewers"
                />

                <x-inputs.switch2
                    label="{{ __('eh/configurations/leave_type/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$lt->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/configurations/leave_type/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/leave_type/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$lt->updated_at" :createdAt="$lt->created_at"/>
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.leave_type.detail_panel')
                </div>
            @endif
        </div>


    </form>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    <script>
        $().ready(function () {
            $("input[type=radio][name='visible_range_type']").change(function () {
                if (this.value == '1') {
                    $('#select2_visible_range_type_id').addClass('d-none')
                } else if (this.value == '2') {
                    $('#select2_visible_range_type_id').removeClass('d-none')
                }
            });

            {{--$('#id_type').on('select2:select', function (e) {--}}
            {{--    if ($('#id_type').val() == {{config('constants.LEAVE_TYPE.TYPE.GENERAL')}}) {--}}
            {{--        $('#leave_type_config_box').removeClass('d-none');--}}
            {{--        $('#config_description').html("{{__('eh/configurations/leave_type/detail.p_config_description_general')}}")--}}
            {{--    } else if ($('#id_type').val() == {{config('constants.LEAVE_TYPE.TYPE.ANNUAL_LEAVE')}}) {--}}
            {{--        $('#leave_type_config_box').addClass('d-none');--}}
            {{--        $('#config_description').html("{{__('eh/configurations/leave_type/detail.p_config_description_annual_leave')}}")--}}
            {{--    } else if ($('#id_type').val() == {{config('constants.LEAVE_TYPE.TYPE.PAID_SICK_LEAVE')}}) {--}}
            {{--        $('#leave_type_config_box').addClass('d-none');--}}
            {{--        $('#config_description').html("{{__('eh/configurations/leave_type/detail.p_config_description_paid_sick_leave')}}")--}}
            {{--    }--}}
            {{--});--}}

            {{--$('#id_setting_billing_cycle').on('select2:select', function (e) {--}}
            {{--    if ($('#id_setting_billing_cycle').val() != {{config('constants.LEAVE_TYPE.BILLING_CYCLE.NOT_APPLICABLE')}}) {--}}
            {{--        $('#billing_cycle_box').removeClass('d-none');--}}
            {{--    } else {--}}
            {{--        $('#billing_cycle_box').addClass('d-none');--}}
            {{--    }--}}
            {{--});--}}

{{--            @if(!$mode['isModeCreate'])--}}
            {{--let leave_type = {{$lt->type}};--}}
            {{--let billing_cycle = {{$lt->configurations['billing_cycle']??config('constants.LEAVE_TYPE.BILLING_CYCLE.NOT_APPLICABLE')}};--}}


            {{--if (leave_type == {{config('constants.LEAVE_TYPE.TYPE.GENERAL')}}) {--}}
            {{--    $('#leave_type_config_box').removeClass('d-none');--}}
            {{--    $('#config_description').html("{{__('eh/configurations/leave_type/detail.p_config_description_general')}}")--}}
            {{--} else if (leave_type == {{config('constants.LEAVE_TYPE.TYPE.ANNUAL_LEAVE')}}) {--}}
            {{--    $('#leave_type_config_box').addClass('d-none');--}}
            {{--    $('#config_description').html("{{__('eh/configurations/leave_type/detail.p_config_description_annual_leave')}}")--}}
            {{--} else if (leave_type == {{config('constants.LEAVE_TYPE.TYPE.PAID_SICK_LEAVE')}}) {--}}
            {{--    $('#leave_type_config_box').addClass('d-none');--}}
            {{--    $('#config_description').html("{{__('eh/configurations/leave_type/detail.p_config_description_paid_sick_leave')}}")--}}
            {{--}--}}

            {{--if (billing_cycle != {{config('constants.LEAVE_TYPE.BILLING_CYCLE.NOT_APPLICABLE')}}) {--}}
            {{--    $('#billing_cycle_box').removeClass('d-none');--}}
            {{--} else {--}}
            {{--    $('#billing_cycle_box').addClass('d-none');--}}
            {{--}--}}
{{--            @endif--}}

        })
    </script>
@endpush
