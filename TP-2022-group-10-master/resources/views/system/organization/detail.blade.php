<?php
  use Illuminate\Support\Str;
?>

{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')

@endsection

{{-- Title --}}
@section('html_title', 'Organization')
@section('page_title', 'Organization')

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">System</li>
    <li class="breadcrumb-item"><a href="{{ route('system.organization.index') }}">Organization</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">Create</li>
    @else
        <li class="breadcrumb-item active">{{ $o->profile->name ?? '-' }}</li>
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
                @include('system.organization.partial.panel_detail')
            </div>
        </div>
    @endif

    <form id="v_form" class="block form-horizontal form-label-left"
          action="@if(!$mode['isModeEdit']){{ route('system.organization.store') }}@elseif($mode['isModeEdit']){{ route('system.organization.update',$o->id) }}@endif"
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
                            <p>{{$o->id}}</p>
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
                                value="{{ old("name", isset($o->profile->name) ? $o->profile->name : null) }}"
                                @if($mode['isModeShow'])readonly="readonly" @endif
                        >
                    </div>
                </div>

                {{-- Timestamp Panel --}}
                @can(config("constants.PERMISSION.INTERNAL-DATA"))
                    @if($mode['isModeShow'])
                        @include('system.organization.partial.timestamp_detail')
                    @endif
                @endcan
            </div>
            <!-- /.card-body -->

        </div>
    </form>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('system.organization.partial.script_datepicker')
    @include('system.organization.partial.script_validation')
    @include('layouts.adminlte_3.components.form.script_switch')
@endpush
