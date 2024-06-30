{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/site/detail.title_html'))
@section('page_title', __('eh/configurations/site/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/site/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/site/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a
            href="{{ route('eh.configurations.site.index') }}">{{ __('eh/configurations/site/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/site/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $s->id }} {{ $s->id }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/site/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.site.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if(!$mode['isModeEdit']){{route('eh.configurations.site.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.site.update', $s->id)}}@endif"
              method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                @if($mode['isModeShow'])
                    <div class="form-group">
                        <label class="form-control-label" for="qrcode">QR code</label>
                        <div>
                            @php
                                $qrcode = [
                                    'site_id' => $s->id,
                                    'site' => $s->site['en-GB']
                                ];
                                $qrcode = json_encode($qrcode);
                            @endphp
                            <img src="https://chart.googleapis.com/chart?cht=qr&chs=180x180&choe=UTF-8&chld=L|2&chl={{$qrcode}}"
                                 id='qrcode' alt="site qrcode"/>
                        </div>
                    </div>
                @endif

                <x-inputs.text
                    :label="__('eh/configurations/site/detail.lb_site_en_gb')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$s->site['en-GB'] ?? ''}}"
                    name="site[en-GB]"
                />

                <x-inputs.text
                    :label="__('eh/configurations/site/detail.lb_site_zh_hk')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$s->site['zh_HK'] ?? ''}}"
                    name="site[zh_HK]"
                />

                <x-inputs.text
                    :label="__('eh/configurations/site/detail.lb_site_zh_cn')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$s->site['zh_CN'] ?? ''}}"
                    name="site[zh_CN]"
                />

                <x-inputs.text
                    :label="__('eh/configurations/site/detail.lb_gps_lat')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$s->gps['lat'] ?? ''}}"
                    name="gps[lat]"
                />

                <x-inputs.text
                    :label="__('eh/configurations/site/detail.lb_gps_long')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$s->gps['long'] ?? ''}}"
                    name="gps[long]"
                />

                <x-inputs.switch2
                    label="{{ __('eh/configurations/site/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$s->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/configurations/site/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/site/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$s->updated_at" :createdAt="$s->created_at"/>
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.site.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
