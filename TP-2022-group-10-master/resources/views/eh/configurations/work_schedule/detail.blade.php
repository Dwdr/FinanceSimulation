{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/work_schedule/detail.title_html'))
@section('page_title', __('eh/configurations/work_schedule/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/work_schedule/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/work_schedule/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a
            href="{{ route('eh.configurations.work_schedule.index') }}">{{ __('eh/configurations/work_schedule/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/work_schedule/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $ws->id }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/work_schedule/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.work_schedule.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if(!$mode['isModeEdit']){{route('eh.configurations.work_schedule.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.work_schedule.update', $ws->id)}}@endif"
              method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.select2
                    :label="__('eh/configurations/work_schedule/detail.lb_employee_type')"
                    :isReadonly="$mode['isModeShow']"
                    name="employee_type_id"
                    value="{{$ws->employeeType->name??''}}"
                    required="true"
                >
                    @foreach($employee_types as $et)
                        <option
                            value="{{ $et->id }}"
                            @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                            @if($et->id===$ws->employee_type_id)
                            selected="selected"
                            @endif
                            @endif
                        >{{ $et->name }}</option>
                    @endforeach
                </x-inputs.select2>

                <x-inputs.checkbox
                    :label="__('eh/configurations/work_schedule/detail.lb_working_day')"
                    :isReadonly="$mode['isModeShow']"
                    :value="$ws->working_day ?? ''"
                    name="working_day[]"
                    lang="eh/configurations/work_schedule/detail"
                    :option="config('constants.WORK_SCHEDULE.WORKING_DAY')"
                    required="true"
                />

                <x-inputs.date
                    :label="__('eh/configurations/work_schedule/detail.lb_from_date')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$ws->from_date ?? ''}}"
                    name="from_date"
                    required="true"
                />

                <x-inputs.radio
                    :label="__('eh/configurations/work_schedule/detail.lb_to_date')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$ws->to_date_type ?? ''}}"
                    lang="eh/configurations/work_schedule/detail"
                    name="to_date_type"
                    :option="config('constants.WORK_SCHEDULE.TO_DATE')"
                    required="true"
                />

                <x-inputs.date
                    label=""
                    :isReadonly="$mode['isModeShow']"
                    value="{{$ws->to_date ?? ''}}"
                    name="to_date"
                    hidden="{{$mode['isModeCreate'] || (!$mode['isModeCreate'] && $ws->to_date_type == 1)}}"
                />

                <x-inputs.date
                    type="time"
                    :label="__('eh/configurations/work_schedule/detail.lb_start_time')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$ws->start_time ?? ''}}"
                    name="start_time"
                    required="true"
                />

                <x-inputs.date
                    type="time"
                    :label="__('eh/configurations/work_schedule/detail.lb_end_time')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$ws->end_time ?? ''}}"
                    name="end_time"
                    required="true"
                />

                <x-inputs.textarea
                    :label="__('eh/configurations/work_schedule/detail.lb_remarks')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$ws->remarks ?? ''}}"
                    name="remarks"
                />

                <x-inputs.switch2
                    label="{{ __('eh/configurations/grade/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$g->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/configurations/grade/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/grade/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$ws->updated_at" :createdAt="$ws->created_at"/>
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.work_schedule.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    <script>
        $().ready(function () {
            if($('input[name=to_date_type]:checked', '#v_form').val()=='2'){
                $('#date_to_date').removeClass('d-none')
            }
            $('#id_to_date').datetimepicker('format','YYYY-MM-DD');
            $('#id_from_date').datetimepicker('format','YYYY-MM-DD');
            $('#id_start_time').datetimepicker('format','HH:mm');
            $('#id_end_time').datetimepicker('format','HH:mm');

            $("input[type=radio][name='to_date_type']").change(function () {
                if (this.value == '1') {
                    $('#date_to_date').addClass('d-none')
                } else if (this.value == '2') {
                    $('#date_to_date').removeClass('d-none')
                }
            });

            $("#id_from_date").on("change.datetimepicker", function (e) {
                $('#id_to_date').datetimepicker('minDate', e.date);
            });
            $("#id_to_date").on("change.datetimepicker", function (e) {
                $('#id_from_date').datetimepicker('maxDate', e.date);
            });
        })
    </script>
@endpush
