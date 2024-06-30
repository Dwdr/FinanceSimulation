@php
    //acc exclude slrse,ml, pl; when rse=1 and % != 100

    //setup function used for 2D array search
    function searchForIdx($code, $array) {
        foreach ($array as $key => $val) {
            if ($val['code'] === $code) {
                return $key;
            }
        }
        return null;
    }

    function searchLeaveConfigByCode($code, $array, $config) {
        foreach ($array as $key => $val) {
            if ($val['code'] === $code) {
                return $array[$key][$config];
            }
        }
        return null;
    }

    function daysInAPeriod($period_from, $period_to, $from, $to){
        //following is TODO
        //check if leave period start date < period start day ?!?!?!
        //e.g. leave between 1/5-31/8, this period month is June (6) ?!?!?!
        //so take 1/6-30/6 ?!?!?!
        //check if leave period end date > period end day ?!?!?!
        //e.g. leave between 1/5-31/8, this period month is June (6) ?!?!?!

        //parially done
        $compare_from = strcmp($period_from, $from);
        if(strcmp($period_from, $from) >=0 ){
            $pick_from = $period_from;
        }else{
            $pick_from = $from;
        }
        // echo "period_from: $period_from | from: $from | $compare_from  | $pick_from <br>";

        $compare_to = strcmp($period_to, $to);
        if(strcmp($period_to, $to) <0 ){
            $pick_to = $period_to;
        }else{
            $pick_to = $to;
        }
        // echo "period_to: $period_to | to: $to | $compare_to | $pick_to <br>";

        $datediff = strtotime($pick_to) - strtotime($pick_from);
        return round($datediff / (60 * 60 * 24))+1;
    }

    function computeNwd($period_days, $s3_basic, $s3_cal_day){
        $nwd = $period_days;
        $amount_nwd = ($s3_basic/$s3_cal_day)*$nwd;
        echo '<span class="badge badge-info">$amount_nwd = ($s3_basic/$s3_cal_day)*$nwd</span> ';
        echo "<span class='badge badge-warning'>amount_nwd=$amount_nwd</span> ";
        echo "<span class='badge badge-secondary'>s3_basic=$s3_basic</span> ";
        echo "<span class='badge badge-secondary'>s3_cal_day=$s3_cal_day</span> ";
        echo "<span class='badge badge-secondary'>nwd=$nwd</span> ";
        echo "<br>";
        return $amount_nwd;
    }

    function computeAdj($period_days, $percentage, $s3_basic, $s3_cal_day){
        $nwd = $period_days;
        $percentage = $percentage/100;
        $amount_adj = ($s3_basic/$s3_cal_day)*$nwd*$percentage;
        echo '<span class="badge badge-info">$amount_adj = ($s3_basic/$s3_cal_day)*$nwd*$percentage</span> ';
        echo "<span class='badge badge-warning'>amount_adj=$amount_adj</span> ";
        echo "<span class='badge badge-secondary'>s3_basic=$s3_basic</span> ";
        echo "<span class='badge badge-secondary'>s3_cal_day=$s3_cal_day</span> ";
        echo "<span class='badge badge-secondary'>nwd=$nwd</span> ";
        echo "<span class='badge badge-secondary'>percentage=$percentage</span> ";
        echo "<br>";
        return $amount_adj;
    }


    function computeAdjRse($period_days, $percentage, $acc_12m_salary, $acc_12m_wd){
        $nwd = $period_days;
        $percentage = $percentage/100;
        $amount_rse = ($acc_12m_salary/$acc_12m_wd)*$nwd*$percentage;
        echo '<span class="badge badge-info">$amount_adj_rse = ($acc_12m_salary/$acc_12m_wd)*$nwd*$rate</span> ';
        echo "<span class='badge badge-warning'>amount_rse=$amount_rse</span> ";
        echo "<span class='badge badge-secondary'>acc_12m_salary=$acc_12m_salary</span> ";
        echo "<span class='badge badge-secondary'>acc_12m_wd=$acc_12m_wd</span> ";
        echo "<span class='badge badge-secondary'>nwd=$nwd</span> ";
        echo "<span class='badge badge-secondary'>percentage=$percentage</span> ";
        echo "<br>";
        return $amount_rse;
    }
@endphp

    <!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>HR</title>
</head>
<body>

