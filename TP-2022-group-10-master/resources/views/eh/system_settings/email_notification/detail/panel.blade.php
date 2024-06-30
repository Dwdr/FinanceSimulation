{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('eh.system_settings.index') }}" class="btn cur-p btn-secondary">{{ __('eh/system_settings/email_notification/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-SETTINGS-EMAIL-NOTIFICATION-U"))
        <a href="{{ route('eh.system_settings.email_notification.edit',$c->id) }}"
           class="btn cur-p btn-success">{{ __('eh/system_settings/email_notification/detail_panel.btn_edit') }}</a>
    @endcan
    @else
        @include('layouts.adminlte_3.components.modal', [
            'type'=>'cancel',
            'modal_name'=>'modal_cancel',
            'btn_name'=> __('eh/system_settings/email_notification/detail_panel.btn_cancel'),
            'msg_heading'=> __('eh/system_settings/email_notification/detail_panel.cancel_msg_heading'),
            'msg_question'=> __('eh/system_settings/email_notification/detail_panel.cancel_msg_question'),
            'btn_msg_yes'=> __('eh/system_settings/email_notification/detail_panel.btn_cancel_msg_yes'),
            'btn_msg_no'=> __('eh/system_settings/email_notification/detail_panel.btn_cancel_msg_no'),
            'url'=> URL::previous()])
        <button type="submit"
                class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('eh/system_settings/email_notification/detail_panel.btn_save') }} @else {{ __('eh/system_settings/email_notification/detail_panel.btn_update') }} @endif</button>
    @endif
    {{csrf_field()}}
