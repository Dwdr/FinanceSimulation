{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_held_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/employee/termination/detail.title_html'))
@section('page_title', __('eh/employee/termination/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/employee/termination/detail.breadcrumb_level_1') }}</li>

    <li class="breadcrumb-item active">
        <a href="{{route('eh.employee.index')}}">
            {{ __('eh/employee/termination/detail.breadcrumb_level_2') }}
        </a>
    </li>

    <li class="breadcrumb-item active">
        <a href="{{route('eh.employee.show',$e->uuid)}}">
            {{$e->employee_id}}
        </a>
    </li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/employee/termination/detail.breadcrumb_level_3') }}</li>
    @else
        <li class="breadcrumb-item active">{{ $et->created_at }}</li>
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.employee.termination.detail.panel')
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
          action="@if(!$mode['isModeEdit']){{route('eh.employee.termination.store', $e->uuid)}}@elseif($mode['isModeEdit']){{route('eh.employee.termination.update',['uuid'=>$e->uuid,'hash_id'=>$et->hash_id])}}@endif"
          method="post">
        @if($mode['isModeEdit'])
            {{method_field('put')}}
        @endif

        <div class="card">
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/employee/detail.lb_employee_id')"
                    :isReadonly="true"
                    name="title_id"
                    value="{{$e->employee_id??''}}"
                />

                <div class="row">

                    <div class="col-md-3">
                        <x-inputs.text
                            :label="__('eh/employee/detail.lb_title')"
                            :isReadonly="true"
                            name="title_id"
                            value="{{$e->title->title[App::getLocale()]??''}}"
                        />
                    </div>

                    <div class="col-md-3">
                        <x-inputs.text
                            :label="__('eh/employee/detail.lb_first_name')"
                            :isReadonly="true"
                            value="{{$e->first_name ?? ''}}"
                            name="first_name"
                            required="true"
                        />
                    </div>

                    <div class="col-md-3">
                        <x-inputs.text
                            :label="__('eh/employee/detail.lb_middle_name')"
                            :isReadonly="true"
                            value="{{$e->middle_name ?? ''}}"
                            name="middle_name"
                        />
                    </div>

                    <div class="col-md-3">
                        <x-inputs.text
                            :label="__('eh/employee/detail.lb_last_name')"
                            :isReadonly="true"
                            value="{{$e->last_name ?? ''}}"
                            name="last_name"
                            required="true"
                        />
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <x-inputs.text
                            :label="__('eh/employee/detail.lb_chinese_name')"
                            :isReadonly="true"
                            value="{{$e->chinese_name ?? ''}}"
                            name="chinese_name"
                        />
                    </div>

                    <div class="col-md-6">
                        <x-inputs.text
                            :label="__('eh/employee/detail.lb_alias')"
                            :isReadonly="true"
                            value="{{$e->alias ?? ''}}"
                            name="alias"
                        />
                    </div>

                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                {{__('eh/employee/termination/detail.card_header_termination_detail')}}
            </div>
            <div class="card-body">

                <x-inputs.select2
                    :label="__('eh/employee/termination/detail.lb_exit_type_id')"
                    :isReadonly="$mode['isModeShow']"
                    name="detail[exit_type_id]"
                    value="{{$exit_type->exit_type[App::getLocale()]??'-'}}"
                    required="true"
                >
                    @if(!$mode['isModeShow'])
                        @foreach($exit_types as $t)
                            <option
                                value="{{ $t->id }}"
                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                @if($t->id==$et->detail['exit_type_id'])
                                selected="selected"
                                @endif
                                @endif
                            >{{ $t->exit_type[App::getLocale()] }}</option>
                        @endforeach
                    @endif
                </x-inputs.select2>

                <x-inputs.textarea
                    :label="__('eh/employee/termination/detail.lb_reason')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$et->detail['reason'] ?? ''}}"
                    name="detail[reason]"
                />

            </div>

        </div>

        <div class="card">
            <div class="card-body">
                @php
                    $effective_type = config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE');
                    array_shift($effective_type);
                @endphp
                <x-inputs.radio
                    :label="__('eh/employee/termination/detail.lb_effective_date')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$et->effective_type ?? ''}}"
                    lang="eh/employee/termination/detail"
                    name="effective_type"
                    :option="$effective_type"
                    required="true"
                    hidden="{{$mode['isModeShow']}}"
                />

                <x-inputs.date
                    label="{{$mode['isModeShow']?__('eh/employee/termination/detail.lb_effective_date'):''}}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$et->effective_date ?? ''}}"
                    name="effective_date"
                    hidden="{{$mode['isModeCreate']}}"
                />

                <x-inputs.textarea
                    :label="__('eh/employee/detail.lb_remarks')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$et->detail['remarks'] ?? ''}}"
                    name="detail[remarks]"
                />

                @if($mode['isModeShow'])
                    <div class="form-group">
                        <label class="form-control-label">{{__('eh/employee/termination/detail.lb_status')}}</label>
                        <h5>
                            @switch($et->status)
                                @case(config('constants.EMPLOYEE_LOG.STATUS.PENDING'))
                                <span class="badge bg-secondary">{{__('eh/employee/movement/detail.lb_status_pending')}}</span>
                                @break
                                @case(config('constants.EMPLOYEE_LOG.STATUS.APPROVED'))
                                <span class="badge bg-success">{{__('eh/employee/movement/detail.lb_status_approved')}}</span>
                                @break
                            @endswitch
                        </h5>
                    </div>
                @endif

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$et->updated_at" :createdAt="$et->created_at"/>
                @endif

            </div>

            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.employee.termination.detail.panel')
                </div>
            @endif
        </div>

    </form>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

    @if(!$mode['isModeShow'])
        <script>
            $().ready(function () {
                var effective_type = {{$et->effective_type??config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.NOW')}};
                if(effective_type == '{{config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.NOW')}}'){
                    $('#date_effective_date').addClass('d-none')
                }else if (effective_type == '{{config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.SELECT_DATE')}}'){
                    $('#date_effective_date').removeClass('d-none')
                }

                $("input[type=radio][name='effective_type']").change(function () {
                    if (this.value == '{{config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.NOW')}}') {
                        $('#date_effective_date').addClass('d-none')
                    } else if (this.value == '{{config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.SELECT_DATE')}}') {
                        $('#date_effective_date').removeClass('d-none')
                    }
                });

                const today = new Date()
                const tomorrow = new Date(today)
                tomorrow.setDate(tomorrow.getDate() + 1)
                $('#id_effective_date').datetimepicker('minDate', tomorrow);
            })
        </script>
    @endif

@endpush
