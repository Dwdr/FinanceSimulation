<?php

/*
acc exclude slrse,ml, pl; when rse=1 and % != 100
*/
//code, name, nwd(+), rse(-), nrse(-), percentage
$employee_config=[
    [
        'start_date'=>'2021-01-01', 'end_date'=>null,
        'mpf_employer_compulsory'=>5, 'mpf_employee_compulsory'=>5,
        'mpf_employer_voluntary'=>5, 'mpf_employee_voluntary'=>5,
    ],
];

//code, name, nwd(+), rse(-), nrse(-), percentage
$leaves_config=[
    ['code'=>'npl', 'name'=>'No Pay Leave', 'nwd'=>true, 'adj'=>false, 'rse'=>false, 'percentage'=>100],
    ['code'=>'slrse', 'name'=>'Sick Leave (RSE)', 'adj'=>true, 'nwd'=>true, 'rse'=>true, 'percentage'=>80],
    ['code'=>'sl', 'name'=>'Sick Leave', 'nwd'=>true, 'adj'=>true, 'rse'=>false, 'percentage'=>100],
    ['code'=>'al', 'name'=>'Annual Leave', 'nwd'=>true, 'adj'=>true, 'rse'=>true, 'percentage'=>100],
    ['code'=>'ml', 'name'=>'Mentality Leave', 'nwd'=>true, 'adj'=>true, 'rse'=>true, 'percentage'=>80],
    ['code'=>'pl', 'name'=>'Paternity Leave', 'nwd'=>true, 'adj'=>true, 'rse'=>true, 'percentage'=>80]
];

//code, name, nwd(+), rse(-), nrse(-), percentage
$holiday_config=[
    ['code'=>'sh', 'name'=>'Statutory Holiday', 'nwd'=>true, 'adj'=>true, 'rse'=>true, 'percentage'=>100],
    ['code'=>'ph', 'name'=>'Public Holiday', 'nwd'=>true, 'adj'=>true, 'rse'=>false, 'percentage'=>100],
];

