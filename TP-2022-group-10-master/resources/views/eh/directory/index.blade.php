{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/employee/index.title_html'))
@section('page_title', __('eh/employee/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/employee/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active"><a href="{{route('eh.employee.index')}}">{{ __('eh/employee/index.breadcrumb_level_2') }}</a></li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')
    <section class="content">
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row">
                    @foreach($employees as $e)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">
                                    {{$e->department->name??'-'}}
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="lead"><b>{{$e->first_name.' '.$e->last_name}}</b></h2>
                                                <small>{{$e->alias}}</small>
{{--                                            <small>{{$e->employee_id??''}}</small>--}}
{{--                                            <p class="text-muted text-sm"><b>{{__('eh/employee/contact.th_designation')}}--}}
{{--                                                    : </b> {{$e->designation->name??'-'}} </p>--}}
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                @if(isset($e->tel))
                                                    <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span>
                                                        {{__('eh/employee/contact.th_tel')}} : {{$e->tel}}</li>
                                                @endif
{{--                                                @if(isset($e->address))--}}
{{--                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>--}}
{{--                                                        {{__('eh/employee/contact.th_address')}}: {{$e->address}}</li>--}}
{{--                                                @endif--}}
                                                @if(isset($e->email))
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span>
                                                        {{__('eh/employee/contact.th_email')}} : {{$e->email}}</li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="col-5 text-center">
                                            @if(isset($e->avatar_file['file_path']))
                                                <img
                                                    src="{{route('files',['s'=>Auth::user()->profile->organization->name_slug,'p'=>$e->avatar_file['file_path'].$e->avatar_file['file_name'],'fn'=>$e->avatar_file['file_source_name'],'dl'=>false])}}"
                                                    alt="user-avatar" class="img-circle img-fluid">
                                            @else
                                                <img src="{{asset('/images/user.jpg')}}" alt="user-avatar" class="img-circle img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <a href="{{ route('eh.employee.show',$e->uuid) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-user"></i> {{__('eh/employee/contact.th_view_profile')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <nav aria-label="Contacts Page Navigation">
                    {{$employees->links("pagination::bootstrap-4")}}
                </nav>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
