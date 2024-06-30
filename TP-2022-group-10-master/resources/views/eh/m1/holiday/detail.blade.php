{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/m1/holiday/detail.title_html'))
@section('page_title', __('eh/m1/holiday/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/m1/holiday/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/m1/holiday/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a
            href="{{ route('m1.holiday.index') }}">{{ __('eh/m1/holiday/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/m1/holiday/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $h->title }}</li>
            <li class="breadcrumb-item active">{{ __('eh/m1/holiday/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.m1.holiday.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if(!$mode['isModeEdit']){{route('m1.holiday.store')}}@elseif($mode['isModeEdit']){{route('m1.holiday.update', $h->id)}}@endif"
              method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">
                <x-inputs.text
                    :label="__('eh/m1/holiday/detail.lb_name')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$h->name ?? ''}}"
                    name="name"
                    required="true"
                />
                <x-inputs.date
                    type="datetime"
                    :label="__('eh/m1/holiday/detail.lb_date')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$h->date ?? ''}}"
                    name="date"
                    format="YYYY-MM-DD"
                    placeholder="YYYY-MM-DD"
                    required="true"
                />
                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$h->updated_at" :createdAt="$h->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.m1.holiday.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    <script>
        $().ready(function () {

        })
    </script>
@endpush
