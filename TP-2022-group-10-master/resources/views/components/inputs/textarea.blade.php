<div class="form-group">
    <label class="form-control-label" for="id_{{$removeNameArray($name)}}">{{$label}} @if(!$isReadonly && $required)<span
            class="text-danger">*</span>@endif</label>
    <div>
        @if($isReadonly)
            @if($value!='')
                @if(!$isSummernote)
                    {!! nl2br($value) !!}
                @else
                    <div class="card">
                        <div class="card-body">
                            {!! $value !!}
                        </div>
                    </div>
                @endif
            @else
                -
            @endif
        @else
            <textarea class="form-control bg-white" name="{{$name}}" id="id_{{$removeNameArray($name)}}" rows="{{$row}}"
                      @if($isReadonly) readonly @endif
                      @if($required) required @endif
                      @if($max!='') maxlength="{{$max}}" @endif
                      placeholder="{{$placeholder}}"
            >@if(!$isSummernote){{ old($name, $value ?? '-') }}@else{!! old($name, $value ?? '-') !!}@endif</textarea>
            @if($hints != '')
                <small id="{{$removeNameArray($name)}}HelpBlock" class="form-text text-muted">
                    {!! $hints !!}
                </small>
            @endif
        @endif
    </div>
</div>

@if(!$isReadonly)
    @push('form_script_validation')
        '{{$name}}': {
        @if($required)required:true, @endif
        @if($max!='')max: {{$max}},@endif
        },
    @endpush
@endif

@if($isSummernote)
    @push('body_end_scripts')
        @if(App::getLocale()=='zh_HK')
            <script src="{{asset('vendor/adminlte-3.1.0/plugins/summernote/lang/summernote-zh-TW.min.js')}}"></script>
        @elseif(App::getLocale()=='zh_CN')
            <script src="{{asset('vendor/adminlte-3.1.0/plugins/summernote/lang/summernote-zh-CN.min.js')}}"></script>
        @endif
        <script>
            $(function () {
                //Add text editor
                $('#id_{{$removeNameArray($name)}}').summernote({
                    height: 300,
                    @if(App::getLocale()=='zh_HK')
                    lang: 'zh-TW',
                    @elseif(App::getLocale()=='zh_CN')
                    lang: 'zh-CN',
                    @endif
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'help']],
                    ],
                })
            })
        </script>
    @endpush
@endif
