{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_ssc')

@section('html_held_style')
@endsection

{{-- Title --}}
@section('html_title', __('ssc/leave_request/detail.title_html'))
@section('page_title', __('ssc/leave_request/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('ssc/leave_request/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('ssc/leave_request/detail.breadcrumb_level_2') }}</li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('ssc/leave_request/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $la->title }}</li>
            <li class="breadcrumb-item active">{{ __('ssc/leave_request/detail.breadcrumb_edit') }}</li>
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
                @include('ssc.leave_request.detail.panel')
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <x-inputs.text
                :label="__('ssc/employee/detail.lb_employee_id')"
                :isReadonly="true"
                name="employee_id"
                value="{{$la->applicant->employee->employee_id??''}}"
            />

            <div class="row">

                <div class="col-md-3">
                    <x-inputs.text
                        :label="__('ssc/employee/detail.lb_title')"
                        :isReadonly="true"
                        name="title_id"
                        value="{{$la->applicant->employee->title->title[App::getLocale()]??''}}"
                    />
                </div>

                <div class="col-md-3">
                    <x-inputs.text
                        :label="__('ssc/employee/detail.lb_first_name')"
                        :isReadonly="true"
                        value="{{$la->applicant->employee->first_name ?? ''}}"
                        name="first_name"
                        required="true"
                    />
                </div>

                <div class="col-md-3">
                    <x-inputs.text
                        :label="__('ssc/employee/detail.lb_middle_name')"
                        :isReadonly="true"
                        value="{{$la->applicant->employee->middle_name ?? ''}}"
                        name="middle_name"
                    />
                </div>

                <div class="col-md-3">
                    <x-inputs.text
                        :label="__('ssc/employee/detail.lb_last_name')"
                        :isReadonly="true"
                        value="{{$la->applicant->employee->last_name ?? ''}}"
                        name="last_name"
                        required="true"
                    />
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <x-inputs.text
                        :label="__('ssc/employee/detail.lb_chinese_name')"
                        :isReadonly="true"
                        value="{{$la->applicant->employee->chinese_name ?? ''}}"
                        name="chinese_name"
                    />
                </div>

                <div class="col-md-6">
                    <x-inputs.text
                        :label="__('ssc/employee/detail.lb_alias')"
                        :isReadonly="true"
                        value="{{$la->applicant->employee->alias ?? ''}}"
                        name="alias"
                    />
                </div>

            </div>

        </div>
    </div>


    {{-- Form --}}
    <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
          action="@if($mode['isModeEdit']){{route('ssc.leave_request.update', $la->uuid)}}@endif"
          method="post">
        @if($mode['isModeEdit'])
            {{method_field('put')}}
        @endif
        <div class="card">
            <div class="card-body">
                @hasanyrole(config('constants.ROLE.ADMIN').'|'.config('constants.ROLE.SUPER_ADMIN'))
                <x-inputs.select2
                    :label="__('ssc/leave_request/detail.lb_applicant_id')"
                    :isReadonly="true"
                    name="applicant_id"
                    value="{{isset($la->applicant)?$la->applicant->employee->first_name.' '.$la->applicant->employee->last_name:''}}"
                    required="true"
                >
                    @foreach($employees as $e)
                        <option
                            value="{{ $e->user->id }}"
                            @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                            @if($e->user->id===$la->applicant_id)
                            selected="selected"
                            @endif
                            @endif
                        >{{ $e->first_name.' '.$e->last_name }}</option>
                    @endforeach
                </x-inputs.select2>
                @else
                    <x-inputs.text
                        type="hidden"
                        :value="Auth::user()->id"
                        name="applicant_id"
                        :isReadonly="true"
                    />
                    @endhasanyrole

                    <x-inputs.select2
                        :label="__('ssc/leave_request/detail.lb_leave_type_id')"
                        :isReadonly="true"
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

        <div class="card @if($mode['isModeCreate']) d-none @endif" id="application_detail_card">
            <div class="card-body">

                <div class="overlay-wrapper d-none loading">
                    <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        <div class="text-bold pt-2"> {{__('common.loading')}}</div>
                    </div>
                </div>

                <x-inputs.text
                    :label="__('ssc/leave_request/detail.lb_title')"
                    :isReadonly="true"
                    value="{{$la->title ?? ''}}"
                    name="title"
                    required="true"
                />

                <x-inputs.textarea
                    :label="__('ssc/leave_request/detail.lb_reason')"
                    :isReadonly="true"
                    value="{{$la->reason ?? ''}}"
                    name="reason"
                />

                <x-inputs.file
                    type="multiple"
                    :label="__('ssc/leave_request/detail.lb_appendix')"
                    :isReadonly="true"
                    :value="$la->appendix??''"
                    name="appendix[]"
                    fileMax="50000"
                    {{--                    allowedFileExtensions="['jpg','png','gif']"--}}
                    {{--                    allowedFileTypes="['image']"--}}
                    {{--                    accept="image/*"--}}
                />

                <x-inputs.date
                    type="datetime"
                    :label="__('ssc/leave_request/detail.lb_start_at')"
                    :isReadonly="true"
                    value="{{$la->start_at ?? ''}}"
                    name="start_at"
                    format="YYYY-MM-DD HH:mm"
                    placeholder="YYYY-MM-DD HH:mm"
                />

                <x-inputs.date
                    type="datetime"
                    :label="__('ssc/leave_request/detail.lb_end_at')"
                    :isReadonly="true"
                    value="{{$la->end_at ?? ''}}"
                    name="end_at"
                    format="YYYY-MM-DD HH:mm"
                    placeholder="YYYY-MM-DD HH:mm"
                />

                <x-inputs.text
                    type="number"
                    :label="__('ssc/leave_request/detail.lb_duration_day')"
                    :isReadonly="true"
                    value="{{$la->duration['day'] ?? ''}}"
                    name="duration[day]"
                    step="1"
                    min="0"
                />

                {{--                TODO only day--}}
                {{--                <x-inputs.text--}}
                {{--                    type="number"--}}
                {{--                    :label="__('ssc/leave_request/detail.lb_duration_hour')"--}}
                {{--                    :isReadonly="true"--}}
                {{--                    value="{{$la->duration['hour'] ?? ''}}"--}}
                {{--                    name="duration[hour]"--}}
                {{--                    step="1"--}}
                {{--                    min="0"--}}
                {{--                />--}}


                {{--                TODO default reviewer disable--}}
                <x-inputs.select2
                    :label="__('ssc/leave_request/detail.lb_reviewers')"
                    :isReadonly="true"
                    name="reviewers_id[]"
                    value="TODO"
                    multiple="true"
                >
                    @if(sizeof($la->reviewer)>0)
                        @foreach($la->reviewer as $vu)
                            <span class="badge bg-primary">{{$vu->employee->first_name.' '.$vu->employee->last_name}}</span>
                        @endforeach
                    @else
                        -
                    @endif
                </x-inputs.select2>

                @if(!$mode['isModeCreate'])
                    <x-inputs.select2
                        :label="__('ssc/leave_request/detail.lb_status')"
                        :isReadonly="$mode['isModeShow']"
                        name="status"
                        required="true"
                        showCustom="true"
                    >
                        @if($mode['isModeShow'])
                            @switch($la->status)
                                @case(config('constants.LEAVE_APPLICATION.STATUS.PENDING'))
                                <span
                                    class="badge bg-secondary">{{ __('ssc/leave_request/detail.config_constants_LEAVE_APPLICATION_STATUS_PENDING') }}</span>
                                @break
                                @case(config('constants.LEAVE_APPLICATION.STATUS.APPROVE'))
                                <span
                                    class="badge bg-success">{{ __('ssc/leave_request/detail.config_constants_LEAVE_APPLICATION_STATUS_APPROVE') }}</span>
                                @break
                                @case(config('constants.LEAVE_APPLICATION.STATUS.REFUSE'))
                                <span
                                    class="badge bg-dark">{{ __('ssc/leave_request/detail.config_constants_LEAVE_APPLICATION_STATUS_REFUSE') }}</span>
                                @break
                                @case(config('constants.LEAVE_APPLICATION.STATUS.WAIT_ADMIN'))
                                <span
                                    class="badge bg-warning">{{ __('ssc/leave_request/detail.config_constants_LEAVE_APPLICATION_STATUS_WAIT_ADMIN') }}</span>
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
                                >{{ __('ssc/leave_request/detail.config_constants_LEAVE_APPLICATION_STATUS_'.$key) }}</option>
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
                    @include('ssc.leave_request.detail.panel')
                </div>
            @endif
        </div>
        {{-- Timestamp Panel --}}
        @if($mode['isModeShow'])
            <div class="card">
                <div class="card-body">
                    TODO Edit Timeline log
                </div>
            </div>
        @endif
    </form>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')


@endpush
