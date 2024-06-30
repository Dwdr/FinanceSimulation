<hr>
<!-- Timestamp -->
@if($updatedAt!='')
<div class="form-group row">
    <label class="col-sm-3 form-control-label">{{__('common.timestamp_last_update')}}</label>
    <div class="col-sm-9">
{{--        <input type="text" value="{{$updatedAt?$updatedAt->diffForHumans():'N/A'}}" class="form-control" id="updated_at" readonly="readonly">--}}
        {{$updatedAt?$updatedAt->diffForHumans():'N/A'}}
    </div>
</div>
@endif
@if($createdAt!='')
<div class="form-group row">
    <label class="col-sm-3 form-control-label">{{__('common.timestamp_created_at')}}</label>
    <div class="col-sm-9">
{{--        <input type="text" value="{{$createdAt??'N/A'}}" class="form-control" id="created_at" readonly="readonly">--}}
        {{$createdAt??'N/A'}}
    </div>
</div>
@endif
