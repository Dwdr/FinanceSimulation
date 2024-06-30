{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/employee/package/detail.title_html'))
@section('page_title', __('eh/employee/package/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/employee/package/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/employee/package/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item">{{ __('eh/employee/package/detail.breadcrumb_level_3') }}</li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/employee/package/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $p->id }} {{ $p->id }}</li>
            <li class="breadcrumb-item active">{{ __('eh/employee/package/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.employee.package.detail.panel')
            </div>
        </div>
    @endif


    {{-- Form --}}
    <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
          action="@if(!$mode['isModeEdit']){{route('eh.employee.package.store',$e->uuid)}}@elseif($mode['isModeEdit']){{route('eh.employee.package.update', ['uuid'=>$e->uuid,'hash_id'=>$p->hash_id])}}@endif"
          method="post">
        @if($mode['isModeEdit'])
            {{method_field('put')}}
        @endif

        <div class="card">
            <div class="card-body">

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

            <div class="card-body">

                <x-inputs.text
                    type="number"
                    :label="__('eh/employee/package/detail.lb_basic_salary')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->detail['basic_salary'] ?? 0}}"
                    name="detail[basic_salary]"
                    :required="true"
                    min="0"
                />

                <x-inputs.text
                    type="number"
                    :label="__('eh/employee/package/detail.lb_mpf_employer_compulsory')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->detail['mpf_employer_compulsory'] ?? 0}}"
                    name="detail[mpf_employer_compulsory]"
                    :required="true"
                    min="0"
                />

                <x-inputs.text
                    type="number"
                    :label="__('eh/employee/package/detail.lb_mpf_employer_voluntary')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->detail['mpf_employer_voluntary'] ?? 0}}"
                    name="detail[mpf_employer_voluntary]"
                    :required="true"
                    min="0"
                />

                <x-inputs.text
                    type="number"
                    :label="__('eh/employee/package/detail.lb_mpf_employee_compulsory')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->detail['mpf_employee_compulsory'] ?? 0}}"
                    name="detail[mpf_employee_compulsory]"
                    :required="true"
                    min="0"
                />

                <x-inputs.text
                    type="number"
                    :label="__('eh/employee/package/detail.lb_mpf_employee_voluntary')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->detail['mpf_employee_voluntary'] ?? 0}}"
                    name="detail[mpf_employee_voluntary]"
                    :required="true"
                    min="0"
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
                    :label="__('eh/employee/package/detail.lb_effective_date')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->effective_type ?? ''}}"
                    lang="eh/employee/package/detail"
                    name="effective_type"
                    :option="$effective_type"
                    required="true"
                    hidden="{{$mode['isModeShow']}}"
                />

                <x-inputs.date
                    label="{{$mode['isModeShow']?__('eh/employee/package/detail.lb_effective_date'):''}}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->effective_date ?? ''}}"
                    name="effective_date"
                    hidden="{{$mode['isModeCreate']}}"
                />

                <x-inputs.textarea
                    :label="__('eh/employee/detail.lb_remarks')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->detail['remarks'] ?? ''}}"
                    name="detail[remarks]"
                />

                @if($mode['isModeShow'])
                    <div class="form-group">
                        <label class="form-control-label" >{{__('eh/employee/package/detail.lb_status')}}</label>
                        <h5>
                            @switch($p->status)
                                @case(config('constants.EMPLOYEE_LOG.STATUS.PENDING'))
                                <span class="badge bg-secondary">{{__('eh/employee/package/detail.lb_status_pending')}}</span>
                                @break
                                @case(config('constants.EMPLOYEE_LOG.STATUS.APPROVED'))
                                <span class="badge bg-success">{{__('eh/employee/package/detail.lb_status_approved')}}</span>
                                @break
                            @endswitch
                        </h5>
                    </div>
                @endif

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$p->updated_at" :createdAt="$p->created_at"/>
                @endif

            </div>

            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.employee.package.detail.panel')
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
                var effective_type = {{$p->effective_type??config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.NOW')}};
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
