{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{asset('vendor/adminlte-3.1.0/plugins/fullcalendar/main.css')}}">
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"--}}
    {{--          integrity="sha512-KXkS7cFeWpYwcoXxyfOumLyRGXMp7BTMTjwrgjMg0+hls4thG2JGzRgQtRfnAuKTn2KWTDZX4UdPg+xTs8k80Q=="--}}
    {{--          crossorigin="anonymous"/>--}}
@endsection

{{-- Title --}}
@section('html_title', __('eh/calendar/index.title_html'))
@section('page_title', __('eh/calendar/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/calendar/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/calendar/index.breadcrumb_level_2') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <div class="card card-primary mb-5">
                <div class="card-body pt-0">
                    <div id="calendar"></div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

    <!-- fullCalendar 2.2.5 -->
    <script src="{{asset('vendor/adminlte-3.1.0/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('vendor/adminlte-3.1.0/plugins/fullcalendar/main.js')}}"></script>
    <script src="{{asset('vendor/adminlte-3.1.0/plugins/fullcalendar/locales/en-gb.js')}}"></script>
    <script src="{{asset('vendor/adminlte-3.1.0/plugins/fullcalendar/locales/zh-cn.js')}}"></script>
    <script src="{{asset('vendor/adminlte-3.1.0/plugins/fullcalendar/locales/zh-tw.js')}}"></script>

    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"--}}
    {{--            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="--}}
    {{--            crossorigin="anonymous"></script>--}}
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"--}}
    {{--            integrity="sha512-o0rWIsZigOfRAgBxl4puyd0t6YKzeAw9em/29Ag7lhCQfaaua/mDwnpE2PVzwqJ08N7/wqrgdjc2E0mwdSY2Tg=="--}}
    {{--            crossorigin="anonymous"></script>--}}

    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/en-gb.min.js"--}}
    {{--            integrity="sha512-X1raypbculVBMKBvYz5AWhTEGG2kDAprbK+4zUq5LHQBnLsK4yQHTbNTzG0ppNuM4OI2HDhOb3BkA4Oc4CEWfw=="--}}
    {{--            crossorigin="anonymous"></script>--}}
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/zh-cn.min.js"--}}
    {{--            integrity="sha512-rznCSaTz1YY+y1RmiVbsNYAuBJoQWuXSdszEcwEp96JuT7K2e8geL/qnXTbNFGwGvVjMUnoAo4mUSqatm2mOYg=="--}}
    {{--            crossorigin="anonymous"></script>--}}
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/zh-hk.min.js"--}}
    {{--            integrity="sha512-ZPINAWV9/LYngZ9wUNn51QEnQg+zq2FaHmsLQwnd3QKNw6BkzJWb3jubY/St4jX5HcoeNcWtRlN8KYgeL4X7NA=="--}}
    {{--            crossorigin="anonymous"></script>--}}

    <script>
        $(document).ready(function () {
            //Date for the calendar events (dummy data)

            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');

            // page is now ready, initialize the calendar...
            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                themeSystem: 'bootstrap',
                height: 700,
                //Random default events
                events: [
                        @foreach($holiday as $event)
                    {
                        title: '{{ $event->title }}',
                        start: new Date('{{date("Y-m-d",strtotime($event->date))}}'),
                        // change event item color
                        @if($event->type_id == 1)
                        backgroundColor: '#f56954', //red
                        borderColor: '#f56954', //red
                        @elseif($event->type_id == 2)
                        backgroundColor: '#f39c12', //yellow
                        borderColor: '#f39c12', //yellow
                        @endif
                        allDay: true
                    },
                        @endforeach
                ],
                editable: false,
                droppable: false, // this allows things to be dropped onto the calendar !!!
                locale: '{{ App::getLocale()=='zh_CN' ? 'zh-cn' : (App::getLocale()=='zh_HK' ? 'zh-hk' : 'en-gb') }}',
            });

            calendar.render();
        });
    </script>

@endpush
