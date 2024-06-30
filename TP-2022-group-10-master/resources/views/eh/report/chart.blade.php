<script>
    /* global Chart:false */
    $(function() {
        'use strict'
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }
        var mode = 'index'
        var intersect = true
        var $salesChart = $('#employee-chart')
        // eslint-disable-next-line no-unused-vars
        var salesChart = new Chart($salesChart, {
            type: 'bar',
            data: {
                labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                datasets: [{
                        backgroundColor: '#007bff',
                        borderColor: '#007bff',
                        data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
                    },
                    {
                        backgroundColor: '#ced4da',
                        borderColor: '#ced4da',
                        data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect
                },
                hover: {
                    mode: mode,
                    intersect: intersect
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        // display: false,
                        gridLines: {
                            display: true,
                            lineWidth: '4px',
                            color: 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'transparent'
                        },
                        ticks: $.extend({
                            beginAtZero: true,

                            // Include a dollar sign in the ticks
                            callback: function(value) {
                                if (value >= 1000) {
                                    value /= 1000
                                    value += ''
                                }

                                return '' + value
                            }
                        }, ticksStyle)
                    }],
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                    }]
                }
            }
        })

        /************************************
         * AREA CHART
         ************************************/
        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $('#ageRangeChart').get(0).getContext('2d')
        var areaChartData = {
            labels: [
                @foreach ($age_record as $key => $value)
                    '{{ $key }}',
                @endforeach
            ],
            datasets: [{
                label: 'Employee',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [
                    @foreach ($age_record as $key => $value)
                        {{ $value }},
                    @endforeach
                ]
            }, ]
        }
        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false,
                    }
                }]
            }
        }
        // This will get the first returned node in the jQuery collection.
        new Chart(areaChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
        })


        /************************************
         * DONUT CHART
         ************************************/
        var employeeGenderData = [
            @if (sizeof($employee_gender_report) > 0)
                @foreach ($employee_gender_report as $name => $count)
                    {
                        label: '{{ $name }}',
                        data: {{ $count }},
                        // color: '#51c0ff'
                    },
                @endforeach
            @else
                {
                    label: '{{ __('eh/report/index.lb_no_data') }}',
                    data: 1,
                    color: '#a9a9a9'
                },
            @endif
        ]
        var exitEmployeeGenderData = [
            @if (sizeof($exit_employee_gender_report) > 0)
                @foreach ($exit_employee_gender_report as $name => $count)
                    {
                        label: '{{ $name }}',
                        data: {{ $count }},
                        // color: '#51c0ff'
                    },
                @endforeach
            @else
                {
                    label: '{{ __('eh/report/index.lb_no_data') }}',
                    data: 1,
                    color: '#a9a9a9'
                },
            @endif
        ]
        $.plot('#employee-gender-chart', employeeGenderData, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    innerRadius: 0.5,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1
                    }

                }
            },
            legend: {
                show: false
            }
        })
        $.plot('#exit-employee-gender-chart', exitEmployeeGenderData, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    innerRadius: 0.5,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1
                    }

                }
            },
            legend: {
                show: false
            }
        })

        /************************************
         * Custom Label formatter
         ************************************/
        function labelFormatter(label, series) {
            return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">' +
                label +
                '<br>' +
                Math.round(series.percent) + '%</div>'
        }
    })
</script>
