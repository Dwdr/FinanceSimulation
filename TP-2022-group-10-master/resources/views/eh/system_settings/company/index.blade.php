{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/system_settings/company/index.title_html'))
@section('page_title', __('eh/system_settings/company/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/system_settings/company/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/system_settings/company/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/system_settings/company/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-COMPANY-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.system_settings.company.index.panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/system_settings/company/index.th_name') }}</th>
                    <th>{{ __('eh/system_settings/company/index.th_parent_company') }}</th>
                    <th>{{ __('eh/system_settings/company/index.th_head_of_company') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/system_settings/company/index.th_name') }}</th>
                    <th>{{ __('eh/system_settings/company/index.th_parent_company') }}</th>
                    <th>{{ __('eh/system_settings/company/index.th_head_of_company') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($companys as $c)
                    <tr>
                        <td>
                            <a href="{{ route('eh.system_settings.company.show',$c->id) }}">
                                {{ $c->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.system_settings.company.show',$c->id) }}">
                                @if(isset($c->parent))
                                    {{ $c->parent->name }}
                                @else
                                    -
                                @endif
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.system_settings.company.show',$c->id) }}">
                                @if(isset($c->head))
                                {{ $c->head->employee->title->title[App::getLocale()].'. '.$c->head->employee->first_name.' '.$c->head->employee->middle_name.' '.$c->head->employee->last_name }}
                                @else
                                    -
                                @endif
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-TITLE-U"))
                                <a href="{{ route('eh.system_settings.company.edit',$c->id) }}"><i class="fas fa-edit"></i></a>
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
    @include('eh.system_settings.company.index.script_table')
@endpush
