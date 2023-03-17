<?php

session_start();

if(isset($_POST["msdrv_val"])) {
    // echo $_POST["msdrv_val"];

    $inp_arr = explode(",",$_POST["msdrv_val"]);
    sort($inp_arr);
    calculateMeanMethod1($inp_arr);
}

function calculateMeanMethod1($arr) {
    
    $mean = 0;
    $freq = array();        // holds extracted freq from rel_arr
    $rel_arr = array();    // holds [user's value] & [it's occurance]
    $prob_arr = array();  // holds final probability to observe
    $small_x = array();  // holds small x value to be in coefficient

    foreach($arr as $value) {
        if(isset($rel_arr[$value])) {
            $rel_arr[$value] += 1;
        } else {
            $rel_arr[$value] = 1;
        }
    }

    $arr_val = array_values($rel_arr);
    $arr_key = array_keys($rel_arr);
    
    foreach($arr_val as $i) {
        array_push($freq, (int)$i);
    }

    foreach($arr_key as $i) {
        array_push($small_x, (int)$i);
    }

    // print_r($freq);

    for($i = 0; $i < count($freq); $i++) {
        array_push( $prob_arr, $freq[$i]/count($arr) );
        // array_push( $m1rel_freqs, round($m1freqs[$i]/count($arr), 2) );
    }

    for($i = 0; $i < count($freq); $i++) {
        $mean += ($small_x[$i] * $prob_arr[$i]);
    }

    echo $mean;

}
?>