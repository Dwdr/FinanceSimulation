{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('jobs.employer.index') }}" class="btn cur-p btn-secondary">{{ __('jobs/employer/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-SETTINGS-employer-C"))
        <a href="{{ route('jobs.employer.create') }}" class="btn cur-p btn-primary">{{ __('jobs/employer/detail_panel.btn_new') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-employer-U"))
        <a href="{{ route('jobs.employer.edit',$e->uuid) }}" class="btn cur-p btn-success">{{ __('jobs/employer/detail_panel.btn_edit') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-employer-D"))
        @include('layouts.adminlte_3.components.modal', [
    'type'=>'delete',
    'modal_name'=>'modal_delete',
    'btn_name'=> __('jobs/employer/detail_panel.btn_delete'),
    'msg_heading'=> __('jobs/employer/detail_panel.delete_msg_heading'),
    'msg_question'=> __('jobs/employer/detail_panel.delete_msg_question'),
    'btn_msg_yes'=> __('jobs/employer/detail_panel.btn_delete_msg_yes'),
    'btn_msg_no'=> __('jobs/employer/detail_panel.btn_delete_msg_no'),
    'url'=> route('jobs.employer.destroy',$e->uuid)
    ])
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', [
        'type'=>'cancel',
        'modal_name'=>'modal_cancel',
        'btn_name'=> __('jobs/employer/detail_panel.btn_cancel'),
        'msg_heading'=> __('jobs/employer/detail_panel.cancel_msg_heading'),
        'msg_question'=> __('jobs/employer/detail_panel.cancel_msg_question'),
        'btn_msg_yes'=> __('jobs/employer/detail_panel.btn_cancel_msg_yes'),
        'btn_msg_no'=> __('jobs/employer/detail_panel.btn_cancel_msg_no'),
        'url'=> URL::previous()])
    <button type="submit" class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('jobs/employer/detail_panel.btn_save') }} @else {{ __('jobs/employer/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
