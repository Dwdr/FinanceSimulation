{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_held_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/employee/detail.title_html'))
@section('page_title', __('eh/employee/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/employee/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">
        <a href="{{route('eh.employee.index')}}">
            {{ __('eh/employee/detail.breadcrumb_level_2') }}
        </a>
    </li>

    @if($mode['isModeCreate']||$mode['isModeClone'])
        <li class="breadcrumb-item active">{{ __('eh/employee/detail.breadcrumb_create') }}</li>
    @else
        <li class="breadcrumb-item active">{{ $e->employee_id }}</li>
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ __('eh/employee/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @include('eh.employee.detail.panel')
                    </div>
                </div>
            </div>
            @if(Auth::user()->employee->uuid!=$e->uuid)
                @if($mode['isModeShow'])
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                @if($e->type == config('constants.EMPLOYEE.TYPE.RESIGNED')||isset($e->termination->hash_id))
                                    <a href="{{ route('eh.employee.termination.show', ['uuid'=>$e->uuid,'hash_id'=>$e->termination->hash_id]) }}"
                                       class="btn btn-danger text-right">{{ __('eh/employee/detail_panel.btn_termination') }}
                                        @if($e->type != config('constants.EMPLOYEE.TYPE.RESIGNED'))
                                            <span class="badge bg-white"><i class="fas fa-clock text-gray"></i></span>
                                        @endif
                                    </a>
                                @else
                                    <a href="{{ route('eh.employee.termination.create', $e->uuid) }}"
                                       class="btn btn-danger text-right">{{ __('eh/employee/detail_panel.btn_termination') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    @endif

    {{-- Form --}}
    <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
          action="@if(!$mode['isModeEdit']){{route('eh.employee.store')}}@elseif($mode['isModeEdit']){{route('eh.employee.update', $e->uuid)}}@endif"
          method="post">
        @if($mode['isModeEdit'])
            {{method_field('put')}}
        @endif

        <div class="row">
            <div class="col-md-3">
            @if($mode['isModeShow'])
                <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if(isset($e->avatar_file['file_path']))
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{route('files',['s'=>Auth::user()->profile->organization->name_slug,'p'=>$e->avatar_file['file_path'].$e->avatar_file['file_name'],'fn'=>$e->avatar_file['file_source_name'],'dl'=>false])}}"
                                         alt="avatar">
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{asset('/images/user.jpg')}}"
                                         alt="avatar">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{$e->first_name}} {{$e->last_name}}</h3>

                            <p class="text-muted text-center">{{$e->department->name??'-'}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b> {{--TODO --}} is active? </b> <span
                                        class="float-right">{{$e->user->is_active}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>{{__('eh/employee/detail.lb_grade')}}</b> <span
                                        class="float-right">{{$e->grade->grade[App::getLocale()]??'-'}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>{{__('eh/employee/detail.lb_employee_id')}}</b> <span
                                        class="float-right">{{$e->employee_id??'-'}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>{{__('eh/employee/detail.lb_is_active')}}</b>
                                    @switch($e->user->is_active)
                                        @case(true)
                                        <span class="badge rounded-pill bg-success float-right">{{__('eh/employee/detail.lb_is_active_enable')}}</span>
                                        @break
                                        @case(false)
                                        <span class="badge rounded-pill bg-danger float-right">{{__('eh/employee/detail.lb_is_active_disable')}}</span>
                                        @break
                                    @endswitch

                                </li>
                            </ul>
                            <div class="text-center">
                                @php
                                    $qrcode = [
                                        'uuid' => $e->uuid,
                                        'employee_id' => $e->employee_id
                                    ];
                                    $qrcode = json_encode($qrcode);
                                @endphp
                                <img src="https://chart.googleapis.com/chart?cht=qr&chs=180x180&choe=UTF-8&chld=L|2&chl={{$qrcode}}"
                                     alt="employee qrcode"/>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    {{-- Timestamp Panel --}}
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong>{{__('common.timestamp_last_update')}}</strong>

                            <p class="text-muted">
                                {{$e->updated_a?$e->updated_a->diffForHumans():'N/A'}}
                            </p>

                            <hr>

                            <strong>{{__('common.timestamp_created_at')}}</strong>

                            <p class="text-muted">
                                {{$e->created_at??'N/A'}}
                            </p>

                        </div>
                    </div>
                @else
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Avatar</h3>
                        </div>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <label class="label" data-toggle="tooltip" title="{{__('common.change-picture')}}">
                                    @if(isset($e->avatar_file['file_path']))
                                        <img
                                            src="{{route('files',['s'=>Auth::user()->profile->organization->name_slug,'p'=>$e->avatar_file['file_path'].$e->avatar_file['file_name'],'fn'=>$e->avatar_file['file_source_name'],'dl'=>false])}}"
                                            id="image"
                                            class="profile-user-img img-fluid img-circle"/>
                                    @else
                                        <img src="{{asset('/images/user.jpg')}}" id="image"
                                             class="profile-user-img img-fluid img-circle">
                                    @endif
                                    <input type="file" class="sr-only" id="avatar" name="avatar" accept="image/*">

                                    <input type="hidden" id="file_name" name="file_name">
                                    <input type="hidden" id="file_source_name" name="file_source_name">
                                    <input type="hidden" id="file_path" name="file_path">
                                    <input type="hidden" id="file_size" name="file_size">
                                    <input type="hidden" id="file_type" name="file_type">
                                    <input type="hidden" id="file_extension" name="file_extension">
                                </label>
                                <div class="progress" style="display: none; max-width: 256px">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                         role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                                    </div>
                                </div>
                            </div>
                            @if($mode['isModeEdit'])
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <x-inputs.switch2
                                        label="{{ __('eh/employee/detail.lb_is_active') }}"
                                        :isReadonly="$mode['isModeShow']"
                                        value="{{$e->user->is_active ?? true}}"
                                        name="is_active"
                                        onText="{{__('eh/employee/detail.lb_is_active_enable')}}"
                                        offText="{{__('eh/employee/detail.lb_is_active_disable')}}"
                                    />
                                </li>
                            </ul>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                @endif

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#personnel_tab" id="personnel_tab_link"
                                   data-toggle="tab">{{__('eh/employee/detail.card_header_personnel_information')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#company_tab" id="company_tab_link"
                                   data-toggle="tab">{{__('eh/employee/detail.card_header_company_information')}}</a></li>
                            @if($mode['isModeShow'])
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_package" id="tab_package_link"
                                       data-toggle="tab">{{__('eh/employee/detail.card_header_package')}}</a></li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_movement" id="tab_movement_link"
                                       data-toggle="tab">{{__('eh/employee/detail.card_header_movement')}}</a></li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_leave_records" id="tab_leave_records_link"
                                       data-toggle="tab">{{__('eh/employee/detail.card_header_leave')}}</a></li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_log_timeline" id="tab_log_timeline_link"
                                       data-toggle="tab">{{__('eh/employee/detail.card_header_log')}}</a></li>
                            @endif
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- personal-pane -->
                            <div class="active tab-pane" id="personnel_tab">
                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_employee_id')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->employee_id ?? ''}}"
                                    name="employee_id"
                                    required="true"
                                />

                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_title')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="title_id"
                                    value="{{$e->title->title[App::getLocale()]??'-'}}"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($titles as $t)
                                            <option
                                                value="{{ $t->id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($t->id===$e->title_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $t->title[App::getLocale()] }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>

                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_first_name')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->first_name ?? ''}}"
                                    name="first_name"
                                    required="true"
                                />

                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_middle_name')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->middle_name ?? ''}}"
                                    name="middle_name"
                                />

                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_last_name')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->last_name ?? ''}}"
                                    name="last_name"
                                    required="true"
                                />

                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_chinese_name')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->chinese_name ?? ''}}"
                                    name="chinese_name"
                                />

                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_alias')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->alias ?? ''}}"
                                    name="alias"
                                />

                                <x-inputs.date
                                    :label="__('eh/employee/detail.lb_date_of_birth')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->date_of_birth ?? ''}}"
                                    name="date_of_birth"
                                />

                                <x-inputs.text
                                    type="tel"
                                    :label="__('eh/employee/detail.lb_tel')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->tel ?? ''}}"
                                    name="tel"
                                />

                                <x-inputs.text
                                    type="email"
                                    :label="__('eh/employee/detail.lb_email')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->email ?? ''}}"
                                    name="email"
                                    required="true"
                                />

                                <x-inputs.text
                                    type="email"
                                    :label="__('eh/employee/detail.lb_personal_email')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->personal_email ?? ''}}"
                                    name="personal_email"
                                />

                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_gender')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="gender_id"
                                    value="{{$e->gender->gender[App::getLocale()]??'-'}}"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($genders as $g)
                                            <option
                                                value="{{ $g->id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($g->id===$e->gender_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $g->gender[App::getLocale()] }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>

                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_martial_status')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="martial_status_id"
                                    value="{{$e->martialStatus->martial_status[App::getLocale()]??'-'}}"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($martial_status as $m)
                                            <option
                                                value="{{ $m->id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($m->id===$e->martial_status_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $m->martial_status[App::getLocale()] }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>

                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_nationality')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="nationality_id"
                                    value="{{$e->nationality->nationality[App::getLocale()]??'-'}}"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($nationalities as $n)
                                            <option
                                                value="{{ $m->id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($n->id===$e->nationality_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $n->nationality[App::getLocale()] }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>

                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_hkid')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->hkid ?? ''}}"
                                    name="hkid"
                                />

                                <x-inputs.file
                                    type="multiple"
                                    :label="__('eh/employee/detail.lb_hkid_image')"
                                    :isReadonly="$mode['isModeShow']"
                                    :isEdit="$mode['isModeEdit']"
                                    deleteRoute="eh.employee.file_delete"
                                    :deleteModelId="$e->uuid ?? ''"
                                    :value="$e->hkid_image ?? ''"
                                    name="hkid_image[]"
                                    fileMax="50000"
                                    {{--                    allowedFileExtensions="['jpg','png','gif']"--}}
                                    allowedFileTypes="['image']"
                                    accept="image/*"
                                />
                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_passport')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->passport ?? ''}}"
                                    name="passport"
                                />
                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_address')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->address ?? ''}}"
                                    name="address"
                                />
                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_emergency_contact_person')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->emergency_contact_person ?? ''}}"
                                    name="emergency_contact_person"
                                />
                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_emergency_contact_person_relationship')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="emergency_contact_person_relationship_id"
                                    value="{{$e->emergencyContactPersonRelationship->relationship[App::getLocale()]??'-'}}"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($relationships as $r)
                                            <option
                                                value="{{ $r->id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($r->id===$e->emergency_contact_person_relationship_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $r->relationship[App::getLocale()] }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>
                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_emergency_contact')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->emergency_contact ?? ''}}"
                                    name="emergency_contact"
                                />
                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_highest_education')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="highest_education_id"
                                    value="{{$e->highestEducation->highest_education[App::getLocale()]??'-'}}"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($highest_educations as $he)
                                            <option
                                                value="{{ $he->id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($he->id===$e->highest_education_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $he->highest_education[App::getLocale()] }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>

                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_bank')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="bank_id"
                                    value="{{$e->bank->bank[App::getLocale()]??'-'}}"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($banks as $b)
                                            <option
                                                value="{{ $b->id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($b->id===$e->bank_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $b->code.' - '.$b->bank[App::getLocale()] }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>

                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_bank_account')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->bank_account ?? ''}}"
                                    name="bank_account"
                                />
                                <x-inputs.text
                                    :label="__('eh/employee/detail.lb_bank_account_receiving_name')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->bank_account_receiving_name ?? ''}}"
                                    name="bank_account_receiving_name"
                                />
                                <x-inputs.file
                                    type="multiple"
                                    :label="__('eh/employee/detail.lb_bank_card_image')"
                                    :isReadonly="$mode['isModeShow']"
                                    :isEdit="$mode['isModeEdit']"
                                    deleteRoute="eh.employee.file_delete"
                                    :deleteModelId="$e->uuid ?? ''"
                                    :value="$e->bank_card_image ?? ''"
                                    name="bank_card_image[]"
                                    fileMax="50000"
                                    {{--                    allowedFileExtensions="['jpg','png','gif']"--}}
                                    allowedFileTypes="['image']"
                                    accept="image/*"
                                />
                            </div>
                            <div class="tab-pane" id="company_tab">
                                <x-inputs.date
                                    :label="__('eh/employee/detail.lb_join_date')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->join_date ?? ''}}"
                                    name="join_date"
                                    required="true"
                                />
                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_department')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="department_id"
                                    :value="$e->department->name??'-'"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($departments as $d)
                                            <option
                                                value="{{ $d->id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($d->id===$e->department_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $d->name }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>

                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_direct_supervisor')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="direct_supervisor_id"
                                    {{--TODO: should show employee full name or chinese name and avatar--}}
                                    :value="$e->directSupervisor->profile->name??'-'"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($employees as $ds)
                                            <option
                                                value="{{ $ds->user_id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($ds->user->id===$e->direct_supervisor_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $ds->first_name.' '.$ds->middle_name.' '.$ds->last_name }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>

                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_designation')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="designation_id"
                                    :value="$e->designation->name??'-'"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($designations as $d)
                                            <option
                                                value="{{ $d->id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($d->id===$e->designation_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $d->name }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>

                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_employee_type')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="employee_type_id"
                                    value="{{$e->employeeType->name??'-'}}"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($employee_types as $et)
                                            <option
                                                value="{{ $et->id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($et->id===$e->employee_type_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $et->name }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>

                                <x-inputs.date
                                    :label="__('eh/employee/detail.lb_probation_end_date')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$mode['isModeCreate']?date('Y-m-d', strtotime('+3 month')):($e->probation_end_date ?? '')}}"
                                    name="probation_end_date"
                                />

                                <x-inputs.file
                                    type="multiple"
                                    :label="__('eh/employee/detail.lb_support_documents')"
                                    :isReadonly="$mode['isModeShow']"
                                    :isEdit="$mode['isModeEdit']"
                                    deleteRoute="eh.employee.file_delete"
                                    :deleteModelId="$e->uuid ?? ''"
                                    :value="$e->support_documents??''"
                                    name="support_documents[]"
                                    fileMax="50000"
                                    {{--                    allowedFileExtensions="['jpg','png','gif']"--}}
                                    {{--                    allowedFileTypes="['image']"--}}
                                    {{--                    accept="image/*"--}}
                                />

                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_grade')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="grade_id"
                                    value="{{$e->grade->grade[App::getLocale()]??'-'}}"
                                >
                                    @if(!$mode['isModeShow'])
                                        @foreach($grades as $g)
                                            <option
                                                value="{{ $g->id }}"
                                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                                @if($g->id===$e->grade_id)
                                                selected="selected"
                                                @endif
                                                @endif
                                            >{{ $g->grade[App::getLocale()] }}</option>
                                        @endforeach
                                    @endif
                                </x-inputs.select2>

                                <x-inputs.text
                                    type="number"
                                    :label="__('eh/employee/detail.lb_salary')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->salary ?? 0}}"
                                    name="salary"
                                    step="0.01"
                                    min="0"
                                />

                                <x-inputs.text
                                    type="number"
                                    :label="__('eh/employee/detail.lb_annual_leave')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->annual_leave ?? 7}}"
                                    name="annual_leave"
                                    step="1"
                                    min="0"
                                    required="true"
                                />

                                <x-inputs.textarea
                                    :label="__('eh/employee/detail.lb_remarks')"
                                    :isReadonly="$mode['isModeShow']"
                                    value="{{$e->remarks ?? ''}}"
                                    name="remarks"
                                />


                                @if($mode['isModeEdit'])
                                    <x-inputs.textarea
                                        :label="__('eh/employee/detail.lb_edit_reason')"
                                        :isReadonly="$mode['isModeShow']"
                                        name="edit_reason"
                                        required="true"
                                    />
                                @endif

                                @if($mode['isModeShow'])

                                    <x-inputs.select2
                                        :label="__('eh/employee/detail.lb_type')"
                                        :isReadonly="$mode['isModeShow']"
                                        name="type"
                                        multiple="true"
                                    >
                                        <h5>
                                            @switch($e->type)
                                                @case(config('constants.EMPLOYEE.TYPE.TRIAL'))
                                                <span
                                                    class="badge bg-warning">{{ __('eh/employee/detail.config_constants_EMPLOYEE_TYPE_TRIAL') }}</span>
                                                @break
                                                @case(config('constants.EMPLOYEE.TYPE.REGULAR'))
                                                <span
                                                    class="badge bg-primary">{{ __('eh/employee/detail.config_constants_EMPLOYEE_TYPE_REGULAR') }}</span>
                                                @break
                                                @case(config('constants.EMPLOYEE.TYPE.RESIGNED'))
                                                <span
                                                    class="badge bg-dark">{{ __('eh/employee/detail.config_constants_EMPLOYEE_TYPE_RESIGNED') }}</span>
                                                @break
                                                @default
                                                <span
                                                    class="badge bg-secondary">{{ __('eh/employee/detail.config_constants_EMPLOYEE_TYPE_UNKNOWN') }}</span>
                                                @break
                                            @endswitch
                                        </h5>
                                    </x-inputs.select2>

                                    {{-- User Role Panel --}}
                                    <x-inputs.text
                                        :label="__('eh/employee/detail.lb_role')"
                                        :isReadonly="$mode['isModeShow']"
                                        value="{{$e->user->getRoleNames()[0] ?? ''}}"
                                        name="role"
                                    />
                                @endif
                            </div>
                            @if($mode['isModeShow'])
                                {{-- TODO change livewire component, employee, movement, leave application,  other  --}}
                                <div class="tab-pane" id="tab_package">
                                    @can(config("constants.PERMISSION.EH-EMPLOYEE-MOVEMENT-C"))
                                        @if($e->type != config('constants.EMPLOYEE.TYPE.RESIGNED')||!isset($e->termination->hash_id))
                                            <a href="{{ route('eh.employee.package.create',$e->uuid) }}"
                                               class="btn cur-p btn-primary mb-3">{{ __('eh/employee/package/index_panel.btn_create') }}</a>
                                        @endif
                                    @endcan

                                    <div class="table-responsive">
                                        <table id="packageDataTable" style="width: 100%;" class="table dataTable no-footer" role="grid"
                                               aria-describedby="datatable1_info"
                                               data-turbolinks="false">
                                            <thead>
                                            <tr role="row">
                                                <th>{{ __('eh/employee/package/index.th_datetime') }}</th>
                                                <th>{{ __('eh/employee/package/index.th_basic_salary') }}</th>
                                                <th>
                                                    {{ __('eh/employee/package/index.th_mpf') }}
                                                    <span data-toggle="tooltip" title="CC:Company Compulsory, CV:Company Voluntary, SC:Staff Compulsory, SV:Staff Voluntary"
                                                          class="badge bg-info">?</span>
                                                </th>
                                                <th>{{ __('eh/employee/package/index.th_status') }}</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>{{ __('eh/employee/package/index.th_datetime') }}</th>
                                                <th>{{ __('eh/employee/package/index.th_basic_salary') }}</th>
                                                <th>{{ __('eh/employee/package/index.th_mpf') }}</th>
                                                <th>{{ __('eh/employee/package/index.th_status') }}</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach($e->package as $p)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('eh.employee.package.show',['uuid'=>$e->uuid,'hash_id'=>$p->hash_id]) }}">
                                                            {{ $p->effective_date??'-' }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('eh.employee.package.show',['uuid'=>$e->uuid,'hash_id'=>$p->hash_id]) }}">
                                                            ${{ $p->detail['basic_salary']??'-' }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">CC:{{ $p->detail['mpf_employer_compulsory']??'-' }}</span>
                                                        <span class="badge bg-secondary">CV:{{ $p->detail['mpf_employer_voluntary']??'-' }}</span>
                                                        <span class="badge bg-info">SC:{{ $p->detail['mpf_employee_compulsory']??'-' }}</span>
                                                        <span class="badge bg-info">SV:{{ $p->detail['mpf_employee_voluntary']??'-' }}</span>
                                                    </td>
                                                    <td>
                                                        @switch($p->status)
                                                            @case(config('constants.EMPLOYEE_LOG.STATUS.PENDING'))
                                                            <span class="badge bg-secondary">{{__('eh/employee/movement/detail.lb_status_pending')}}</span>
                                                            @break
                                                            @case(config('constants.EMPLOYEE_LOG.STATUS.APPROVED'))
                                                            <span class="badge bg-success">{{__('eh/employee/movement/detail.lb_status_approved')}}</span>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                    {{--                        <td>--}}
                                                    {{--                            @can(config("constants.PERMISSION.EH-EMPLOYEE-U"))--}}
                                                    {{--                                <a href="{{ route('eh.employee.movement.edit',['uuid'=>$e->uuid,'movement_uuid'=>$m->uuid]) }}"><i class="fas fa-edit"></i></a>--}}
                                                    {{--                            @endcan--}}
                                                    {{--                        </td>--}}
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                    <!-- Time line for Package -->
                                    {{--                                    <div class="timeline timeline-inverse">--}}
                                    {{--                                    @foreach($e->package as $p)--}}
                                    {{--                                        <!-- timeline time label -->--}}
                                    {{--                                            <div class="time-label">--}}
                                    {{--                                                <span class="bg-success">{{ $p['effective_date'] }}</span>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <!-- /.timeline-label -->--}}
                                    {{--                                            <!-- timeline item -->--}}
                                    {{--                                            <div>--}}
                                    {{--                                                <i class="fas fa-user bg-success"></i>--}}
                                    {{--                                                <div class="timeline-item">--}}
                                    {{--                                                    <h3 class="timeline-header">--}}
                                    {{--                                                        <strong class="text-primary">Package</strong>--}}
                                    {{--                                                    </h3>--}}
                                    {{--                                                    <div class="timeline-body">--}}
                                    {{--                                                        basic_salary: {{ $p['detail']['basic_salary'] }}<br>--}}
                                    {{--                                                        mpf_employer_compulsory: {{ $p['detail']['mpf_employer_compulsory'] }}<br>--}}
                                    {{--                                                        mpf_employer_voluntary: {{ $p['detail']['mpf_employer_voluntary'] }}<br>--}}
                                    {{--                                                        mpf_employee_compulsory: {{ $p['detail']['mpf_employee_compulsory'] }}<br>--}}
                                    {{--                                                        mpf_employee_voluntary: {{ $p['detail']['mpf_employee_voluntary'] }}<br>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                    @endforeach--}}

                                    {{--                                    <!-- END timeline item -->--}}
                                    {{--                                        <div>--}}
                                    {{--                                            <i class="fas fa-clock bg-gray"></i>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}

                                </div>
                                <div class="tab-pane" id="tab_movement">
                                    @can(config("constants.PERMISSION.EH-EMPLOYEE-MOVEMENT-C"))
                                        @if($e->type != config('constants.EMPLOYEE.TYPE.RESIGNED')||!isset($e->termination->hash_id))
                                            <a href="{{ route('eh.employee.movement.create',$e->uuid) }}"
                                               class="btn cur-p btn-primary mb-3">{{ __('eh/employee/movement/index_panel.btn_create') }}</a>
                                        @endif
                                    @endcan
                                    <div class="table-responsive">
                                        <table id="movementDataTable" style="width: 100%;" class="table dataTable no-footer" role="grid"
                                               aria-describedby="datatable1_info"
                                               data-turbolinks="false">
                                            <thead>
                                            <tr role="row">
                                                <th>{{ __('eh/employee/movement/index.th_date') }}</th>
                                                <th>{{ __('eh/employee/movement/index.th_employee') }}</th>
                                                <th>{{ __('eh/employee/movement/index.th_effective_date') }}</th>
                                                <th>{{ __('eh/employee/movement/index.th_status') }}</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>{{ __('eh/employee/movement/index.th_date') }}</th>
                                                <th>{{ __('eh/employee/movement/index.th_employee') }}</th>
                                                <th>{{ __('eh/employee/movement/index.th_effective_date') }}</th>
                                                <th>{{ __('eh/employee/movement/index.th_status') }}</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach($e->employeeMovement as $m)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('eh.employee.movement.show',['uuid'=>$e->uuid,'hash_id'=>$m->hash_id]) }}">
                                                            {{ $m->created_at }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('eh.employee.movement.show',['uuid'=>$e->uuid,'hash_id'=>$m->hash_id]) }}">
                                                            {{ $m->employee->first_name }} {{ $m->employee->last_name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('eh.employee.movement.show',['uuid'=>$e->uuid,'hash_id'=>$m->hash_id]) }}">
                                                            {{ $m->effective_date??'-' }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('eh.employee.movement.show',['uuid'=>$e->uuid,'hash_id'=>$m->hash_id]) }}">
                                                            @switch($m->status)
                                                                @case(config('constants.EMPLOYEE_LOG.STATUS.PENDING'))
                                                                <span
                                                                    class="badge bg-secondary">{{__('eh/employee/movement/detail.lb_status_pending')}}</span>
                                                                @break
                                                                @case(config('constants.EMPLOYEE_LOG.STATUS.APPROVED'))
                                                                <span
                                                                    class="badge bg-success">{{__('eh/employee/movement/detail.lb_status_approved')}}</span>
                                                                @break
                                                            @endswitch
                                                        </a>
                                                    </td>
                                                    {{--                                                                            <td>--}}
                                                    {{--                                                                                @can(config("constants.PERMISSION.EH-EMPLOYEE-U"))--}}
                                                    {{--                                                                                    <a href="{{ route('eh.employee.movement.edit',['uuid'=>$e->uuid,'movement_uuid'=>$m->uuid]) }}"><i class="fas fa-edit"></i></a>--}}
                                                    {{--                                                                                @endcan--}}
                                                    {{--                                                                            </td>--}}
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_leave_records">
                                    <div class="timeline timeline-inverse">
                                        @if(sizeof($e->leave_application)>0)
                                            @foreach($e->leave_application as $la)
                                                <div class="time-label">
                                                    <span class="bg-primary">{{ $la['period_start'] }}</span>
                                                </div>
                                                <div>
                                                    <i class="fas fa-flag bg-primary"></i>
                                                    <div class="timeline-item">
                                                        <div class="timeline-body">
                                                            [{{ $la->leaveType->name??'-' }}] From: {{ $la->period_start??'-' }} To: {{ $la->period_end??'-' }}<br>
                                                            Reason: {{ $la->title??'-' }}<br>
                                                            Status: {{ $la->status??'-' }}<br> {{-- TODO mapping --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div>
                                                <i class="fas fa-clock bg-gray"></i>
                                            </div>
                                        @else
                                            <div class="callout callout-info">
                                                <p>{{__('eh/employee/detail.msg_no_any_record')}}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_log_timeline">
                                    <div class="timeline timeline-inverse">
                                        @if(sizeof($log)>0)
                                            @foreach($log as $date => $values)
                                                <div class="time-label">
                                                    <span class="bg-success">{{$date}}</span>
                                                </div>
                                                @foreach($values as $v)
                                                    <div>
                                                        @switch($v->event)
                                                            @case(config('constants.EMPLOYEE_LOG.EVENT.CREATED'))
                                                            <i class="fas fa-plus bg-success"></i>
                                                            @break
                                                            @case(config('constants.EMPLOYEE_LOG.EVENT.UPDATED'))
                                                            <i class="fas fa-pen bg-blue"></i>
                                                            @break
                                                            @case(config('constants.EMPLOYEE_LOG.EVENT.DELETED'))
                                                            <i class="fas fa-minus bg-danger"></i>
                                                            @break
                                                        @endswitch
                                                        <div class="timeline-item">
                                                            {{--                                                        <h3 class="timeline-header">--}}
                                                            {{-- TODO JL Question must be the same person?? --}}
                                                            {{--                                                            @if($v->creator->hasRole(config('constants.ROLE.SUPER_ADMIN')))--}}
                                                            {{--                                                                <strong class="text-primary">{{$v->creator->profile->name}}</strong>--}}
                                                            {{--                                                            @else--}}
                                                            {{--                                                                <a href="{{route('eh.employee.show',$v->creator->employee->uuid)}}">{{$v->creator->employee->first_name.' '.$v->creator->employee->last_name}}</a>--}}
                                                            {{--                                                            @endif--}}
                                                            {{--                                                        </h3>--}}

                                                            <div class="timeline-body">
                                                                {{$v->created_at->format('H:i')}}
                                                                #{{ $v->hash_id }}
                                                                Action:{{'['.array_search($v->type, config('constants.EMPLOYEE_LOG.TYPE')).'] '.array_search($v->event, config('constants.EMPLOYEE_LOG.EVENT'))}}
                                                                Description:{{$v->description??'n/a'}}
                                                                <a style="text-decoration: underline;" href="{{route('eh.employee.log.show',$v->hash_id)}}">[Read raw data]</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                            <div>
                                                <i class="fas fa-clock bg-gray"></i>
                                            </div>
                                        @else
                                            <div class="callout callout-info">
                                                <p>{{__('eh/employee/detail.msg_no_any_record')}}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                    {{-- Panel --}}
                    @if(!$mode['isModeShow'])
                        <div class="card-footer">
                            @include('eh.employee.detail.panel')
                        </div>
                    @endif
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </form>
@endsection

@section('control_sidebar')
    @include('eh.employee.control_sidebar')
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @if(!$mode['isModeShow'])
        @include('eh.employee.detail.script_cropper')
    @else
        @include('eh.employee.detail.script_table')

        <script>
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            if (urlParams.has('tab')) {
                const tab = urlParams.get('tab');
                $('#personnel_tab').removeClass('show');
                $('#personnel_tab').removeClass('active');
                $('#personnel_tab_link').removeClass('active');
                switch (tab) {
                    case 'movement':
                        $('#tab_movement').addClass('show');
                        $('#tab_movement').addClass('active');
                        $('#tab_movement_link').addClass('active');
                        break;
                    case 'timeline':
                        $('#tab_log_timeline').addClass('show');
                        $('#tab_log_timeline').addClass('active');
                        $('#tab_log_timeline_link').addClass('active');
                        break;
                    case 'package':
                        $('#tab_package').addClass('show');
                        $('#tab_package').addClass('active');
                        $('#tab_package_link').addClass('active');
                        break;
                    default:
                        $('#personnel_tab').addClass('show');
                        $('#personnel_tab').addClass('active');
                        $('#personnel_tab_link').addClass('active');
                        break;
                }
            }
        </script>
    @endif
@endpush
