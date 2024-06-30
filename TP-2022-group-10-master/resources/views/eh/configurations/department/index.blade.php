{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/department/index.title_html'))
@section('page_title', __('eh/configurations/department/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/department/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/department/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/department/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-DEPARTMENT-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.department.index_panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/configurations/department/index.th_name') }}</th>
                    <th>{{ __('eh/configurations/department/index.th_parent_department') }}</th>
                    <th>{{ __('eh/configurations/department/index.th_head_of_department') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/configurations/department/index.th_name') }}</th>
                    <th>{{ __('eh/configurations/department/index.th_parent_department') }}</th>
                    <th>{{ __('eh/configurations/department/index.th_head_of_department') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($departments as $d)
                    <tr>
                        <td>
                            <a href="{{ route('eh.configurations.department.show',$d->id) }}">
                                {{ $d->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.department.show',$d->id) }}">
                                @if(isset($d->parent))
                                    {{ $d->parent->name }}
                                @else
                                    -
                                @endif
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.department.show',$d->id) }}">
                                @if(isset($d->head))
                                {{ $d->head->employee->title->title[App::getLocale()].'. '.$d->head->employee->first_name.' '.$d->head->employee->middle_name.' '.$d->head->employee->last_name }}
                                @else
                                    -
                                @endif
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-TITLE-U"))
                                <a href="{{ route('eh.configurations.department.edit',$d->id) }}"><i class="fas fa-edit"></i></a>
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
    @include('eh.configurations.department.index_script_table')
@endpush
