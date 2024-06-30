{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/system_settings/queue/index.title_html'))
@section('page_title', __('eh/system_settings/queue/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/system_settings/queue/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active"><a href="{{route('eh.system_settings.index')}}">{{ __('eh/system_settings/queue/index.breadcrumb_level_2') }}</a></li>
    <li class="breadcrumb-item active">{{ __('eh/system_settings/queue/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/system_settings/queue/index.th_datetime') }}</th>
                    <th>{{ __('eh/system_settings/queue/index.th_type') }}</th>
                    <th>{{ __('eh/system_settings/queue/index.th_job_count') }}</th>
                    <th>{{ __('eh/system_settings/queue/index.th_success_count') }}</th>
                    <th>{{ __('eh/system_settings/queue/index.th_fail_count') }}</th>
                    <th>{{ __('eh/system_settings/queue/index.th_status') }}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/system_settings/queue/index.th_datetime') }}</th>
                    <th>{{ __('eh/system_settings/queue/index.th_type') }}</th>
                    <th>{{ __('eh/system_settings/queue/index.th_job_count') }}</th>
                    <th>{{ __('eh/system_settings/queue/index.th_success_count') }}</th>
                    <th>{{ __('eh/system_settings/queue/index.th_fail_count') }}</th>
                    <th>{{ __('eh/system_settings/queue/index.th_status') }}</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($queues as $q)
                    <tr>
                        <td>
                            <a href="{{ route('eh.system_settings.queue.show',$q->uuid) }}">
                                {{ $q->effective_date }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.system_settings.queue.show',$q->uuid) }}">
                                {{ $q->type }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.system_settings.queue.show',$q->uuid) }}">
                                {{ $q->job_count }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.system_settings.queue.show',$q->uuid) }}">
                                {{ sizeof($q->success_record) }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.system_settings.queue.show',$q->uuid) }}">
                                {{ sizeof($q->fail_record) }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.system_settings.queue.show',$q->uuid) }}">
                                {{ $q->status }}
                            </a>
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
    @include('eh.system_settings.queue.index_script_table')
@endpush
