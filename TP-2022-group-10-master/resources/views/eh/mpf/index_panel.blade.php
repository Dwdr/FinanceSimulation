<!-- Date range -->
<div class="form-group" style="color: red;">
    hidden this part first, dont delete the logic (i.e. comment it first), use the 12 month pagination to change the month period
    <label>{{__('eh/mpf/index.th_period_date_range')}}:</label>

    <div class="input-group">
        <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
        </div>
        <input type="text" class="form-control float-right" id="reservation">
    </div>
    <!-- /.input group -->
</div>
<!-- /.form group -->

@push('body_end_scripts')
    <script src="{{asset('vendor/adminlte-3.1.0/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script>
        <!-- date-range-picker -->
        $(function () {
            //Date range picker
            $('#reservation').daterangepicker({
                opens: 'right',
                locale: {
                    "format": "YYYY-MM-DD",
                },
            }, function(start, end, label) {
                // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                window.location.href = "{{route('eh.mpf.index')}}?period_start="+start.format('YYYY-MM-DD')+"&period_end="+end.format('YYYY-MM-DD');
            });

            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            if (urlParams.has('period_start') && urlParams.has('period_end')) {
                const period_start = urlParams.get('period_start');
                const period_end = urlParams.get('period_end');
                $('#reservation').data('daterangepicker').setStartDate(period_start);
                $('#reservation').data('daterangepicker').setEndDate(period_end);
            }else{
                $('#reservation').data('daterangepicker').setStartDate('{{date('Y-m-d',strtotime("-3 month"))}}');
                $('#reservation').data('daterangepicker').setEndDate('{{date('Y-m-d')}}');
            }
        });
    </script>
@endpush
