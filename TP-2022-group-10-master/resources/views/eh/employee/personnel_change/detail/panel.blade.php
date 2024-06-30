{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('eh.personnel_change.index') }}" class="btn cur-p btn-secondary">{{ __('eh/employee/personnel_change/detail_panel.btn_back') }}</a>
{{--    @can(config("constants.PERMISSION.EH-EMPLOYEE-PERSONNEL-CHANGE-C"))--}}
{{--        <a href="{{ route('eh.personnel_change.create') }}" class="btn cur-p btn-primary">{{ __('eh/employee/personnel_change/detail_panel.btn_new') }}</a>--}}
{{--    @endcan--}}

    @hasanyrole(config('constants.ROLE.SUPER_ADMIN').'|'.config('constants.ROLE.ADMIN'))
        @if($ep->status != config('constants.EMPLOYEE_LOG.STATUS.APPROVED'))
            <a href="{{ route('eh.personnel_change.edit',$ep->hash_id) }}" class="btn cur-p btn-success">{{ __('eh/employee/personnel_change/detail_panel.btn_edit') }}</a>
        @endif
    @else
        @can(config("constants.PERMISSION.ACCOUNT-U"))
            @if($ep->status == config('constants.EMPLOYEE_LOG.STATUS.SUBMITTED'))
                @include('layouts.adminlte_3.components.modal', [
                'type'=>'delete',
                'modal_name'=>'modal_delete',
                'btn_name'=> __('eh/employee/personnel_change/detail_panel.btn_cancel'),
                'msg_heading'=> __('eh/employee/personnel_change/detail_panel.delete_msg_heading'),
                'msg_question'=> __('eh/employee/personnel_change/detail_panel.delete_msg_question'),
                'btn_msg_yes'=> __('eh/employee/personnel_change/detail_panel.btn_delete_msg_yes'),
                'btn_msg_no'=> __('eh/employee/personnel_change/detail_panel.btn_delete_msg_no'),
                'url'=> route('eh.personnel_change.destroy',$ep->hash_id)
                ])
            @endif
        @endcan
    @endrole
@else
    @include('layouts.adminlte_3.components.modal', [
    'type'=>'cancel',
    'modal_name'=>'modal_cancel',
    'btn_name'=> __('eh/employee/personnel_change/detail_panel.btn_cancel'),
    'msg_heading'=> __('eh/employee/personnel_change/detail_panel.cancel_msg_heading'),
    'msg_question'=> __('eh/employee/personnel_change/detail_panel.cancel_msg_question'),
    'btn_msg_yes'=> __('eh/employee/personnel_change/detail_panel.btn_cancel_msg_yes'),
    'btn_msg_no'=> __('eh/employee/personnel_change/detail_panel.btn_cancel_msg_no'),
    'url'=> URL::previous()])
    <button type="submit"
            class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('eh/employee/personnel_change/detail_panel.btn_save') }} @else {{ __('eh/employee/personnel_change/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
