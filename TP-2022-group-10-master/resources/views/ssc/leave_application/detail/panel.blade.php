{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('ssc.leave_application.index') }}"
       class="btn cur-p btn-secondary">{{ __('ssc/leave_application/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-LEAVE-APPLICATION-C"))
        <a href="{{ route('ssc.leave_application.create') }}"
           class="btn cur-p btn-primary">{{ __('ssc/leave_application/detail_panel.btn_new') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-LEAVE-APPLICATION-C"))
        <a href="{{ route('ssc.leave_application.clone', $la->uuid) }}"
           class="btn cur-p btn-primary">{{ __('ssc/leave_application/detail_panel.btn_clone') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-LEAVE-APPLICATION-U"))
        @if($la->status == config('constants.LEAVE_APPLICATION.STATUS.PENDING')
                || Auth::user()->hasRole(config('constants.ROLE.ADMIN'))
                || Auth::user()->hasRole(config('constants.ROLE.SUPER_ADMIN')))
            <a href="{{ route('ssc.leave_application.edit',$la->uuid) }}"
               class="btn cur-p btn-success">{{ __('ssc/leave_application/detail_panel.btn_edit') }}</a>
        @endif
    @endcan
    @can(config("constants.PERMISSION.EH-LEAVE-APPLICATION-U"))
        @if($la->status == config('constants.LEAVE_APPLICATION.STATUS.PENDING'))
            @include('layouts.adminlte_3.components.modal', [
        'type'=>'delete',
        'modal_name'=>'modal_delete',
        'btn_name'=> __('ssc/leave_application/detail_panel.btn_delete'),
        'msg_heading'=> __('ssc/leave_application/detail_panel.delete_msg_heading'),
        'msg_question'=> __('ssc/leave_application/detail_panel.delete_msg_question'),
        'btn_msg_yes'=> __('ssc/leave_application/detail_panel.btn_delete_msg_yes'),
        'btn_msg_no'=> __('ssc/leave_application/detail_panel.btn_delete_msg_no'),
        'url'=> route('ssc.leave_application.destroy',$la->uuid)
        ])
        @endif
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', [
    'type'=>'cancel',
    'modal_name'=>'modal_cancel',
    'btn_name'=> __('ssc/leave_application/detail_panel.btn_cancel'),
    'msg_heading'=> __('ssc/leave_application/detail_panel.cancel_msg_heading'),
    'msg_question'=> __('ssc/leave_application/detail_panel.cancel_msg_question'),
    'btn_msg_yes'=> __('ssc/leave_application/detail_panel.btn_cancel_msg_yes'),
    'btn_msg_no'=> __('ssc/leave_application/detail_panel.btn_cancel_msg_no'),
    'url'=> URL::previous()])
    <button type="submit"
            class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('ssc/leave_application/detail_panel.btn_save') }} @else {{ __('ssc/leave_application/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
