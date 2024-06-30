{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_ssc')

@section('html_head_style')

@endsection

{{-- Title --}}
@section('html_title', 'Profile')
@section('page_title', 'Profile')

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">Profile</li>
    @if ($mode['isModeEdit'])
        <li class="breadcrumb-item active">Edit</li>
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if ($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('system.user.partial.panel_profile')
            </div>
        </div>
    @endif

    <form id="v_form" class="block form-horizontal form-label-left"
        action="@if ($mode['isModeEdit']) {{ route('profile.update') }} @endif" method="post">
        {{--        todo update input component --}}
        <div class="card">
            <!-- form start -->
            @if ($mode['isModeEdit'])
                {{ method_field('put') }}
            @endif
            <div class="card-body">
                @if ($mode['isModeShow'])
                    @role(config('constants.ROLE.SUPER_ADMIN'))
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">ID</label>
                            <div class="col-sm-9">
                                <input id="id_id" name="id" type="text" class="form-control"
                                    value="{{ old('name', isset($u->id) ? $u->id : null) }}" readonly="readonly">
                            </div>
                        </div>
                    @endrole
                @endif
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Name</label>
                    <div class="col-sm-9">
                        <input id="id_name" name="name" type="text" class="form-control"
                            value="{{ old('name', isset($u->profile->name) ? $u->profile->name : null) }}"
                            @if ($mode['isModeShow']) readonly="readonly" @endif>
                    </div>
                </div>
                @if ($mode['isModeShow'])
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Email</label>
                        <div class="col-sm-9">
                            <input id="id_email" name="email" type="email" class="form-control"
                                value="{{ old('email', isset($u->email) ? $u->email : null) }}"
                                @if ($mode['isModeShow']) readonly="readonly" @endif>
                        </div>
                    </div>
                @endif

                {{-- Timestamp Panel --}}
                {{--                @can('profile.u') --}}
                {{--                    @if ($mode['isModeShow']) --}}
                {{--                        @include('system.user.partial.timestamp_detail') --}}
                {{--                    @endif --}}
                {{--                @endcan --}}
            </div>
            <!-- /.card-body -->

        </div>

        @if ($mode['isModeShow'])
            @hasanyrole('cs-admin|cs-teacher')
            @else
                <div class="card">
                    <div class="card-header">
                        OAuth Connect
                    </div>
                    <div class="card-body">
                        {{-- todo disconnect should double confirm (modal) --}}

                        @if (isset($oauth['apple']))
                            <a class="btn btn-app bg-primary" href="{{ route('oauth.disconnect', 'apple') }}">
                                <span class="badge bg-success"><i class="fas fa-check"></i></span>
                                <i class="fab fa-apple"></i> Apple
                            </a>
                        @else
                            <a class="btn btn-app bg-secondary" href="{{ route('oauth.login', 'apple') }}">
                                <i class="fab fa-apple"></i> Apple
                            </a>
                        @endif
                        @if (isset($oauth['google']))
                            <a class="btn btn-app bg-primary" href="{{ route('oauth.disconnect', 'google') }}">
                                <span class="badge bg-success"><i class="fas fa-check"></i></span>
                                <i class="fab fa-google"></i> Google
                            </a>
                        @else
                            <a class="btn btn-app bg-secondary" href="{{ route('oauth.login', 'google') }}">
                                <i class="fab fa-google"></i> Google
                            </a>
                        @endif
                        @if (isset($oauth['facebook']))
                            <a class="btn btn-app bg-primary" href="{{ route('oauth.disconnect', 'facebook') }}">
                                <span class="badge bg-success"><i class="fas fa-check"></i></span>
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                        @else
                            <a class="btn btn-app bg-secondary" href="{{ route('oauth.login', 'facebook') }}">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                        @endif
                        @if (isset($oauth['twitter']))
                            <a class="btn btn-app bg-primary" href="{{ route('oauth.disconnect', 'twitter') }}">
                                <span class="badge bg-success"><i class="fas fa-check"></i></span>
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                        @else
                            <a class="btn btn-app bg-secondary" href="{{ route('oauth.login', 'twitter') }}">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                        @endif
                        @if (isset($oauth['linkedin']))
                            <a class="btn btn-app bg-primary" href="{{ route('oauth.disconnect', 'linkedin') }}">
                                <span class="badge bg-success"><i class="fas fa-check"></i></span>
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </a>
                        @else
                            <a class="btn btn-app bg-secondary" href="{{ route('oauth.login', 'linkedin') }}">
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </a>
                        @endif
                        @if (isset($oauth['github']))
                            <a class="btn btn-app bg-primary" href="{{ route('oauth.disconnect', 'github') }}">
                                <span class="badge bg-success"><i class="fas fa-check"></i></span>
                                <i class="fab fa-github"></i> Github
                            </a>
                        @else
                            <a class="btn btn-app bg-secondary" href="{{ route('oauth.login', 'github') }}">
                                <i class="fab fa-github"></i> Github
                            </a>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
            @endhasanyrole

        @endif

        <div class="card">
            <div class="card-header">
                Profile
            </div>
            <div class="card-body">
                @if (!$mode['isModeCreate'])
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Avatar</label>
                        <div class="col-sm-9">
                            @if ($mode['isModeEdit'])
                                <label class="label" data-toggle="tooltip" title="Change Avatar">
                                    @if (!is_null($u->profile->avatar))
                                        <img src="{{ asset($u->profile->avatar->path . $u->profile->avatar->name) }}"
                                            id="avatar" class="img-size-256 img-fluid img-thumbnail mb-3" />
                                    @else
                                        <img src="{{ asset('/images/user.jpg') }}" id="avatar"
                                            class="img-size-256 img-fluid img-thumbnail mb-3">
                                    @endif
                                    <input type="file" class="sr-only" id="input" name="input"
                                        accept="image/*">
                                    <input type="hidden" id="avatar_id" name="avatar_id">
                                </label>
                                <div class="progress" style="display: none; max-width: 256px">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                                    </div>
                                </div>
                            @endif

                            @if ($mode['isModeShow'])
                                @if (!is_null($u->profile->avatar))
                                    <img src="{{ asset($u->profile->avatar->path . $u->profile->avatar->name) }}"
                                        id="avatar" class="img-size-256 img-fluid img-thumbnail mb-3" />
                                @else
                                    <img src="{{ asset('/images/user.jpg') }}" id="avatar"
                                        class="img-size-256 img-fluid img-thumbnail mb-3">
                                @endif
                            @endif
                        </div>
                    </div>
                @endif
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Contacts</label>
                    <div class="col-sm-9">
                        <input id="id_contacts" name="contacts" type="text" class="form-control"
                            value="{{ old('contacts', isset($u->profile->contacts) ? $u->profile->contacts : null) }}"
                            @if ($mode['isModeShow']) readonly="readonly" @endif>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Address</label>
                    <div class="col-sm-9">
                        <input id="id_address" name="address" type="text" class="form-control"
                            value="{{ old('address', isset($u->profile->address) ? $u->profile->address : null) }}"
                            @if ($mode['isModeShow']) readonly="readonly" @endif>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">DOB</label>
                    <div class="col-sm-9">
                        <div class="input-group date" id="id_dob" data-target-input="nearest">
                            <input type="text" name="dob" class="form-control datetimepicker-input"
                                data-target="#reservationdate" placeholder="YYYY-MM-DD"
                                value="@if ($mode['isModeCreate']) {{ date('Y-m-d') }}@else{{ old('dob', isset($u->profile->dob) ? $u->profile->dob : null) }} @endif"
                                @if ($mode['isModeShow']) readonly="readonly" @endif />
                            <div class="input-group-append" data-target="#id_dob" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                <div class="form-group row"> --}}
                {{--                    <label class="col-sm-3 form-control-label">Status</label> --}}
                {{--                    <div class="col-sm-9"> --}}
                {{--                        <input type="checkbox" id="id_status" name="status" data-bootstrap-switch --}}
                {{--                               data-on-text="Allow" data-off-text="Refuse" data-off-color="danger" --}}
                {{--                               @if ($mode['isModeShow']) readonly --}}
                {{--                               @endif @if (!$mode['isModeCreate']) @if ($u->profile->status ?? false) checked @endif @endif> --}}
                {{--                    </div> --}}
                {{--                </div> --}}
            </div>
            @if (!$mode['isModeShow'])
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

    @if ($mode['isModeEdit'])
        @include('system.user.partial.script_cropper')
    @endif
@endpush
