{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/cico/index.title_html'))
@section('page_title', __('eh/cico/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/cico/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/cico/index.breadcrumb_level_2') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info"
                   data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/cico/index.th_datetime') }}</th>
                    <th>{{ __('eh/cico/index.th_employee_id') }}</th>
                    <th>{{ __('eh/cico/index.th_employee') }}</th>
                    <th>{{ __('eh/cico/index.th_site') }}</th>
                    <th>{{ __('eh/cico/index.th_type') }}</th>
                    <th>{{ __('eh/cico/index.th_location') }}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/cico/index.th_datetime') }}</th>
                    <th>{{ __('eh/cico/index.th_employee_id') }}</th>
                    <th>{{ __('eh/cico/index.th_employee') }}</th>
                    <th>{{ __('eh/cico/index.th_site') }}</th>
                    <th>{{ __('eh/cico/index.th_type') }}</th>
                    <th>{{ __('eh/cico/index.th_location') }}</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($check as $c)
                    <tr>
                        <td>
                            {{ $c->created_at }}
                        </td>
                        <td>
                            {{ $c->employee->employee_id }}
                        </td>
                        <td>
                            {{ $c->employee->first_name }} {{ $c->employee->last_name }}
                        </td>
                        <td>
                            {{ $c->site->site[App::getLocale()] }}
                        </td>
                        <td>
                            {{ $c->type }}
                        </td>
                        <td>
                            <pre>{{ json_encode($c->location??[],JSON_PRETTY_PRINT) }}</pre>
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
    @include('eh.cico.index.script_table')
@endpush
