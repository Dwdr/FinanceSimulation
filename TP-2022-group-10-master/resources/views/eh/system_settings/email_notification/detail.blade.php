{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/system_settings/email_notification/detail.title_html'))
@section('page_title', __('eh/system_settings/email_notification/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/system_settings/email_notification/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/system_settings/email_notification/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item">{{ __('eh/system_settings/email_notification/detail.breadcrumb_level_3') }}</li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/system_settings/email_notification/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $c->name }}</li>
            <li class="breadcrumb-item active">{{ __('eh/system_settings/email_notification/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.system_settings.email_notification.detail.panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if($mode['isModeEdit']){{route('eh.system_settings.email_notification.update', $c->id)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('eh/system_settings/email_notification/detail.th_email_template_type') }}</th>
                        <th scope="col">{{ __('eh/system_settings/email_notification/detail.th_email_template_description') }}</th>
                        <th scope="col" class="text-center">{{ __('eh/system_settings/email_notification/detail.th_admin') }}</th>
                        <th scope="col" class="text-center">{{ __('eh/system_settings/email_notification/detail.th_employee') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($types as $key => $value)
                        @if($value != \App\Models\EH\SystemSettings\EmailTemplateType::MSG_JA_0001 &&
                            $value != \App\Models\EH\SystemSettings\EmailTemplateType::MSG_JA_0002 &&
                            $value != \App\Models\EH\SystemSettings\EmailTemplateType::MSG_JA_0003 &&
                            $value != \App\Models\EH\SystemSettings\EmailTemplateType::MSG_JA_0004 &&
                            $value != \App\Models\EH\SystemSettings\EmailTemplateType::MSG_LA_0001 &&
                            $value != \App\Models\EH\SystemSettings\EmailTemplateType::MSG_LA_0002 &&
                            $value != \App\Models\EH\SystemSettings\EmailTemplateType::MSG_PS_0001 &&
                            $value != \App\Models\EH\SystemSettings\EmailTemplateType::MSG_PS_0002
                            )
                            @continue
                        @endif
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ __('eh/system_settings/email_notification/detail.td_type_description_'.$key) }}</td>
                            <td class="text-center">
                                @if($mode['isModeShow'])
                                    @if($c->email_notification[$value]['admin']??false) <i class="fas fa-check-circle text-success"></i> @endif
                                @else
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="id_{{$key}}_admin_{{$loop->index}}"
                                               name="email_notification[{{$value}}][admin]"
                                               value="on"
                                               @if($mode['isModeShow']) disabled @endif
                                               @if($c->email_notification[$value]['admin']??false) checked @endif
                                        >
                                        <label for="id_{{$key}}_admin_{{$loop->index}}"></label>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($mode['isModeShow'])
                                    @if($c->email_notification[$value]['employee']??false) <i class="fas fa-check-circle text-success"></i> @endif
                                @else
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="id_{{$key}}_employee_{{$loop->index}}"
                                               name="email_notification[{{$value}}][employee]"
                                               value="on"
                                               @if($mode['isModeShow']) disabled @endif
                                               @if($c->email_notification[$value]['employee']??false) checked @endif
                                        >
                                        <label for="id_{{$key}}_employee_{{$loop->index}}"></label>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$c->updated_at"/>
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.system_settings.email_notification.detail.panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
