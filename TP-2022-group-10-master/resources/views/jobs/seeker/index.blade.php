{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/seeker/index.title_html'))
@section('page_title', __('jobs/seeker/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/seeker/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/seeker/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/seeker/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @hasanyrole(config("constants.ROLE.JOBS-ADMIN")|config("constants.ROLE.JOBS-SEEKER"))
    @can(config("constants.PERMISSION.EH-SETTINGS-seeker-C"))
        <div class="card">
            <div class="card-body">
                @include('jobs.seeker.index_panel')
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
                    <th>{{ __('jobs/seeker/index.th_name') }}</th>
                    <th>{{ __('jobs/seeker/index.th_email') }}</th>
                    <th>{{ __('jobs/seeker/index.th_contact_number') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('jobs/seeker/index.th_name') }}</th>
                    <th>{{ __('jobs/seeker/index.th_email') }}</th>
                    <th>{{ __('jobs/seeker/index.th_contact_number') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($seekers as $s)
                    <tr>
                        <td>
                            <a href="{{ route('jobs.seeker.show',$s->uuid) }}">
                                {{ $s->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('jobs.seeker.show',$s->uuid) }}">
                                {{ $s->email }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('jobs.seeker.show',$s->uuid) }}">
                                {{ $s->contact_number }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-TITLE-U"))
                                <a href="{{ route('jobs.seeker.edit',$s->uuid) }}"><i class="fas fa-edit"></i></a>
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
    @include('jobs.seeker.index_script_table')
@endpush
