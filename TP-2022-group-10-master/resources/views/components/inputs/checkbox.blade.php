<div class="form-group">
        @if(sizeof($option)==1)
        <div class="icheck-primary d-inline">
            <input type="checkbox" id="id_{{$removeNameArray($name)}}_0" name="{{$name}}"
                   value="{{$option[""]}}"
                   @if($isReadonly) disabled @endif
                   @if(is_array($value))
                   @foreach($value as $v)
                   @if($v==$option[""]) checked @break @endif
                   @endforeach
                   @else
                   @if($value) checked @endif
                @endif
            >
            <label for="id_{{$removeNameArray($name)}}_0" class="mr-2">
                {{$label}}
                @if(!$isReadonly && $required)<span
                    class="text-danger">*</span>@endif
            </label>
        </div>
        @else
        <label class="form-control-label">{{$label}} @if(!$isReadonly && $required)<span
                class="text-danger">*</span>@endif</label>
        <div class="">
            @foreach($option as $key => $o)
                <div class="icheck-primary d-inline">
                    <input type="checkbox" id="id_{{$removeNameArray($name)}}_{{$loop->index}}" name="{{$name}}"
                           value="{{$o}}"
                           @if($isReadonly) disabled @endif
                           @if(is_array($value))
                           @foreach($value as $v)
                           @if($v==$o) checked @break @endif
                           @endforeach
                           @else
                           @if($value) checked @endif
                        @endif
                    >
                    <label for="id_{{$removeNameArray($name)}}_{{$loop->index}}" class="mr-2">
                        @if(trans()->has($lang.'.checkbox_option_'.strtolower($key)))
                            {{trans($lang.'.checkbox_option_'.strtolower($key))}}
                        @else
                            {{$key}}
                        @endif
                    </label>
                </div>
            @endforeach
        </div>
        @endif
</div>

@push('form_script_validation')
    '{{$name}}': {
    @if($required)required:true, @endif
    },
@endpush
