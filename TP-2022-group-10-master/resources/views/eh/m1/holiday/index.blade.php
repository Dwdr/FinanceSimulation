{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/m1/holiday/index.title_html'))
@section('page_title', __('eh/m1/holiday/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/m1/holiday/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/m1/holiday/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/m1/holiday/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-M1-HOLIDAY-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.m1.holiday.index_panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/m1/holiday/index.th_type') }}</th>
                    <th>{{ __('eh/m1/holiday/index.th_name') }}</th>
                    <th>{{ __('eh/m1/holiday/index.th_date') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/m1/holiday/index.th_type') }}</th>
                    <th>{{ __('eh/m1/holiday/index.th_name') }}</th>
                    <th>{{ __('eh/m1/holiday/index.th_date') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($holidays as $h)
                    <tr>
                        <td>
                            <a href="{{ route('m1.holiday.show',$h->id) }}">
                                {{ $h->type }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('m1.holiday.show',$h->id) }}">
                                {{ $h->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('m1.holiday.show',$h->id) }}">
                                {{ $h->date }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-M1-HOLIDAY-U"))
                                <a href="{{ route('m1.holiday.edit',$h->id) }}"><i class="fas fa-edit"></i></a>
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
    @include('eh.m1.holiday.index_script_table')
@endpush
