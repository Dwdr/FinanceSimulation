{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('jobs.seeker.index') }}" class="btn cur-p btn-secondary">{{ __('jobs/seeker/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-SETTINGS-seeker-C"))
        <a href="{{ route('jobs.seeker.create') }}" class="btn cur-p btn-primary">{{ __('jobs/seeker/detail_panel.btn_new') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-seeker-U"))
        <a href="{{ route('jobs.seeker.edit',$s->uuid) }}" class="btn cur-p btn-success">{{ __('jobs/seeker/detail_panel.btn_edit') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-seeker-D"))
        @include('layouts.adminlte_3.components.modal', [
    'type'=>'delete',
    'modal_name'=>'modal_delete',
    'btn_name'=> __('jobs/seeker/detail_panel.btn_delete'),
    'msg_heading'=> __('jobs/seeker/detail_panel.delete_msg_heading'),
    'msg_question'=> __('jobs/seeker/detail_panel.delete_msg_question'),
    'btn_msg_yes'=> __('jobs/seeker/detail_panel.btn_delete_msg_yes'),
    'btn_msg_no'=> __('jobs/seeker/detail_panel.btn_delete_msg_no'),
    'url'=> route('jobs.seeker.destroy',$s->uuid)
    ])
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', [
        'type'=>'cancel',
        'modal_name'=>'modal_cancel',
        'btn_name'=> __('jobs/seeker/detail_panel.btn_cancel'),
        'msg_heading'=> __('jobs/seeker/detail_panel.cancel_msg_heading'),
        'msg_question'=> __('jobs/seeker/detail_panel.cancel_msg_question'),
        'btn_msg_yes'=> __('jobs/seeker/detail_panel.btn_cancel_msg_yes'),
        'btn_msg_no'=> __('jobs/seeker/detail_panel.btn_cancel_msg_no'),
        'url'=> URL::previous()])
    <button type="submit" class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('jobs/seeker/detail_panel.btn_save') }} @else {{ __('jobs/seeker/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
