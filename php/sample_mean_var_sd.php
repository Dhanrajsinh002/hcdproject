<?php

session_start();

$mean = 0;
$sample_size = 0;
$xi_sum = 0;

if(isset($_POST["mvsd_data"])) {
    $arr = explode(",",$_POST["mvsd_data"]);
    
    $mean = findMean($arr);
    // echo $xi_sum;
    // exit(0);
    $variance = findVariance($arr);
    $sd = findStandardDeviation($arr);

    // echo "  <div class='row'>
    //             <div class='col text-center fs-3 border pt-3 pb-3'><p class='font-weight-bold'> Mean</p></div>
    //             <div class='col text-center fs-3 border pt-3 pb-3'><p class='font-weight-bold'> Varience</p></div>
    //             <div class='col text-center fs-3 border pt-3 pb-3'><p class='font-weight-bold'> Standard Deviation</p></div>
    //         </div>

    //         <div class='row'>
    //             <div class='col text-center fs-3 border pt-3 pb-3' id='meanResult'><p class='font-weight-bold'>".$mean."</p></div>
    //             <div class='col text-center fs-3 border pt-3 pb-3' id='medianResult'><p class='font-weight-bold'>".$variance."</p></div>
    //             <div class='col text-center fs-3 border pt-3 pb-3' id='modeResult'><p class='font-weight-bold'>".$sd."</p></div>
    //         </div>
    //         ";

    echo "  <thead>
                <tr>
                    <th scope='col text-center'>Mean</th>
                    <th scope='col text-center'>Varience</th>
                    <th scope='col text-center'>Standard Deviation</th>
                </tr>
            </thead>

            <tbody>            
                <tr> 
                    <td id='meanResult'>".$mean."</td> 
                    <td id='medianResult'>".$variance."</td>  
                    <td id='modeResult'>".$sd."</td> 
                </tr>
            </tbody>
            ";
}

function findMean($arr) {
    global $sample_size, $xi_sum;
    $sample_size = count($arr);
    for($i = 0; $i < $sample_size; $i++) {
        $xi_sum += $arr[$i];
    }
    
    return round($xi_sum / $sample_size, 2);
}

function findVariance($arr) {
    global $mean, $sample_size;
    // echo $sample_size;
    // exit(0);
    $nume = 0;
    for($i = 0; $i < $sample_size; $i++) {
        $nume += pow($arr[$i] - $mean, 2);
    }

    return round($nume/($sample_size - 1), 2);
}

// function findStandardDeviation($arr) {
//     global $sample_size, $xi_sum;
//     $nume = 0;
//     for($i = 0; $i < $sample_size; $i++) {
//         $nume += ( pow($arr[$i], 2) - ( pow($xi_sum, 2) / $sample_size ) );
//     }

//     return (sqrt($nume / ($sample_size - 1)));
// }

function findStandardDeviation($arr) {
    global $mean, $sample_size;
    $nume = 0;
    for($i = 0; $i < $sample_size; $i++) {
        $nume += pow($arr[$i] - $mean ,2);
    }

    return round(sqrt($nume/ ($sample_size - 1)), 2);
}
