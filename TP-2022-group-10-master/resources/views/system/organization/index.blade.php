{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')

@endsection

{{-- Title --}}
@section('html_title', 'Organization')
@section('page_title', 'Organization')

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">System</li>
    <li class="breadcrumb-item active">Organization</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')
    @can('system.organization.c')
        <div class="card">
            <div class="card-body">
                @include('system.organization.partial.panel_index')
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
                    <th>Owner</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Owner</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($organizations as $o)
                    <tr>
                        <td><a href="{{ route('system.organization.show',$o->id) }}">{{ $o->id}}</a></td>
                        <td>{{ $o->name ?? null }}</td>
                        <td>{{ $o->owner->profile->name }}</td>
                        <td class="text-center">
                            @can('system.organization.r')
                                <a href="{{ route('system.organization.show',$o->id) }}"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('system.organization.u')
                                <a href="{{ route('system.organization.edit',$o->id) }}"><i class="fas fa-edit"></i></a>
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
    @include('system.organization.partial.script_table')
@endpush
