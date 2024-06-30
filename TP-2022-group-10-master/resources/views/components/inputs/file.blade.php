<div class="form-group">
    <label class="form-control-label">{{$label}} @if(!$isReadonly && $required)<span
            class="text-danger">*</span>@endif</label>
    <div class="">
        @if($isReadonly && $legacy)
            <ul class="mailbox-attachments clearfix">
                @foreach($value as $v)
                    <li style="margin-bottom: 0;">
                        <span class="mailbox-attachment-icon"><i class="far {{$getFileIcon($v['file_extension'])}}"></i></span>
                        <div class="mailbox-attachment-info">
                            <div class="mailbox-attachment-name">
                                <i class="fas fa-paperclip"></i> {{$v['file_name']}}
                            </div>
                            <span class="mailbox-attachment-size">
                              {{$humanFileSize($v['file_size'])}}&nbsp;
                              <a href="{{route('files',['s'=>Auth::user()->profile->organization->name_slug,'p'=>$v['file_path'].$v['file_name'],'fn'=>$v['file_source_name'],'dl'=>1])}}"
                                 class="btn btn-default btn-xs" target="_blank" style="float: right"><i class="fas fa-cloud-download-alt"></i></a>
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>

        @elseif($isReadonly && sizeof($value)==0)
            -
        @else
            <div class="file-loading">
                <input id="id_{{$removeNameArray($name)}}" name="{{$name}}" type="file"
                       @if($type=='multiple') multiple @endif
                       @if($placeholder!='') data-msg-placeholder="{{$placeholder}}" @endif
                       @if($accept!='') accept="{{$accept}}" @endif
                >
            </div>
            <div id="errorBlock_id_{{$removeNameArray($name)}}" class="help-block"></div>
            @if($tips!='' && !$isReadonly)
                <small id="fileHelp" class="form-text text-muted">{{$tips}}</small>
            @endif
        @endif
    </div>
</div>

@if(!$isReadonly)
    @push('form_script_validation')
        '{{$name}}': {
        @if($required)required:true, @endif
        },
    @endpush
@endif

@section('form_style_file_input')
    <!-- Bootstrap FileInput -->
    <link href="{{asset('vendor/adminlte-3.1.0/plugins/bootstrap-fileinput/css/fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css"/>
    {{--    <link href="{{asset('vendor/adminlte-3.1.0/plugins/bootstrap-fileinput/themes/fas/theme.css')}}" media="all" rel="stylesheet" type="text/css"/>--}}
@endsection

@section('form_script_file_input')
    <!-- Bootstrap FileInput -->
    <script src="{{asset('vendor/adminlte-3.1.0/plugins/bootstrap-fileinput/js/plugins/piexif.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/adminlte-3.1.0/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/adminlte-3.1.0/plugins/bootstrap-fileinput/js/fileinput.min.js')}}"></script>
    <script src="{{asset('vendor/adminlte-3.1.0/plugins/bootstrap-fileinput/themes/fas/theme.js')}}"></script>
    <script src="{{asset('vendor/adminlte-3.1.0/plugins/bootstrap-fileinput/js/locales/'.(App::getLocale()=='en_GB'?'LANG':(App::getLocale()=='zh_HK'?'zh-TW':'zh')).'.js')}}"></script>
@endsection

@push('body_end_scripts')
    <script>
        var krajeeGetCount = function (id) {
            var cnt = $('#' + id).fileinput('getFilesCount');
            return cnt === 0 ? 'You have no files remaining.' :
                'You have ' + cnt + ' file' + (cnt > 1 ? 's' : '') + ' remaining.';
        };

        $('#id_{{$removeNameArray($name)}}').fileinput({
            language: "{{(App::getLocale()=='en_GB'?'LANG':(App::getLocale()=='zh_HK'?'zh-TW':'zh'))}}",
            dropZoneEnabled: false,
            theme: "fas",
            showUpload: false,
            showClose: false,
            @if($isReadonly)
            showCaption: false,
            showRemove: false,
            showBrowse: false,
            @endif
                @if($fileMax!=0)
            maxFileSize: {{$fileMax}},
            @endif
                @if($fileMinCount!=0)
            minFileCount: {{$fileMinCount}},
            @endif
                @if($fileMaxCount!=0)
            maxFileCount: {{$fileMaxCount}},
            @endif
                @if($allowedFileExtensions!='')
            allowedFileExtensions: {!! $allowedFileExtensions !!},
            @endif
                @if($allowedFileTypes!='')
            allowedFileTypes: {!! $allowedFileTypes !!},
            @endif
            elErrorContainer: "#errorBlock_id_{{$removeNameArray($name)}}",
            showPreview: true,
            preferIconPreview: true,
            reversePreviewOrder: true,
            overwriteInitial: false,
            validateInitialCount: true,

            // TODO edit and show page
            initialPreview: [
                @if($isReadonly||$isEdit)
                    @foreach($value as $v)
                    '{!! route('files',['s'=>Auth::user()->profile->organization->name_slug,'p'=>$v['file_path'].$v['file_name'],'fn'=>$v['file_source_name'],'dl'=>0]) !!}',
                @endforeach
                @endif
            ],
            initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
            initialPreviewFileType: 'image', // image is the default and can be overridden in config below
            @if(!$isEdit)
            layoutTemplates: {
                actionDelete: '',
                actionDrag: '',
            },
            initialPreviewShowDelete: false,
            @endif
            initialPreviewConfig: [
                    @if($isReadonly||$isEdit)
                    @foreach($value as $v)
                {
                    type: "{{$v['file_type']}}",
                    caption: "{{$v['file_source_name']}}",
                    downloadUrl: "{{route('files',['s'=>Auth::user()->profile->organization->name_slug,'p'=>$v['file_path'].$v['file_name'],'fn'=>$v['file_source_name'],'dl'=>0])}}",
                    @if($deleteRoute!='')
                        url: "{{route($deleteRoute,['uuid'=>$deleteModelId,'p'=>$v['file_path'].$v['file_name'],'fn'=>$v['file_source_name'],'field'=>$removeNameArray($name)])}}",
                    @endif
                    size: {{$v['file_size']}},
                    width: "120px",
                    key: {{$loop->index}}
                },
                @endforeach
                @endif
            ],
            @if($isEdit && $deleteRoute !='')
            // deleteUrl: "/site/file-delete",
            @endif
        }).on('filebeforedelete', function () {
            var aborted = !window.confirm('Are you sure you want to delete this file?');
            {{--if (aborted) {--}}
            {{--    window.alert('File deletion was aborted! ' + krajeeGetCount('id_{{$removeNameArray($name)}}'));--}}
            {{--};--}}
                return aborted;
        }).on('filedeleted', function () {
            setTimeout(function () {
                console.log('File deletion was successful! ' + krajeeGetCount('id_{{$removeNameArray($name)}}'))
            }, 900);
        });
    </script>
@endpush

