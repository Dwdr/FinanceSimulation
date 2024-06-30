{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_held_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/leave_application/detail.title_html'))
@section('page_title', __('eh/leave_application/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/leave_application/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active"><a href="{{route('eh.leave_application.index')}}">{{ __('eh/leave_application/detail.breadcrumb_level_2') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/leave_application/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $la->title }}</li>
            <li class="breadcrumb-item active">{{ __('eh/leave_application/detail.breadcrumb_edit') }}</li>
        @else
            <li class="breadcrumb-item active">{{ $la->title }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.leave_application.detail.panel')
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
          action="@if(!$mode['isModeEdit']){{route('eh.leave_application.store')}}@elseif($mode['isModeEdit']){{route('eh.leave_application.update', $la->uuid)}}@endif"
          method="post">
        @if($mode['isModeEdit'])
            {{method_field('put')}}
        @endif
        <div class="card">
            <div class="card-body">
                @hasanyrole(config('constants.ROLE.ADMIN').'|'.config('constants.ROLE.SUPER_ADMIN'))
                    @if(!$mode['isModeCreate'])
                        <x-inputs.text
                            :label="__('eh/leave_application/detail.lb_applicant_id')"
                            :isReadonly="true"
                            value="{{$la->employee->first_name.' '.$la->employee->last_name ?? ''}}"
                            name="employee_name"
                            required="true"
                        />
                        <x-inputs.text
                            type="hidden"
                            :value="$la->employee_uuid"
                            name="employee_uuid"
                        />
                    @else
                        <x-inputs.select2
                            :label="__('eh/leave_application/detail.lb_applicant_id')"
                            :isReadonly="!$mode['isModeCreate']"
                            name="employee_uuid"
                            value="{{isset($la->employee)?$la->employee->first_name.' '.$la->employee->last_name:''}}"
                            required="true"
                        >
                            @foreach($employees as $e)
                                <option
                                    value="{{ $e->uuid }}"
                                    @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                    @if($e->uuid===$la->employee_uuid)
                                    selected="selected"
                                    @endif
                                    @endif
                                >{{ $e->first_name.' '.$e->last_name }}</option>
                            @endforeach
                        </x-inputs.select2>
                    @endif
                @else
                    <x-inputs.text
                        type="hidden"
                        :value="Auth::user()->employee->uuid"
                        name="employee_uuid"
                    />
                @endhasanyrole

                    <x-inputs.select2
                        :label="__('eh/leave_application/detail.lb_leave_type_id')"
                        :isReadonly="!$mode['isModeCreate']"
                        name="leave_type_id"
                        value="{{$la->leaveType->name??''}}"
                        required="true"
                    >
                        @foreach($leave_types as $lt)
                            <option
                                value="{{ $lt->id }}"
                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                @if($lt->id===$la->leave_type_id)
                                selected="selected"
                                @endif
                                @endif
                            >{{ $lt->name }}</option>
                        @endforeach
                    </x-inputs.select2>

            </div>
        </div>

        <div class="alert alert-danger alert-dismissible d-none" id="alert_message_box">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            <span id="alert_message"></span>
        </div>

        <div class="card @if($mode['isModeCreate']) d-none @endif" id="application_detail_card">
            <div class="card-body">

                <div class="overlay-wrapper d-none loading">
                    <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        <div class="text-bold pt-2"> {{__('common.loading')}}</div>
                    </div>
                </div>

                <x-inputs.text
                    :label="__('eh/leave_application/detail.lb_title')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$la->title ?? ''}}"
                    name="title"
                    required="true"
                />

                {{--                <x-inputs.textarea--}}
                {{--                    :label="__('eh/leave_application/detail.lb_reason')"--}}
                {{--                    :isReadonly="$mode['isModeShow']"--}}
                {{--                    value="{{$la->reason ?? ''}}"--}}
                {{--                    name="reason"--}}
                {{--                />--}}

                <x-inputs.file
                    type="multiple"
                    :label="__('eh/leave_application/detail.lb_appendix')"
                    :isReadonly="$mode['isModeShow']"
                    :isEdit="$mode['isModeEdit']"
                    deleteRoute="eh.leave_application.file_delete"
                    :deleteModelId="$la->uuid ?? ''"
                    :value="$la->appendix??''"
                    name="appendix[]"
                    fileMax="50000"
                    {{--                    allowedFileExtensions="['jpg','png','gif']"--}}
                    {{--                    allowedFileTypes="['image']"--}}
                    {{--                    accept="image/*"--}}
                />

                <x-inputs.date
                    type="datetime"
                    :label="__('eh/leave_application/detail.lb_start_at')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$la->start_at ?? ''}}"
                    name="period_start"
                    format="YYYY-MM-DD"
                    placeholder="YYYY-MM-DD"
                    required="true"
                />

                <x-inputs.date
                    type="datetime"
                    :label="__('eh/leave_application/detail.lb_end_at')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$la->end_at ?? ''}}"
                    name="period_end"
                    format="YYYY-MM-DD"
                    placeholder="YYYY-MM-DD"
                    required="true"
                />

                {{--                <x-inputs.text--}}
                {{--                    type="number"--}}
                {{--                    :label="__('eh/leave_application/detail.lb_duration_day')"--}}
                {{--                    :isReadonly="$mode['isModeShow']"--}}
                {{--                    value="{{$la->duration['day'] ?? ''}}"--}}
                {{--                    name="duration[day]"--}}
                {{--                    step="0.5"--}}
                {{--                    min="0"--}}
                {{--                    required="true"--}}
                {{--                />--}}

                {{--                <x-inputs.text--}}
                {{--                    type="number"--}}
                {{--                    :label="__('eh/leave_application/detail.lb_duration_hour')"--}}
                {{--                    :isReadonly="$mode['isModeShow']"--}}
                {{--                    value="{{$la->duration['hour'] ?? ''}}"--}}
                {{--                    name="duration[hour]"--}}
                {{--                    step="1"--}}
                {{--                    min="0"--}}
                {{--                />--}}


                {{--                TODO default reviewer disable--}}
                <x-inputs.select2
                    :label="__('eh/leave_application/detail.lb_reviewers')"
                    :isReadonly="$mode['isModeShow']"
                    name="reviewers_id[]"
                    value="TODO"
                    multiple="true"
                >

                    @if($mode['isModeShow'])
                        @if(sizeof($la->reviewer)>0)
                            @foreach($la->reviewer as $vu)
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
                                        @foreach($la->reviewer as $vu)
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

                @if(!$mode['isModeCreate'])
                    <x-inputs.select2
                        :label="__('eh/leave_application/detail.lb_status')"
                        :isReadonly="$mode['isModeShow']"
                        name="status"
                        required="true"
                        showCustom="true"
                    >
                        @if($mode['isModeShow'] || Auth::user()->hasRole(config('constants.ROLE.USER')))
                            @switch($la->status)
                                @case(config('constants.LEAVE_APPLICATION.STATUS.PENDING'))
                                <span
                                    class="badge bg-secondary">{{ __('eh/leave_application/detail.config_constants_LEAVE_APPLICATION_STATUS_PENDING') }}</span>
                                @break
                                @case(config('constants.LEAVE_APPLICATION.STATUS.APPROVE'))
                                <span
                                    class="badge bg-success">{{ __('eh/leave_application/detail.config_constants_LEAVE_APPLICATION_STATUS_APPROVE') }}</span>
                                @break
                                @case(config('constants.LEAVE_APPLICATION.STATUS.REFUSE'))
                                <span
                                    class="badge bg-dark">{{ __('eh/leave_application/detail.config_constants_LEAVE_APPLICATION_STATUS_REFUSE') }}</span>
                                @break
                                @case(config('constants.LEAVE_APPLICATION.STATUS.WAIT_ADMIN'))
                                <span
                                    class="badge bg-warning">{{ __('eh/leave_application/detail.config_constants_LEAVE_APPLICATION_STATUS_WAIT_ADMIN') }}</span>
                                @break
                                @default
                                -
                                @break
                            @endswitch
                        @else
                            @foreach(config('constants.LEAVE_APPLICATION.STATUS') as $key => $value)
                                @if($value == config('constants.LEAVE_APPLICATION.STATUS.WAIT_ADMIN'))
                                    @continue
                                @endif
                                <option
                                    value="{{ $value }}"
                                    @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                    @if($value===$la->status)
                                    selected="selected"
                                    @endif
                                    @endif
                                >{{ __('eh/leave_application/detail.config_constants_LEAVE_APPLICATION_STATUS_'.$key) }}</option>
                            @endforeach
                        @endif
                    </x-inputs.select2>
                @endif

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$la->updated_at" :createdAt="$la->created_at"/>
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.leave_application.detail.panel')
                </div>
            @endif
        </div>
        {{--        --}}{{-- Timestamp Panel --}}
        {{--        @if($mode['isModeShow'])--}}
        {{--            <div class="card">--}}
        {{--                <div class="card-body">--}}
        {{--                    TODO Edit Timeline log--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        @endif--}}
    </form>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    <script>
        $().ready(function () {
            var working_start_time = 0;
            var working_end_time = 0;
            var working_day = [];
            var holiday_group = [];
            var holiday = [];

            $('#id_period_start').datetimepicker('format', 'YYYY-MM-DD');
            $('#id_end_start').datetimepicker('format', 'YYYY-MM-DD');

            $("#id_period_start").on("change.datetimepicker", function (e) {
                $('#id_end_start').datetimepicker('minDate', e.date);
                // countDuration();
            });
            $("#id_end_start").on("change.datetimepicker", function (e) {
                $('#id_period_start').datetimepicker('maxDate', e.date);
                // countDuration();
            });

            @if($mode['isModeCreate'])

            const getLeaveTypeData = (tid, euuid) => {
                $('.loading').removeClass('d-none');
                $('#application_detail_card').removeClass('d-none');
                $('#alert_message_box').addClass('d-none');
                $.post("{{route('eh.leave_application.getLeaveTypeData')}}", {tid: tid, euuid: euuid, _token: "{{ csrf_token() }}",},
                    function (data) {
                        // console.log(data.data);
                        if (data.data.status) {
                            $('#id_title').val(data.data.lt.title_template);
                            // $('#id_reason').text(data.data.lt.content_template);
                            if (data.data.w.length > 0) {
                                working_start_time = data.data.w[0].start_time;
                                working_end_time = data.data.w[0].end_time;
                                working_day = data.data.w[0].working_day.map((i) => Number(i))
                            }
                            if (data.data.h.length > 0) {
                                updateHoliday(data.data.h);
                            }

                            if (data.data.lt.settings.allow_select_reviewers) {
                                $('#id_reviewers_id').next(".select2-container").show();
                            } else {
                                $('#id_reviewers_id').next(".select2-container").hide();
                            }

                            // set date
                            let today = new Date();
                            const tomorrow = new Date(today)
                            const tomorrowEnd = new Date(today)
                            tomorrow.setDate(tomorrow.getDate() + 1)
                            var start_count = 1
                            var dayOfWeek = tomorrow.getDay();
                            while (!working_day.includes(dayOfWeek)) {
                                start_count++;
                                tomorrow.setDate(tomorrow.getDate() + 1)
                                dayOfWeek = tomorrow.getDay();
                            }
                            tomorrow.setDate(today.getDate() + start_count)
                            tomorrowEnd.setDate(today.getDate() + start_count)
                            var start = working_start_time.split(":");
                            var end = working_end_time.split(":");
                            tomorrow.setHours(start[0], start[1], 0, 0)
                            tomorrowEnd.setHours(end[0], end[1], 0, 0)
                            $('#id_period_start').datetimepicker('date', new Date(tomorrow));
                            $('#id_end_start').datetimepicker('date', new Date(tomorrowEnd));

                            $('.reviewer').remove();
                            $.each(data.data.lt.reviewer, function (i, val) {
                                // TODO disable select2 default reviewer option
                                $('#select2_reviewers_id > div').prepend(
                                    '<span class="badge bg-secondary mb-1 reviewer">' + val.employee.first_name + ' ' + val.employee.last_name + '</span> '
                                );
                            })

                            // countDuration();

                            $('.loading').addClass('d-none');
                        } else {
                            $('#alert_message_box').removeClass('d-none');
                            $('#alert_message').html(data.data.message);

                            $('.loading').addClass('d-none');
                            $('#application_detail_card').addClass('d-none');
                        }


                    })
                    .fail(function () {
                        alert("Server Error!");
                        $('.loading').addClass('d-none');
                        $('#application_detail_card').addClass('d-none');
                    });
            }

            if ($('#id_leave_type_id').val() != "" && $('#id_employee_uuid').val() != "") {
                getLeaveTypeData($('#id_leave_type_id').val(), $('#id_employee_uuid').val());
            }

            $('#id_employee_uuid').on('select2:select', function (e) {
                if ($('#id_leave_type_id').val() != "") {
                    getLeaveTypeData($('#id_leave_type_id').val(), e.params.data.id);
                }
            });

            $('#id_leave_type_id').on('select2:select', function (e) {
                if ($('#id_employee_uuid').val() != "") {
                    getLeaveTypeData(e.params.data.id, $('#id_employee_uuid').val());
                }
            });

            @endif

            const countDuration = () => {
                var start = working_start_time.split(":");
                var end = working_end_time.split(":");

                var start_time = new Date(0, 0, 0, start[0], start[1], 0);
                var end_time = new Date(0, 0, 0, end[0], end[1], 0);
                var diff = end_time.getTime() - start_time.getTime();
                var hours = Math.floor(diff / 1000 / 60 / 60);
                diff -= hours * 1000 * 60 * 60;
                var minutes = Math.floor(diff / 1000 / 60);
                if (hours < 0) {
                    hours = hours + 24;
                }
                hours += minutes / 60
                // console.log('hour: ' + hours)

                const startDate = new Date($("#id_period_start_input").val());
                const endDate = new Date($("#id_end_start_input").val());
                var diffDate = endDate.getTime() - startDate.getTime();
                var diffHours = Math.floor(diffDate / 1000 / 60 / 60);
                diffDate -= diffHours * 1000 * 60 * 60;
                var diffMinutes = Math.floor(diffDate / 1000 / 60);
                if (diffHours < 0) {
                    diffHours = diffHours + 24;
                }
                diffHours += diffMinutes / 60
                // console.log('diffHours: ' + diffHours)
                // console.log('FinalHours: ' + diffHours % 24)

                var duration = getBusinessDatesCount(startDate, endDate);
                // console.log('getBusinessDatesCount: ' + duration);
                // console.log("startDate.getHours(): " + startDate.getHours())
                // console.log("start_time.getDate(): " + start_time.getHours())
                // console.log("endDate.getHours(): " + endDate.getHours())
                // console.log("end_time.getHours(): " + end_time.getHours())

                if (startDate.getDate() === endDate.getDate() && (startDate.getHours() > start_time.getHours() || endDate.getHours() < end_time.getHours())) {
                    duration = 0;
                    diffHours %= 24;
                    // console.log('case 1')
                } else if (diffHours % 24 >= hours && startDate.getHours() <= start_time.getHours() && endDate.getHours() >= end_time.getHours()) {
                    diffHours = 0;
                    // console.log('case 2')
                } else if ((working_day.includes(endDate.getDay())) && (working_day.includes(startDate.getDay()))) {
                    if (startDate.getDate() !== endDate.getDate() && (endDate.getHours() !== start_time.getHours() && startDate.getHours() !== end_time.getHours())) {
                        duration--;
                        // console.log('case 3.1')
                        if (startDate.getHours() >= start_time.getHours() && endDate.getHours() <= end_time.getHours()) {
                            if (startDate.getHours() === endDate.getHours()) {
                                duration++;
                                // console.log('case 3.2')
                            }
                        }
                    }
                    diffHours %= 24;
                    // console.log('case 3')
                } else if ((working_day.includes(endDate.getDay())) && (endDate.getHours() > start_time.getHours() || endDate.getHours() < end_time.getHours())) {
                    if (startDate.getDate() !== endDate.getDate()) {
                        duration--;
                        // console.log('case 4.1')
                    }
                    diffHours %= 24;
                    // console.log('case 4')
                } else if ((working_day.includes(endDate.getDay())) && endDate.getHours() <= end_time.getHours() && endDate.getHours() >= start_time.getHours()) {
                    diffHours %= 24;
                    // console.log('case 5')
                } else {
                    diffHours = 0;
                    // console.log('case else')
                }

                // console.log('duration:'+duration);
                // console.log('diffHours:'+diffHours);
                if (diffHours !== 0) {
                    if (diffHours > (hours / 2)) {
                        duration++;
                    } else {
                        duration += 0.5;
                    }
                }
                $('#id_duration_day').val(duration);
                $('#id_duration_hour').val(diffHours);
                // console.log('-------------------------------');
            }

            function getBusinessDatesCount(startDate, endDate) {
                let count = 0;
                const curDate = new Date(startDate.getTime());
                while (curDate < endDate) {
                    const dayOfWeek = curDate.getDay();
                    if (working_day.includes(dayOfWeek)) {
                        // console.log('getBusinessDatesCount dayOfWeek: '+dayOfWeek);
                        if (!holiday.includes(formatDate(curDate))) {
                            count++;
                        }
                    }
                    curDate.setDate(curDate.getDate() + 1);
                }
                return count;
            }

            function updateHoliday(data) {
                holiday = [];
                holiday_group = data;
                for (var i = 0; i < data.length; i++) {
                    let holiday_start = holiday_group[i].from_date;
                    let holiday_end = holiday_group[i].to_date;
                    if (holiday_start === holiday_end) {
                        holiday.push(holiday_start);
                    } else {
                        let curDate = new Date(holiday_start);
                        let endDate = new Date(holiday_end);
                        while (curDate <= endDate) {
                            holiday.push(formatDate(curDate));
                            curDate.setDate(curDate.getDate() + 1);
                        }
                    }
                }
            }

            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }
        })
    </script>
@endpush
