{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')

@endsection

{{-- Title --}}
@section('html_title', 'Currency')
@section('page_title', 'Currency')

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">Settings</li>
    <li class="breadcrumb-item active">Currency</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')
    @can('system.settings.c')
        <div class="card">
            <div class="card-body">
                @include('system.settings.currency.partial.panel_index')
            </div>
        </div>
    @endcan
    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info">
                <thead>
                <tr role="row">
                    <th>Currency</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($currency as $c)
                    <tr>
                        <td><a href="{{ route('system.settings.currency.show',$c->id) }}">{{ $c->currency}}</a></td>
                        <td>
                            @switch($c->status)
                                @case(1)
                                <span class="badge badge-primary">Enable</span>
                                @break

                                @case(0)
                                <span class="badge badge-danger">Not enabled</span>
                                @break

                                @endswitch
                        </td>
                        <td class="text-center">
                            @can('system.settings.r')
                                <a href="{{ route('system.settings.currency.show',$c->id) }}"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('system.settings.u')
                                <a href="{{ route('system.settings.currency.edit',$c->id) }}"><i class="fas fa-edit"></i></a>
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
    @include('system.settings.currency.partial.script_table')
@endpush
