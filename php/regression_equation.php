<?php

session_start();

$scatterData = array(); // [x][y]

$sumX = 0;
$sumY = 0;
$sumXY = 0;
$b0 = 0;
$b1 = 0;

if (isset($_POST['x']) && isset($_POST['y'])) {

    global $b0, $b1;

    $x_arr = explode(",", $_POST['x']);
    $y_arr = explode(",", $_POST['y']);

    for ($i = 0; $i < count($x_arr); $i++) {
        array_push($scatterData, $x_arr[$i]);
        array_push($scatterData, $y_arr[$i]);
    }

    $Sxx = findSXX($x_arr, $y_arr);
    $Sxy = findSXY($x_arr, $y_arr);

    $b1 = $Sxy / $Sxx;

    $b0 = ($sumY / count($y_arr)) - $b1 * ($sumX / count($x_arr));

    $_SESSION['b0'] = $b0;
    $_SESSION['b1'] = $b1;
    $_SESSION['x_arr'] = $x_arr;
    $_SESSION['y_arr'] = $y_arr;
    $_SESSION['scatterData'] = $scatterData;

    // $y_hat = $bo + $b1*

    // print_r($scatterData);
    // exit(0);

    echo "  <thead class='thead-dark'>
                <tr>
                    <th scope='col text-center'><i><b>x</b></i></th>
                    <th scope='col text-center'><i><b>y</b></i></th>
                    <th scope='col text-center'><i><b>x - x̄</b></i></th>
                    <th scope='col text-center'><i><b>y - ȳ</b></i></th>
                    <th scope='col text-center'><i><b>(x - x̄)<sup>2</sup></b></i></th>
                    <th scope='col text-center'><i><b>(x - x̄)(y - ȳ)</b></i></th>
                </tr>
            </thead>
            <tbody>";

    for ($i = 0; $i < count($x_arr); $i++) {
        echo "<tr>
                    <td style='width: 16.66%;'>" . $x_arr[$i] . "</td>
                    <td style='width: 16.66%;'>" . $y_arr[$i] . "</td>
                    <td style='width: 16.66%;'>" . $x_arr[$i] - ($sumX / count($x_arr)) . "</td>
                    <td style='width: 16.66%;'>" . $y_arr[$i] - ($sumY / count($y_arr)) . "</td>
                    <td style='width: 16.66%;'>" . pow($x_arr[$i] - ($sumX / count($x_arr)), 2) . "</td>
                    <td style='width: 16.66%;'>" . ($x_arr[$i] - ($sumX / count($x_arr))) * ($y_arr[$i] - ($sumY / count($y_arr))) . "</td>
                </tr>";
    }

    echo "  <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Σ(x - x̄) = <i><b>" . $Sxx . "</b></i></td>
                <td>Σ(x - x̄)(y - ȳ) = <i><b>" . $Sxy . "</b></i></td>
            </tr>
            
            <tr>";
            echo "<td colspan='6'><i><b>ŷ = " . $b0; 
            if($b1 > 0) {
                echo " +";
            } else {
                // echo "+";
            }
            echo " ".$b1 . " * x</b></i>   </td>
            </tr>
            
            <!--<tr>
                <td colspan='2'><i><b>ŷ = " . $b0 . " + " . $b1 . " * </b></i> <input type='text' class='fs-3' name='eq1' id='eq1' style='width: 5%' placeholder='<b><i>x</i></b>' required/></td>
                <td colspan='2'><i><b>ŷ = " . $b0 . " + " . $b1 . " * </b></i> <input type='text' class='fs-3' name='eq2' id='eq2' style='width: 5%' required/></td>
                <td colspan='2'><button id='eq_btn' class='btn btn-primary m-lg-3 fs-4' onclick='claculateYHat(document.getElementById(`eq1`).value, document.getElementById(`eq2`).value)'>Calculate</button></td>
            </tr>-->
             <tr>
                <td colspan='2'><i><b>ŷ = <input type='text' class='fs-3' name='eq1_b0' id='eq1_b0' style='width: 7%' placeholder='b0' required/>  <input type = 'text' class = 'fs-3' name = 'eq1_sign' id = 'eq1_sign' style = 'width: 7%' placeholder = '+/-' maxlength = '1' required/>  <input type='text' class='fs-3' name='eq1_b1' id='eq1_b1' style='width: 7%' placeholder='b1' required/> * </b></i> <input type='text' class='fs-3' name='eq1_x' id='eq1_x' style='width: 5%' placeholder='x' required/></td>
                <td colspan='2'><i><b>ŷ = <input type='text' class='fs-3' name='eq2_b0' id='eq2_b0' style='width: 7%' placeholder='b0' disabled/>  <input type = 'text' class = 'fs-3' name = 'eq2_sign' id = 'eq2_sign' style = 'width: 7%' placeholder = '+/-' maxlength = '1' disabled/>  <input type='text' class='fs-3' name='eq2_b1' id='eq2_b1' style='width: 7%' placeholder='b1' disabled/> * </b></i> <input type='text' class='fs-3' name='eq2_x' id='eq2_x' style='width: 5%' placeholder='x' required/></td>
                <td colspan='2'><button id='eq_btn' class='btn btn-primary m-lg-3 fs-4' onclick='claculateYHat(document.getElementById(`eq1_b0`).value, document.getElementById(`eq1_b1`).value, document.getElementById(`eq1_x`).value)'>Calculate</button></td>
            </tr>
            </tbody>";
}

