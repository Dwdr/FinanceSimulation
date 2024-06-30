{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('jobs.banner.index') }}" class="btn cur-p btn-secondary">{{ __('jobs/banner/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-SETTINGS-banner-C"))
        <a href="{{ route('jobs.banner.create') }}" class="btn cur-p btn-primary">{{ __('jobs/banner/detail_panel.btn_new') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-banner-U"))
        <a href="{{ route('jobs.banner.edit',$b->uuid) }}" class="btn cur-p btn-success">{{ __('jobs/banner/detail_panel.btn_edit') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-banner-D"))
        @include('layouts.adminlte_3.components.modal', [
    'type'=>'delete',
    'modal_name'=>'modal_delete',
    'btn_name'=> __('jobs/banner/detail_panel.btn_delete'),
    'msg_heading'=> __('jobs/banner/detail_panel.delete_msg_heading'),
    'msg_question'=> __('jobs/banner/detail_panel.delete_msg_question'),
    'btn_msg_yes'=> __('jobs/banner/detail_panel.btn_delete_msg_yes'),
    'btn_msg_no'=> __('jobs/banner/detail_panel.btn_delete_msg_no'),
    'url'=> route('jobs.banner.destroy',$b->uuid)
    ])
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', [
        'type'=>'cancel',
        'modal_name'=>'modal_cancel',
        'btn_name'=> __('jobs/banner/detail_panel.btn_cancel'),
        'msg_heading'=> __('jobs/banner/detail_panel.cancel_msg_heading'),
        'msg_question'=> __('jobs/banner/detail_panel.cancel_msg_question'),
        'btn_msg_yes'=> __('jobs/banner/detail_panel.btn_cancel_msg_yes'),
        'btn_msg_no'=> __('jobs/banner/detail_panel.btn_cancel_msg_no'),
        'url'=> URL::previous()])
    <button type="submit" class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('jobs/banner/detail_panel.btn_save') }} @else {{ __('jobs/banner/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
