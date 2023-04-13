<?php

session_start();

if(isset($_POST['sm']) && isset($_POST['n']) && isset($_POST['psd']) && isset($_POST['ci_alpha']) && isset($_POST['ci'])) {

    $margin_error = $_POST['ci_alpha'] * ($_POST['psd'] / sqrt($_POST['n']));

    $ci_negative = $_POST['sm'] - $margin_error;
    $ci_positive = $_POST['sm'] + $margin_error;

    // echo $_POST['ci_alpha']." - ". $_POST['psd']." - ". $_POST['n']."\n";
    // echo $margin_error." - ".$ci_negative." - ".$ci_positive;
    
    echo "  <thead class='thead-dark'>
                <tr>
                    <th>Results</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td> We are <b><i>" . $_POST['ci'] . "% </i></b> Confident that Population Mean &mu; is between <b><i>".$ci_negative."</i></b> and <b><i>".$ci_positive. "</i></b> </td>
                </tr>
                <tr>
                    <td> For that we are getting <b><i>" . $margin_error . "% </i></b> of Marginal Error </td>
                </tr>
            </tbody>";
}

if(isset($_POST['val']) && isset($_POST['psd']) && isset($_POST['ci_alpha']) && isset($_POST['ci'])) {

    $val_arr = explode(",", $_POST['val']);

    $sn = count($val_arr);
    $sm = findMean($val_arr, $sn);

    $margin_error = $_POST['ci_alpha'] * ($_POST['psd'] / sqrt($sn));

    $ci_negative = $sm - $margin_error;
    $ci_positive = $sm + $margin_error;

    // echo $_POST['ci_alpha']." - ". $_POST['psd']." - ". $sn. " - ".$sm."\n";
    // echo $margin_error." - ".$ci_negative." - ".$ci_positive;

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

?>