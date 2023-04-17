<?php

session_start();

require './db_config.php';

if( isset($_POST['nh']) && isset($_POST['sl']) && isset($_POST['sm']) && isset($_POST['sd']) && isset($_POST['ss']) && isset($_POST['c']) ) {

    $conditions = $_POST['c'];
    $z = round(($_POST['sm'] - $_POST['nh']) / ($_POST['sd'] / sqrt($_POST['ss'])), 2);
    $compare_prefix = "";
    $decision = "";
    $region = "";
    $pv = 0;

    if ($conditions == "two_tailed") {
        $pv = 2 * findPV($z);
    } else if ($conditions == "left_tailed") {
        $pv = findPV($z);
    } else if ($conditions == "right_tailed") {
        $pv = 1 - findPV($z);
    }

    if($pv <= $_POST['sl']) {
        $compare_prefix = "less or equal to";
        $decision = "rejected";
        $region = "rejection";
    } else {
        $compare_prefix = "more than";
        $decision = "accepted";
        $region = "acceptance";
    }

    echo "  <thead class='thead-dark'>
                <tr>
                    <th>Results</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td> The value of the test statistic is <b><i>z</i></b> = " . $z . " </td>
                </tr>
                <tr>
                    <td> Here The value of the test statistic is " . $compare_prefix . " The <b><i>P</i></b> Value " . $pv . " limits and appears in " . $region . "</td>
                </tr>
                <tr>
                    <td> Hence Null Hypothesis (<b><i>H<sub>0</sub></i></b>) is " . $decision . "</td>
                </tr>
            </tbody>";

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

    // $sel = "SELECT `$col` FROM z_table WHERE `z` = $row";
    $sel = "SELECT * FROM z_table WHERE `z` = $row";
    // echo $sel."\n";
    // exit(0);
    $res = $conn->query($sel);

    if ($res->num_rows > 0) {
        // while ($row = $res->fetch_assoc()) {
        //     echo "col ". $col;
        //     echo "\nres ".$row[$col];
        //     return $row[$col];
        // }
        $row = $res->fetch_assoc();
        foreach ($row as $key => $value) {
            if ($key == (string)$col) {
                return $value;
            } else {
                // echo "no match\n";
            }
        }
        // echo "col " . $col;
        // echo "\nres " . $row[$col];
        // return $row[$col];
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