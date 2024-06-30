{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/help/index.title_html'))
@section('page_title', __('eh/help/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/help/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item">{{ __('eh/help/index.breadcrumb_level_2') }}</li>

@endsection

{{-- Body Main Content --}}
@section('body_main_content')
    <div class="card card-success card-outline">
        <div class="card-body">
            <div class="row">
                <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        @foreach($helps as $i => $h)
                            <a class="nav-link @if($i==0) active @endif" id="tab-name-{{ $i }}" data-toggle="pill" href="#tab-{{ $i }}" role="tab" aria-controls="tab-{{ $i }}" aria-selected="false">{{ $h->content['question'] }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="col-7 col-sm-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        @foreach($helps as $i => $h)
                            <div class="tab-pane text-left fade @if($i==0) show active @endif" id="tab-{{ $i }}" role="tabpanel" aria-labelledby="tab-name-{{ $i }}">{{ $h->content['answer'] }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <div class="row">--}}
    {{--        <div class="col-12" id="accordion">--}}
    {{--            @foreach($faqs as $f)--}}
    {{--            <div class="card card-{{config('constants.COLOR.'.$f->color)}} card-outline">--}}
    {{--                <a class="d-block w-100" data-toggle="collapse" href="#faq_{{$loop->index}}">--}}
    {{--                    <div class="card-header">--}}
    {{--                        <h4 class="card-title w-100">--}}
    {{--                            {{$f->question}}--}}
    {{--                        </h4>--}}
    {{--                    </div>--}}
    {{--                </a>--}}
    {{--                <div id="faq_{{$loop->index}}" class="collapse @if($loop->index==0) show @endif" data-parent="#accordion">--}}
    {{--                    <div class="card-body">--}}
    {{--                        {{$f->answer}}--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            @endforeach--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <div class="row">--}}
    {{--        <div class="col-12 mt-3 text-center">--}}
    {{--            <p class="lead">--}}
    {{--                <a href="mailto:{{Auth::user()->profile->organization->config['contact_email']??'info@clixells.com'}}">Contact us</a>,--}}
    {{--                if you found not the right anwser or you have a other question?<br />--}}
    {{--            </p>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection

@section('control_sidebar')
    @include('eh.help.control_sidebar')
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
