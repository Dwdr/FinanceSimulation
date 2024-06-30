{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')

@endsection

{{-- Title --}}
@section('html_title', 'User')
@section('page_title', 'User')

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">System</li>
    <li class="breadcrumb-item active">User</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')
    @can('system.user.c')
        <div class="card">
            <div class="card-body">
                @include('system.user.partial.panel_index')
            </div>
        </div>
    @endcan
    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info">
                <thead>
                <tr role="row">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($users as $u)
                    <tr>
                        <td><a href="{{ route('system.user.show',$u->id) }}">{{ $u->id}}</a></td>
                        <td>{{ $u->profile->name ?? null }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            @foreach($u->roles as $role)
                                <span class="badge badge-primary">{{$role->name}}</span>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @can('system.user.r')
                                <a href="{{ route('system.user.show',$u->id) }}"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('system.user.u')
                                <a href="{{ route('system.user.edit',$u->id) }}"><i class="fas fa-edit"></i></a>
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
    @include('system.user.partial.script_table')
@endpush
