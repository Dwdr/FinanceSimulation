{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
    <style>
        pre{
            border-radius: 10px !important;
            padding: 10px !important;
        }
    </style>
@endsection

{{-- Title --}}
@section('html_title', 'Book Entry')
@section('page_title', 'Book Entry')

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">System</li>
    <li class="breadcrumb-item"><a href="{{ route('system.audit-log.index') }}">Audit Log</a></li>
    <li class="breadcrumb-item active">{{ $auditLog->id }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    <div class="card">
        <div class="card-body">

            <table class="table table-striped">
                <tbody>
                <tr>
                    <th scope="row">ID</th>
                    <td>{{$auditLog->id}}</td>
                </tr>
                <tr>
                    <th scope="row">User ID</th>
                    {{-- todo to user detail page--}}
                    <td><a href="#">{{$auditLog->user_id}}</a></td>
                </tr>
                <tr>
                    <th scope="row">User Type</th>
                    <td>{{$auditLog->user_type}}</td>
                </tr>
                <tr>
                    <th scope="row">User Agent</th>
                    <td>{{$auditLog->user_agent}}</td>
                </tr>
                <tr>
                    <th scope="row">IP Address</th>
                    <td><code>{{$auditLog->ip_address}}</code></td>
                </tr>
                <tr>
                    <th scope="row">Event</th>
                    <td>
                        <h5>
                        @switch($auditLog->event)
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
                        </h5>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Auditable ID</th>
                    {{-- todo to detail page--}}
                    <td><a href="#">{{$auditLog->auditable_id}}</a></td>
                </tr>
                <tr>
                    <th scope="row">Auditable Type</th>
                    <td>{{$auditLog->auditable_type}}</td>
                </tr>
                <tr>
                    <th scope="row">URL</th>
                    <td><a href="{{$auditLog->url}}" target="_blank">{{$auditLog->url}}<i class="fas fa-external-link-alt ml-1"></i></a></td>
                </tr>
                <tr>
                    <th scope="row">Tags</th>
                    <td>{{$auditLog->tags}}</td>
                </tr>
                <tr>
                    <th scope="row">Old values</th>
                    <td><pre class="prettyprint">{{json_encode(json_decode($auditLog->old_values), JSON_PRETTY_PRINT)}}</pre></td>
                </tr>
                <tr>
                    <th scope="row">New values</th>
                    <td><pre class="prettyprint">{{json_encode(json_decode($auditLog->new_values), JSON_PRETTY_PRINT)}}</pre></td>
                </tr>
                <tr>
                    <th scope="row">Created at</th>
                    <td><kbd>{{$auditLog->created_at->diffForHumans()}}</kbd><br>{{$auditLog->created_at}}</td>
                </tr>
                <tr>
                    <th scope="row">Updated at</th>
                    <td><kbd>{{$auditLog->updated_at->diffForHumans()}}</kbd><br>{{$auditLog->updated_at}}</td>
                </tr>

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <a href="{{ route('system.audit-log.index') }}" class="btn cur-p btn-secondary">Back</a>
        </div>
        <!-- /.card-footer -->
    </div>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
@endpush
