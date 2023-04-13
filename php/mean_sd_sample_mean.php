<?php

session_start();

$lbl_combinations = array();
$val_combinations = array();

$val_mean_arr = array();
$mean_rel_arr = array();

if( isset($_POST['LBL']) && isset($_POST['VAL']) && isset($_POST['SS'])) {

    $lbl_arr = explode(",", $_POST['LBL']);
    $val_arr = explode(",", $_POST['VAL']);

    $lbl_combinations = getCombinations($lbl_arr, $_POST['SS']);
    $val_combinations = getCombinations($val_arr, $_POST['SS']);

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

    $smean = array_sum($val_mean_arr) / count($val_combinations);

    $ssd = function () use ($smean, $val_mean_arr) {
        $sum = 0;
        for ($i = 0; $i < count($val_mean_arr); $i++) {
            $sum += pow( $val_mean_arr[$i] - $smean ,2);
        }

        return round( sqrt( $sum / count($val_mean_arr)), 2);
    };

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

    // echo "</tbody>";

    echo "  <tr>
                <td colspan='3'>
                    <table class='table table-bordered table-light table-hover table-striped text-center fs-3'>
                        <thead class='thead-dark'>
                            <tr>
                                <th scope='col text-center'>Mean of Sample Mean <b><i>μ<sub>x̄</sub> = μ</i></b></th>
                                <th scope='col text-center'>Standard Deviation of Sample Mean <b><i>σ<sub>x̄</sub></i></b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='text-center' style='width: 50%;'>" . $smean . "</td>
                                <td class='text-center' style='width: 50%;'>" . $ssd() . "</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
    </tbody>";

}

function getCombinations($pool, $groupSize) {
    
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

?>