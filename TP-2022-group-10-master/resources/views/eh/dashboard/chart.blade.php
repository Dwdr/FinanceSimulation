<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/plugins/plugin.zoom.min.js"></script>

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


    })



    /************************************
     * Stock CHART <Line Chart>
     ************************************/
    const lineChartLabels = [
        @foreach ($stockSearched as $key => $value)
            '{{ $value->Date }}',
        @endforeach
    ];

    const lineChartData = [
        @foreach ($stockSearched as $key => $value)
            '{{ $value->AdjClose }}',
        @endforeach
    ];

    // Define an empty Array of colors to hold our dynamic point colors
    let pointColors = [];

    for (let i = 0; i < lineChartData.length; i++) {
        // If not the first point, compare against the previous value
        if (i !== 0) {
            if (lineChartData[i] > lineChartData[i - 1]) {
                // Green if higher than previous value
                pointColors.push('green');
            } else {
                // Red if lower than previous value
                pointColors.push('red');
            }
        } else {
            // Add a neutral color for the first data point
            pointColors.push('rgb(0,0,255)');
        }
    }

    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: lineChartLabels,
            datasets: [{
                label: 'Adj Close',
                data: lineChartData,
                borderColor: 'rgba(0, 0, 0, 0)', // hide line by setting border to no color
                backgroundColor: 'rgba(0, 0, 0, 0)', // hide area by setting background to no color
                pointBorderColor: 'rgba(0,0,0, 0.2)', // set point border color
                pointBackgroundColor: pointColors, // add dynamic point background color
                pointRadius: 4, // increase point size to make it more prominent
                pointHoverRadius: 6 // increase hover size to make it easier to click
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                zoom: {
                    pan: {
                        enabled: true,
                        mode: 'x'
                    },
                    zoom: {
                        wheel: {
                            enabled: true,
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'xy',
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
                        maxTicksLimit: 12
                    }
                }
            }
        }
    });
</script>
