{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_held_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/leave_balance/detail.title_html'))
@section('page_title', __('eh/leave_balance/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/leave_balance/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/leave_balance/detail.breadcrumb_level_2') }}</li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/leave_balance/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $e->employee_id }}</li>
            <li class="breadcrumb-item active">{{ __('eh/leave_balance/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.leave_balance.detail.panel')
            </div>
        </div>
    @endif

    {{-- Form --}}

    <div class="card">
        <div class="card-body">

            <x-inputs.text
                :label="__('eh/employee/detail.lb_employee_id')"
                :isReadonly="true"
                name="employee_id"
                value="{{$e->employee_id??''}}"
            />

            <div class="row">

                <div class="col-md-3">
                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_title')"
                        :isReadonly="true"
                        name="title_id"
                        value="{{$e->title->title[App::getLocale()]??''}}"
                    />
                </div>

                <div class="col-md-3">
                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_first_name')"
                        :isReadonly="true"
                        value="{{$e->first_name ?? ''}}"
                        name="first_name"
                        required="true"
                    />
                </div>

                <div class="col-md-3">
                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_middle_name')"
                        :isReadonly="true"
                        value="{{$e->middle_name ?? ''}}"
                        name="middle_name"
                    />
                </div>

                <div class="col-md-3">
                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_last_name')"
                        :isReadonly="true"
                        value="{{$e->last_name ?? ''}}"
                        name="last_name"
                        required="true"
                    />
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_chinese_name')"
                        :isReadonly="true"
                        value="{{$e->chinese_name ?? ''}}"
                        name="chinese_name"
                    />
                </div>

                <div class="col-md-6">
                    <x-inputs.text
                        :label="__('eh/employee/detail.lb_alias')"
                        :isReadonly="true"
                        value="{{$e->alias ?? ''}}"
                        name="alias"
                    />
                </div>

            </div>

        </div>
    </div>

    <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
          action="@if($mode['isModeEdit']){{route('eh.leave_balance.update', $e->uuid)}}@endif"
          method="post">
        @if($mode['isModeEdit'])
            {{method_field('put')}}
        @endif
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th scope="col">{{__('eh/leave_balance/detail.lb_leave_type')}}</th>
                            <th scope="col">{{__('eh/leave_balance/detail.lb_max')}}</th>
                            <th scope="col">{{__('eh/leave_balance/detail.lb_using')}}</th>
                            <th scope="col">{{__('eh/leave_balance/detail.lb_adjustment')}}</th>
                            <th scope="col">{{__('eh/leave_balance/detail.lb_last')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(sizeof($lt)>0)
                        @foreach($lt as $t)
                        <tr>
                            <th scope="row">{{$t->name}}</th>
                            <td>
                                {{$lb[$t->id][0]->max_balance??$t->default_balance}}
                            </td>
                            <td>
                                {{$lb[$t->id][0]->using_balance??0}}
                            </td>
                            <td>
                                <x-inputs.text
                                    label=""
                                    type="number"
                                    :isReadonly="$mode['isModeShow']"
                                    required="true"
                                    value="{{$lb[$t->id][0]->adjustment??0}}"
                                    name="lb[{{$t->id}}]"
                                    min="0"
                                    step="1"
                                />
                            </td>
                            <td>
                                @php
                                    $max = $lb[$t->id][0]->max_balance??$t->default_balance;
                                    $using = $lb[$t->id][0]->using_balance??0;
                                    $adjustment = $lb[$t->id][0]->adjustment??0;
                                @endphp
                                {{($max-$using+$adjustment)<0?0:($max-$using+$adjustment)}}
                            </td>
                        </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">{{__('eh/leave_balance/detail.lb_no_leave_type')}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.leave_balance.detail.panel')
                </div>
            @endif
        </div>

    </form>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
