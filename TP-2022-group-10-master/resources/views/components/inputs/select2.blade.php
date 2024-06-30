<div class="form-group @if($hidden) d-none @endif" id="select2_{{$removeNameArray($name)}}">
    @if($label!='')
    <label class="form-control-label" for="id_{{$removeNameArray($name)}}">{{$label}} @if(!$isReadonly && $required)<span
            class="text-danger">*</span>@endif</label>
    @endif
    <div class="">
        @if($isReadonly)
            @if($multiple || $showCustom)
                {{ $slot }}
            @else
                @if($value!='')
                    {{$value??'-'}}
                @else
                    <select name="{{$name}}" id="id_{{$removeNameArray($name)}}" class="form-control select2"
                            @if($isReadonly)disabled="disabled" @endif
                            @if($multiple)multiple="multiple" @endif
                    >
                        <option></option>
                        {{ $slot }}
                    </select>
                @endif
            @endif
        @else
            <select name="{{$name}}" id="id_{{$removeNameArray($name)}}" class="form-control select2"
                    @if($multiple)multiple="multiple" @endif
            >
                <option></option>
                {{ $slot }}
            </select>
        @endif
    </div>
</div>

@push('form_script_validation')
    '{{$name}}': {
    @if($required)required:true, @endif
    },
@endpush

@section('form_script_select2')
    @include('layouts.adminlte_3.components.form.script_select2')
@endsection
