{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('eh.employee.show',$et->employee_uuid) }}"
       class="btn cur-p btn-secondary">{{ __('eh/employee/termination/detail_panel.btn_back') }}</a>
    @if($e->type != config('constants.EMPLOYEE.TYPE.RESIGNED'))
        @can(config("constants.PERMISSION.EH-EMPLOYEE-TERMINATION-U"))
            <a href="{{ route('eh.employee.termination.edit',['uuid'=>$et->employee_uuid,'hash_id'=>$et->hash_id]) }}"
               class="btn cur-p btn-success">{{ __('eh/employee/termination/detail_panel.btn_edit') }}</a>
        @endcan
        @can(config("constants.PERMISSION.EH-EMPLOYEE-TERMINATION-D"))
            @include('layouts.adminlte_3.components.modal', [
    'type'=>'delete',
    'modal_name'=>'modal_cancel',
    'btn_name'=> __('eh/employee/termination/detail_panel.btn_cancel'),
    'msg_heading'=> __('eh/employee/termination/detail_panel.cancel_msg_heading'),
    'msg_question'=> __('eh/employee/termination/detail_panel.cancel_msg_question'),
    'btn_msg_yes'=> __('eh/employee/termination/detail_panel.btn_cancel_msg_yes'),
    'btn_msg_no'=> __('eh/employee/termination/detail_panel.btn_cancel_msg_no'),
        'url'=> route('eh.employee.termination.destroy',['uuid'=>$et->employee_uuid,'hash_id'=>$et->hash_id])
            ])
        @endcan
    @endif
@else
    @include('layouts.adminlte_3.components.modal', [
    'type'=>'cancel',
    'modal_name'=>'modal_cancel',
    'btn_name'=> __('eh/employee/termination/detail_panel.btn_cancel'),
    'msg_heading'=> __('eh/employee/termination/detail_panel.cancel_msg_heading'),
    'msg_question'=> __('eh/employee/termination/detail_panel.cancel_msg_question'),
    'btn_msg_yes'=> __('eh/employee/termination/detail_panel.btn_cancel_msg_yes'),
    'btn_msg_no'=> __('eh/employee/termination/detail_panel.btn_cancel_msg_no'),
    'url'=> URL::previous()])
    @include('layouts.adminlte_3.components.modal', [
'type'=>'submit',
'modal_name'=>'modal_termination',
'btn_class' => 'btn cur-p btn-primary',
'btn_name'=> !$mode['isModeEdit']?__('eh/employee/termination/detail_panel.btn_save'):__('eh/employee/termination/detail_panel.btn_update'),
'msg_heading'=> __('eh/employee/termination/detail_panel.termination_msg_heading'),
'msg_question'=> __('eh/employee/termination/detail_panel.termination_msg_question'),
'btn_msg_yes'=> __('eh/employee/termination/detail_panel.btn_termination_msg_yes'),
'btn_msg_no'=> __('eh/employee/termination/detail_panel.btn_termination_msg_no'),
'btn_onclick_yes' => "$('#v_form').submit()"
])
@endif
{{csrf_field()}}
