{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/system_settings/queue/detail.title_html'))
@section('page_title', __('eh/system_settings/queue/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/system_settings/queue/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active"><a href="{{route('eh.system_settings.index')}}">{{ __('eh/system_settings/queue/detail.breadcrumb_level_2') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('eh.system_settings.queue.index') }}">{{ __('eh/system_settings/queue/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/system_settings/queue/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $b->id }} {{ $b->id }}</li>
            <li class="breadcrumb-item active">{{ __('eh/system_settings/queue/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    <div class="card">

            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/system_settings/queue/detail.lb_type')"
                    :isReadonly="true"
                    value="{{$q->type ?? ''}}"
                    name="type"
                />

                @if($q->type == config('constants.JOB.TYPE.GENERATOR_PAYROLL'))

                <div class="form-group">
                    <label class="form-control-label" for="id_old_data">{{__('eh/system_settings/queue/detail.lb_employee')}}</label>
                    <pre class="bg-secondary rounded">{{ json_encode($q->payload['employee']??[],JSON_PRETTY_PRINT) }}</pre>
                </div>

                <x-inputs.text
                    :label="__('eh/system_settings/queue/detail.lb_period_start')"
                    :isReadonly="true"
                    value="{{$q->payload['period_start'] ?? ''}}"
                    name="period_start"
                />

                <x-inputs.text
                    :label="__('eh/system_settings/queue/detail.lb_period_end')"
                    :isReadonly="true"
                    value="{{$q->payload['period_end'] ?? ''}}"
                    name="period_end"
                />

                @else

                    <div class="form-group">
                        <label class="form-control-label" for="id_old_data">{{__('eh/system_settings/queue/detail.lb_employee')}}</label>
                        <pre class="bg-secondary rounded">{{ json_encode($q->payload??[],JSON_PRETTY_PRINT) }}</pre>
                    </div>

                @endif

                <x-inputs.text
                    :label="__('eh/system_settings/queue/detail.lb_effective_date')"
                    :isReadonly="true"
                    value="{{$q->effective_date ?? ''}}"
                    name="effective_date"
                />

                <x-inputs.text
                    :label="__('eh/system_settings/queue/detail.lb_job_count')"
                    :isReadonly="true"
                    value="{{$q->job_count ?? ''}}"
                    name="job_count"
                />

                <div class="form-group">
                    <label class="form-control-label">{{__('eh/system_settings/queue/detail.lb_success_record')}}</label>
                    <pre class="bg-secondary rounded">{{ json_encode($q->success_record??[],JSON_PRETTY_PRINT) }}</pre>
                </div>

                <div class="form-group">
                    <label class="form-control-label">{{__('eh/system_settings/queue/detail.lb_fail_record')}}</label>
                    <pre class="bg-secondary rounded">{{ json_encode($q->fail_record??[],JSON_PRETTY_PRINT) }}</pre>
                </div>


                <x-inputs.text
                    :label="__('eh/system_settings/queue/detail.lb_status')"
                    :isReadonly="true"
                    value="{{$q->status ?? ''}}"
                    name="status"
                />


                {{-- Timestamp Panel --}}
                    @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$q->updated_at" :createdAt="$q->created_at" />
                    @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.system_settings.queue.detail.panel')
                </div>
            @endif

    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
