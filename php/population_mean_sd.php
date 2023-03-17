<?php

session_start();

if(isset($_POST['msd_data'])) {
    $arr = explode(",",$_POST['msd_data']);

    $mean = findMean($arr);
    $sd = findSD($arr, count($arr), $mean);
    echo "  <tr>
                <td colspan='2'>Population Mean:- ".$mean."</td>
            </tr>
            <tr>
                <td colspan='2'>Population S.D.:- ".$sd."</td>
            </tr>";
}

function findMean($arr) {
    $xi_sum = 0;
    $sample_size = count($arr);
    for($i = 0; $i < $sample_size; $i++) {
        $xi_sum += $arr[$i];
    }
    
    return round($xi_sum / $sample_size, 2);
}

function findSD($arr, $len, $mue) {
    $xi_sqr = 0;
    for($i = 0; $i < $len; $i++) {
        $xi_sqr += pow($arr[$i], 2);
    }

    return round( sqrt( ($xi_sqr/$len) - pow($mue,2)), 2);
}

?>