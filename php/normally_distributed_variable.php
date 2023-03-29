<?php

session_start();

if(isset($_POST['LBL'])&& isset($_POST['VAL'])) {

    $lbl_arr = explode(",",$_POST['LBL']);
    $val_arr = explode(",",$_POST['VAL']);
    
    calculateRelativeFrequency($val_arr);
}

function calculateRelativeFrequency($val) {
    
    $sum = 0;
    for ($i = 0; $i < count($val); $i++) {
        $sum += $val[$i];
    }
    
    $rel_freq = array();

    for ($i = 0; $i < count($val); $i++) {
        array_push($rel_freq, $val[$i] / $sum);
    }

    print_r($rel_freq);
}

// incomplete: implemet graph
?>