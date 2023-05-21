<?php

session_start();

require '.\db_config.php';
require '..\vendor\autoload.php';

use MathPHP\Probability\Distribution\Continuous\StudentT;
use MathPHP\Probability\Distribution\Table;

// if(isset($_POST['nh']) && isset($_POST['sl']) && isset($_POST['sm']) && isset($_POST['ssd']) && isset($_POST['ss']) && isset($_POST['c']) && isset($_POST['cv'])) {
if(isset($_POST['nh']) && isset($_POST['sl']) && isset($_POST['sm']) && isset($_POST['ssd']) && isset($_POST['ss']) && isset($_POST['c'])) {

    // $t = round(($_POST['sm'] - $_POST['nh']) / ($_POST['ssd'] / sqrt($_POST['ss'])), 2);

    // $tDist = new MathPHP\Probability\Distribution\Continuous\StudentT($_POST['ss']);
    // exit(0);
    /* for critical value portion */

    // $_SESSION['t'] = round(($_POST['sm'] - $_POST['nh']) / ($_POST['ssd'] / sqrt($_POST['ss'])), 3);
    // $opmus_cv_conditions = $_POST['c'];
    // $_SESSION['alpha'] = $_POST['sl'];
    // $_SESSION['opmus_cv_compare_prefix'] = "";
    // $_SESSION['opmus_cv_decision'] = "";
    // $_SESSION['opmus_cv_region'] = "";
    // $_SESSION['opmus_cv'] = 0;

    // if ($opmus_cv_conditions == "two_tailed") {
    //     $_SESSION['opmus_cv'] = 2 * findPV($_POST['ss'] - 1, $_SESSION['alpha']);

    //     if($_SESSION['t'] <= -($_SESSION['opmus_cv']) || $_SESSION['t'] >= $_SESSION['opmus_cv']) {
    //         $_SESSION['opmus_cv_compare_prefix'] = "less or equal to";
    //         $_SESSION['opmus_cv_decision'] = "rejected";
    //         $_SESSION['opmus_cv_region'] = "rejection";
    //     } else {
    //         $_SESSION['opmus_cv_compare_prefix'] = "more than";
    //         $_SESSION['opmus_cv_decision'] = "accepted";
    //         $_SESSION['opmus_cv_region'] = "acceptance";
    //     }

    // } else if ($opmus_cv_conditions == "left_tailed") {
    //     $_SESSION['opmus_cv'] = findPV($_POST['ss'] - 1, $_SESSION['alpha']);

    //     if($_SESSION['t'] <= - ($_SESSION['opmus_cv'])) {
    //         $_SESSION['opmus_cv_compare_prefix'] = "less than";
    //         $_SESSION['opmus_cv_decision'] = "rejected";
    //         $_SESSION['opmus_cv_region'] = "rejection";
    //     } else {
    //         $_SESSION['opmus_cv_compare_prefix'] = "more than";
    //         $_SESSION['opmus_cv_decision'] = "accepted";
    //         $_SESSION['opmus_cv_region'] = "acceptance";
    //     }

    // } else if ($opmus_cv_conditions == "right_tailed") {
    //     $_SESSION['opmus_cv'] = 1 - findPV($_POST['ss'] - 1, $_SESSION['alpha']);

    //     if($_SESSION['t'] >= ($_SESSION['opmus_cv'])) {
    //         $_SESSION['opmus_cv_compare_prefix'] = "more than";
    //         $_SESSION['opmus_cv_decision'] = "rejected";
    //         $_SESSION['opmus_cv_region'] = "rejection";
    //     } else {
    //         $_SESSION['opmus_cv_compare_prefix'] = "less than";
    //         $_SESSION['opmus_cv_decision'] = "accepted";
    //         $_SESSION['opmus_cv_region'] = "acceptance";
    //     }
    // }

    
    $opmus_cv_conditions = $_POST['c'];
    $alpha = $_POST['sl']/100;
    $opmus_cv_compare_prefix = "";
    $opmus_cv_decision = "";
    $opmus_cv_region = "";

    $t = round(($_POST['sm'] - $_POST['nh']) / ($_POST['ssd'] / sqrt($_POST['ss'])), 3);

    $tDistInv = new StudentT($_POST['ss']-1);
    $inv = number_format((float)$tDistInv->inverse(1 - $alpha), 3);
    // echo $t."\n";
    // echo number_format((float)$inv, 3);
    // exit(0);

    if ($opmus_cv_conditions == "two_tailed") {
        // $inv = 2 * findPV($_POST['ss'] - 1, $alpha);

        if ($t <= -($inv) || $t >= $inv) {
            $opmus_cv_compare_prefix = "less or equal to";
            $opmus_cv_decision = "rejected";
            $opmus_cv_region = "rejection";
        } else {
            $opmus_cv_compare_prefix = "more than";
            $opmus_cv_decision = "accepted";
            $opmus_cv_region = "acceptance";
        }
    } else if ($opmus_cv_conditions == "left_tailed") {
        // $inv = findPV($_POST['ss'] - 1, $alpha);

        if ($t <= -($inv)
        ) {
            $opmus_cv_compare_prefix = "less than";
            $opmus_cv_decision = "rejected";
            $opmus_cv_region = "rejection";
        } else {
            $opmus_cv_compare_prefix = "more than";
            $opmus_cv_decision = "accepted";
            $opmus_cv_region = "acceptance";
        }
    } else if ($opmus_cv_conditions == "right_tailed") {
        // $inv = 1 - findPV($_POST['ss'] - 1, $alpha);

        if ($t >= ($inv)) {
            $opmus_cv_compare_prefix = "more than";
            $opmus_cv_decision = "rejected";
            $opmus_cv_region = "rejection";
        } else {
            $opmus_cv_compare_prefix = "less than";
            $opmus_cv_decision = "accepted";
            $opmus_cv_region = "acceptance";
        }
    }

    /* for p-value potion */

    $tDist = new StudentT($_POST['ss'] - 1);
    $cdf = $tDist->cdf($t);
    $p = 0;

    if($opmus_cv_conditions == "right_tailed") {
        $p = 1 - round(abs($cdf), 5);
    } else if ($opmus_cv_conditions == "left_tailed") {
        $p = round(abs($cdf), 5);
    }
    
    $opmus_pv_decision = "";
    $opmus_pv_sign_prefix = "";
    $opmus_pv_compare_prefix = "";
    $opmus_pv_region = "";

    if ($p <= $alpha) {
        $opmus_pv_decision = "rejected";
        $opmus_pv_compare_prefix = "left side of";
        $opmus_pv_region = "rejection region";
    } else {
        $opmus_pv_decision = "accepted";
        $opmus_pv_compare_prefix = "right side of";
        $opmus_pv_region = "acceptance region";
    }

    echo "  <thead class='thead-dark'>
                <tr>
                    <th>Critical Value Results</th>
                    <th> <b><i>P</i></b> - Value Results</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>The value of the test statistic is <b><i>t</i></b> = " . $t . "</td>
                    <td>The value of the test statistic is <b><i>t</i></b> = " . $t . "</td>
                </tr>
                <tr>
                    <td>Here The value of the test statistic is " . $opmus_cv_compare_prefix . " The Critical Value " . $inv . " limits and appears in " . $opmus_cv_region . "</td>
                    <td>Here The <b><i>P</i></b> Value is " . $p . " which is " . $opmus_pv_compare_prefix . " &alpha; limits and appears in " . $opmus_pv_region . "</td>
                </tr>
                <tr>
                    <td>Hence Null Hypothesis (<b><i>H<sub>0</sub></i></b>) is " . $opmus_cv_decision . "</td>
                    <td>Hence Null Hypothesis (<b><i>H<sub>0</sub></i></b>) is " . $opmus_pv_decision . "</td>
                </tr>
            </tbody>
            ";

    return (int)$t;

}

