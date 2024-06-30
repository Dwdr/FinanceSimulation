{{-- Panel --}}
@include('layouts.adminlte_3.components.modal', [
    'type'=>'cancel',
    'modal_name'=>'modal_cancel',
    'btn_name'=> __('eh/payroll/create_panel.btn_cancel'),
    'msg_heading'=> __('eh/payroll/create_panel.cancel_msg_heading'),
    'msg_question'=> __('eh/payroll/create_panel.cancel_msg_question'),
    'btn_msg_yes'=> __('eh/payroll/create_panel.btn_cancel_msg_yes'),
    'btn_msg_no'=> __('eh/payroll/create_panel.btn_cancel_msg_no'),
    'url'=> URL::previous()])
<button type="submit" class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('eh/payroll/create_panel.btn_generate') }} @else {{ __('eh/payroll/create_panel.btn_update') }} @endif</button>
