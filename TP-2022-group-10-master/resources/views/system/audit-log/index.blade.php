{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')

@endsection

{{-- Title --}}
@section('html_title', 'Audit Log')
@section('page_title', 'Audit Log')

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">System</li>
    <li class="breadcrumb-item active">Audit Log</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info">
                <thead>
                <tr role="row">
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Auditable ID</th>
                    <th>Auditable Type</th>
                    <th>Event</th>
{{--                    <th>URL</th>--}}
                    <th>IP</th>
{{--                    <th>User Agent</th>--}}
{{--                    <th>Tags</th>--}}
                    <th>Created at</th>
{{--                    <th>Updated at</th>--}}
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Auditable ID</th>
                    <th>Auditable Type</th>
                    <th>Event</th>
{{--                    <th>URL</th>--}}
                    <th>IP</th>
{{--                    <th>User Agent</th>--}}
{{--                    <th>Tags</th>--}}
                    <th>Created at</th>
{{--                    <th>Updated at</th>--}}
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($auditLogs as $a)
                    <tr>
                        <td><a href="{{ route('system.audit-log.show',$a->id) }}">{{ $a->id }}</a></td>
                        <td>{{ $a->user_id }}</td>
                        <td>{{ $a->auditable_id }}</td>
                        <td>{{ $a->auditable_type }}</td>
                        <td>
                            @switch($a->event)
                                @case('created')
                                <span class="badge badge-success">Created</span>
                                @break
                                @case('updated')
                                <span class="badge badge-primary">Updated</span>
                                @break
                                @case('deleted')
                                <span class="badge badge-danger">Deleted</span>
                                @break
                                @case('restored')
                                <span class="badge badge-warning">Restored</span>
                                @break
                                @default
                                <span class="badge badge-pill badge-dark">Unknown</span>
                            @endswitch
                        </td>
{{--                        <td>{{ $a->url }}</td>--}}
                        <td>{{ $a->ip_address }}</td>
{{--                        <td>{{ $a->user_agent }}</td>--}}
{{--                        <td>{{ $a->tags }}</td>--}}
                        <td>{{ $a->created_at }}</td>
{{--                        <td>{{ $a->updated_at }}</td>--}}
                        <td><a href="{{ route('system.audit-log.show',$a->id) }}"><i class="fas fa-eye"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>



@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('system.audit-log.partial.script_table')
@endpush
