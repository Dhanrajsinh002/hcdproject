<?php

session_start();

if(isset($_POST['sm']) && isset($_POST['ss']) && isset($_POST['psd']) && isset($_POST['ci'])) {
    
    $interval = 0;
    $ci_should_be = 0;

    if($_POST['ci'] >= 99.7 || ($_POST['ci'] < 99.7 && $_POST['ci'] > 95) ) {
        $interval = 3;
        $ci_should_be = 99.7;
    } else if ($_POST['ci'] == 95 || ($_POST['ci'] < 95 && $_POST['ci'] > 68)) {
        $interval = 2;
        $ci_should_be = 95;
    } else {
        $interval = 1;
        $ci_should_be = 68;
    }

    $ssd = $_POST['psd'] / sqrt($_POST['ss']);

    $er_negative = $_POST['sm'] - $interval * $ssd;
    $er_positive = $_POST['sm'] + $interval * $ssd;

    $margin_error = ($er_positive - $er_negative) / $interval;

    echo "  <thead class='thead-dark'>
                <tr>
                    <th>Results</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td> For <b><i>". $_POST['ci'] . "% </i></b> Confidence Interval (&because; considering actual Empirical Interval ".$ci_should_be. "%)</td>
                </tr>

                <tr>
                    <td> The empirical rule tells us that about <b><i>" . $ci_should_be . "%</i></b> of the sample means are within <b><i>" . $interval . " standard deviations </i></b> of the mean:<br> <b><i>" . round($er_negative, 2) . " to " . round($er_positive, 2) . "</i></b></td>
                </tr>

                <tr>
                    <td> Having Marginal Error <b><i>x&#772 &plusmn; Margin Error = " . $_POST['sm'] . " &plusmn; " . round($margin_error, 2) . "</i></b></td>
                </tr>
                
                <tr>
                    <td> <b><i>" . round($margin_error, 2) . ", " . $ci_should_be . "% </i></b> of the sample means of<b><i> samples of size " . $_POST['ss'] . " are within " . round($margin_error, 2) . "</i></b> of the population mean </td>
                </tr>
            </tbody>";
}

if(isset($_POST['val']) && isset($_POST['psd']) && isset($_POST['ci_val'])) {
    
    $val_arr = explode(",", $_POST['val']);

    $sn = count($val_arr);
    $sm = findMean($val_arr);
    // $sd = findSD($val_arr, $sn, $sm);
    $sd = $_POST['psd'];

    $interval = 0;
    $ci_should_be = 0;

    if ($_POST['ci_val'] >= 99.7 || ($_POST['ci_val'] < 99.7 && $_POST['ci_val'] > 95)) {
        $interval = 3;
        $ci_should_be = 99.7;
    } else if ($_POST['ci_val'] == 95 || ($_POST['ci_val'] < 95 && $_POST['ci_val'] > 68)) {
        $interval = 2;
        $ci_should_be = 95;
    } else {
        $interval = 1;
        $ci_should_be = 68;
    }

    $ssd = $sd / sqrt($sn);

    $er_negative = $sm - $interval * $ssd;
    $er_positive = $sm + $interval * $ssd;

    $margin_error = ($er_positive - $er_negative) / $interval;

    // echo $sn ." - ". $sm ." - ". $sd."\n";
    // echo $ssd ." - ". $er_negative ." - ". $er_positive ." - ". $margin_error;
    // exit(0);
    echo "  <thead class='thead-dark'>
                <tr>
                    <th>Results</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td> For <b><i>" . $_POST['ci_val'] . "% </i></b> Confidence Interval (&because; considering actual Empirical Interval " . $ci_should_be . "%)</td>
                </tr>

                <tr>
                    <td> The empirical rule tells us that about <b><i>" . $ci_should_be . "%</i></b> of the sample means are within <b><i>" . $interval . " standard deviations </i></b> of the mean:<br> <b><i>" . round($er_negative, 4) . " to " . round($er_positive, 4) . "</i></b></td>
                </tr>

                <tr>
                    <td> Having Marginal Error <b><i>x&#772 &plusmn; Margin Error = " . round($sm, 2) . " &plusmn; " . round($margin_error, 2) . "</i></b></td>
                </tr>
                
                <tr>
                    <td> <b><i>" . round($margin_error, 2) . ", " . $ci_should_be . "% </i></b> of the sample means of<b><i> samples of size " . $sn . " are within " . round($margin_error, 2) . "</i></b> of the population mean </td>
                </tr>
            </tbody>";
}

function findMean($arr)
{
    $sum = 0;
    for ($i = 0; $i < count($arr); $i++) {
        $sum += $arr[$i];
    }
    return ($sum / count($arr));
}

function findSD($arr, $len, $mue)
{
    $xi_sqr = 0;
    for ($i = 0; $i < $len; $i++) {
        $xi_sqr += pow($arr[$i], 2);
    }

    return round(sqrt(($xi_sqr / $len) - pow($mue, 2)), 2);
}

?>