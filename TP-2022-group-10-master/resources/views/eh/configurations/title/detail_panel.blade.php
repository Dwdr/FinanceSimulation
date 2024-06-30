{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('eh.configurations.title.index') }}" class="btn cur-p btn-secondary">{{ __('eh/configurations/title/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-SETTINGS-TITLE-C"))
        <a href="{{ route('eh.configurations.title.create') }}" class="btn cur-p btn-primary">{{ __('eh/configurations/title/detail_panel.btn_new') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EA-SETTINGS-TITLE-C"))
        <a href="{{ route('eh.configurations.title.clone', $t->id) }}" class="btn cur-p btn-primary">{{ __('eh/configurations/title/detail_panel.btn_clone') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-TITLE-U"))
        <a href="{{ route('eh.configurations.title.edit',$t->id) }}" class="btn cur-p btn-success">{{ __('eh/configurations/title/detail_panel.btn_edit') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-TITLE-D"))
        @include('layouts.adminlte_3.components.modal', [
    'type'=>'delete',
    'modal_name'=>'modal_delete',
    'btn_name'=> __('eh/configurations/title/detail_panel.btn_delete'),
    'msg_heading'=> __('eh/configurations/title/detail_panel.delete_msg_heading'),
    'msg_question'=> __('eh/configurations/title/detail_panel.delete_msg_question'),
    'btn_msg_yes'=> __('eh/configurations/title/detail_panel.btn_delete_msg_yes'),
    'btn_msg_no'=> __('eh/configurations/title/detail_panel.btn_delete_msg_no'),
    'url'=> route('eh.configurations.title.destroy',$t->id)
    ])
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', [
        'type'=>'cancel',
        'modal_name'=>'modal_cancel',
        'btn_name'=> __('eh/configurations/title/detail_panel.btn_cancel'),
        'msg_heading'=> __('eh/configurations/title/detail_panel.cancel_msg_heading'),
        'msg_question'=> __('eh/configurations/title/detail_panel.cancel_msg_question'),
        'btn_msg_yes'=> __('eh/configurations/title/detail_panel.btn_cancel_msg_yes'),
        'btn_msg_no'=> __('eh/configurations/title/detail_panel.btn_cancel_msg_no'),
        'url'=> URL::previous()])
    <button type="submit" class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('eh/configurations/title/detail_panel.btn_save') }} @else {{ __('eh/configurations/title/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
