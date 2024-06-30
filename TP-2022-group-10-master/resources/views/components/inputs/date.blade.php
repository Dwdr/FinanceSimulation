<div class="form-group @if($hidden) d-none @endif" id="date_{{$removeNameArray($name)}}">
    @if($label!='')
    <label class="form-control-label" for="id_{{$name}}">{{$label}} @if(!$isReadonly && $required)<span
            class="text-danger">*</span>@endif</label>
    @endif
    <div class="">
        <div class="input-group date" id="id_{{$removeNameArray($name)}}" data-target-input="#id_{{$removeNameArray($name)}}_input">
            @if($isReadonly)
                {{ old($name, $value!='' ? date($type=='datetime'?'Y-m-d H:i':($type=='time'?'H:i':($type=='year'?'Y':'Y-m-d')),strtotime($value)) : date($type=='time'?'H:i':($type=='year'?'Y':'Y-m-d'))) }}
            @else
                <input type="text" name="{{$name}}" id="id_{{$removeNameArray($name)}}_input" class="form-control datetimepicker-input"
                       data-target="#id_{{$name}}"
                       @if($placeholder!='')
                       placeholder="{{$placeholder}}"
                       @else
                       placeholder="{{$type=='datetime'?'YYYY-MM-DD hh:mm':($type=='time'?'hh:mm':($type=='year'?'YYYY':'YYYY-MM-DD'))}}"
                       @endif

                       value="{{ old($name, $value!='' ? date($type=='datetime'?'Y-m-d H:i':($type=='time'?'H:i':($type=='year'?'Y':'Y-m-d')),strtotime($value)) : date($type=='time'?'H:i':($type=='year'?'Y':'Y-m-d'))) }}"
                       @if($required)required @endif
                />
                <div class="input-group-append" data-target="#id_{{$name}}" data-toggle="datetimepicker">
                    <div class="input-group-text">
                        @if($type!='time')
                            <i class="fa fa-calendar"></i>
                        @else
                            <i class="fa fa-clock"></i>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        @if($hints != '')
            <small id="{{$removeNameArray($name)}}HelpBlock" class="form-text text-muted">
                {{$hints}}
            </small>
        @endif
    </div>
</div>

@push('body_end_scripts')
    @if(!$isReadonly)
        <script>
            $().ready(function () {
                $('#id_{{$name}}').datetimepicker({
                    ignoreReadonly: true,
                    format: @if($format!='') '{{$format}}'
                    @else @if($type=='datetime')'YYYY-MM-DD HH:mm'@elseif($type=='time') 'HH:mm' @elseif($type=='year') 'YYYY'
                    @else 'YYYY-MM-DD' @endif @endif,
                    @if($type!='time') todayHighlight: true,
                    @endif
                    autoclose: true,
                    locale: '{{App::getLocale()}}',
                    @if($type=='datetime')icons: {time: "far fa-clock"}, @endif
                    {{--                @if(!$required) clearBtn: true, @endif--}}
                });
            });
        </script>
    @endif
@endpush

@push('form_script_validation')
    '{{$name}}': {
    @if($required)required:true, @endif
    @if($type=='datetime' || $type=='date') date: true, @endif
    @if($type=='time') time24: true, @endif
    },
@endpush
