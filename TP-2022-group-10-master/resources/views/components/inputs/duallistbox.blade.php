<div class="form-group">
    @if($label!='')
        <label class="form-control-label" for="id_{{$removeNameArray($name)}}">{{$label}} @if(!$isReadonly && $required)<span
                class="text-danger">*</span>@endif</label>
    @endif
    <div>
        @if($isReadonly)
            {{ old($name, isset($value) ? $value != '' ? $value: '-' :'-') }}
        @else
            <div>
                <select name="{{$name}}" id="id_{{$removeNameArray($name)}}" class="duallistbox" multiple="multiple">
                    {{ $slot }}
                </select>
            </div>
            @if($hints != '')
                <small id="{{$removeNameArray($name)}}HelpBlock" class="form-text text-muted">
                    {{$hints}}
                </small>
            @endif
        @endif
    </div>
</div>

@section('form_script_duallistbox')
    @include('layouts.adminlte_3.components.form.script_duallistbox')
@endsection
