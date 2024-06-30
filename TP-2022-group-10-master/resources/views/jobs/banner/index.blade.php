{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/banner/index.title_html'))
@section('page_title', __('jobs/banner/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/banner/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/banner/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/banner/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-banner-C"))
        <div class="card">
            <div class="card-body">
                @include('jobs.banner.index_panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('jobs/banner/index.th_company_name') }}</th>
                    <th>{{ __('jobs/banner/index.th_contact_person') }}</th>
                    <th>{{ __('jobs/banner/index.th_contact_number') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('jobs/banner/index.th_company_name') }}</th>
                    <th>{{ __('jobs/banner/index.th_contact_person') }}</th>
                    <th>{{ __('jobs/banner/index.th_contact_number') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($banners as $b)
                    <tr>
                        <td>
                            <a href="{{ route('jobs.banner.show',$b->uuid) }}">
                                {{ $b->company_name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('jobs.banner.show',$b->uuid) }}">
                                {{ $b->contact_person }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('jobs.banner.show',$b->uuid) }}">
                                {{ $b->contact_number }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-TITLE-U"))
                                <a href="{{ route('jobs.banner.edit',$b->uuid) }}"><i class="fas fa-edit"></i></a>
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
    @include('jobs.banner.index_script_table')
@endpush