if( isset($_POST['b0']) && isset($_POST['sign']) && isset($_POST['b1']) && isset($_POST['x1']) && isset($_POST['x2'])) {
    echo $_POST['b0']." || ". $_POST['sign']." || ". $_POST['b1']." || ". $_POST['x1']." || ". $_POST['x2'];        
}

// if (isset($_POST['x1']) && isset($_POST['x2'])) {

//     $sct_arr = array(); // all datapoints of X and Y values
//     $predt_arr = array(); // preidcted Y Hat values (calculated) & X (entered by user)

//     $gChart_arr = array();

//     $dataScattered = $_SESSION['scatterData'];
//     $x_data = $_SESSION['x_arr'];
//     $y_data = $_SESSION['y_arr'];

//     $first_point = calculateYHat($_POST['x1']);
//     $second_point = calculateYHat($_POST['x2']);

//     for ($i = 0; $i < count($dataScattered); $i += 2) {
//         array_push($sct_arr, array("x" => $dataScattered[$i], "y" => $dataScattered[$i + 1]));
//     }

//     array_push($predt_arr, array("y" => $first_point, "label" => $_POST['x1']));
//     array_push($predt_arr, array("y" => $second_point, "label" => $_POST['x2']));

//     // array_push($gChart_arr, array('X','Y','Predicted'));

//     // for($i = 0; $i < count($x_data); $i++) {
//     //     if($i == $_POST['x1'] || $i == $_POST['x2']) {

//     //     } else {
//     //         array_push($gChart_arr, );
//     //     }
//     // }

//     // print_r($sct_arr);
//     plotScatter($sct_arr,$predt_arr);
//     // plotLine($predt_arr);
// }

function findSXX($x, $y)
{

    global $sumX, $sumY;
    $sumX2 = 0;

    for ($i = 0; $i < count($x); $i++) {
        $sumX += $x[$i];
        $sumY += $y[$i];
        $sumX2 += pow($x[$i], 2);
    }

    return $sumX2 - (pow($sumX, 2) / count($x));
}

function findSXY($x, $y)
{

    global $sumX, $sumY;
    $sumXY = 0;

    for ($i = 0; $i < count($x); $i++) {
        $sumXY += ($x[$i] * $y[$i]);
    }

    return $sumXY - (($sumX * $sumY) / count($x));
}

function calculateYHat($x)
{
    return $_SESSION['b0'] + $_SESSION['b1'] * $x;
}

function plotScatter($data, $predt_data)
{
?>
    <script>
        var chart = new CanvasJS.Chart("comboPlot", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1",
            title: {
                text: ""
            },
            axisX: {
                title: "X",
                suffix: ""
            },
            axisY: {
                title: "Y",
                suffix: ""
            },
            // toolTip: {
            //     shared: true
            // },
            data: [{
                    type: "scatter",
                    markerType: "circle",
                    markerSize: 10,
                    toolTipContent: "Y : {y} <br>X : {x} ",
                    dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
                }, {
                    type: "line",
                    toolTipContent: "<i><b>ŷ</b></i> : {y} <br><i><b>x</b></i> : {x} ",
                    dataPoints: <?php echo json_encode($predt_data, JSON_NUMERIC_CHECK); ?>
                }]
        });
        chart.render();


    </script>
<?php
}

// function plotLine($data)
// {
// ?>
     <!-- <script>
//         var chart = new CanvasJS.Chart("comboPlot", {
//             title: {
//                 text: "Push-ups Over a Week"
//             },
//             axisY: {
//                 title: "Number of Push-ups"
//             },
//             data: [{
//                 type: "line",
                // dataPoints: <?php //echo json_encode($data, JSON_NUMERIC_CHECK); ?>
//             }]
//         });
//         chart.render();
//     </script> -->
 <?php
// }

?>