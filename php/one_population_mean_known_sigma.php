<?php

session_start();

require './db_config.php';

if(isset($_POST['nh']) && isset($_POST['sl']) && isset($_POST['sm']) && isset($_POST['sd']) && isset($_POST['ss']) && isset($_POST['c']) && isset($_POST['ci_alpha'])) {

    /* for critical value potion */

    $cv_decision = "";
    $cv_sign_prefix = "";
    $cv_compare_prefix = "";
    $cv_region = "";
    $z = round(($_POST['sm'] - $_POST['nh']) / ($_POST['sd'] / sqrt($_POST['ss'])), 2);
    $cv = $_POST['ci_alpha'];

    if ($_POST['c'] == "tow_tailed") {
        $cv_sign_prefix = "±";
        if ($z <= - ($cv) || $z >= $cv) {
            $cv_decision = "rejected";
            $cv_compare_prefix = "outside of";
            $cv_region = "rejection region";
        } else {
            $cv_decision = "accepted";
            $cv_compare_prefix = "inside of";
            $cv_region = "acceptance region";
        }
    } else if ($_POST['c'] == "right_tailed") {
        if ($z > $cv) {
            $cv_decision = "rejected";
            $cv_compare_prefix = "right side of";
            $cv_region = "rejection region";
        } else {
            $cv_decision = "accepted";
            $cv_compare_prefix = "left side of";
            $cv_region = "acceptance region";
        }
    } else {
        $cv_sign_prefix = "-";
        if ($z < - ($cv)) {
            $cv_decision = "rejected";
            $cv_compare_prefix = "left side of";
            $cv_region = "rejection region";
        } else {
            $cv_decision = "accepted";
            $cv_compare_prefix = "right side of";
            $cv_region = "acceptance region";
        }
    }

    /* for p-value portion */

    $pv_conditions = $_POST['c'];
    $pv_compare_prefix = "";
    $pv_decision = "";
    $pv_region = "";
    $pv = 0;

    if ($pv_conditions == "two_tailed") {
        $pv = 2 * findPV($z);
    } else if ($pv_conditions == "left_tailed") {
        $pv = findPV($z);
    } else if ($pv_conditions == "right_tailed") {
        $pv = 1 - findPV($z);
    }

    if ($pv <= $_POST['sl']) {
        $pv_compare_prefix = "less or equal to";
        $pv_decision = "rejected";
        $pv_region = "rejection";
    } else {
        $pv_compare_prefix = "more than";
        $pv_decision = "accepted";
        $pv_region = "acceptance";
    }

    echo "  <thead class='thead-dark'>
                <tr>
                    <th>Critical Value Results</th>
                    <th> <b><i>P</i></b> - Value Results</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>The value of the test statistic is <b><i>z</i></b> = " . $z . "</td>
                    <td>The value of the test statistic is <b><i>z</i></b> = " . $z . "</td>
                </tr>
                <tr>
                    <td>Here The value of the test statistic is " . $cv_compare_prefix . " The Critical Value " . $cv_sign_prefix . "" . $cv . " limits and appears in " . $cv_region . "</td>
                    <td>Here The value of the test statistic is " . $pv_compare_prefix . " The <b><i>P</i></b> Value " . $pv . " limits and appears in " . $pv_region . "</td>
                </tr>
                <tr>
                    <td>Hence Null Hypothesis (<b><i>H<sub>0</sub></i></b>) is " . $cv_decision . "</td>
                    <td>Hence Null Hypothesis (<b><i>H<sub>0</sub></i></b>) is " . $pv_decision . "</td>
                </tr>
            </tbody>
            ";

}

function findPV($z)
{

    global $conn;

    $row = intval($z * 10) / 10;
    $col = abs((intval($z * 100) / 100) - intval((intval($z * 100) / 100) * 10) / 10);
    if ($row == 0) {
        if ($z < 0) {
            $row = '-0.0';
        } else {
            $row = '0.0';
        }
    }

    $sel = "SELECT * FROM z_table WHERE `z` = $row";
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
        if ($row < -3.8) {
            echo "less val - ";
            return 0.0001;
        } else {
            echo "more val - ";
            return 0.9999;
        }
    }
}

?>