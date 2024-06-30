{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/system_settings/email_template/index.title_html'))
@section('page_title', __('eh/system_settings/email_template/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/system_settings/email_template/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/system_settings/email_template/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/system_settings/email_template/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/system_settings/email_template/index.th_email_template_type') }}</th>
                    <th>{{ __('eh/system_settings/email_template/index.th_email_template_description') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/system_settings/email_template/index.th_email_template_type') }}</th>
                    <th>{{ __('eh/system_settings/email_template/index.th_email_template_description') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($types as $key => $value)
                    <tr>
                        <td>
                            <a href="{{ route('eh.system_settings.email_template.show',$value) }}">
                                {{ $key }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.system_settings.email_template.show',$value) }}">
                                {{ __('eh/system_settings/email_template/index.td_type_description_'.$key) }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.MM-SETTINGS-EMAIL-TEMPLATE-U"))
                                <a href="{{ route('eh.system_settings.email_template.edit',$value) }}"><i class="fas fa-edit"></i></a>
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
    @include('eh.system_settings.email_template.index.script_table')
@endpush
