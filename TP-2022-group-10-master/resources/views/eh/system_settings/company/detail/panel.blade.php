{{-- Panel --}}
@if($mode['isModeShow'])
    @role(config('constants.ROLE.SUPER_ADMIN'))
    <a href="{{ route('eh.system_settings.company.index') }}"
       class="btn cur-p btn-secondary">{{ __('eh/system_settings/company/detail_panel.btn_back') }}</a>
    @else
    <a href="{{ route('eh.system_settings.index') }}" class="btn cur-p btn-secondary">{{ __('eh/system_settings/company/detail_panel.btn_back') }}</a>
    @endrole
    {{--TODO update admin permission--}}
    {{--    @can(config("constants.PERMISSION.EH-SETTINGS-COMPANY-C"))--}}
    {{--        <a href="{{ route('eh.configurations.company.create') }}" class="btn cur-p btn-primary">{{ __('eh/system_settings/company/detail_panel.btn_new') }}</a>--}}
    {{--    @endcan--}}
    @can(config("constants.PERMISSION.EH-SETTINGS-COMPANY-U"))
        <a href="{{ route('eh.system_settings.company.edit',$c->id) }}"
           class="btn cur-p btn-success">{{ __('eh/system_settings/company/detail_panel.btn_edit') }}</a>
    @endcan
    {{--    @can(config("constants.PERMISSION.EH-SETTINGS-COMPANY-D"))--}}
    {{--        @include('layouts.adminlte_3.components.modal', [--}}
    {{--    'type'=>'delete',--}}
    {{--    'modal_name'=>'modal_delete',--}}
    {{--    'btn_name'=> __('eh/system_settings/company/detail_panel.btn_delete'),--}}
    {{--    'msg_heading'=> __('eh/system_settings/company/detail_panel.delete_msg_heading'),--}}
    {{--    'msg_question'=> __('eh/system_settings/company/detail_panel.delete_msg_question'),--}}
    {{--    'btn_msg_yes'=> __('eh/system_settings/company/detail_panel.btn_delete_msg_yes'),--}}
    {{--    'btn_msg_no'=> __('eh/system_settings/company/detail_panel.btn_delete_msg_no'),--}}
    {{--    'url'=> route('eh.configurations.company.destroy',$c->id)--}}
    {{--    ])--}}
    {{--    @endcan--}}
    @else
        @include('layouts.adminlte_3.components.modal', [
            'type'=>'cancel',
            'modal_name'=>'modal_cancel',
            'btn_name'=> __('eh/system_settings/company/detail_panel.btn_cancel'),
            'msg_heading'=> __('eh/system_settings/company/detail_panel.cancel_msg_heading'),
            'msg_question'=> __('eh/system_settings/company/detail_panel.cancel_msg_question'),
            'btn_msg_yes'=> __('eh/system_settings/company/detail_panel.btn_cancel_msg_yes'),
            'btn_msg_no'=> __('eh/system_settings/company/detail_panel.btn_cancel_msg_no'),
            'url'=> URL::previous()])
        <button type="submit"
                class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('eh/system_settings/company/detail_panel.btn_save') }} @else {{ __('eh/system_settings/company/detail_panel.btn_update') }} @endif</button>
    @endif
    {{csrf_field()}}
