<?php

session_start();

if(isset($_POST['msd_data'])) {
    $arr = explode(",",$_POST['msd_data']);

    $mean = findMean($arr);
    $sd = findSD($arr, count($arr), $mean);
    echo "  
            <thead>
            <tr>
                <th scope='col text-center'>Population Mean</th>
                <th scope='col text-center'>Population S.D.</th>
            </tr>
            
            </thead>

            <tbody>
            <tr>
                <td class='text-center'> ".$mean."</td>
                <td class='text-center'> ".$sd."</td>
            </tr>
            </tbody>";
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