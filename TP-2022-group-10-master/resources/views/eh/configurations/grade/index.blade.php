{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/grade/index.title_html'))
@section('page_title', __('eh/configurations/grade/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/grade/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/grade/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/grade/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-GRADE-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.grade.index_panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/configurations/grade/index.th_grade_en_gb') }}</th>
                    <th>{{ __('eh/configurations/grade/index.th_grade_zh_hk') }}</th>
                    <th>{{ __('eh/configurations/grade/index.th_grade_zh_cn') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/configurations/grade/index.th_grade_en_gb') }}</th>
                    <th>{{ __('eh/configurations/grade/index.th_grade_zh_hk') }}</th>
                    <th>{{ __('eh/configurations/grade/index.th_grade_zh_cn') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($grades as $g)
                    <tr>
                        <td>
                            <a href="{{ route('eh.configurations.grade.show',$g->id) }}">
                                {{ $g->grade['en-GB'] }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.grade.show',$g->id) }}">
                                {{ $g->grade['zh_HK'] }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.grade.show',$g->id) }}">
                                {{ $g->grade['zh_CN'] }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-GENDER-U"))
                                <a href="{{ route('eh.configurations.grade.edit',$g->id) }}"><i class="fas fa-edit"></i></a>
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
    @include('eh.configurations.grade.index_script_table')
@endpush
