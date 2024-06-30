{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('system.settings.currency.index') }}" class="btn cur-p btn-secondary">Back</a>
    @can('system.settings.c')
        <a href="{{ route('system.settings.currency.create') }}" class="btn cur-p btn-primary">New</a>
    @endcan
    @can('system.settings.u')
        <a href="{{ route('system.settings.currency.edit',$c->id) }}" class="btn cur-p btn-success">Edit</a>
    @endcan
    @can('system.settings.d')
        @include('layouts.adminlte_3.components.modal', ['type'=>'delete','modal_name'=>'modal_delete','msg_heading'=>'Delete','msg_question'=>'Record will be deleted and cannot be undo. Are you sure?','btn_name'=>'Delete','btn_msg_yes'=>'Yes, delete','btn_msg_no'=>'No, cancel','url'=> route('system.settings.currency.destroy', $c->id) ])
    @endcan
@else
    @include('layouts.adminlte_3.components.modal', ['type'=>'cancel','modal_name'=>'modal_cancel','msg_heading'=>'Cancel','msg_question'=>'Are you sure you wanna cancel this operation?','btn_name'=>'Cancel','btn_msg_yes'=>'Yes, cancel','btn_msg_no'=>'No, stay here','url'=> URL::previous()])
    <button type="submit" class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) Save @else Update @endif</button>
@endif
{{csrf_field()}}
