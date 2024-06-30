{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('eh.configurations.holiday-type.index') }}" class="btn cur-p btn-secondary">{{ __('eh/configurations/holiday_type/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-M1-HOLIDAY-TYPE-CONFIG-C"))
        <a href="{{ route('eh.configurations.holiday-type.create') }}" class="btn cur-p btn-primary">{{ __('eh/configurations/holiday_type/detail_panel.btn_new') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EA-M1-HOLIDAY-TYPE-CONFIG-C"))
        <a href="{{ route('eh.configurations.holiday-type.clone', $t->id) }}" class="btn cur-p btn-primary">{{ __('eh/configurations/holiday_type/detail_panel.btn_clone') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-M1-HOLIDAY-TYPE-CONFIG-U"))
        <a href="{{ route('eh.configurations.holiday-type.edit',$t->id) }}" class="btn cur-p btn-success">{{ __('eh/configurations/holiday_type/detail_panel.btn_edit') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-M1-HOLIDAY-TYPE-CONFIG-D"))
        @include('layouts.adminlte_3.components.modal', [
    'type'=>'delete',
    'modal_name'=>'modal_delete',
    'btn_name'=> __('eh/configurations/holiday_type/detail_panel.btn_delete'),
    'msg_heading'=> __('eh/configurations/holiday_type/detail_panel.delete_msg_heading'),
    'msg_question'=> __('eh/configurations/holiday_type/detail_panel.delete_msg_question'),
    'btn_msg_yes'=> __('eh/configurations/holiday_type/detail_panel.btn_delete_msg_yes'),
    'btn_msg_no'=> __('eh/configurations/holiday_type/detail_panel.btn_delete_msg_no'),
    'url'=> route('eh.configurations.holiday-type.destroy',$t->id)
    ])
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', [
        'type'=>'cancel',
        'modal_name'=>'modal_cancel',
        'btn_name'=> __('eh/configurations/holiday_type/detail_panel.btn_cancel'),
        'msg_heading'=> __('eh/configurations/holiday_type/detail_panel.cancel_msg_heading'),
        'msg_question'=> __('eh/configurations/holiday_type/detail_panel.cancel_msg_question'),
        'btn_msg_yes'=> __('eh/configurations/holiday_type/detail_panel.btn_cancel_msg_yes'),
        'btn_msg_no'=> __('eh/configurations/holiday_type/detail_panel.btn_cancel_msg_no'),
        'url'=> URL::previous()])
    <button type="submit" class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('eh/configurations/holiday_type/detail_panel.btn_save') }} @else {{ __('eh/configurations/holiday_type/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
