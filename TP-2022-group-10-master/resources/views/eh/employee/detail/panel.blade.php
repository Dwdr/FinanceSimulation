{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('eh.employee.index') }}" class="btn cur-p btn-secondary mb-1">{{ __('eh/employee/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-EMPLOYEE-C"))
        <a href="{{ route('eh.employee.create') }}" class="btn cur-p btn-primary mb-1">{{ __('eh/employee/detail_panel.btn_new') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-EMPLOYEE-C"))
        <a href="{{ route('eh.employee.clone', $e->uuid) }}"
           class="btn cur-p btn-primary mb-1">{{ __('eh/employee/detail_panel.btn_clone') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-EMPLOYEE-U"))
        <a href="{{ route('eh.employee.edit',$e->uuid) }}" class="btn cur-p btn-success mb-1">{{ __('eh/employee/detail_panel.btn_edit') }}</a>
        @include('layouts.adminlte_3.components.modal', [
              'type'=>'reset',
              'modal_name'=>'modal_reset_password',
              'msg_heading'=>__('eh/employee/detail_panel.reset-password'),
              'msg_question'=>__('eh/employee/detail_panel.are-you-sure-you-wanna-reset-login-password'),
              'btn_name'=>__('eh/employee/detail_panel.reset-password'),
              'btn_class' => 'btn cur-p btn-success mb-1',
              'btn_msg_yes'=>__('eh/employee/detail_panel.yes-reset-password'),
              'btn_msg_no'=>__('common.no-cancel'),
              'url'=> route('eh.employee.reset_password', $e->uuid)
            ])
    @endcan
    @can(config("constants.PERMISSION.EH-EMPLOYEE-D"))
        @include('layouts.adminlte_3.components.modal', [
    'type'=>'delete',
    'modal_name'=>'modal_delete',
    'btn_name'=> __('eh/employee/detail_panel.btn_delete'),
    'msg_heading'=> __('eh/employee/detail_panel.delete_msg_heading'),
    'msg_question'=> __('eh/employee/detail_panel.delete_msg_question'),
    'btn_class' => 'btn cur-p btn-danger mb-1',
    'btn_msg_yes'=> __('eh/employee/detail_panel.btn_delete_msg_yes'),
    'btn_msg_no'=> __('eh/employee/detail_panel.btn_delete_msg_no'),
    'url'=> route('eh.employee.destroy',$e->uuid)
    ])
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', [
    'type'=>'cancel',
    'modal_name'=>'modal_cancel',
    'btn_name'=> __('eh/employee/detail_panel.btn_cancel'),
    'msg_heading'=> __('eh/employee/detail_panel.cancel_msg_heading'),
    'msg_question'=> __('eh/employee/detail_panel.cancel_msg_question'),
    'btn_msg_yes'=> __('eh/employee/detail_panel.btn_cancel_msg_yes'),
    'btn_msg_no'=> __('eh/employee/detail_panel.btn_cancel_msg_no'),
    'url'=> URL::previous()])
    <button type="submit"
            class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('eh/employee/detail_panel.btn_save') }} @else {{ __('eh/employee/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
