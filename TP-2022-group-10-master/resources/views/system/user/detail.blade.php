{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')

@endsection

{{-- Title --}}
@section('html_title', 'User')
@section('page_title', 'User')

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">System</li>
    <li class="breadcrumb-item"><a href="{{ route('system.user.index') }}">User</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">Create</li>
    @else
        <li class="breadcrumb-item active">{{ $u->profile->name ?? '-' }}</li>
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">Edit</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('system.user.partial.panel_detail')
            </div>
        </div>
    @endif

    <form id="v_form" class="block form-horizontal form-label-left"
          action="@if(!$mode['isModeEdit']){{ route('system.user.store') }}@elseif($mode['isModeEdit']){{ route('system.user.update',$u->id) }}@endif"
          method="post">
        {{--        todo update input component--}}
        <div class="card">
            <!-- form start -->
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">
                @if($mode['isModeShow'])
                    @role(config('constants.ROLE.SUPER_ADMIN'))
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">ID</label>
                        <div class="col-sm-9">
                            <input
                                    id="id_id"
                                    name="id"
                                    type="text"
                                    class="form-control"
                                    value="{{ old("name", isset($u->id) ? $u->id : null) }}"
                                    readonly="readonly"
                            >
                        </div>
                    </div>
                    @endrole
                @endif
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Name</label>
                    <div class="col-sm-9">
                        <input
                                id="id_name"
                                name="name"
                                type="text"
                                class="form-control"
                                value="{{ old("name", isset($u->profile->name) ? $u->profile->name : null) }}"
                                @if($mode['isModeShow'])readonly="readonly" @endif
                        >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Email</label>
                    <div class="col-sm-9">
                        <input
                                id="id_email"
                                name="email"
                                type="email"
                                class="form-control"
                                value="{{ old("email", isset($u->email) ? $u->email : null) }}"
                                @if($mode['isModeShow'])readonly="readonly" @endif
                        >
                    </div>
                </div>

                @if($mode['isModeCreate'])
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Password</label>
                        <div class="col-sm-9">
                            <input type="text" id="password" name="password"
                                   class="form-control {{ $errors->has('password') ? 'has-error' : '' }}"
                                   value="{{ Str::random('8') }}" required>
                        </div>
                    </div>
                @endif

                {{-- Timestamp Panel --}}
                @can(config("constants.PERMISSION.INTERNAL-DATA"))
                    @if($mode['isModeShow'])
                        @include('system.user.partial.timestamp_detail')
                    @endif
                @endcan
            </div>
            <!-- /.card-body -->

        </div>

        <div class="card">
            <div class="card-header">
                Profile
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Avatar</label>
                    <div class="col-sm-9">
                        <input
                                id="id_avatar"
                                name="avatar"
                                type="text"
                                class="form-control"
                                value="{{ old("avatar", isset($u->profile->avatar) ? $u->profile->avatar : null) }}"
                                @if($mode['isModeShow'])readonly="readonly" @endif
                        >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Contacts</label>
                    <div class="col-sm-9">
                        <input
                                id="id_contacts"
                                name="contacts"
                                type="text"
                                class="form-control"
                                value="{{ old("contacts", isset($u->profile->contacts) ? $u->profile->contacts : null) }}"
                                @if($mode['isModeShow'])readonly="readonly" @endif
                        >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Address</label>
                    <div class="col-sm-9">
                        <input
                                id="id_address"
                                name="address"
                                type="text"
                                class="form-control"
                                value="{{ old("address", isset($u->profile->address) ? $u->profile->address : null) }}"
                                @if($mode['isModeShow'])readonly="readonly" @endif
                        >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">DOB</label>
                    <div class="col-sm-9">
                        <div class="input-group date" id="id_dob" data-target-input="nearest">
                            <input type="text" name="dob" class="form-control datetimepicker-input"
                                   data-target="#reservationdate" placeholder="YYYY-MM-DD"
                                   value="@if($mode['isModeCreate']){{ date("Y-m-d") }}@else{{ old("dob", isset($u->profile->dob) ? $u->profile->dob : null) }}@endif"
                                   @if($mode['isModeShow'])readonly="readonly"@endif/>
                            <div class="input-group-append" data-target="#id_dob" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Status</label>
                    <div class="col-sm-9">
                        <input type="checkbox" id="id_status" name="status" data-bootstrap-switch
                               data-on-text="Allow" data-off-text="Refuse" data-off-color="danger"
                               @if($mode['isModeShow']) readonly
                               @endif @if(!$mode['isModeCreate']) @if($u->profile->status??false) checked @endif @endif>
                    </div>
                </div>
            </div>
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('system.user.partial.panel_detail')
                </div>
                <!-- /.card-footer -->
            @endif
        </div>
    </form>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('system.user.partial.script_datepicker')
    @include('system.user.partial.script_validation')
    @include('layouts.adminlte_3.components.form.script_switch')
@endpush