//code, name, date
$holiday_list=[
    //https://www.labour.gov.hk/eng/news/latest_holidays2021.htm
    ['code'=>'sh', 'name'=>'The first day of January', 'date'=>'2021-01-01'],
    ['code'=>'sh', 'name'=>'Lunar New Year Day', 'date'=>'2021-02-12'],
    ['code'=>'sh', 'name'=>'The second day of Lunar New Year', 'date'=>'2021-02-13'],
    ['code'=>'sh', 'name'=>'The fourth day of Lunar New Year', 'date'=>'2021-02-15'],
    ['code'=>'sh', 'name'=>'Ching Ming Festival', 'date'=>'2021-04-04'],
    ['code'=>'sh', 'name'=>'Labour Day', 'date'=>'2021-05-01'],
    ['code'=>'sh', 'name'=>'Tuen Ng Festival', 'date'=>'2021-06-14'],
    ['code'=>'sh', 'name'=>'Hong Kong Special Administrative Region Establishment Day', 'date'=>'2021-07-01'],
    ['code'=>'sh', 'name'=>'The day following the Chinese Mid-Autumn Festival', 'date'=>'2021-09-22'],
    ['code'=>'sh', 'name'=>'National Day', 'date'=>'2021-10-01'],
    ['code'=>'sh', 'name'=>'Chung Yeung Festival', 'date'=>'2021-10-14'],
    //Chinese Winter Solstice Festival or Christmas Day (at the option of the employer) 21or25

    //https://www.labour.gov.hk/eng/news/latest_holidays2022.htm
    ['code'=>'sh', 'name'=>'The first day of January', 'date'=>'2022-01-01'],
    ['code'=>'sh', 'name'=>'Lunar New Year Day', 'date'=>'2022-02-01'],
    ['code'=>'sh', 'name'=>'The second day of Lunar New Year', 'date'=>'2022-02-02'],
    ['code'=>'sh', 'name'=>'The fourth day of Lunar New Year', 'date'=>'2022-02-03'],
    ['code'=>'sh', 'name'=>'Ching Ming Festival', 'date'=>'2022-04-05'],
    ['code'=>'sh', 'name'=>'Labour Day', 'date'=>'2022-05-01'],
    ['code'=>'sh', 'name'=>'Tuen Ng Festival', 'date'=>'2022-06-03'],
    ['code'=>'sh', 'name'=>'Hong Kong Special Administrative Region Establishment Day', 'date'=>'2022-07-01'],
    ['code'=>'sh', 'name'=>'The day following the Chinese Mid-Autumn Festival', 'date'=>'2022-09-12'],
    ['code'=>'sh', 'name'=>'National Day', 'date'=>'2022-10-01'],
    ['code'=>'sh', 'name'=>'Chung Yeung Festival', 'date'=>'2022-10-04'],
    //Chinese Winter Solstice Festival or Christmas Day (at the option of the employer) 22or25

    //https://www.gov.hk/en/about/abouthk/holiday/2021.htm
    ['code'=>'ph', 'name'=>'The first day of January', 'date'=>'2021-01-01'],
    ['code'=>'ph', 'name'=>'Lunar New Year Day', 'date'=>'2021-02-12'],
    ['code'=>'ph', 'name'=>'The second day of Lunar New Year', 'date'=>'2021-02-13'],
    ['code'=>'ph', 'name'=>'The fourth day of Lunar New Year', 'date'=>'2021-02-15'],
    ['code'=>'ph', 'name'=>'Good Friday', 'date'=>'2021-04-02'],
    ['code'=>'ph', 'name'=>'The day following Good Friday', 'date'=>'2021-04-03'],
    ['code'=>'ph', 'name'=>'The day following Ching Ming Festival', 'date'=>'2021-04-05'],
    ['code'=>'ph', 'name'=>'The day following Easter Monday', 'date'=>'2021-04-06'],
    ['code'=>'ph', 'name'=>'Labour Day', 'date'=>'2021-05-01'],
    ['code'=>'ph', 'name'=>'Birthday of the Buddha', 'date'=>'2021-05-19'],
    ['code'=>'ph', 'name'=>'Tuen Ng Festival', 'date'=>'2021-06-14'],
    ['code'=>'ph', 'name'=>'Hong Kong Special Administrative Region Establishment Day', 'date'=>'2021-07-01'],
    ['code'=>'ph', 'name'=>'The day following the Chinese Mid-Autumn Festival', 'date'=>'2021-09-22'],
    ['code'=>'ph', 'name'=>'National Day', 'date'=>'2021-10-01'],
    ['code'=>'ph', 'name'=>'Chung Yeung Festival', 'date'=>'2021-10-14'],
    ['code'=>'ph', 'name'=>'Christmas Day', 'date'=>'2021-12-25'],
    ['code'=>'ph', 'name'=>'The first weekday after Christmas Day', 'date'=>'2021-12-27'],

    //https://www.gov.hk/en/about/abouthk/holiday/2022.htm
    ['code'=>'ph', 'name'=>'The first day of January', 'date'=>'2022-01-01'],
    ['code'=>'ph', 'name'=>'Lunar New Year Day', 'date'=>'2022-02-01'],
    ['code'=>'ph', 'name'=>'The second day of Lunar New Year', 'date'=>'2022-02-02'],
    ['code'=>'ph', 'name'=>'The fourth day of Lunar New Year', 'date'=>'2022-02-03'],
    ['code'=>'ph', 'name'=>'Ching Ming Festival	', 'date'=>'2022-04-05'],
    ['code'=>'ph', 'name'=>'Good Friday', 'date'=>'2022-04-15'],
    ['code'=>'ph', 'name'=>'The day following Good Friday', 'date'=>'2022-04-16'],
    ['code'=>'ph', 'name'=>'Easter Monday	', 'date'=>'2022-04-18'],
    ['code'=>'ph', 'name'=>'The day following Labour Day', 'date'=>'2022-05-02'],
    ['code'=>'ph', 'name'=>'The day following Birthday of the Buddha', 'date'=>'2022-05-09'],
    ['code'=>'ph', 'name'=>'Tuen Ng Festival', 'date'=>'2022-06-03'],
    ['code'=>'ph', 'name'=>'Hong Kong Special Administrative Region Establishment Day', 'date'=>'2022-07-01'],
    ['code'=>'ph', 'name'=>'The day following the Chinese Mid-Autumn Festival', 'date'=>'2022-09-12'],
    ['code'=>'ph', 'name'=>'National Day', 'date'=>'2022-10-01'],
    ['code'=>'ph', 'name'=>'Chung Yeung Festival', 'date'=>'2022-10-04'],
    ['code'=>'ph', 'name'=>'The first weekday after Christmas Day', 'date'=>'2022-12-26'],
    ['code'=>'ph', 'name'=>'The second weekday after Christmas Day', 'date'=>'2022-12-27'],
//        ['code'=>'ph', 'name'=>'', 'date'=>'2021-00-00'],
];

