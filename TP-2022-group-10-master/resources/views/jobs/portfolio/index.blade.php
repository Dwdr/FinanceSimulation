{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/portfolio/index.title_html'))
@section('page_title', __('jobs/portfolio/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/portfolio/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/portfolio/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/portfolio/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @hasanyrole(config("constants.ROLE.JOBS-ADMIN")|config("constants.ROLE.JOBS-SEEKER"))
    @can(config("constants.PERMISSION.EH-SETTINGS-portfolio-C"))
        <div class="card">
            <div class="card-body">
                @include('jobs.portfolio.index_panel')
            </div>
        </div>
    @endcan
    @endhasanyrole

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('jobs/portfolio/index.th_id') }}</th>
                    <th>{{ __('jobs/portfolio/index.th_type') }}</th>
                    <th>{{ __('jobs/portfolio/index.th_attributes') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('jobs/portfolio/index.th_id') }}</th>
                    <th>{{ __('jobs/portfolio/index.th_type') }}</th>
                    <th>{{ __('jobs/portfolio/index.th_attributes') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($portfolios as $p)
                    <tr>
                        <td>
                            <a href="{{ route('jobs.portfolio.show',$p->uuid) }}">
                                {{ substr($p->uuid,0,8) }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('jobs.portfolio.show',$p->uuid) }}">
                                {{ $p->type }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('jobs.portfolio.show',$p->uuid) }}">
                                {{ $p->attributes['file'] }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-TITLE-U"))
                                <a href="{{ route('jobs.portfolio.edit',$p->uuid) }}"><i class="fas fa-edit"></i></a>
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
    @include('jobs.portfolio.index_script_table')
@endpush
