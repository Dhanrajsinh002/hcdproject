<?php

session_start();

if(isset($_POST['sm']) && isset($_POST['n']) && isset($_POST['ssd']) && isset($_POST['ci']) && isset($_POST['ci_alpha'])) {
    
    $margin_error = $_POST['ci_alpha'] * ($_POST['ssd'] / sqrt($_POST['n']));

    $ci_negative = $_POST['sm'] - $margin_error;
    $ci_positive = $_POST['sm'] + $margin_error;

    echo "  <thead class='thead-dark'>
                <tr>
                    <th>Results</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td> We are <b><i>" . $_POST['ci'] . "% </i></b> Confident that Population Mean &mu; is between <b><i>" . $ci_negative . "</i></b> and <b><i>" . $ci_positive . "</i></b> </td>
                </tr>
                <tr>
                    <td> For that we are getting <b><i>" . $margin_error . "% </i></b> of Marginal Error </td>
                </tr>
            </tbody>";
}

if(isset($_POST['val']) && isset($_POST['ssd']) && isset($_POST['ci']) && isset($_POST['ci_alpha'])) {

    $val_arr = explode(",", $_POST['val']);

    $sn = count($val_arr);
    $sm = findMean($val_arr, $sn);
    $ssd = 0;

    if($_POST['ssd'] == "") {
        $ssd = findSD($val_arr, count($val_arr), $sm);
    } else {
        echo $_POST['ssd'];
    }

    $margin_error = $_POST['ci_alpha'] * ($ssd / sqrt($sn));

    $ci_negative = $sm - $margin_error;
    $ci_positive = $sm + $margin_error;

    echo "  <thead class='thead-dark'>
                <tr>
                    <th>Results</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td> We are <b><i>" . $_POST['ci'] . "% </i></b> Confident that Population Mean &mu; is between <b><i>" . round($ci_negative, 2) . "</i></b> and <b><i>" . round($ci_positive, 2) . "</i></b> </td>
                </tr>
                <tr>
                    <td> For that we are getting <b><i>" . round($margin_error, 2) . "% </i></b> of Marginal Error </td>
                </tr>
            </tbody>";
}

function findMean($arr, $n)
{
    $sum = 0;
    for ($i = 0; $i < $n; $i++) {
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