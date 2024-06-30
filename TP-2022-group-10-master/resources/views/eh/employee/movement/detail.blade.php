{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_held_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/employee/movement/detail.title_html'))
@section('page_title', __('eh/employee/movement/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/employee/movement/detail.breadcrumb_level_1') }}</li>

    <li class="breadcrumb-item active">
        <a href="{{route('eh.employee.index')}}">
            {{ __('eh/employee/movement/detail.breadcrumb_level_2') }}
        </a>
    </li>

    <li class="breadcrumb-item active">
        <a href="{{route('eh.employee.show',$e->uuid)}}">
            {{$e->employee_id}}
        </a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{route('eh.employee.movement.index',$e->uuid)}}">
            {{ __('eh/employee/movement/detail.breadcrumb_level_3') }}
        </a>
    </li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/employee/movement/detail.breadcrumb_create') }}</li>
    @else
        <li class="breadcrumb-item active">{{ $em->created_at }}</li>
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.employee.movement.detail.panel')
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
          action="@if(!$mode['isModeEdit']){{route('eh.employee.movement.store',$e->uuid)}}@endif"
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
            <div class="card-header">
                {{__('eh/employee/movement/detail.card_header_movement_detail')}}
            </div>
            <div class="card-body">

                @if(!$mode['isModeShow'])
                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_employee_id')"
                        :isReadonly="$mode['isModeShow']"
                        value="{{$e->employee_id ?? ''}}"
                        name="employee_id"
                        required="true"
                    />

                    <x-inputs.date
                        :label="__('eh/employee/detail.lb_join_date')"
                        :isReadonly="$mode['isModeShow']"
                        value="{{$e->join_date ?? ''}}"
                        name="join_date"
                    />

                    <x-inputs.select2
                        :label="__('eh/employee/detail.lb_department')"
                        :isReadonly="$mode['isModeShow']"
                        name="department_id"
                        value="{{$e->department->name??''}}"
                    >
                        @foreach($departments as $d)
                            <option
                                value="{{ $d->id }}"
                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'] || $mode['isModeCreate'])
                                @if($d->id===$e->department_id)
                                selected="selected"
                                @endif
                                @endif
                            >{{ $d->name }}</option>
                        @endforeach
                    </x-inputs.select2>

                    <x-inputs.select2
                        :label="__('eh/employee/detail.lb_direct_supervisor')"
                        :isReadonly="$mode['isModeShow']"
                        name="direct_supervisor_id"
                        {{--TODO: should show employee full name or chinese name and avatar--}}
                        value="{{$e->directSupervisor->profile->name??''}}"
                    >
                        @foreach($employees as $ds)
                            <option
                                value="{{ $ds->user_id }}"
                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'] || $mode['isModeCreate'])
                                @if($ds->user->id===$e->direct_supervisor_id)
                                selected="selected"
                                @endif
                                @endif
                            >{{ $ds->first_name.' '.$ds->last_name }}</option>
                        @endforeach
                    </x-inputs.select2>

                    <x-inputs.select2
                        :label="__('eh/employee/detail.lb_designation')"
                        :isReadonly="$mode['isModeShow']"
                        name="designation_id"
                        value="{{$e->designation->name??''}}"
                    >
                        @foreach($designations as $d)
                            <option
                                value="{{ $d->id }}"
                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'] || $mode['isModeCreate'])
                                @if($d->id===$e->designation_id)
                                selected="selected"
                                @endif
                                @endif
                            >{{ $d->name }}</option>
                        @endforeach
                    </x-inputs.select2>

                    <x-inputs.select2
                        :label="__('eh/employee/detail.lb_employee_type')"
                        :isReadonly="$mode['isModeShow']"
                        name="employee_type_id"
                        value="{{$e->employeeType->name??''}}"
                    >
                        @foreach($employee_types as $et)
                            <option
                                value="{{ $et->id }}"
                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'] || $mode['isModeCreate'])
                                @if($et->id===$e->employee_type_id)
                                selected="selected"
                                @endif
                                @endif
                            >{{ $et->name }}</option>
                        @endforeach
                    </x-inputs.select2>

                    <x-inputs.select2
                        :label="__('eh/employee/detail.lb_grade')"
                        :isReadonly="$mode['isModeShow']"
                        name="grade_id"
                        value="{{$e->grade->grade[App::getLocale()]??''}}"
                    >
                        @foreach($grades as $g)
                            <option
                                value="{{ $g->id }}"
                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'] || $mode['isModeCreate'])
                                @if($g->id===$e->grade_id)
                                selected="selected"
                                @endif
                                @endif
                            >{{ $g->grade[App::getLocale()] }}</option>
                        @endforeach
                    </x-inputs.select2>

                    <x-inputs.text
                        type="number"
                        :label="__('eh/employee/detail.lb_salary')"
                        :isReadonly="$mode['isModeShow']"
                        value="{{$e->salary ?? ''}}"
                        name="salary"
                        step="0.01"
                        min="0"
                    />
                @else

                    @foreach($em->updated_data as $key => $value)

                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label" for="id_{{$key}}">{{__('eh/employee/detail.lb_'.$key)}}</label>
                            <div class="col-sm-9">
                                @switch($key)
                                    @case('department_id')
                                    {{ \App\Models\EH\Configurations\Department::find($em->original_data[$key])->name??'NULL' }}
                                    <strong class="ml-2 mr-2">=></strong>
                                    {{ \App\Models\EH\Configurations\Department::find($em->updated_data[$key])->name }}
                                    @break

                                    @case('direct_supervisor_id')
                                    {{ \App\Models\Auth\UserProfile::where('user_id',$em->original_data[$key])->first()->name??'NULL' }}
                                    <strong class="ml-2 mr-2">=></strong>
                                    {{ \App\Models\Auth\UserProfile::where('user_id',$em->updated_data[$key])->first()->name }}
                                    @break

                                    @case('designation_id')
                                    {{ \App\Models\EH\Configurations\Designation::find($em->original_data[$key])->name??'NULL' }}
                                    <strong class="ml-2 mr-2">=></strong>
                                    {{ \App\Models\EH\Configurations\Designation::find($em->updated_data[$key])->name }}
                                    @break

                                    @case('employee_type_id')
                                    {{ \App\Models\EH\Configurations\EmployeeType::find($em->original_data[$key])->name??'NULL' }}
                                    <strong class="ml-2 mr-2">=></strong>
                                    {{ \App\Models\EH\Configurations\EmployeeType::find($em->updated_data[$key])->name }}
                                    @break

                                    @case('grade_id')
                                    {{ \App\Models\EH\Configurations\Grade::find($em->original_data[$key])->grade[App::getLocale()]??'NULL' }}
                                    <strong class="ml-2 mr-2">=></strong>
                                    {{ \App\Models\EH\Configurations\Grade::find($em->updated_data[$key])->grade[App::getLocale()] }}
                                    @break

                                    @default
                                    {{ $em->original_data[$key]??'NULL' }}
                                    <strong class="ml-2 mr-2">=></strong>
                                    {{ $em->updated_data[$key] }}
                                    @break
                                @endswitch
                            </div>
                        </div>

                    @endforeach

                @endif


            </div>

        </div>

        <div class="card">
            <div class="card-body">

                <x-inputs.radio
                    :label="__('eh/employee/movement/detail.lb_effective_date')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$em->effective_type ?? ''}}"
                    lang="eh/employee/movement/detail"
                    name="effective_type"
                    :option="config('constants.EMPLOYEE.EFFECTIVE_DATE')"
                    required="true"
                    hidden="{{$mode['isModeShow']}}"
                />

                <x-inputs.date
                    label="{{$mode['isModeShow']?__('eh/employee/movement/detail.lb_effective_date'):''}}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$em->effective_date ?? ''}}"
                    name="effective_date"
                    hidden="{{$mode['isModeCreate']}}"
                />

                <x-inputs.textarea
                    :label="__('eh/employee/detail.lb_remarks')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$em->detail['remarks'] ?? ''}}"
                    name="detail[remarks]"
                />

                @if($mode['isModeShow'])
                <div class="form-group">
                    <label class="form-control-label" >{{__('eh/employee/movement/detail.lb_status')}}</label>
                    <h5>
                        @switch($p->status)
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
                    <x-inputs.timestamp :updatedAt="$em->updated_at" :createdAt="$em->created_at"/>
                @endif

            </div>

            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.employee.movement.detail.panel')
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
                var effective_type = {{$em->effective_type??1}};
                if(effective_type == '1'){
                    $('#date_effective_date').addClass('d-none')
                }else if (effective_type == '2'){
                    $('#date_effective_date').removeClass('d-none')
                }

                $("input[type=radio][name='effective_type']").change(function () {
                    if (this.value == '1') {
                        $('#date_effective_date').addClass('d-none')
                    } else if (this.value == '2') {
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
