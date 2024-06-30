{{-- Timestamp --}}
<div class="form-group row">
    <label class="col-sm-3 form-control-label">Last Update</label>
    <div class="col-sm-9">
        <input type="text" value="@if($u->updated_at!=null){{ $u->updated_at->diffForHumans() }}@else{{ "n/a" }}@endif" class="form-control" id="updated_at" @if($mode['isModeShow'])readonly="readonly" @endif>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 form-control-label">Created at</label>
    <div class="col-sm-9">
        <input type="text" value="@if($u->created_at!=null){{ $u->created_at }}@else{{ "n/a" }}@endif" class="form-control" id="created_at" @if($mode['isModeShow'])readonly="readonly" @endif>
    </div>
</div>