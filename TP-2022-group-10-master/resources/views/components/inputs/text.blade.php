<div class="form-group @if($type=='hidden') d-none @endif">
    @if($label!='')
    <label class="form-control-label" for="id_{{$removeNameArray($name)}}">{{$label}} @if(!$isReadonly && $required)<span
            class="text-danger">*</span>@endif</label>
    @endif
    <div class="">
        @if($isReadonly)
            {{ old($name, isset($value) ? $value != '' ? $value: '-' :'-') }}
        @else
            <div>
                <input
                    id="id_{{$removeNameArray($name)}}"
                    name="{{$name}}"
                    type="{{$type}}"
                    class="form-control"
                    value="{{ old($name, $value ?? '-') }}"
                    placeholder="{{$placeholder}}"
                    @if($required) required @endif
{{--                    @if($type == 'number' || $type == 'tel')--}}
{{--                    pattern="[0-9]*"--}}
{{--                    @endif--}}
                    {{$attributes}}
                >
            </div>
            @if($hints != '')
                <small id="{{$removeNameArray($name)}}HelpBlock" class="form-text text-muted">
                    {{$hints}}
                </small>
            @endif
        @endif
    </div>
</div>

@if(!$isReadonly)
    @push('form_script_validation')
        '{{$name}}': {
        @if($required)required:true, @endif
        @if($max!='' && $min!='')
            @if($max==$min)
                exactlength: {{$max}},
            @else
                range: [{{$min}}, {{$max}}],
            @endif
        @else
            @if($type=='number')
                number: true,
                @if($max!='')max: {{$max}},@endif
                @if($min!='')min: {{$min}},@endif
            @else
                @if($max!='')maxlength: {{$max}},@endif
                @if($min!='')minlength: {{$min}},@endif
            @endif
        @endif
        },
    @endpush
@endif
