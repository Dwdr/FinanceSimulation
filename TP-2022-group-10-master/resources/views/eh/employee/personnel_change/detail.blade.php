{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_held_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/employee/personnel_change/detail.title_html'))
@section('page_title', __('eh/employee/personnel_change/detail.title_page'))

@section('body_page_breadcrumb')
    @unlessrole(config('constants.ROLE.USER'))
    <li class="breadcrumb-item active">{{ __('eh/employee/personnel_change/index.breadcrumb_level_1') }}</li>
    @endunlessrole

    @role(config('constants.ROLE.USER'))
    <li class="breadcrumb-item active">
        <a href="{{route('profile.index')}}">
            {{ __('eh/employee/personnel_change/detail.breadcrumb_level_2') }}
        </a>
    </li>
    @else
        <li class="breadcrumb-item active">
            <a href="{{route('eh.employee.index')}}">
                {{ __('eh/employee/personnel_change/detail.breadcrumb_level_2_admin') }}
            </a>
        </li>
    @endif

    <li class="breadcrumb-item active">
        <a href="{{route('eh.personnel_change.index')}}">
            {{ __('eh/employee/personnel_change/detail.breadcrumb_level_3') }}
        </a>
    </li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/employee/movement/detail.breadcrumb_create') }}</li>
    @else
        <li class="breadcrumb-item active">{{ $ep->created_at }}</li>
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.employee.personnel_change.detail.panel')
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
          action="@if(!$mode['isModeEdit']){{route('eh.personnel_change.store')}}@elseif($mode['isModeEdit']){{route('eh.personnel_change.update', $ep->hash_id)}}@endif"
          method="post">
        @if($mode['isModeEdit'])
            {{method_field('put')}}
        @endif

        @if(!Auth::user()->hasRole(config('constants.ROLE.USER')))
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
        @endif

        <div class="card">
            <div class="card-header">
                {{__('eh/employee/detail.card_header_personnel_information')}}
            </div>
            <div class="card-body">

                @if($mode['isModeCreate'])

                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_employee_id')"
                        :isReadonly="true"
                        value="{{$u->employee->employee_id ?? ''}}"
                        name="employee_id"
                        required="true"
                    />

                    <x-inputs.select2
                        :label="__('eh/employee/detail.lb_title')"
                        :isReadonly="!$mode['isModeCreate']"
                        name="title_id"
                        value="{{$u->employee->title->title[App::getLocale()]??''}}"
                    >
                        @if($mode['isModeCreate'])
                            @foreach($titles as $t)
                                <option
                                    value="{{ $t->id }}"
                                    @if($mode['isModeCreate'])
                                    @if($t->id===$u->employee->title_id)
                                    selected="selected"
                                    @endif
                                    @endif
                                >{{ $t->title[App::getLocale()] }}</option>
                            @endforeach
                        @endif
                    </x-inputs.select2>

                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_first_name')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->first_name ?? ''}}"
                        name="first_name"
                        required="true"
                    />

                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_middle_name')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->middle_name ?? ''}}"
                        name="middle_name"
                    />

                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_last_name')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->last_name ?? ''}}"
                        name="last_name"
                        required="true"
                    />

                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_chinese_name')"
                        :isReadonly="$mode['isModeShow']"
                        value="{{$u->employee->chinese_name ?? ''}}"
                        name="chinese_name"
                    />

                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_alias')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->alias ?? ''}}"
                        name="alias"
                    />

                    <x-inputs.date
                        :label="__('eh/employee/detail.lb_date_of_birth')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->date_of_birth ?? ''}}"
                        name="date_of_birth"
                    />

                    <x-inputs.text
                        type="tel"
                        :label="__('eh/employee/detail.lb_tel')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->tel ?? ''}}"
                        name="tel"
                    />

                    <x-inputs.text
                        type="email"
                        :label="__('eh/employee/detail.lb_personal_email')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->personal_email ?? ''}}"
                        name="personal_email"
                    />

                    <x-inputs.select2
                        :label="__('eh/employee/detail.lb_gender')"
                        :isReadonly="!$mode['isModeCreate']"
                        name="gender_id"
                        value="{{$u->employee->gender->gender[App::getLocale()]??''}}"
                    >
                        @if($mode['isModeCreate'])
                            @foreach($genders as $g)
                                <option
                                    value="{{ $g->id }}"
                                    @if($mode['isModeCreate'])
                                    @if($g->id===$u->employee->gender_id)
                                    selected="selected"
                                    @endif
                                    @endif
                                >{{ $g->gender[App::getLocale()] }}</option>
                            @endforeach
                        @endif
                    </x-inputs.select2>

                    <x-inputs.select2
                        :label="__('eh/employee/detail.lb_martial_status')"
                        :isReadonly="!$mode['isModeCreate']"
                        name="martial_status_id"
                        value="{{$u->employee->martialStatus->martial_status[App::getLocale()]??''}}"
                    >
                        @if($mode['isModeCreate'])
                            @foreach($martial_status as $m)
                                <option
                                    value="{{ $m->id }}"
                                    @if($mode['isModeCreate'])
                                    @if($m->id===$u->employee->martial_status_id)
                                    selected="selected"
                                    @endif
                                    @endif
                                >{{ $m->martial_status[App::getLocale()] }}</option>
                            @endforeach
                        @endif
                    </x-inputs.select2>

                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_address')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->address ?? ''}}"
                        name="address"
                    />

                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_emergency_contact_person')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->emergency_contact_person ?? ''}}"
                        name="emergency_contact_person"
                    />

                    <x-inputs.select2
                        :label="__('eh/employee/detail.lb_emergency_contact_person_relationship')"
                        :isReadonly="!$mode['isModeCreate']"
                        name="emergency_contact_person_relationship_id"
                        value="{{$u->employee->emergencyContactPersonRelationship->relationship[App::getLocale()]??''}}"
                    >
                        @if($mode['isModeCreate'])
                            @foreach($relationships as $r)
                                <option
                                    value="{{ $r->id }}"
                                    @if($mode['isModeCreate'])
                                    @if($r->id===$u->employee->emergency_contact_person_relationship_id)
                                    selected="selected"
                                    @endif
                                    @endif
                                >{{ $r->relationship[App::getLocale()] }}</option>
                            @endforeach
                        @endif
                    </x-inputs.select2>

                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_emergency_contact')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->emergency_contact ?? ''}}"
                        name="emergency_contact"
                    />

                    <x-inputs.select2
                        :label="__('eh/employee/detail.lb_highest_education')"
                        :isReadonly="!$mode['isModeCreate']"
                        name="highest_education_id"
                        value="{{$u->employee->highestEducation->highest_education[App::getLocale()]??''}}"
                    >
                        @if($mode['isModeCreate'])
                            @foreach($highest_educations as $he)
                                <option
                                    value="{{ $he->id }}"
                                    @if($mode['isModeCreate'])
                                    @if($he->id===$u->employee->highest_education_id)
                                    selected="selected"
                                    @endif
                                    @endif
                                >{{ $he->highest_education[App::getLocale()] }}</option>
                            @endforeach
                        @endif
                    </x-inputs.select2>

                    <x-inputs.select2
                        :label="__('eh/employee/detail.lb_bank')"
                        :isReadonly="!$mode['isModeCreate']"
                        name="bank_id"
                        value="{{$u->employee->bank->bank[App::getLocale()]??''}}"
                    >
                        @if($mode['isModeCreate'])
                            @foreach($banks as $b)
                                <option
                                    value="{{ $b->id }}"
                                    @if($mode['isModeCreate'])
                                    @if($b->id===$u->employee->bank_id)
                                    selected="selected"
                                    @endif
                                    @endif
                                >{{ $b->code.' - '.$b->bank[App::getLocale()] }}</option>
                            @endforeach
                        @endif
                    </x-inputs.select2>

                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_bank_account')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->bank_account ?? ''}}"
                        name="bank_account"
                    />

                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_bank_account_receiving_name')"
                        :isReadonly="!$mode['isModeCreate']"
                        value="{{$u->employee->bank_account_receiving_name ?? ''}}"
                        name="bank_account_receiving_name"
                    />

                @else

                    @foreach($ep->updated_data as $key => $value)

                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label" for="id_{{$key}}">{{__('eh/employee/detail.lb_'.$key)}}</label>
                            <div class="col-sm-9">
                                @switch($key)
                                    @case('title_id')
                                    {{ \App\Models\EH\Configurations\Title::find($ep->original_data[$key])->title[App::getLocale()]??'NULL' }}
                                    <strong>&nbsp;&nbsp;&nbsp;=>&nbsp;&nbsp;&nbsp;</strong>
                                    {{ \App\Models\EH\Configurations\Title::find($ep->updated_data[$key])->title[App::getLocale()] }}
                                    @break

                                    @case('gender_id')
                                    {{ \App\Models\EH\Configurations\Gender::find($ep->original_data[$key])->gender[App::getLocale()]??'NULL' }}
                                    <strong>&nbsp;&nbsp;&nbsp;=>&nbsp;&nbsp;&nbsp;</strong>
                                    {{ \App\Models\EH\Configurations\Gender::find($ep->updated_data[$key])->gender[App::getLocale()] }}
                                    @break

                                    @case('martial_status_id')
                                    {{ \App\Models\EH\Configurations\MartialStatus::find($ep->original_data[$key])->martial_status[App::getLocale()]??'NULL' }}
                                    <strong>&nbsp;&nbsp;&nbsp;=>&nbsp;&nbsp;&nbsp;</strong>
                                    {{ \App\Models\EH\Configurations\MartialStatus::find($ep->updated_data[$key])->martial_status[App::getLocale()] }}
                                    @break

                                    @case('emergency_contact_person_relationship_id')
                                    {{ \App\Models\EH\Configurations\Relationship::find($ep->original_data[$key])->relationship[App::getLocale()]??'NULL' }}
                                    <strong>&nbsp;&nbsp;&nbsp;=>&nbsp;&nbsp;&nbsp;</strong>
                                    {{ \App\Models\EH\Configurations\Relationship::find($ep->updated_data[$key])->relationship[App::getLocale()] }}
                                    @break

                                    @case('highest_education_id')
                                    {{ \App\Models\EH\Configurations\HighestEducation::find($ep->original_data[$key])->highest_education[App::getLocale()]??'NULL' }}
                                    <strong>&nbsp;&nbsp;&nbsp;=>&nbsp;&nbsp;&nbsp;</strong>
                                    {{ \App\Models\EH\Configurations\HighestEducation::find($ep->updated_data[$key])->highest_education[App::getLocale()] }}
                                    @break

                                    @case('bank_id')
                                    {{ \App\Models\EH\Configurations\Bank::find($ep->original_data[$key])->bank[App::getLocale()]??'NULL' }}
                                    <strong>&nbsp;&nbsp;&nbsp;=>&nbsp;&nbsp;&nbsp;</strong>
                                    {{ \App\Models\EH\Configurations\Bank::find($ep->updated_data[$key])->bank[App::getLocale()] }}
                                    @break

                                    @default
                                    {{ $ep->original_data[$key]??'NULL' }}
                                    <strong>&nbsp;&nbsp;&nbsp;=>&nbsp;&nbsp;&nbsp;</strong>
                                    {{ $ep->updated_data[$key] }}
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

                @php
                    $effective_type = config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE');
                    array_shift($effective_type);
                @endphp
                <x-inputs.radio
                    :label="__('eh/employee/personnel_change/detail.lb_effective_date')"
                    :isReadonly="!$mode['isModeCreate']"
                    value="{{$ep->effective_type ?? ''}}"
                    lang="eh/employee/movement/detail"
                    name="effective_type"
                    :option="config('constants.EMPLOYEE.EFFECTIVE_DATE')"
                    required="true"
                    hidden="{{!$mode['isModeCreate']}}"
                />

                <x-inputs.date
                    label="{{!$mode['isModeCreate']?__('eh/employee/personnel_change/detail.lb_effective_date'):''}}"
                    :isReadonly="!$mode['isModeCreate']"
                    value="{{$ep->effective_date ?? ''}}"
                    name="effective_date"
                    hidden="{{$mode['isModeCreate']}}"
                />

                <x-inputs.textarea
                    :label="__('eh/employee/detail.lb_remarks')"
                    :isReadonly="!$mode['isModeCreate']"
                    value="{{$ep->detail['remarks'] ?? ''}}"
                    name="detail[remarks]"
                />

                @if(!$mode['isModeCreate'])
                    @if($mode['isModeShow'])
                        <div class="form-group">
                            <label class="form-control-label">{{__('eh/employee/personnel_change/detail.lb_status')}}</label>
                            <h5>
                                @switch($ep->status)
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.SUBMITTED'))
                                    <span
                                        class="badge bg-secondary">{{__('eh/employee/personnel_change/detail.lb_status_submitted')}}</span>
                                    @break
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.APPROVED'))
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.APPROVED_UPDATED'))
                                    <span class="badge bg-primary">{{__('eh/employee/personnel_change/detail.lb_status_approved')}}</span>
                                    @break
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.DECLINED'))
                                    <span class="badge bg-danger">{{__('eh/employee/personnel_change/detail.lb_status_declined')}}</span>
                                    @break
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.CANCELED'))
                                    <span class="badge bg-secondary">{{__('eh/employee/personnel_change/detail.lb_status_canceled')}}</span>
                                    @break
                                @endswitch
                            </h5>
                        </div>
                    @elseif($mode['isModeEdit'])
                        <x-inputs.select2
                            :label="__('eh/employee/personnel_change/detail.lb_status')"
                            :isReadonly="!$mode['isModeEdit']"
                            name="status"
                            value="{{$ep->status??''}}"
                        >
                            <option
                                value="{{ config('constants.EMPLOYEE_LOG.STATUS.APPROVED') }}"
                                @if(config('constants.EMPLOYEE_LOG.STATUS.APPROVED')==$ep->status)
                                selected="selected"
                                @endif
                            >{{__('eh/employee/personnel_change/detail.lb_status_approval')}}</option>
                            <option
                                value="{{ config('constants.EMPLOYEE_LOG.STATUS.DECLINED') }}"
                                @if(config('constants.EMPLOYEE_LOG.STATUS.DECLINED')==$ep->status)
                                selected="selected"
                                @endif
                            >{{__('eh/employee/personnel_change/detail.lb_status_decline')}}</option>
                        </x-inputs.select2>
                    @endif
                @endif

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$ep->updated_at" :createdAt="$ep->created_at"/>
                @endif

            </div>

            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('system.user.partial.panel_employee')
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
                var effective_type = {{$ep->effective_type??config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.NOW')}};
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
