{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('m1.holiday.index') }}" class="btn cur-p btn-secondary">{{ __('eh/m1/holiday/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-M1-HOLIDAY-C"))
        <a href="{{ route('m1.holiday.create') }}" class="btn cur-p btn-primary">{{ __('eh/m1/holiday/detail_panel.btn_new') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EA-M1-HOLIDAY-C"))
        <a href="{{ route('m1.holiday.clone', $h->id) }}" class="btn cur-p btn-primary">{{ __('eh/m1/holiday/detail_panel.btn_clone') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-M1-HOLIDAY-U"))
        <a href="{{ route('m1.holiday.edit',$h->id) }}" class="btn cur-p btn-success">{{ __('eh/m1/holiday/detail_panel.btn_edit') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-M1-HOLIDAY-D"))
        @include('layouts.adminlte_3.components.modal', [
    'type'=>'delete',
    'modal_name'=>'modal_delete',
    'btn_name'=> __('eh/m1/holiday/detail_panel.btn_delete'),
    'msg_heading'=> __('eh/m1/holiday/detail_panel.delete_msg_heading'),
    'msg_question'=> __('eh/m1/holiday/detail_panel.delete_msg_question'),
    'btn_msg_yes'=> __('eh/m1/holiday/detail_panel.btn_delete_msg_yes'),
    'btn_msg_no'=> __('eh/m1/holiday/detail_panel.btn_delete_msg_no'),
    'url'=> route('m1.holiday.destroy',$h->id)
    ])
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', [
        'type'=>'cancel',
        'modal_name'=>'modal_cancel',
        'btn_name'=> __('eh/m1/holiday/detail_panel.btn_cancel'),
        'msg_heading'=> __('eh/m1/holiday/detail_panel.cancel_msg_heading'),
        'msg_question'=> __('eh/m1/holiday/detail_panel.cancel_msg_question'),
        'btn_msg_yes'=> __('eh/m1/holiday/detail_panel.btn_cancel_msg_yes'),
        'btn_msg_no'=> __('eh/m1/holiday/detail_panel.btn_cancel_msg_no'),
        'url'=> URL::previous()])
    <button type="submit" class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('eh/m1/holiday/detail_panel.btn_save') }} @else {{ __('eh/m1/holiday/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