//period_start, period_end, basic
$payroll_history=[
    ['period_start'=>'2021-01-01', 'period_end'=>'2021-01-31'],
    ['period_start'=>'2021-02-01', 'period_end'=>'2021-02-28'],
    ['period_start'=>'2021-03-01', 'period_end'=>'2021-03-31'],
    ['period_start'=>'2021-04-01', 'period_end'=>'2021-04-30'],
    ['period_start'=>'2021-05-01', 'period_end'=>'2021-05-31'],
    ['period_start'=>'2021-06-01', 'period_end'=>'2021-06-30'],
    ['period_start'=>'2021-07-01', 'period_end'=>'2021-07-31'],
    ['period_start'=>'2021-08-01', 'period_end'=>'2021-08-31'],
    ['period_start'=>'2021-09-01', 'period_end'=>'2021-09-30'],
    ['period_start'=>'2021-10-01', 'period_end'=>'2021-10-31'],
    ['period_start'=>'2021-11-01', 'period_end'=>'2021-11-30'],
    ['period_start'=>'2021-12-01', 'period_end'=>'2021-12-31'],
    ['period_start'=>'2022-01-01', 'period_end'=>'2022-01-31'],
    ['period_start'=>'2022-02-01', 'period_end'=>'2022-02-28'],
    ['period_start'=>'2022-03-01', 'period_end'=>'2022-03-31'],
    ['period_start'=>'2022-04-01', 'period_end'=>'2022-04-30'],
    ['period_start'=>'2022-05-01', 'period_end'=>'2022-05-31'],
    ['period_start'=>'2022-06-01', 'period_end'=>'2022-06-30'],
    ['period_start'=>'2022-07-01', 'period_end'=>'2022-07-31'],
    ['period_start'=>'2022-08-01', 'period_end'=>'2022-08-31'],
    ['period_start'=>'2022-09-01', 'period_end'=>'2022-09-30'],
    ['period_start'=>'2022-10-01', 'period_end'=>'2022-10-31'],
    ['period_start'=>'2022-11-01', 'period_end'=>'2022-11-30'],
    ['period_start'=>'2022-12-01', 'period_end'=>'2022-12-31'],
];

$salary_history=[
    ['since'=>'2021-01-01', 'basic'=>10000],
    ['since'=>'2021-09-01', 'basic'=>12000],
    ['since'=>'2022-06-01', 'basic'=>15000],
];

//code, period_start, period_end, status
$leaves_records=[
    ['code'=>'npl', 'period_start'=>'2021-03-01', 'period_end'=>'2021-03-01', 'status'=>'approved'],
    ['code'=>'slrse', 'period_start'=>'2021-04-01', 'period_end'=>'2021-04-05', 'status'=>'approved'],
    // ['code'=>'slrse', 'period_start'=>'2021-04-16', 'period_end'=>'2021-04-22', 'status'=>'approved'],
    // ['code'=>'slrse', 'period_start'=>'2021-04-17', 'period_end'=>'2021-04-22', 'status'=>'approved'],
    ['code'=>'al', 'period_start'=>'2021-06-15', 'period_end'=>'2021-06-15', 'status'=>'approved'],
    ['code'=>'ml', 'period_start'=>'2021-07-01', 'period_end'=>'2021-09-20', 'status'=>'approved'],
    ['code'=>'sl', 'period_start'=>'2021-10-01', 'period_end'=>'2021-10-01', 'status'=>'approved'],
    ['code'=>'sl', 'period_start'=>'2021-10-15', 'period_end'=>'2021-10-15', 'status'=>'approved'],
    ['code'=>'npl', 'period_start'=>'2021-10-31', 'period_end'=>'2021-10-31', 'status'=>'approved'],
];

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

?>

    <!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>HR</title>
