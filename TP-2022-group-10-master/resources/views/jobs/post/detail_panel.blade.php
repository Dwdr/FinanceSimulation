{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('jobs.post.index') }}" class="btn cur-p btn-secondary">{{ __('jobs/post/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-SETTINGS-post-C"))
        <a href="{{ route('jobs.post.create') }}" class="btn cur-p btn-primary">{{ __('jobs/post/detail_panel.btn_new') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-post-U"))
        <a href="{{ route('jobs.post.edit',$p->uuid) }}" class="btn cur-p btn-success">{{ __('jobs/post/detail_panel.btn_edit') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-post-D"))
        @include('layouts.adminlte_3.components.modal', [
    'type'=>'delete',
    'modal_name'=>'modal_delete',
    'btn_name'=> __('jobs/post/detail_panel.btn_delete'),
    'msg_heading'=> __('jobs/post/detail_panel.delete_msg_heading'),
    'msg_question'=> __('jobs/post/detail_panel.delete_msg_question'),
    'btn_msg_yes'=> __('jobs/post/detail_panel.btn_delete_msg_yes'),
    'btn_msg_no'=> __('jobs/post/detail_panel.btn_delete_msg_no'),
    'url'=> route('jobs.post.destroy',$p->uuid)
    ])
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', [
        'type'=>'cancel',
        'modal_name'=>'modal_cancel',
        'btn_name'=> __('jobs/post/detail_panel.btn_cancel'),
        'msg_heading'=> __('jobs/post/detail_panel.cancel_msg_heading'),
        'msg_question'=> __('jobs/post/detail_panel.cancel_msg_question'),
        'btn_msg_yes'=> __('jobs/post/detail_panel.btn_cancel_msg_yes'),
        'btn_msg_no'=> __('jobs/post/detail_panel.btn_cancel_msg_no'),
        'url'=> URL::previous()])
    <button type="submit" class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('jobs/post/detail_panel.btn_save') }} @else {{ __('jobs/post/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
