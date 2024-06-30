{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('eh.configurations.highest_education.index') }}" class="btn cur-p btn-secondary">{{ __('eh/configurations/highest_education/detail_panel.btn_back') }}</a>
    @can(config("constants.PERMISSION.EH-SETTINGS-HIGHEST-EDUCATION-C"))
        <a href="{{ route('eh.configurations.highest_education.create') }}" class="btn cur-p btn-primary">{{ __('eh/configurations/highest_education/detail_panel.btn_new') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EA-SETTINGS-HIGHEST-EDUCATION-C"))
        <a href="{{ route('eh.configurations.highest_education.clone', $he->id) }}" class="btn cur-p btn-primary">{{ __('eh/configurations/highest_education/detail_panel.btn_clone') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-HIGHEST-EDUCATION-U"))
        <a href="{{ route('eh.configurations.highest_education.edit',$he->id) }}" class="btn cur-p btn-success">{{ __('eh/configurations/highest_education/detail_panel.btn_edit') }}</a>
    @endcan
    @can(config("constants.PERMISSION.EH-SETTINGS-HIGHEST-EDUCATION-D"))
        @include('layouts.adminlte_3.components.modal', [
    'type'=>'delete',
    'modal_name'=>'modal_delete',
    'btn_name'=> __('eh/configurations/highest_education/detail_panel.btn_delete'),
    'msg_heading'=> __('eh/configurations/highest_education/detail_panel.delete_msg_heading'),
    'msg_question'=> __('eh/configurations/highest_education/detail_panel.delete_msg_question'),
    'btn_msg_yes'=> __('eh/configurations/highest_education/detail_panel.btn_delete_msg_yes'),
    'btn_msg_no'=> __('eh/configurations/highest_education/detail_panel.btn_delete_msg_no'),
    'url'=> route('eh.configurations.highest_education.destroy',$he->id)
    ])
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', [
        'type'=>'cancel',
        'modal_name'=>'modal_cancel',
        'btn_name'=> __('eh/configurations/highest_education/detail_panel.btn_cancel'),
        'msg_heading'=> __('eh/configurations/highest_education/detail_panel.cancel_msg_heading'),
        'msg_question'=> __('eh/configurations/highest_education/detail_panel.cancel_msg_question'),
        'btn_msg_yes'=> __('eh/configurations/highest_education/detail_panel.btn_cancel_msg_yes'),
        'btn_msg_no'=> __('eh/configurations/highest_education/detail_panel.btn_cancel_msg_no'),
        'url'=> URL::previous()])
    <button type="submit" class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) {{ __('eh/configurations/highest_education/detail_panel.btn_save') }} @else {{ __('eh/configurations/highest_education/detail_panel.btn_update') }} @endif</button>
@endif
{{csrf_field()}}