// if(isset($_POST['c']) && isset($_POST['pv'])) {

    // /* for p-value potion */

    // $opmus_pv_decision = "";
    // $opmus_pv_sign_prefix = "";
    // $opmus_pv_compare_prefix = "";
    // $opmus_pv_region = "";
    // $p = $_POST['pv'];

    // $tDist = new StudentT($_POST['ss'] - 1);
    // print_r($tDist);
    // $cdf = $tDist->cdf($t);
    // echo "\nCDF " . $cdf;
    // $absCdf = abs($cdf);
    // echo "\nABS " . (1 - $absCdf);

    // // $t = round(($_POST['sm'] - $_POST['nh']) / ($_POST['ssd'] / sqrt($_POST['ss'])), 2);
    // // $opmus_pv = $_POST['ci_alpha'];

    // if($p <= $_SESSION['alpha']) {
    //     $opmus_pv_decision = "rejected";
    //     $opmus_pv_compare_prefix = "left side of";
    //     $opmus_pv_region = "rejection region";
    // } else {
    //     $opmus_pv_decision = "accepted";
    //     $opmus_pv_compare_prefix = "right side of";
    //     $opmus_pv_region = "acceptance region";
    // }

    // echo "  <thead class='thead-dark'>
    //             <tr>
    //                 <th>Critical Value Results</th>
    //                 <th> <b><i>P</i></b> - Value Results</th>
    //             </tr>
    //         </thead>

    //         <tbody>
    //             <tr>
    //                 <td>The value of the test statistic is <b><i>t</i></b> = " . $_SESSION['t'] . "</td>
    //                 <td>The value of the test statistic is <b><i>t</i></b> = " . $_SESSION['t'] . "</td>
    //             </tr>
    //             <tr>
    //                 <td>Here The value of the test statistic is " . $_SESSION['opmus_cv_compare_prefix'] . " The Critical Value " . $_SESSION['opmus_cv'] . " limits and appears in " . $_SESSION['opmus_cv_region']  . "</td>
    //                 <td>Here The <b><i>P</i></b> Value is " . $p . " which is ". $opmus_pv_compare_prefix . " &alpha; limits and appears in " . $opmus_pv_region . "</td>
    //             </tr>
    //             <tr>
    //                 <td>Hence Null Hypothesis (<b><i>H<sub>0</sub></i></b>) is " . $_SESSION['opmus_cv_decision'] . "</td>
    //                 <td>Hence Null Hypothesis (<b><i>H<sub>0</sub></i></b>) is " . $opmus_pv_decision . "</td>
    //             </tr>
    //         </tbody>
    //         ";
// }

function findPV($df, $alpha)
{

    global $conn;
    $v = '';
    $col = $alpha;

    if($df > 29) {
        $v = 'inf';
    } else if($df < 1) {
        $v = '1';
    } else {
        $v = $df;
    }

    $sel = "SELECT * FROM t_table WHERE `v` = '$v'";
    $res = $conn->query($sel);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        foreach ($row as $key => $value) {
            if ($key == (string)$col) {
                return $value;
            } else {
                // echo "no match\n";
            }
        }
    } else {
        
    }
}
