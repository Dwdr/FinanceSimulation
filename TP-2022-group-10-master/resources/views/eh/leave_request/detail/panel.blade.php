{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('eh.leave_request.index') }}"
       class="btn cur-p btn-secondary">{{ __('eh/leave_request/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-LEAVE-APPLICATION-U"))
        @if($la->status == config('constants.LEAVE_APPLICATION.STATUS.PENDING'))
            <a href="{{ route('eh.leave_request.edit',$la->uuid) }}"
               class="btn cur-p btn-success">{{ __('eh/leave_request/detail_panel.btn_edit') }}</a>
        @endif
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', [
    'type'=>'cancel',
    'modal_name'=>'modal_cancel',
    'btn_name'=> __('eh/leave_request/detail_panel.btn_cancel'),
    'msg_heading'=> __('eh/leave_request/detail_panel.cancel_msg_heading'),
    'msg_question'=> __('eh/leave_request/detail_panel.cancel_msg_question'),
    'btn_msg_yes'=> __('eh/leave_request/detail_panel.btn_cancel_msg_yes'),
    'btn_msg_no'=> __('eh/leave_request/detail_panel.btn_cancel_msg_no'),
    'url'=> URL::previous()])
    <button type="submit"
            class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('eh/leave_request/detail_panel.btn_save') }} @else {{ __('eh/leave_request/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
