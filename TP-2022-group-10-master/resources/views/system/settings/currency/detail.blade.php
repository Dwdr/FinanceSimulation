{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')

@endsection

{{-- Title --}}
@section('html_title', 'Currency')
@section('page_title', 'Currency')

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('system.settings.currency.index') }}">Currency</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">Create</li>
    @else
        <li class="breadcrumb-item active">{{ $c->id ?? '-' }}</li>
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
                @include('system.settings.currency.partial.panel_detail')
            </div>
        </div>
    @endif

    <form id="v_form" class="block form-horizontal form-label-left"
          action="@if(!$mode['isModeEdit']){{ route('system.settings.currency.store') }}@elseif($mode['isModeEdit']){{ route('system.settings.currency.update',$c->id) }}@endif"
          method="post">

        <div class="card">
            <!-- form start -->
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Currency</label>
                    <div class="col-sm-9">
                        <input
                                id="currency"
                                name="currency"
                                type="text"
                                class="form-control"
                                value="{{ old("title", isset($c->currency) ? $c->currency : null) }}"
                                @if($mode['isModeShow'])readonly="readonly" @endif
                        >
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Status</label>
                    <div class="col-sm-9">
                        <input type="checkbox" id="id_status" name="status" data-bootstrap-switch
                               data-on-text="Enable" data-off-text="Not enabled" data-off-color="danger"
                               @if($mode['isModeShow']) readonly @endif
                               @if(!$mode['isModeCreate']) @if($c->status??false) checked
                               @endif @else checked @endif>
                    </div>
                </div>

            </div>


            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('system.settings.currency.partial.panel_detail')
                </div>
                <!-- /.card-footer -->
            @endif

        </div>


@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('system.settings.currency.partial.script_validation')
    @include('layouts.adminlte_3.components.form.script_switch')
@endpush
