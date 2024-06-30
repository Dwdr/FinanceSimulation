{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/site/index.title_html'))
@section('page_title', __('eh/configurations/site/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/site/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/site/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/site/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-SITE-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.site.index_panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/configurations/site/index.th_site_en_gb') }}</th>
                    <th>{{ __('eh/configurations/site/index.th_site_zh_hk') }}</th>
                    <th>{{ __('eh/configurations/site/index.th_site_zh_cn') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/configurations/site/index.th_site_en_gb') }}</th>
                    <th>{{ __('eh/configurations/site/index.th_site_zh_hk') }}</th>
                    <th>{{ __('eh/configurations/site/index.th_site_zh_cn') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($sites as $s)
                    <tr>
                        <td>
                            <a href="{{ route('eh.configurations.site.show',$s->id) }}">
                                {{ $s->site['en-GB'] }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.site.show',$s->id) }}">
                                {{ $s->site['zh_HK'] }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.site.show',$s->id) }}">
                                {{ $s->site['zh_CN'] }}
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-SITE-U"))
                                <a href="{{ route('eh.configurations.site.edit',$s->id) }}"><i class="fas fa-edit"></i></a>
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
    @include('eh.configurations.site.index_script_table')
@endpush
