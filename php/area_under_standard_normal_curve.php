<?php

session_start();

require './db_config.php';

// $server_name = "localhost";
// $user_name = "root";
// $password = "";
// $db_name = "statistical_calculators_db";

// $conn = mysqli_connect($server_name, $user_name, $password, $db_name);
// if (!$conn) {
//     die("Connection Failed: " . mysqli_connect_error());
// }

$z1 = 0;
$z2 = 0;

if(isset($_POST['Z1']) && isset($_POST['Z2']) && isset($_POST['Conditions'])) {

    $z1 = $_POST['Z1'];
    $z2 = $_POST['Z2'];

    checkConditions($_POST['Conditions']);
    // if((float)$_POST['Z1'] < -3.8) {
    //     $z1 = 0.0001;

    //     if((float)$_POST['Z2'] < -3.8) {
    //         // both value is less value

    //         $z2 = 0.0001;
    //         // directCalculation($z1, $z2);

    //     } else if ((float)$_POST['Z2'] > 3.8) {
    //         // z1 is less value and z2 is high value

    //         $z2 = 0.9999;
    //         // directCalculation($z1, $z2);

    //     } else {
    //         // z1 is less value and z2 is correct value

    //         $z2 = (float)$_POST['Z2'];
    //         checkConditions($_POST['Conditions']);
    //     }
    // } else if ((float)$_POST['Z1'] > 3.8) {
    //     $z1 = 0.9999;

    //     if ((float)$_POST['Z2'] < -3.8) {
    //         // z1 is high value and z2 is less value
            
    //         $z2 = 0.0001;
    //         // directCalculation($z1, $z2);

    //     } else if ((float)$_POST['Z2'] > 3.8) {
    //         // both value is less value
        
    //         $z2 = 0.9999;
    //         // directCalculation($z1, $z2);

    //     } else {
    //         // z1 is high value and z2 is correct value
            
    //         $z2 = (float)$_POST['Z2'];
    //         checkConditions($_POST['Conditions']);
    //     }
    // } else if ((float)$_POST['Z2'] < -3.8) {
    //     // z1 is correct value and z2 is less value

    //     $z1 = (float)$_POST['Z1'];
    //     $z2 = 0.0001;
    //     checkConditions($_POST['Conditions']);

    // } else if ((float)$_POST['Z2'] > 3.8) {
    //     // z1 is correct value and z2 is high value
    
    //     $z1 = (float)$_POST['Z1'];
    //     $z2 = 0.9999;
    //     checkConditions($_POST['Conditions']);

    // } else {
    //     // both are coorect values

    //     $z1 = (float)$_POST['Z1'];
    //     $z2 = (float)$_POST['Z2'];
    //     checkConditions($_POST['Conditions']);
    // }

    // if ( ($z1 == 0.0001 && $z1 == 0.9999) && ($z2 == 0.0001 && $z2 == 0.9999)) {

    //     directCalculation($z1, $z2, $_POST['Conditions']);
    
    // } else if ($z1 == 0.0001 && $z1 == 0.9999) {
    //     directCalculation($z1, $_POST['Conditions']);
    // }

}

function checkConditions($conditions) {

    global $z1, $z2;

    if ($conditions == "left_of") {
        calculateLeft($z1);
    } else if ($conditions == "right_of") {
        calculateRight($z1);
    } else if ($conditions == "between_of") {
        calculateBetween($z1, $z2);
    } else if ($conditions == "outside_of") {
        calculateOutside($z1, $z2);
    } else {

    }
}

function calculateLeft($z) {
    
    $rc_arr = convertZToRC($z);

    echo "lft RC ".$rc_arr."\n";

}

function calculateRight($z) {
    
    $rc_arr = convertZToRC($z);

    echo "rght RC ". round(1 - $rc_arr, 4) . "\n";
}

function calculateBetween($z1, $z2) {

    $rc_arr1 = convertZToRC($z1);
    $rc_arr2 = convertZToRC($z2);

    echo "btw RC1 ".$rc_arr1 . "\n";
    echo "btw RC2 ".$rc_arr2 . "\n";

}

function calculateOutside($z1, $z2) {
    $rc_arr1 = convertZToRC($z1);
    $rc_arr2 = convertZToRC($z2);

    echo "out RC1 ".$rc_arr1 . "\n";
    echo "out RC2 ".$rc_arr2 . "\n";
}

function convertZToRC($z) {

    global $conn;

    // suppose z = 1.625872 (string)
    // $z_frmt = ($z > 0) ? number_format(floor($z * 100) / 100, 2, '.', '') : number_format(ceil($z * 100) / 100, 2, '.', ''); // z = 1.62
    // $row = ((floor($z_frmt * 10) / 10) < 0) ? (floor($z_frmt * 10) / 10) + 0.1 : floor($z_frmt * 10) / 10 ; // row = 1.6
    // $col = abs(number_format($z_frmt - intval($z_frmt * 10) / 10, 2)); // col = 0.02

    $row = intval($z * 10) / 10;
    $col = abs((intval($z * 100) / 100) - intval((intval($z * 100) / 100) * 10) / 10);

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
        foreach($row as $key => $value) {
            if($key == (String)$col) {
                return $value;
            } else {
                // echo "no match\n";
            }
        }
            // echo "col " . $col;
            // echo "\nres " . $row[$col];
            // return $row[$col];
    } else {
        if($row < -3.8) {
            echo "less val - ";
            return 0.0001;
        } else {
            echo "more val - ";
            return 0.9999;
        }
    }
}
?>