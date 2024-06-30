{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/guideline/detail.title_html'))
@section('page_title', __('eh/guideline/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/guideline/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/guideline/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('eh.guideline.index') }}">{{ __('eh/guideline/detail.breadcrumb_level_3') }}</a>
    </li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/guideline/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $f->uuid }}</li>
            <li class="breadcrumb-item active">{{ __('eh/guideline/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.guideline.detail.panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if(!$mode['isModeEdit']){{route('eh.guideline.store')}}@elseif($mode['isModeEdit']){{route('eh.guideline.update', $f->uuid)}}@endif"
              method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/guideline/detail.lb_question')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$f->question ?? ''}}"
                    name="question"
                    required="true"
                />

                <x-inputs.textarea
                    :label="__('eh/guideline/detail.lb_answer')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$f->answer ?? ''}}"
                    name="answer"
                    required="true"
                />

                <x-inputs.text
                    type="number"
                    :label="__('eh/guideline/detail.lb_ordering')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$f->ordering ?? 0}}"
                    name="ordering"
                    required="true"
                    min="0"
                    step="1"
                />

                <div class="form-group">
                    <label class="form-control-label" for="id_color">{{__('eh/guideline/detail.lb_color')}} @if(!$mode['isModeShow'])<span
                            class="text-danger">*</span>@endif</label>
                    <div class="row pl-2">
                        @if($mode['isModeShow'])
                            <div class="bg-{{config('constants.COLOR.'.$f->color)}} border mr-1" style="width: 25px; height: 25px;"></div>
                        @else
                            @foreach(config('constants.COLOR') as $code => $name)
                                <div class="mb-1">
                                    <div class="icheck-primary d-inline mr-2">
                                        <input type="radio" id="id_color_{{$loop->index}}" name="color"
                                               value="{{$code}}"
                                               @if(($f->color??'')==$code || ($loop->index==0 && ($f->color??'')=='')) checked @endif
                                        >
                                        <label for="id_color_{{$loop->index}}">
                                            <div class="bg-{{$name}} border" style="width: 25px; height: 25px;"></div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <x-inputs.switch2
                    label="{{ __('eh/guideline/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$f->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/guideline/detail.select_option_yes') }}"
                    offText="{{ __('eh/guideline/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$f->updated_at" :createdAt="$f->created_at"/>
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.guideline.detail.panel')
                </div>
            @endif
        </form>
    </div>
@endsection

@section('control_sidebar')
    @include('eh.guideline.control_sidebar')
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
