{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ URL::previous() }}" class="btn cur-p btn-secondary">Back</a>
    @can('profile.u')
        <a href="{{ route('profile.edit') }}" class="btn cur-p btn-success">Edit</a>
    @endcan
    {{-- todo change password--}}
@else
    @include('layouts.adminlte_3.components.modal', ['type'=>'cancel','modal_name'=>'modal_cancel','msg_heading'=>'Cancel','msg_question'=>'Are you sure you wanna cancel this operation?','btn_name'=>'Cancel','btn_msg_yes'=>'Yes, cancel','btn_msg_no'=>'No, stay here','url'=> URL::previous()])
    <button type="submit" class="btn cur-p btn-primary">@if(!$mode['isModeEdit']) Save @else Update @endif</button>
@endif
{{csrf_field()}}
