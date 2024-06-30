<div class="form-group">
    <label class="form-control-label" for="id_{{$removeNameArray($name)}}">{{$label}} @if(!$isReadonly && $required)<span class="text-danger">*</span>@endif</label>
    <div class="col-sm-9">
        @if($isReadonly)
            <h4>
                @if($value)
                    <span class="badge bg-primary">{{$onText}}</span>
                @else
                    <span class="badge bg-danger">{{$offText}}</span>
                @endif
            </h4>
        @else
            <input type="checkbox" id="id_{{$removeNameArray($name)}}" name="{{$name}}" data-bootstrap-switch
                   data-on-text="{{$onText}}" data-off-text="{{$offText}}" data-off-color="danger"
                   @if($isReadonly) readonly @endif
                   @if($value) checked @endif
            >
        @endif
    </div>
</div>

@push('form_script_validation')
    '{{$name}}': {
    @if($required)required:true, @endif
    },
@endpush

@section('form_script_switch')
    @include('layouts.adminlte_3.components.form.script_switch')
@endsection
