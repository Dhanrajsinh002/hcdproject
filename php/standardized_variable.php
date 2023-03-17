<?php

session_start();

$z_array = array();
$mean = 0;
$sample_size = 0;

if(isset($_POST['z_data'])) {
    $arr = explode(",",$_POST["z_data"]);
    
    $mean = findMean($arr);
    $sd = findSD($arr, $sample_size, $mean);

    // echo $sd;
    for($i = 0; $i < $sample_size; $i++) {
        array_push($z_array, ($arr[$i] - $mean)/$sd);
    }

    // return $z_array;

    echo "  <tr> <th>x</th>";
    for($i = 0; $i < $sample_size; $i++) {
        echo "<td>".$arr[$i]."</td>";    
    }
    echo "</tr>";

    echo "  <tr> <th>z</th>";
    for($i = 0; $i < $sample_size; $i++) {
        echo "<td>".$z_array[$i]."</td>";    
    }
    echo "</tr>";
}

function findMean($arr) {
    global $sample_size;
    $sample_size = count($arr);
    $xi_sum = 0;
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