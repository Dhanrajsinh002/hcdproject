<?php

session_start();

require './db_config.php';

$z1 = 0;
$z2 = 0;

if(isset($_POST['Z1']) && isset($_POST['Z2']) && isset($_POST['Conditions'])) {

    if((float)$_POST['Z1'] < -3.8) {
        $z1 = 0.0001;

        if((float)$_POST['Z2'] < -3.8) {
            // both value is less value

            $z2 = 0.0001;

        } else if ((float)$_POST['Z2'] > 3.8) {
            // z1 is less value and z2 is high value

            $z2 = 0.9999;

        } else {
            // z1 is less value and z2 is correct value

            $z2 = (float)$_POST['Z2'];
        }
    } else if ((float)$_POST['Z1'] > 3.8) {
        $z1 = 0.9999;

        if ((float)$_POST['Z2'] < -3.8) {
            // z1 is high value and z2 is less value
            
            $z2 = 0.0001;

        } else if ((float)$_POST['Z2'] > 3.8) {
            // both value is less value
        
            $z2 = 0.9999;

        } else {
            // z1 is high value and z2 is correct value
            
            $z2 = (float)$_POST['Z2'];
        }
    } else if ((float)$_POST['Z2'] < -3.8) {
        // z1 is correct value and z2 is less value

        $z1 = (float)$_POST['Z1'];
        $z2 = 0.0001;

    } else if ((float)$_POST['Z2'] > 3.8) {
        // z1 is correct value and z2 is high value
    
        $z1 = (float)$_POST['Z1'];
        $z2 = 0.9999;

    } else {
        // both are coorect values

        $z1 = (float)$_POST['Z1'];
        $z2 = (float)$_POST['Z2'];
    }

    if($_POST['Conditions'] == "left_of") {
        calculateLeft($z1);
    } else if($_POST['Conditions'] == "right_of") {
        calculateRight($z1);
    } else if($_POST['Conditions'] == "between_of") {
        calculateBetween($z1, $z2);
    } else if($_POST['Conditions'] == "outside_of") {
        calculateOutside($z1, $z2);
    } else {

    }
}

function calculateLeft($z) {
    
    $rc_arr = convertZToRC($z);

    echo $rc_arr."\n";

}

function calculateRight($z) {
    
}

function calculateBetween($z1, $z2) {}

function calculateOutside($z1, $z2) {}

function convertZToRC($z) {

    // suppose z = 1.625872 (string)
    $z_frmt = ($z > 0) ? number_format(floor($z * 100) / 100, 2, '.', '') : number_format(ceil($z * 100) / 100, 2, '.', ''); // z = 1.62
    $row = ((floor($z_frmt * 10) / 10) < 0) ? (floor($z_frmt * 10) / 10) + 0.1 : floor($z_frmt * 10) / 10 ; // row = 1.6
    $col = abs(number_format($z_frmt - intval($z_frmt * 10) / 10, 2)); // col = 0.02

    $sel = "SELECT " . $col . " FROM z_table WHERE z = " . $row . "";
    echo $sel;
    exit(0);
    $res = $conn->query($sel);

    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            return $row[$col] . "\n";
        }
    }
}
?>