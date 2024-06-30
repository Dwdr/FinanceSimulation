{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_ssc')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('ssc_help_index.title_html'))
@section('page_title', __('ssc_help_index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('ssc_help_index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item">{{ __('ssc_help_index.breadcrumb_level_3') }}</li>

@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    <div class="row">
        <div class="col-12" id="accordion">
            @foreach($helps as $h)
            <div class="card card-{{config('constants.COLOR.'.$h->color)}} card-outline">
                <a class="d-block w-100" data-toggle="collapse" href="#faq_{{$loop->index}}">
                    <div class="card-header">
                        <h4 class="card-title w-100">
                            {{$h->content['question']}}
                        </h4>
                    </div>
                </a>
                <div id="faq_{{$loop->index}}" class="collapse @if($loop->index==0) show @endif" data-parent="#accordion">
                    <div class="card-body">
                        {{$h->content['answer']}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-3 text-center">
            <p class="lead">
                <a href="mailto:{{Auth::user()->profile->organization->config['contact_email']??'info@clixells.com'}}">Contact us</a>,
                if you found not the right anwser or you have a other question?<br />
            </p>
        </div>
    </div>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
