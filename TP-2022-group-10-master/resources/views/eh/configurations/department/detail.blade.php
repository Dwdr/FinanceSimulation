{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/department/detail.title_html'))
@section('page_title', __('eh/configurations/department/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/department/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/department/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('eh.configurations.department.index') }}">{{ __('eh/configurations/department/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/department/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $d->name }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/department/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.department.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if(!$mode['isModeEdit']){{route('eh.configurations.department.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.department.update', $d->id)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/configurations/department/detail.lb_name')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$d->name ?? ''}}"
                    name="name"
                    required="true"
                />

                <x-inputs.select2
                    :label="__('eh/configurations/department/detail.lb_parent_department')"
                    :isReadonly="$mode['isModeShow']"
                    name="parent_id"
                    value="{{$d->parent->name??''}}"
                >
                    @foreach($departments as $ds)
                        <option
                            value="{{ $ds->id }}"
                            @if($mode['isModeShow'] || $mode['isModeEdit'])
                            @if($ds->id===$d->parent_id)
                            selected="selected"
                            @endif
                            @endif
                        >{{ $ds->name }}</option>
                    @endforeach
                </x-inputs.select2>

                <x-inputs.select2
                    :label="__('eh/configurations/department/detail.lb_head_of_department')"
                    :isReadonly="$mode['isModeShow']"
                    name="head_id"
                    {{--TODO: should show employee full name or chinese name and avatar--}}
                    value="{{$d->head->profile->name??''}}"
                >
                    @foreach($employees as $e)
                        <option
                            value="{{ $e->user_id }}"
                            @if($mode['isModeShow'] || $mode['isModeEdit'])
                            @if($e->user_id===$d->head_id)
                            selected="selected"
                            @endif
                            @endif
                        >{{ $e->first_name.' '.$e->middle_name.' '.$e->last_name }}</option>
                    @endforeach
                </x-inputs.select2>

                <x-inputs.switch2
                    label="{{ __('eh/configurations/department/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$d->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/configurations/department/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/department/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                    @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$d->updated_at" :createdAt="$d->created_at" />
                    @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.department.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
