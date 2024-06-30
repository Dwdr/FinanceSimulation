{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('eh.employee.movement.index',$em->employee_uuid) }}" class="btn cur-p btn-secondary">{{ __('eh/employee/movement/detail_panel.btn_back') }}</a>
    @if($e->type != config('constants.EMPLOYEE.TYPE.RESIGNED')||!isset($e->termination->hash_id))
        @can(config("constants.PERMISSION.EH-EMPLOYEE-MOVEMENT-C"))
            <a href="{{ route('eh.employee.movement.create',$e->uuid) }}" class="btn cur-p btn-primary">{{ __('eh/employee/movement/detail_panel.btn_new') }}</a>
        @endcan
        @can(config("constants.PERMISSION.EH-EMPLOYEE-MOVEMENT-D"))
            @include('layouts.adminlte_3.components.modal', [
        'type'=>'delete',
        'modal_name'=>'modal_delete',
        'btn_name'=> __('eh/employee/movement/detail_panel.btn_delete'),
        'msg_heading'=> __('eh/employee/movement/detail_panel.delete_msg_heading'),
        'msg_question'=> __('eh/employee/movement/detail_panel.delete_msg_question'),
        'btn_msg_yes'=> __('eh/employee/movement/detail_panel.btn_delete_msg_yes'),
        'btn_msg_no'=> __('eh/employee/movement/detail_panel.btn_delete_msg_no'),
        'url'=> route('eh.employee.movement.destroy',['uuid'=>$em->employee_uuid,'hash_id'=>$em->hash_id])
        ])
        @endcan
    @endif
@else
    @include('layouts.adminlte_3.components.modal', [
    'type'=>'cancel',
    'modal_name'=>'modal_cancel',
    'btn_name'=> __('eh/employee/movement/detail_panel.btn_cancel'),
    'msg_heading'=> __('eh/employee/movement/detail_panel.cancel_msg_heading'),
    'msg_question'=> __('eh/employee/movement/detail_panel.cancel_msg_question'),
    'btn_msg_yes'=> __('eh/employee/movement/detail_panel.btn_cancel_msg_yes'),
    'btn_msg_no'=> __('eh/employee/movement/detail_panel.btn_cancel_msg_no'),
    'url'=> URL::previous()])
    <button type="submit"
            class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('eh/employee/movement/detail_panel.btn_save') }} @else {{ __('eh/employee/movement/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
