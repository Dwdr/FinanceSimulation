{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/employer/index.title_html'))
@section('page_title', __('jobs/employer/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/employer/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/employer/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/employer/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-employer-C"))
        <div class="card">
            <div class="card-body">
                @include('jobs.employer.index_panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('jobs/employer/index.th_company_name') }}</th>
                    <th>{{ __('jobs/employer/index.th_contact_person') }}</th>
                    <th>{{ __('jobs/employer/index.th_contact_number') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('jobs/employer/index.th_company_name') }}</th>
                    <th>{{ __('jobs/employer/index.th_contact_person') }}</th>
                    <th>{{ __('jobs/employer/index.th_contact_number') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($employers as $e)
                    <tr>
                        <td>
                            <a href="{{ route('jobs.employer.show',$e->uuid) }}">
                                {{ $e->company_name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('jobs.employer.show',$e->uuid) }}">
                                {{ $e->contact_person }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('jobs.employer.show',$e->uuid) }}">
                                {{ $e->contact_number }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-TITLE-U"))
                                <a href="{{ route('jobs.employer.edit',$e->uuid) }}"><i class="fas fa-edit"></i></a>
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
    @include('jobs.employer.index_script_table')
@endpush