<h1><span class="badge badge-warning">STEP 01 Config: $employee_config</span></h1>
<table class="table">
    <thead>
    <tr>
        <th>effective_date</th>
        <th>basic_salary</th>
        <th>mpf_employer_compulsory</th>
        <th>mpf_employee_compulsory</th>
        <th>mpf_employer_voluntary</th>
        <th>mpf_employee_voluntary</th>
    </tr>
    </thead>
    <tbody>
    @foreach($e->package as $p)
        <tr>
            <td>{{ $p['effective_date'] }}</td>
            <td>{{ $p['detail']['basic_salary'] }}</td>
            <td>{{ $p['detail']['mpf_employer_compulsory'] }}</td>
            <td>{{ $p['detail']['mpf_employer_voluntary'] }}</td>
            <td>{{ $p['detail']['mpf_employee_compulsory'] }}</td>
            <td>{{ $p['detail']['mpf_employee_voluntary'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h1><span class="badge badge-warning">STEP 02 Record: $leaves_records</span></h1>
<table class="table">
    <thead>
    <tr>
        <th>period_start</th>
        <th>period_end</th>
        <th>code</th>
        <th>status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($e->leave_record as $lr)
        <tr>
            <td>{{ $lr['period_start'] }}</td>
            <td>{{ $lr['period_end'] }}</td>
            <td>{{ $lr['code'] }}</td>
            <td>{{ $lr['status'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h1><span class="badge badge-warning">STEP 03 Generate: Payroll</span></h1>
@php
    //Config Period settings
        //for($j=0; $j<24;$j++){
            $s3_period_start=$payroll->generator['s3_period_start'];
            $s3_period_end=$payroll->generator['s3_period_end'];
            echo "<span class='badge badge-success'>s3_period_start=$s3_period_start</span> ";
            echo "<span class='badge badge-success'>s3_period_end=$s3_period_end</span> ";
            echo "<br>";
            //line total variables
            $total_basic = 0;
            $total_leave = 0;
            $total_holiday = 0;
            $total_ri = 0;
            $total_mpf = 0;
            $total_grand = 0;
        //}
@endphp
<table class="table">
    <thead>
    <tr>
        <th>Process</th>
        <th>Formula</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Preparation</td>
        <td>
            @php
                $s3_employee_start_year=$payroll->generator['preparation']['s3_employee_start_year'];
                $s3_employee_start_month=$payroll->generator['preparation']['s3_employee_start_month'];
                $s3_employee_start_day=$payroll->generator['preparation']['s3_employee_start_day'];
                //add logic handle leave date
                $s3_employee_end_year=$payroll->generator['preparation']['s3_employee_end_year'];
                $s3_employee_end_month=$payroll->generator['preparation']['s3_employee_end_month'];
                $s3_employee_end_day=$payroll->generator['preparation']['s3_employee_end_day'];

                $s3_period_start_year = $payroll->generator['preparation']['s3_period_start_year'];
                $s3_period_start_month = $payroll->generator['preparation']['s3_period_start_month'];
                $s3_period_end_year = $payroll->generator['preparation']['s3_period_end_year'];
                $s3_period_end_month = $payroll->generator['preparation']['s3_period_end_month'];

                $s3_cal_day=$payroll->generator['preparation']['s3_cal_day'];

                $s3_mpf_employer_compulsory=$payroll->generator['preparation']['s3_mpf_employer_compulsory'];
                $s3_mpf_employer_voluntary=$payroll->generator['preparation']['s3_mpf_employer_voluntary'];
                $s3_mpf_employee_compulsory=$payroll->generator['preparation']['s3_mpf_employee_compulsory'];
                $s3_mpf_employee_voluntary=$payroll->generator['preparation']['s3_mpf_employee_voluntary'];
            @endphp
            <span class='badge badge-dark'>s3_employee_start_year={{$s3_employee_start_year}}</span>
            <span class='badge badge-dark'>s3_employee_start_month={{$s3_employee_start_month}}</span>
            <span class='badge badge-dark'>s3_employee_start_day={{$s3_employee_start_day}}</span>
            <br>
            <span class='badge badge-dark'>s3_employee_end_year={{$s3_employee_end_year}}</span>
            <span class='badge badge-dark'>s3_employee_end_month={{$s3_employee_end_month}}</span>
            <span class='badge badge-dark'>s3_employee_end_day={{$s3_employee_end_day}}</span>
            <br>
            <span class='badge badge-dark'>s3_period_start_year={{$s3_period_start_year}}</span>
            <span class='badge badge-dark'>s3_period_start_month={{$s3_period_start_month}}</span>
            <span class='badge badge-dark'>s3_period_end_year={{$s3_period_end_year}}</span>
            <span class='badge badge-dark'>s3_period_end_month={{$s3_period_end_month}}</span>
            <br>
            <span class='badge badge-secondary'>s3_cal_day={{$s3_cal_day}}</span>
            <br>
            <span class='badge badge-dark'>s3_mpf_employer_compulsory={{$s3_mpf_employer_compulsory}}</span>
            <span class='badge badge-dark'>s3_mpf_employer_voluntary={{$s3_mpf_employer_voluntary}}</span>
            <span class='badge badge-dark'>s3_mpf_employee_compulsory={{$s3_mpf_employee_compulsory}}</span>
            <span class='badge badge-dark'>s3_mpf_employee_voluntary={{$s3_mpf_employee_voluntary}}</span>
            <br>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>Basic</td>
        <td>
            @php
                $s3_basic = $payroll->generator['basic']['s3_basic'];
            @endphp
            <span class='badge badge-success'>s3_basic={{$s3_basic}}</span>
        </td>
        <td>
            @php
                $total_basic = $payroll->generator['basic']['total_basic'];
            @endphp
            ${{ round($total_basic, 2) }}
        </td>
    </tr>
    <tr>
        <td>Leave</td>
        <td>
            @php
                $selected_array = array();

                //step 1: check if the leave records full within the calculation period
                //TODO improvement, use sql statement to filter
                //TODO improvement, should co-join table leaves_config
                foreach($e->leave_record as $lr){
                    $lr_code=$lr['code'];
                    $lr_status=$lr['status'];
                    $lr_period_start_year=date('Y', strtotime($lr['period_start']));
                    $lr_period_start_month=date('m', strtotime($lr['period_start']));
                    $lr_period_start_day=date('d', strtotime($lr['period_start']));
                    $lr_period_end_year=date('Y', strtotime($lr['period_end']));
                    $lr_period_end_month=date('m', strtotime($lr['period_end']));
                    $lr_period_end_day=date('d', strtotime($lr['period_end']));

                    //check if $s3_period_start_year = $lr_period_start_year &&
                    //check if $s3_period_start_moth = $lr_period_start_month
                    if(($s3_period_start_year == $lr_period_start_year) && ($s3_period_start_month == $lr_period_start_month)){
                        //push the leave record array to the selected array
                        array_push($selected_array, $lr);
                    }
                }

                //step 2: calculate past 12/mo acc salary and worlday (wd)
                //this should be read from table, now use manual input
                $selected_array = $payroll->generator['leave']['selected_array'];
                $acc_12m_salary = $payroll->generator['leave']['acc_12m_salary'];
                $acc_12m_wd = $payroll->generator['leave']['acc_12m_wd'];

                //step 3: get the detail of the leave type with parameters config
                for($i=0; $i<sizeof($selected_array); $i++){
                    //print the detail of the selected array, make sure data extracted are correct
                    $code = $selected_array[$i]['code'];
                    $status = $selected_array[$i]['status'];
                    $period_start = $selected_array[$i]['period_start'];
                    $period_end = $selected_array[$i]['period_end'];
                    $period_days = daysInAPeriod($s3_period_start, $s3_period_end, $period_start, $period_end);
                    $is_nwd = $selected_array[$i]->config->is_nwd;
                    $is_adj = $selected_array[$i]->config->is_adj;
                    $is_rse = $selected_array[$i]->config->is_rse;
                    $percentage = $selected_array[$i]->config->percentage;

                    //calculate the non-workday (NWD) deduction
                    if($is_nwd){
                        $total_leave -= computeNwd($period_days, $s3_basic, $s3_cal_day);
                    }

                    //calculate the rse (RSE) addition
                    //compute the addition or subtraction based on different type of leaves
                    if($is_adj){
                        if($is_rse){
                            $total_leave += computeAdjRse($period_days, $percentage, $acc_12m_salary, $acc_12m_wd);
                        }else{
                            $total_leave += computeAdj($period_days, $percentage, $s3_basic, $s3_cal_day);
                        }
                    }
                }
            @endphp
            <span class='badge badge-success'>code={{$code??''}}</span>
            <span class='badge badge-secondary'>status={{$status??''}}</span>
            <span class='badge badge-secondary'>period_start={{$period_start??''}}</span>
            <span class='badge badge-secondary'>period_end={{$period_end??''}}</span>
            <span class='badge badge-secondary'>period_days={{$period_days??''}}</span>
            <span class='badge badge-secondary'>is_nwd={{$is_nwd??''}}</span>
            <span class='badge badge-secondary'>is_adj={{$is_adj??''}}</span>
            <span class='badge badge-secondary'>is_rse={{$is_rse??''}}</span>
            <span class='badge badge-secondary'>percentage={{$percentage??''}}</span>
            <br>
        </td>
        <td>
            ${{ round($payroll->generator['leave']['total_leave'], 2) }}
        </td>
    </tr>
    <tr>
        <td>Holiday</td>
        <td>
            @php
                $selected_array = array();

                //step 1: check if the leave records full within the calculation period
                //TODO improvement, use sql statement to filter
                //TODO improvement, should co-join table leaves_config
                foreach($holiday_list as $h){
                    $lr_code=$lr['code'];
                    $lr_status=$lr['status'];
                    $lr_period_start_year=date('Y', strtotime($lr['period_start']));
                    $lr_period_start_month=date('m', strtotime($lr['period_start']));
                    $lr_period_start_day=date('d', strtotime($lr['period_start']));
                    $lr_period_end_year=date('Y', strtotime($lr['period_end']));
                    $lr_period_end_month=date('m', strtotime($lr['period_end']));
                    $lr_period_end_day=date('d', strtotime($lr['period_end']));

                    //check if $s3_period_start_year = $lr_period_start_year &&
                    //check if $s3_period_start_moth = $lr_period_start_month
                    if(($s3_period_start_year == $lr_period_start_year) && ($s3_period_start_month == $lr_period_start_month)){
                        //push the leave record array to the selected array
                        array_push($selected_array, $lr);
                    }
                }
            @endphp
        </td>
        <td>
            ${{ round($payroll->generator['holiday']['total_holiday'], 2) }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align: right;">Revalent Income (RI)</td>
        <td>
            @php
                $toral_ri = $payroll->generator['ri']['total_ri'];
            @endphp
            ${{ round($toral_ri, 2) }}
        </td>
    </tr>
    <tr>
    <tr>
        <td>MPF</td>
        <td>
            @php
                //todo fix
                $mpf_employer_compulsory = $payroll->generator['mpf']['mpf_employer_compulsory'];
                $mpf_employee_compulsory = $payroll->generator['mpf']['mpf_employee_compulsory'];
                $mpf_employer_voluntary = $payroll->generator['mpf']['mpf_employer_voluntary'];
                $mpf_employee_voluntary = $payroll->generator['mpf']['mpf_employee_voluntary'];
            @endphp

            <span class="badge badge-info">$mpf_employer_compulsory={{$toral_ri*$s3_mpf_employer_compulsory/100}}</span>
            <br>
            <span class='badge badge-warning'>mpf_employer_compulsory={{$mpf_employer_compulsory}}</span>
            <span class='badge badge-secondary'>toral_ri={{$toral_ri}}</span>
            <span class='badge badge-secondary'>s3_mpf_employer_compulsory={{$s3_mpf_employer_compulsory}}</span>
            <br>
            <span class="badge badge-info">$mpf_employee_compulsory={{$toral_ri*$s3_mpf_employee_compulsory/100}}</span><br>
            <span class='badge badge-warning'>mpf_employee_compulsory={{$mpf_employee_compulsory}}</span>
            <span class='badge badge-secondary'>toral_ri={{$toral_ri}}</span>
            <span class='badge badge-secondary'>s3_mpf_employee_compulsory={{$s3_mpf_employee_compulsory}}</span>
            <br>
            <span class="badge badge-info">$mpf_employer_voluntary={{$toral_ri*$s3_mpf_employer_voluntary/100}}</span><br>
            <span class='badge badge-warning'>mpf_employer_voluntary={{$mpf_employer_voluntary}}</span>
            <span class='badge badge-secondary'>toral_ri={{$toral_ri}}</span>
            <span class='badge badge-secondary'>s3_mpf_employer_voluntary={{$s3_mpf_employer_voluntary}}</span>
            <br>
            <span class="badge badge-info">$mpf_employee_voluntary={{$toral_ri*$s3_mpf_employee_voluntary/100}}</span>
            <br>
            <span class='badge badge-warning'>mpf_employee_voluntary={{$mpf_employee_voluntary}}</span>
            <span class='badge badge-secondary'>toral_ri={{$toral_ri}}</span>
            <span class='badge badge-secondary'>s3_mpf_employee_voluntary={{$s3_mpf_employee_voluntary}}</span>
            <br>
        </td>
        <td>
            @php
                $total_mpf = $payroll->generator['mpf']['total_mpf'];
            @endphp
            ${{round($total_mpf, 2)}}
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align: right;">Grand Total</td>
        <td>
            @php
                $total_grand = $payroll->generator['grand_total'];
            @endphp
            ${{round($total_grand, 2)}}
        </td>
    </tr>
    </tbody>
</table>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
