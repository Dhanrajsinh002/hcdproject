<?php

session_start();

$z_array = array();
$mean = 0;
$sample_size = 0;

if(isset($_POST['z_data'])) {

    $arr = array_unique(explode(",",$_POST["z_data"]));
    
    $mean = findMean($arr);
    $sd = findSD($arr, $sample_size, $mean);

    // echo $sd;
    for($i = 0; $i < $sample_size; $i++) {
        array_push($z_array, ($arr[$i] - $mean)/$sd);
    }

    // return $z_array;

    echo "  <thead>
                <tr>
                    <th scope='col text-center'>x</th>
                    <th scope='col text-center'>z</th>
                    <th scope='col text-center'>Mean</th>
                </tr>
            </thead>

            <tbody>";
                    for ($i = 0; $i < $sample_size; $i++) {
                        echo "  <tr> ";
                        echo "      <td class='text-center'>" . $arr[$i] . "</td>";
                        echo "      <td class='text-center'>" . $z_array[$i] . "</td>";
                        if($i == $sample_size-1) {
                            echo "      <td class='text-center' rowspan='".($i+1)."'>" . $mean . "</td>";
                        }
                        echo "  </tr>";
                    }
                echo"</tbody>";
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