<?php

session_start();

$lbl_combinations = array();
$val_combinations = array();

$val_mean_arr = array();
$mean_rel_arr = array();

$dataPoints = [];

if (isset($_POST['LBL']) && isset($_POST['VAL']) && isset($_POST['GRP'])) {

    $lbl_arr = explode(",", $_POST['LBL']);
    $val_arr = explode(",", $_POST['VAL']);

    $lbl_combinations = getCombinations($lbl_arr, $_POST['GRP']);
    $val_combinations = getCombinations($val_arr, $_POST['GRP']);

    // to find mean of grouped value

    $sum = 0;
    $len = 0;

    for ($i = 0; $i < count($lbl_combinations); $i++) {
        for ($j = 0; $j < count($val_combinations[$i]); $j++) {
            $sum += $val_combinations[$i][$j];
            $len++;
        }
        array_push($val_mean_arr, $sum / $len);
        $sum = 0;
        $len = 0;
    }

    // set into associative array so we can create dot plot
    foreach ($val_mean_arr as $value) {
        if (isset($mean_rel_arr[(string)$value])) {
            $mean_rel_arr[(string)$value] += 1;
        } else {
            $mean_rel_arr[(string)$value] = 1;
        }
    }

    echo "<thead class='thead-dark'>
                <tr>
                    <th scope='col text-center'>Sample Label</th>
                    <th scope='col text-center'>Sample Value</th>
                    <th scope='col text-center'>Sample Mean <b><i>x̄</i></b></th>
                </tr>
            </thead><tbody>";
    for ($i = 0; $i < count($lbl_combinations); $i++) {
        echo "<tr> <td class='text-center' style='width: 33.33%;'>";
        for ($j = 0; $j < count($val_combinations[$i]); $j++) {
            if ($j == (count($val_combinations[$i]) - 1)) {
                echo $lbl_combinations[$i][$j];
            } else {
                echo $lbl_combinations[$i][$j] . " , ";
            }
        }
        echo "</td> <td class='text-center' style='width: 33.33%;'>";
        for ($j = 0; $j < count($val_combinations[$i]); $j++) {
            if ($j == (count($val_combinations[$i]) - 1)) {
                echo $val_combinations[$i][$j];
            } else {
                echo $val_combinations[$i][$j] . " , ";
            }
        }
        echo "</td><td class='text-center' style='width: 33.33%;'>" . $val_mean_arr[$i] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";

    foreach ($mean_rel_arr as $key => $value) {
        for ($i = 1; $i <= $value; $i++) {
            array_push($dataPoints, (object) array("y" => $i, "x" => (string)$key));
        }
    }

    echo plotDotplot($dataPoints);
    exit(0);
}

function getCombinations($pool, $groupSize)
{

    $combinations = array();
    $poolSize = count($pool);

    if ($groupSize > $poolSize) {
        return $combinations;
    }

    for ($i = 0; $i < $poolSize; $i++) {
        if ($groupSize == 1) {
            $combinations[] = array($pool[$i]);
        } else {
            $remainingPool = array_slice($pool, $i + 1);
            $subcombinations = getCombinations($remainingPool, $groupSize - 1);
            foreach ($subcombinations as $subcombination) {
                array_unshift($subcombination, $pool[$i]);
                $combinations[] = $subcombination;
            }
        }
    }

    return $combinations;
}

function plotDotplot($datapoints)
{
?>
    <script>
        function compareDataPointXAscend(dataPoint1, dataPoint2) {
            return dataPoint1.label - dataPoint2.label;
        }

        var chart = new CanvasJS.Chart("sedDot", {
            animationEnabled: true,
            theme: "light1",
            title: {
                text: "Dot Plot"
            },
            axisX: {
                title: "Sample Mean",
            },
            axisY: {
                title: "Frequency",
                interval: 1
            },
            data: [{
                type: "scatter",
                markerType: "circle",
                markerSize: 20,
                toolTipContent: "Freq. : {y} <br>S.M. : {x} ",
                dataPoints: <?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>
            }]
        });

        chart.options.data[0].dataPoints.sort(compareDataPointXAscend);

        chart.render();
    </script>
<?php
}
// $lbl_arr = array('A', 'B', 'C', 'D', 'E');
// $val_arr = array(76 , 78 , 79 , 81 , 86 );
// $groupSize = 2;

// // Calculate the number of distinct combinations
// $lbl_combinations = array();
// $val_combinations = array();

// for ($i = 0; $i < count($lbl_arr); $i++) {
//     for ($j = $i + 1; $j < count($lbl_arr); $j++) {
//         $lbl_combinations[] = array($lbl_arr[$i], $lbl_arr[$j]);
//         $val_combinations[] = array($val_arr[$i], $val_arr[$j]);
//     }
// }

// Print the distinct combinations
// foreach ($lbl_combinations as $combination) {
//     echo implode(',', $combination) . " ";
// }

// echo "<br>";

// foreach ($val_combinations as $combination) {
//     echo implode(',', $combination) . " ";
// }
?>