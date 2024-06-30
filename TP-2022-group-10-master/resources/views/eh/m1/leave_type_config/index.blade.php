{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/m1/leave_type_config/index.title_html'))
@section('page_title', __('eh/m1/leave_type_config/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/m1/leave_type_config/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/m1/leave_type_config/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/m1/leave_type_config/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-LEAVE-TYPE-CONFIG-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.m1.leave_type_config.index_panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/m1/leave_type_config/index.th_code') }}</th>
                    <th>{{ __('eh/m1/leave_type_config/index.th_name') }}</th>
                    <th>{{ __('eh/m1/leave_type_config/index.th_is_nwd') }}</th>
                    <th>{{ __('eh/m1/leave_type_config/index.th_is_adj') }}</th>
                    <th>{{ __('eh/m1/leave_type_config/index.th_is_rse') }}</th>
                    <th>{{ __('eh/m1/leave_type_config/index.th_percentage') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/m1/leave_type_config/index.th_code') }}</th>
                    <th>{{ __('eh/m1/leave_type_config/index.th_name') }}</th>
                    <th>{{ __('eh/m1/leave_type_config/index.th_is_nwd') }}</th>
                    <th>{{ __('eh/m1/leave_type_config/index.th_is_adj') }}</th>
                    <th>{{ __('eh/m1/leave_type_config/index.th_is_rse') }}</th>
                    <th>{{ __('eh/m1/leave_type_config/index.th_percentage') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($types as $t)
                    <tr>
                        <td>
                            <a href="{{ route('m1.leave-type-config.show',$t->id) }}">
                                {{ $t->code }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('m1.leave-type-config.show',$t->id) }}">
                                {{ $t->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('m1.leave-type-config.show',$t->id) }}">
                                {{ $t->is_nwd }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('m1.leave-type-config.show',$t->id) }}">
                                {{ $t->is_adj }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('m1.leave-type-config.show',$t->id) }}">
                                {{ $t->is_rse }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('m1.leave-type-config.show',$t->id) }}">
                                {{ $t->percentage }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-LEAVE-TYPE-CONFIG-U"))
                                <a href="{{ route('m1.leave-type-config.edit',$t->id) }}"><i class="fas fa-edit"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.m1.leave_type_config.index_script_table')
@endpush
