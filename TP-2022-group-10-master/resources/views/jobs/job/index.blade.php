{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/job/index.title_html'))
@section('page_title', __('jobs/job/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/job/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/job/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/job/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-jobs-C"))
        <div class="card">
            <div class="card-body">
                @include('jobs.job.index_panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('jobs/job/index.th_id') }}</th>
                    <th>{{ __('jobs/job/index.th_title') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('jobs/job/index.th_id') }}</th>
                    <th>{{ __('jobs/job/index.th_title') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($jobs as $j)
                    <tr>
                        <td>
                            <a href="{{ route('jobs.job.show',$j->uuid) }}">
                                {{ substr($j->uuid,0,8) }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('jobs.job.show',$j->uuid) }}">
                                {{ $j->title }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('jobs.job.show',$j->uuid) }}">
                                {{ $j->contact_number }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-TITLE-U"))
                                <a href="{{ route('jobs.job.edit',$j->uuid) }}"><i class="fas fa-edit"></i></a>
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
    @include('jobs.job.index_script_table')
@endpush
