{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{asset('vendor/adminlte-3.1.0/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
@endsection

{{-- Title --}}
@section('html_title', __('eh/payroll/create.title_html'))
@section('page_title', __('eh/payroll/create.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/payroll/create.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('eh.payroll.index') }}">{{ __('eh/payroll/create.breadcrumb_level_2') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/payroll/create.breadcrumb_create') }}</li>
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    <div>

        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if(!$mode['isModeEdit']){{route('eh.payroll.store')}}@elseif($mode['isModeEdit']){{route('eh.payroll.update', $p->uuid)}}@endif"
              method="post">
            @csrf
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif

            {{-- Panel --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('eh.payroll.create_panel')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            {{__('eh/payroll/create.card_header_list_of_employee')}}
                        </div>
                        <div class="card-body">
                            <x-inputs.duallistbox
                                name="employees[]"
                                label="Employee"
                            >
                                @foreach($employees as $e)
                                    <option value="{{ $e->uuid }}">{{ $e->first_name.' '.$e->last_name }}</option>
                                @endforeach
                            </x-inputs.duallistbox>

                            <x-inputs.duallistbox
                                name="departments[]"
                                label="Department"
                            >
                                @foreach($departments as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </x-inputs.duallistbox>

                        </div>
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-header">
                            {{__('eh/payroll/create.card_header_date_period')}}
                        </div>
                        <div class="card-body">

                            @php
                                $month_ini = new DateTime("first day of last month");
                                $month_end = new DateTime("last day of last month");
                            @endphp

                            <x-inputs.date
                                :label="__('eh/payroll/create.lb_period_start')"
                                :isReadonly="$mode['isModeShow']"
                                value="{{$p->period_start ?? $month_ini->format('Y-m-d')}}"
                                name="period_start"
                                required="true"
                            />
                            <x-inputs.date
                                :label="__('eh/payroll/create.lb_period_end')"
                                :isReadonly="$mode['isModeShow']"
                                value="{{$p->period_end ?? $month_end->format('Y-m-d')}}"
                                name="period_end"
                                required="true"
                            />
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            {{__('eh/payroll/create.card_header_config')}}
                        </div>
                        <div class="card-body">

                            <x-inputs.radio
                                :label="__('eh/payroll/create.lb_generate_date')"
                                :isReadonly="$mode['isModeShow']"
                                value="{{$p->generate_type ?? ''}}"
                                lang="eh/payroll/detail"
                                name="generate_type"
                                :option="config('constants.PAYROLL.GENERATE_DATE')"
                                required="true"
                                hidden="{{$mode['isModeShow']}}"
                            />

                            <x-inputs.date
                                label="{{$mode['isModeShow']?__('eh/payroll/create.lb_generate_date'):''}}"
                                :isReadonly="$mode['isModeShow']"
                                value="{{$p->generate_date ?? ''}}"
                                name="generate_date"
                                hidden="{{$mode['isModeCreate']}}"
                            />

                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    <script>
        $().ready(function () {
            var generate_type = {{$p->generate_type??1}};
            if (generate_type == '1') {
                $('#date_generate_date').addClass('d-none')
            } else if (generate_type == '2') {
                $('#date_generate_date').removeClass('d-none')
            }

            $("input[type=radio][name='generate_type']").change(function () {
                if (this.value == '1') {
                    $('#date_generate_date').addClass('d-none')
                } else if (this.value == '2') {
                    $('#date_generate_date').removeClass('d-none')
                }
            });

            const today = new Date()
            const tomorrow = new Date(today)
            tomorrow.setDate(tomorrow.getDate() + 1)
            $('#id_generate_date').datetimepicker('minDate', tomorrow);
        })
    </script>
@endpush
