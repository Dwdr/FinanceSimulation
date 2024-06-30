<div class="content-header">
    @hasSection('page_title')
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        @section('page_title') @show
                    </h1>
                </div><!-- /.col -->

                @hasSection('body_page_breadcrumb')
                    <!-- body_header_breadcrumb -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{--                        @hasanyrole('cs-admin|cs-teacher') --}}
                            {{--                        <li class="breadcrumb-item"><a href="{{ route('eh.dashboard.index') }}">{{__('common.home')}}</a></li> --}}
                            {{--                        @else --}}
                            <li class="breadcrumb-item"><a href="{{ route('eh.dashboard.index') }}">Financial
                                    Simulator</a></li>
                            {{--                        @endhasanyrole --}}
                            @section('body_page_breadcrumb') @show
                            {{-- <li class="breadcrumb-item active">Dashboard v2</li> --}}
                        </ol>
                    </div>
                    <!-- End body_header_breadcrumb -->
                @endif

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    @endif
</div>
