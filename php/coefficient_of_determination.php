<?php

session_start();

$scatterData = array(); // [x][y]

$sumX = 0;
$sumY = 0;
$sumXY = 0;
$b0 = 0;
$b1 = 0;
$SST = 0;
$SSR = 0;
$SSE = 0;

if (isset($_POST['x']) && isset($_POST['y'])) {

    global $b0, $b1;

    $x_arr = explode(",", $_POST['x']);
    $y_arr = explode(",", $_POST['y']);

    // for ($i = 0; $i < count($x_arr); $i++) {
    //     array_push($scatterData, $x_arr[$i]);
    //     array_push($scatterData, $y_arr[$i]);
    // }

    $Sxx = findSXX($x_arr, $y_arr);
    $Sxy = findSXY($x_arr, $y_arr);

    $b1 = $Sxy / $Sxx;

    $b0 = ($sumY / count($y_arr)) - $b1 * ($sumX / count($x_arr));

    echo "  <thead class='thead-dark'>
                <tr>
                    <th scope='col text-center'><i><b>x</b></i></th>
                    <th scope='col text-center'><i><b>y</b></i></th>
                    <th scope='col text-center'><i><b>y&#770;</b></i></th>
                    <th scope='col text-center'><i><b>y - ȳ</b></i></th>
                    <th scope='col text-center'><i><b>(y - ȳ)<sup>2</sup></b></i></th>
                    <th scope='col text-center'><i><b>y&#770; - ȳ</b></i></th>
                    <th scope='col text-center'><i><b>(y&#770; - ȳ)<sup>2</sup></b></i></th>
                    <th scope='col text-center'><i><b>y - y&#770;</b></i></th>
                    <th scope='col text-center'><i><b>(y - y&#770;)<sup>2</sup></b></i></th>
                </tr>
            </thead>
            <tbody>";

    for ($i = 0; $i < count($x_arr); $i++) {
        $x = $x_arr[$i];
        $y = $y_arr[$i];
        $y_bar = $sumY / count($y_arr);
        $y_hat = $b0 + $b1 * $x;
        $y_y_bar = $y - $y_bar;
        $y_hat_y_bar = $y_hat - $y_bar;
        $y_y_hat = $y - $y_hat;

        $SST += pow($y_y_bar, 2);
        $SSR += pow($y_hat_y_bar, 2);
        $SSE += pow($y_y_hat, 2);

        echo "<tr>
                    <td style='width: 11.11%;'>" . $x . "</td>
                    <td style='width: 11.11%;'>" . $y . "</td>
                    <td style='width: 11.11%;'>" . $y_hat . "</td>
                    <td style='width: 11.11%;'>" . $y_y_bar . "</td>
                    <td style='width: 11.11%;'>" . pow($y_y_bar, 2) . "</td>
                    <td style='width: 11.11%;'>" . $y_hat_y_bar . "</td>
                    <td style='width: 11.11%;'>" . pow($y_hat_y_bar, 2) . "</td>
                    <td style='width: 11.11%;'>" . $y_y_hat . "</td>
                    <td style='width: 11.11%;'>" . pow($y_y_hat, 2) . "</td>
                </tr>";
    }

    echo "  <tr>
                <td colspan='4'></td>
                <td><i><b>SST = " . $SST . "</b></i></td>
                <td></td>
                <td><i><b>SSR = " . $SSR . "</b></i></td>
                <td></td>
                <td><i><b>SSE = " . $SSE . "</b></i></td>
            </tr>
            
            <tr>
                <td colspan='9'></td>
            </tr>
            
            <tr>
                <td class='text-center' colspan='9' >
                    Coefficient of Determination (<i><b>r&#xb2;</b></i>) = <sup>".$SSR."</sup>&frasl;<sub>".$SST."</sub> = ".$SSR/$SST."
                </td>
            </tr>
            <tbody>";
}

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

?>