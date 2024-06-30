{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/holiday/detail.title_html'))
@section('page_title', __('eh/configurations/holiday/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/holiday/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/holiday/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a
            href="{{ route('eh.configurations.holiday.index') }}">{{ __('eh/configurations/holiday/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/holiday/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $h->title }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/holiday/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.holiday.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if(!$mode['isModeEdit']){{route('eh.configurations.holiday.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.holiday.update', $h->id)}}@endif"
              method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/configurations/holiday/detail.lb_title')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$h->title ?? ''}}"
                    name="title"
                    required="true"
                />

                <x-inputs.select2
                    :label="__('eh/configurations/holiday/detail.lb_type')"
                    :isReadonly="$mode['isModeShow']"
                    name="type_id"
                    required="true"
                    value="{{$h->type->name ?? ''}}"
                >
                    @if(!$mode['isModeShow'])
                        @foreach($holiday_type as $t)
                            <option
                                value="{{ $t->id }}"
                                @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
                                @if($t->id==$h->type_id)
                                selected="selected"
                                @endif
                                @endif
                            >{{ $t->name }}</option>
                        @endforeach
                    @endif
                </x-inputs.select2>

                <x-inputs.date
                    type="date"
                    :label="__('eh/configurations/holiday/detail.lb_date')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$h->date ?? ''}}"
                    name="date"
                    required="true"
                />

                <hr>

                <x-inputs.switch2
                    label="{{ __('eh/configurations/holiday/detail.lb_is_show_payroll') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$h->is_show_payroll ?? false}}"
                    name="is_show_payroll"
                    onText="{{ __('eh/configurations/holiday/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/holiday/detail.select_option_no') }}"
                />

                <x-inputs.switch2
                    label="{{ __('eh/configurations/holiday/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$h->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/configurations/holiday/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/holiday/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$h->updated_at" :createdAt="$h->created_at"/>
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.holiday.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    <script>
        $().ready(function () {
            $('#id_from_date').datetimepicker('format', 'YYYY-MM-DD');
            $('#id_to_date').datetimepicker('format', 'YYYY-MM-DD');

            $("#id_year").on("change.datetimepicker", function (e) {
                let year = moment(e.date).format('YYYY');
                let from_date = moment($('#id_from_date').datetimepicker('viewDate')).format('-MM-DD');
                let to_date = moment($('#to_date').datetimepicker('viewDate')).format('-MM-DD');
                console.log(year);
                console.log(from_date);
                console.log(to_date);

                $('#id_from_date').datetimepicker('maxDate', false);
                $('#id_from_date').datetimepicker('minDate', false);
                $('#id_to_date').datetimepicker('maxDate', false);
                $('#id_to_date').datetimepicker('minDate', false);

                $('#id_from_date').datetimepicker('date', year + '' + from_date);
                $('#id_to_date').datetimepicker('date', year + '' + to_date);

                $('#id_from_date').datetimepicker('minDate', year + '-01-01');
                $('#id_from_date').datetimepicker('maxDate', year + '' + to_date);

                $('#id_to_date').datetimepicker('minDate', year + '' + from_date);
                $('#id_to_date').datetimepicker('maxDate', year + '-12-31');
            });

            $("#id_from_date").on("change.datetimepicker", function (e) {
                $('#id_to_date').datetimepicker('minDate', e.date);
            });
            $("#id_to_date").on("change.datetimepicker", function (e) {
                $('#id_from_date').datetimepicker('maxDate', e.date);
            });
        })
    </script>
@endpush
