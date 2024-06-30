{{-- Timestamp --}}
<div class="form-group row">
    <label class="col-sm-3 form-control-label">{{ __('templates/adminlte/components/form/timestamp_detail.label_last_update') }}</label>
    <div class="col-sm-9">
        <input type="text" value="@if($updated_at!=null){{ $updated_at->diffForHumans() }}@else{{ "n/a" }}@endif" class="form-control" id="updated_at" @if($mode['isModeShow'])readonly="readonly" @endif>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 form-control-label">{{ __('templates/adminlte/components/form/timestamp_detail.label_created_at') }}</label>
    <div class="col-sm-9">
        <input type="text" value="@if($created_at!=null){{ $created_at }}@else{{ "n/a" }}@endif" class="form-control" id="created_at" @if($mode['isModeShow'])readonly="readonly" @endif>
    </div>
</div>