<div class="form-group @if($hidden) d-none @endif">
    <label class="form-control-label" for="id_{{$removeNameArray($name)}}">{{$label}} @if(!$isReadonly && $required)<span
            class="text-danger">*</span>@endif</label>
    <div class="">
        @if($isReadonly)
            @foreach($option as $key => $o)
                @if($value==$o || ($loop->index==0 && $value==""))
                    <h5><span class="badge bg-primary">
                            @if(trans()->has($lang.'.radio_option_'.strtolower($key)))
                                {{trans($lang.'.radio_option_'.strtolower($key))}}
                            @else
                                {{$key}}
                            @endif
                        </span>
                    </h5>
                @endif
            @endforeach
        @else
            @foreach($option as $key => $o)
                <div class="icheck-primary d-inline mr-2">
                    <input type="radio" id="id_{{$removeNameArray($name)}}_{{$loop->index}}" name="{{$name}}"
                           value="{{$o}}"
                           @if($isReadonly) disabled @endif
                           @if($value==$o || ($loop->index==0 && $value=="")) checked @endif
                    >
                    <label for="id_{{$removeNameArray($name)}}_{{$loop->index}}">
                        @if(trans()->has($lang.'.radio_option_'.strtolower($key)))
                            {{trans($lang.'.radio_option_'.strtolower($key))}}
                        @else
                            {{$key}}
                        @endif
                    </label>
                </div>
            @endforeach
        @endif
    </div>
</div>

@push('form_script_validation')
    '{{$name}}': {
    @if($required)required:true, @endif
    },
@endpush
