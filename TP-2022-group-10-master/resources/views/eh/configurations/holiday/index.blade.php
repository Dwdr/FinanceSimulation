{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/holiday/index.title_html'))
@section('page_title', __('eh/configurations/holiday/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/holiday/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/holiday/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/holiday/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-HOLIDAY-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.holiday.index_panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/configurations/holiday/index.th_title') }}</th>
                    <th>{{ __('eh/configurations/holiday/index.th_type') }}</th>
                    <th>{{ __('eh/configurations/holiday/index.th_date') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/configurations/holiday/index.th_title') }}</th>
                    <th>{{ __('eh/configurations/holiday/index.th_type') }}</th>
                    <th>{{ __('eh/configurations/holiday/index.th_date') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($holiday as $h)
                    <tr>
                        <td>
                            <a href="{{ route('eh.configurations.holiday.show',$h->id) }}">
                                {{ $h->title??'-' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.holiday.show',$h->id) }}">
                                {{ $h->config->name??'-' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.holiday.show',$h->id) }}">
                                {{ $h->date??'-' }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-HOLIDAY-U"))
                                <a href="{{ route('eh.configurations.holiday.edit',$h->id) }}"><i class="fas fa-edit"></i></a>
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
    @include('eh.configurations.holiday.index_script_table')
@endpush
