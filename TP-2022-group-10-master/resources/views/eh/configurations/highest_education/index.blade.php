{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/highest_education/index.title_html'))
@section('page_title', __('eh/configurations/highest_education/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/highest_education/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/highest_education/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/highest_education/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-HIGHEST-EDUCATION-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.highest_education.index_panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/configurations/highest_education/index.th_highest_education_en_gb') }}</th>
                    <th>{{ __('eh/configurations/highest_education/index.th_highest_education_zh_hk') }}</th>
                    <th>{{ __('eh/configurations/highest_education/index.th_highest_education_zh_cn') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/configurations/highest_education/index.th_highest_education_en_gb') }}</th>
                    <th>{{ __('eh/configurations/highest_education/index.th_highest_education_zh_hk') }}</th>
                    <th>{{ __('eh/configurations/highest_education/index.th_highest_education_zh_cn') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($highest_educations as $g)
                    <tr>
                        <td>
                            <a href="{{ route('eh.configurations.highest_education.show',$g->id) }}">
                                {{ $g->highest_education['en-GB'] }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.highest_education.show',$g->id) }}">
                                {{ $g->highest_education['zh_HK'] }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.highest_education.show',$g->id) }}">
                                {{ $g->highest_education['zh_CN'] }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-HIGHEST-EDUCATION-U"))
                                <a href="{{ route('eh.configurations.highest_education.edit',$g->id) }}"><i class="fas fa-edit"></i></a>
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
    @include('eh.configurations.highest_education.index_script_table')
@endpush
