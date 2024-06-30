{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/guideline/index.title_html'))
@section('page_title', __('eh/guideline/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/guideline/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/guideline/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/guideline/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-FAQ-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.guideline.index.panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/guideline/index.th_type') }}</th>
                    <th>{{ __('eh/guideline/index.th_ordering') }}</th>
                    <th>{{ __('eh/guideline/index.th_question') }}</th>
                    <th>{{ __('eh/guideline/index.th_color') }}</th>
                    <th>{{ __('eh/guideline/index.th_is_active') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/guideline/index.th_type') }}</th>
                    <th>{{ __('eh/guideline/index.th_ordering') }}</th>
                    <th>{{ __('eh/guideline/index.th_question') }}</th>
                    <th>{{ __('eh/guideline/index.th_color') }}</th>
                    <th>{{ __('eh/guideline/index.th_is_active') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($faqs as $f)
                    <tr>
                        <td>
                            <a href="{{ route('eh.guideline.show',$f->uuid) }}">
                                {{ $f->type }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.guideline.show',$f->uuid) }}">
                                {{ $f->ordering }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.guideline.show',$f->uuid) }}">
                                {{ $f->content['question'] }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.guideline.show',$f->uuid) }}">
                                <div class="bg-{{config('constants.COLOR.'.$f->color)}} border mr-1" style="width: 25px; height: 25px;"></div>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.guideline.show',$f->uuid) }}">
                                @if($f->is_active)
                                    <span class="badge badge-success">{{__('common.yes')}}</span>
                                    @else
                                    <span class="badge badge-secondary">{{__('common.no')}}</span>
                                @endif
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-FAQ-U"))
                                <a href="{{ route('eh.guideline.edit',$f->uuid) }}"><i class="fas fa-edit"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('control_sidebar')
    @include('eh.guideline.control_sidebar')
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.guideline.index.script_table')
@endpush