</head>
<body>
<h1><span class="badge badge-warning">STEP 01 Config: $employee_config</span></h1>
<table class="table">
    <thead>
    <tr>
        <th>start_date</th>
        <th>end_date</th>
        <th>mpf_employer_compulsory</th>
        <th>mpf_employee_compulsory</th>
        <th>mpf_employer_voluntary</th>
        <th>mpf_employee_voluntary</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($employee_config as $ec){ ?>
    <tr>
        <td><?php echo $ec['start_date']; ?></td>
        <td><?php echo $ec['end_date']; ?></td>
        <td><?php echo $ec['mpf_employer_compulsory']; ?></td>
        <td><?php echo $ec['mpf_employee_compulsory']; ?></td>
        <td><?php echo $ec['mpf_employer_voluntary']; ?></td>
        <td><?php echo $ec['mpf_employee_voluntary']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<h1><span class="badge badge-warning">STEP 01 Config: $leaves_config</span></h1>
<table class="table">
    <thead>
    <tr>
        <th>code</th>
        <th>name</th>
        <th>nwd</th>
        <th>adj +</th>
        <th>rse</th>
        <th>percentage</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($leaves_config as $lc){ ?>
    <tr>
        <td><?php echo $lc['code']; ?></td>
        <td><?php echo $lc['name']; ?></td>
        <td><?php echo $lc['nwd']; ?></td>
        <td><?php echo $lc['adj']; ?></td>
        <td><?php echo $lc['rse']; ?></td>
        <td><?php echo $lc['percentage']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<h1><span class="badge badge-warning">STEP 01 Config: $holiday_config</span></h1>
<table class="table">
    <thead>
    <tr>
        <th>code</th>
        <th>name</th>
        <th>nwd</th>
        <th>adj +</th>
        <th>rse</th>
        <th>percentage</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($holiday_config as $hc){ ?>
    <tr>
        <td>
        <?php
        switch($hc['code']){
            case('ph'):
                echo '<span class="badge badge-danger">PH</span>';
                break;
            case('sh'):
                echo '<span class="badge badge-success">SH</span>';
                break;
        }
        ?>
        <td><?php echo $hc['name']; ?></td>
        <td><?php echo $hc['nwd']; ?></td>
        <td><?php echo $hc['adj']; ?></td>
        <td><?php echo $hc['rse']; ?></td>
        <td><?php echo $hc['percentage']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<h1><span class="badge badge-warning">STEP 01 Config: $holiday_list</span></h1>
<table class="table">
    <thead>
    <tr>
        <th>code</th>
        <th>name</th>
        <th>date</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($holiday_list as $h){ ?>
    <tr>
        <td>
            <?php
            switch($h['code']){
                case('ph'):
                    echo '<span class="badge badge-danger">PH</span>';
                    break;
                case('sh'):
                    echo '<span class="badge badge-success">SH</span>';
                    break;
            }
            ?>
        </td>
        <td><?php echo $h['name']; ?></td>
        <td><?php echo $h['date']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<h1><span class="badge badge-warning">STEP 02 Record: $salary_history</span></h1>
<table class="table">
    <thead>
    <tr>
        <th>since</th>
        <th>basic</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($salary_history as $sh){ ?>
    <tr>
        <td><?php echo $sh['since']; ?></td>
        <td><?php echo $sh['basic']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<h1><span class="badge badge-warning">STEP 02 Record: $leaves_records</span></h1>
<table class="table">
    <thead>
    <tr>
        <th>code</th>
        <th>period_start</th>
        <th>period_end</th>
        <th>status</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($leaves_records as $lr){ ?>
    <tr>
        <td><?php echo $lr['code']; ?></td>
        <td><?php echo $lr['period_start']; ?></td>
        <td><?php echo $lr['period_end']; ?></td>
        <td><?php echo $lr['status']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<h1><span class="badge badge-warning">STEP 03 Generate: Payroll</span></h1>
<?php
//Config Period settings
for($j=0; $j<sizeof($payroll_history);$j++){
$s3_period_start=$payroll_history[$j]['period_start'];
$s3_period_end=$payroll_history[$j]['period_end'];
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
?>
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
            <?php
            $s3_employee_start_year=date("Y", strtotime($employee_config[0]['start_date']));
            $s3_employee_start_month=date("m", strtotime($employee_config[0]['start_date']));
            $s3_employee_start_day=date("d", strtotime($employee_config[0]['start_date']));
            $s3_employee_end_year=date("Y", strtotime($employee_config[0]['end_date']));
            $s3_employee_end_month=date("m", strtotime($employee_config[0]['end_date']));
            $s3_employee_end_day=date("d", strtotime($employee_config[0]['start_date']));
            echo "<span class='badge badge-dark'>s3_employee_start_year=$s3_employee_start_year</span> ";
            echo "<span class='badge badge-dark'>s3_employee_start_month=$s3_employee_start_month</span> ";
            echo "<span class='badge badge-dark'>s3_employee_start_day=$s3_employee_start_day</span> ";
            echo "<br>";
            echo "<span class='badge badge-dark'>s3_employee_end_year=$s3_employee_end_year</span> ";
            echo "<span class='badge badge-dark'>s3_employee_end_month=$s3_employee_end_month</span> ";
            echo "<span class='badge badge-dark'>s3_employee_end_day=$s3_employee_end_day</span> ";
            echo "<br>";

            $s3_period_start_year = date("Y", strtotime($s3_period_start));
            $s3_period_start_month = date("m", strtotime($s3_period_start));
            $s3_period_end_year = date("Y", strtotime($s3_period_end));
            $s3_period_end_month = date("m", strtotime($s3_period_end));
            echo "<span class='badge badge-dark'>s3_period_start_year=$s3_period_start_year</span> ";
            echo "<span class='badge badge-dark'>s3_period_start_month=$s3_period_start_month</span> ";
            echo "<span class='badge badge-dark'>s3_period_end_year=$s3_period_end_year</span> ";
            echo "<span class='badge badge-dark'>s3_period_end_month=$s3_period_end_month</span> ";
            echo "<br>";

            $s3_cal_day=cal_days_in_month(CAL_GREGORIAN, $s3_period_start_month, $s3_period_start_year);
            echo "<span class='badge badge-secondary'>s3_cal_day=$s3_cal_day</span> ";
            echo "<br>";

            $s3_mpf_employer_compulsory=$employee_config[0]['mpf_employer_compulsory'];
            $s3_mpf_employer_voluntary=$employee_config[0]['mpf_employer_voluntary'];
            $s3_mpf_employee_compulsory=$employee_config[0]['mpf_employee_compulsory'];
            $s3_mpf_employee_voluntary=$employee_config[0]['mpf_employee_voluntary'];
            echo "<span class='badge badge-dark'>s3_mpf_employer_compulsory=$s3_mpf_employer_compulsory</span> ";
            echo "<span class='badge badge-dark'>s3_mpf_employer_voluntary=$s3_mpf_employer_voluntary</span> ";
            echo "<span class='badge badge-dark'>s3_mpf_employee_compulsory=$s3_mpf_employee_compulsory</span> ";
            echo "<span class='badge badge-dark'>s3_mpf_employee_voluntary=$s3_mpf_employee_voluntary</span> ";

            echo "<br>";
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <?php //todo fix basic ?>
        <td>Basic</td>
        <td>
            <?php
            $s3_basic = $salary_history[0]['basic'];;
            for($k=0; $k<sizeof($salary_history);$k++){
                if(strcmp($salary_history[$k]['since'], $s3_period_start) <= 0){
                    $s3_basic = $salary_history[$k]['basic'];
                }else{
                    break;
                }
                // $compare_to = strcmp($salary_history[$k]['since'], $s3_period_start);
                // if(strcmp($salary_history[$k]['since'], $s3_period_start) <0 ){
                //     $pick = $salary_history[$k]['since'];
                // }else{
                //     $pick = $s3_period_start;
                // }
                // echo "salary_history: ".$salary_history[$k]['since']." | s3_period_start: $s3_period_start | $compare_to | $pick <br>";
                //$datediff = strtotime($pick_to) - strtotime($pick_from);
            }
            //reset($salary_history);
            echo "<span class='badge badge-success'>s3_basic=$s3_basic</span> ";
            ?>
        </td>
        <td>
            <?php
            $total_basic = $s3_basic;
            echo '$'.round($total_basic, 2);
            ?>
        </td>
    </tr>
    <tr>
        <td>Leave</td>
        <td>
            <?php
            $selected_array = array();

            //step 1: check if the leave records full within the calculation period
            //TODO improvement, use sql statement to filter
            //TODO improvement, should co-join table leaves_config
            foreach($leaves_records as $lr){
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
            $acc_12m_salary = 29677.42;
            $acc_12m_wd = 89;

            //step 3: get the detail of the leave type with parameters config
            for($i=0; $i<sizeof($selected_array); $i++){
                //print the detail of the selected array, make sure data extracted are correct
                $code = $selected_array[$i]['code'];
                $status = $selected_array[$i]['status'];
                $period_start = $selected_array[$i]['period_start'];
                $period_end = $selected_array[$i]['period_end'];
                $period_days = daysInAPeriod($s3_period_start, $s3_period_end, $period_start, $period_end);
                $is_nwd = searchLeaveConfigByCode($code, $leaves_config, 'nwd');
                $is_adj = searchLeaveConfigByCode($code, $leaves_config, 'adj');
                $is_rse = searchLeaveConfigByCode($code, $leaves_config, 'rse');
                $percentage = searchLeaveConfigByCode($code, $leaves_config, 'percentage');

                echo "<span class='badge badge-success'>code=$code</span> ";
                echo "<span class='badge badge-secondary'>status=$status</span> ";
                echo "<span class='badge badge-secondary'>period_start=$period_start</span> ";
                echo "<span class='badge badge-secondary'>period_end=$period_end</span> ";
                echo "<span class='badge badge-secondary'>period_days=$period_days</span> ";
                echo "<span class='badge badge-secondary'>is_nwd=$is_nwd</span> ";
                echo "<span class='badge badge-secondary'>is_adj=$is_adj</span> ";
                echo "<span class='badge badge-secondary'>is_rse=$is_rse</span> ";
                echo "<span class='badge badge-secondary'>percentage=$percentage</span> ";
                echo "<br>";

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

                //any other calculation
                switch($code){
                    case('npl'):
                        break;
                    case 'slrse':
                        break;
                    case 'sl':
                        break;
                    case 'ml':
                        break;
                    case 'pl':
                        break;
                    case 'al':
                        break;
                }
            }
            ?>
        </td>
        <td>
            <?php
            echo '$'.round($total_leave, 2);
            ?>
        </td>
    </tr>
    <tr>
        <td>Holiday</td>
        <td>
            <?php
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
            ?>
        </td>
        <td>
            <?php
            echo '$'.round($total_holiday, 2);
            ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align: right;">Revalent Income (RI)</td>
        <td>
            <?php
            $toral_ri = $total_basic + $total_leave + $total_holiday;
            echo '$'.round($toral_ri, 2);
            ?>
        </td>
    </tr>
    <tr>
    <tr>
        <td>MPF</td>
        <td>
            <?php

            //todo fix
            $mpf_employer_compulsory = $toral_ri*$s3_mpf_employer_compulsory/100;
            echo '<span class="badge badge-info">$mpf_employer_compulsory = $toral_ri*$s3_mpf_employer_compulsory/100</span><br>';
            echo "<span class='badge badge-warning'>mpf_employer_compulsory=$mpf_employer_compulsory</span> ";
            echo "<span class='badge badge-secondary'>toral_ri=$toral_ri</span> ";
            echo "<span class='badge badge-secondary'>s3_mpf_employer_compulsory=$s3_mpf_employer_compulsory</span> ";
            echo "<br>";

            $mpf_employee_compulsory = $toral_ri*$s3_mpf_employee_compulsory/100;
            echo '<span class="badge badge-info">$mpf_employee_compulsory = $toral_ri*$s3_mpf_employee_compulsory/100</span><br>';
            echo "<span class='badge badge-warning'>mpf_employee_compulsory=$mpf_employee_compulsory</span> ";
            echo "<span class='badge badge-secondary'>toral_ri=$toral_ri</span> ";
            echo "<span class='badge badge-secondary'>s3_mpf_employee_compulsory=$s3_mpf_employee_compulsory</span> ";
            echo "<br>";

            $mpf_employer_voluntary = $toral_ri*$s3_mpf_employer_voluntary/100;
            echo '<span class="badge badge-info">$mpf_employer_voluntary = $toral_ri*$s3_mpf_employer_voluntary/100</span><br>';
            echo "<span class='badge badge-warning'>mpf_employer_voluntary=$mpf_employer_voluntary</span> ";
            echo "<span class='badge badge-secondary'>toral_ri=$toral_ri</span> ";
            echo "<span class='badge badge-secondary'>s3_mpf_employer_voluntary=$s3_mpf_employer_voluntary</span> ";
            echo "<br>";

            $mpf_employee_voluntary = $toral_ri*$s3_mpf_employee_voluntary/100;
            echo '<span class="badge badge-info">$mpf_employee_voluntary = $toral_ri*$s3_mpf_employee_voluntary/100</span><br>';
            echo "<span class='badge badge-warning'>mpf_employee_voluntary=$mpf_employee_voluntary</span> ";
            echo "<span class='badge badge-secondary'>toral_ri=$toral_ri</span> ";
            echo "<span class='badge badge-secondary'>s3_mpf_employee_voluntary=$s3_mpf_employee_voluntary</span> ";
            echo "<br>";
            ?>
        </td>
        <td>
            <?php
            $total_mpf = $mpf_employee_compulsory + $mpf_employee_voluntary;
            echo '$'.round($total_mpf, 2);
            ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align: right;">Grand Total</td>
        <td>
            <?php
            $total_grand = $toral_ri - $total_mpf;
            echo '$'.round($total_grand, 2);
            ?>
        </td>
    </tr>
    </tbody>
</table>
<?php } ?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
