{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')

@endsection

{{-- Title --}}
@section('html_title', 'Profile')
@section('page_title', 'Profile')

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">Profile</li>
    @if($mode['isModeEdit'])
        <li class="breadcrumb-item active">Edit</li>
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('system.user.partial.panel_employee')
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if(isset($u->employee->avatar_file['file_path']))
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{route('files',['s'=>Auth::user()->profile->organization->name_slug,'p'=>$u->employee->avatar_file['file_path'].$u->employee->avatar_file['file_name'],'fn'=>$u->employee->avatar_file['file_source_name'],'dl'=>false])}}"
                                 alt="avatar">
                        @else
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{asset('/images/user.jpg')}}"
                                 alt="avatar">
                        @endif
                    </div>

                    <h3 class="profile-username text-center">{{$u->employee->first_name}} {{$u->employee->last_name}}</h3>

                    <p class="text-muted text-center">{{$u->employee->department->name??'-'}}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>{{__('eh/employee/detail.lb_grade')}}</b> <span
                                class="float-right">{{$u->employee->grade->grade[App::getLocale()]??'-'}}</span>
                        </li>
                        <li class="list-group-item">
                            <b>{{__('eh/employee/detail.lb_employee_id')}}</b> <span
                                class="float-right">{{$u->employee->employee_id??'-'}}</span>
                        </li>
                    </ul>
                    <div class="text-center">
                        @php
                            $qrcode = [
                                'uuid' => $u->employee->uuid,
                                'employee_id' => $u->employee->employee_id
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
                        {{$u->employee->updated_a?$u->employee->updated_a->diffForHumans():'N/A'}}
                    </p>

                    <hr>

                    <strong>{{__('common.timestamp_created_at')}}</strong>

                    <p class="text-muted">
                        {{$u->employee->created_at??'N/A'}}
                    </p>

                </div>
            </div>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#personnel"
                                                data-toggle="tab">{{__('eh/employee/detail.card_header_personnel_information')}}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#company"
                                                data-toggle="tab">{{__('eh/employee/detail.card_header_company_information')}}</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="personnel">


                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_employee_id')"
                                :isReadonly="true"
                                value="{{$u->employee->employee_id ?? ''}}"
                                name="employee_id"
                                required="true"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_title')"
                                :isReadonly="true"
                                name="title_id"
                                value="{{$u->employee->title->title[App::getLocale()]??'-'}}"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_first_name')"
                                :isReadonly="true"
                                value="{{$u->employee->first_name ?? ''}}"
                                name="first_name"
                                required="true"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_middle_name')"
                                :isReadonly="true"
                                value="{{$u->employee->middle_name ?? ''}}"
                                name="middle_name"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_last_name')"
                                :isReadonly="true"
                                value="{{$u->employee->last_name ?? ''}}"
                                name="last_name"
                                required="true"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_chinese_name')"
                                :isReadonly="true"
                                value="{{$u->employee->chinese_name ?? ''}}"
                                name="chinese_name"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_alias')"
                                :isReadonly="true"
                                value="{{$u->employee->alias ?? ''}}"
                                name="alias"
                            />

                            <x-inputs.date
                                :label="__('eh/employee/detail.lb_date_of_birth')"
                                :isReadonly="true"
                                value="{{$u->employee->date_of_birth ?? ''}}"
                                name="date_of_birth"
                            />

                            <x-inputs.text
                                type="tel"
                                :label="__('eh/employee/detail.lb_tel')"
                                :isReadonly="true"
                                value="{{$u->employee->tel ?? ''}}"
                                name="tel"
                            />

                            <x-inputs.text
                                type="email"
                                :label="__('eh/employee/detail.lb_email')"
                                :isReadonly="true"
                                value="{{$u->employee->email ?? ''}}"
                                name="email"
                                required="true"
                            />

                            <x-inputs.text
                                type="email"
                                :label="__('eh/employee/detail.lb_personal_email')"
                                :isReadonly="true"
                                value="{{$u->employee->personal_email ?? ''}}"
                                name="personal_email"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_gender')"
                                :isReadonly="true"
                                name="gender_id"
                                value="{{$u->employee->gender->gender[App::getLocale()]??'-'}}"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_martial_status')"
                                :isReadonly="true"
                                name="martial_status_id"
                                value="{{$u->employee->martialStatus->martial_status[App::getLocale()]??'-'}}"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_nationality')"
                                :isReadonly="true"
                                name="nationality_id"
                                value="{{$u->employee->nationality->nationality[App::getLocale()]??'-'}}"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_hkid')"
                                :isReadonly="true"
                                value="{{$u->employee->hkid ?? ''}}"
                                name="hkid"
                            />

                            <x-inputs.file
                                type="multiple"
                                :label="__('eh/employee/detail.lb_hkid_image')"
                                :isReadonly="true"
                                :isEdit="$mode['isModeEdit']"
                                deleteRoute="eh.employee.file_delete"
                                :deleteModelId="$u->employee->uuid ?? ''"
                                :value="$u->employee->hkid_image ?? ''"
                                name="hkid_image[]"
                                fileMax="50000"
                                {{--                    allowedFileExtensions="['jpg','png','gif']"--}}
                                allowedFileTypes="['image']"
                                accept="image/*"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_passport')"
                                :isReadonly="true"
                                value="{{$u->employee->passport ?? ''}}"
                                name="passport"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_address')"
                                :isReadonly="true"
                                value="{{$u->employee->address ?? ''}}"
                                name="address"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_emergency_contact_person')"
                                :isReadonly="true"
                                value="{{$u->employee->emergency_contact_person ?? ''}}"
                                name="emergency_contact_person"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_emergency_contact_person_relationship')"
                                :isReadonly="true"
                                name="emergency_contact_person_relationship_id"
                                value="{{$u->employee->emergencyContactPersonRelationship->relationship[App::getLocale()]??'-'}}"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_emergency_contact')"
                                :isReadonly="true"
                                value="{{$u->employee->emergency_contact ?? ''}}"
                                name="emergency_contact"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_highest_education')"
                                :isReadonly="true"
                                name="highest_education_id"
                                value="{{$u->employee->highestEducation->highest_education[App::getLocale()]??'-'}}"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_bank')"
                                :isReadonly="true"
                                name="bank_id"
                                value="{{$u->employee->bank->bank[App::getLocale()]??'-'}}"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_bank_account')"
                                :isReadonly="true"
                                value="{{$u->employee->bank_account ?? ''}}"
                                name="bank_account"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_bank_account_receiving_name')"
                                :isReadonly="true"
                                value="{{$u->employee->bank_account_receiving_name ?? ''}}"
                                name="bank_account_receiving_name"
                            />

                            <x-inputs.file
                                type="multiple"
                                :label="__('eh/employee/detail.lb_bank_card_image')"
                                :isReadonly="true"
                                :isEdit="false"
                                deleteRoute="eh.employee.file_delete"
                                :deleteModelId="$u->employee->uuid ?? ''"
                                :value="$u->employee->bank_card_image ?? ''"
                                name="bank_card_image[]"
                                fileMax="50000"
                                {{--                    allowedFileExtensions="['jpg','png','gif']"--}}
                                allowedFileTypes="['image']"
                                accept="image/*"
                            />

                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="company">

                            <x-inputs.date
                                :label="__('eh/employee/detail.lb_join_date')"
                                :isReadonly="true"
                                value="{{$u->employee->join_date ?? ''}}"
                                name="join_date"
                                required="true"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_department')"
                                :isReadonly="true"
                                name="department_id"
                                value="{{$u->employee->department->name??'-'}}"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_direct_supervisor')"
                                :isReadonly="true"
                                name="direct_supervisor_id"
                                {{--TODO: should show employee full name or chinese name and avatar--}}
                                value="{{$u->employee->directSupervisor->profile->name??'-'}}"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_designation')"
                                :isReadonly="true"
                                name="designation_id"
                                value="{{$u->employee->designation->name??'-'}}"
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_employee_type')"
                                :isReadonly="true"
                                name="employee_type_id"
                                value="{{$u->employee->employeeType->name??'-'}}"
                            />

                            <x-inputs.date
                                :label="__('eh/employee/detail.lb_probation_end_date')"
                                :isReadonly="true"
                                value="{{$mode['isModeCreate']?date('Y-m-d', strtotime('+3 month')):($u->employee->probation_end_date ?? '')}}"
                                name="probation_end_date"
                            />

                            <x-inputs.file
                                type="multiple"
                                :label="__('eh/employee/detail.lb_support_documents')"
                                :isReadonly="true"
                                :isEdit="$mode['isModeEdit']"
                                deleteRoute="eh.employee.file_delete"
                                :deleteModelId="$u->employee->uuid ?? ''"
                                :value="$u->employee->support_documents??''"
                                name="support_documents[]"
                                fileMax="50000"
                                {{--                    allowedFileExtensions="['jpg','png','gif']"--}}
                                {{--                    allowedFileTypes="['image']"--}}
                                {{--                    accept="image/*"--}}
                            />

                            <x-inputs.text
                                :label="__('eh/employee/detail.lb_grade')"
                                :isReadonly="true"
                                name="grade_id"
                                value="{{$u->employee->grade->grade[App::getLocale()]??'-'}}"
                            />

                            <x-inputs.text
                                type="number"
                                :label="__('eh/employee/detail.lb_salary')"
                                :isReadonly="true"
                                value="{{$u->employee->salary ?? 0}}"
                                name="salary"
                                step="0.01"
                                min="0"
                            />

                            <x-inputs.text
                                type="number"
                                :label="__('eh/employee/detail.lb_annual_leave')"
                                :isReadonly="true"
                                value="{{$u->employee->annual_leave ?? 7}}"
                                name="annual_leave"
                                step="1"
                                min="0"
                                required="true"
                            />

                            <x-inputs.textarea
                                :label="__('eh/employee/detail.lb_remarks')"
                                :isReadonly="true"
                                value="{{$u->employee->remarks ?? ''}}"
                                name="remarks"
                            />


                            @if($mode['isModeShow'])

                                <x-inputs.select2
                                    :label="__('eh/employee/detail.lb_type')"
                                    :isReadonly="$mode['isModeShow']"
                                    name="type"
                                    multiple="true"
                                >
                                    <h5>
                                        @switch($u->employee->type)
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

                            @endif
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
                {{-- Panel --}}
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
