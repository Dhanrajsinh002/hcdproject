<?php

session_start();

$scatterData = array(); // [x][y]

$sumX = 0;
$sumY = 0;
$sumXY = 0;
$SXYBAR = 0;
$SXB = 0;
$SYB = 0;

if (isset($_POST['x']) && isset($_POST['y'])) {

    global $SXYBAR, $SXB, $SYB;

    $x_arr = explode(",", $_POST['x']);
    $y_arr = explode(",", $_POST['y']);

    $Sxx = findSXX($x_arr, $y_arr);
    $Sxy = findSXY($x_arr, $y_arr);

    echo "  <thead class='thead-dark'>
                <tr>
                    <th scope='col text-center'><i><b>x</b></i></th>
                    <th scope='col text-center'><i><b>y</b></i></th>
                    <th scope='col text-center'><i><b>x - x̄</b></i></th>
                    <th scope='col text-center'><i><b>y - ȳ</b></i></th>
                    <th scope='col text-center'><i><b>(x - x̄)(y - ȳ)</b></i></th>
                    <th scope='col text-center'><i><b>(x - x̄)<sup>2</sup></b></i></th>
                    <th scope='col text-center'><i><b>(y - ȳ)<sup>2</sup></b></i></th>
                </tr>
            </thead>
            <tbody>";

    for ($i = 0; $i < count($x_arr); $i++) {
        $x = $x_arr[$i];
        $y = $y_arr[$i];
        $x_bar = $x - ($sumX / count($x_arr));
        $y_bar = $y - ($sumY / count($y_arr));
        $x_bar_y_bar = $x_bar * $y_bar;
        $x_sqr = pow($x_bar, 2);
        $y_sqr = pow($y_bar, 2);

        $SXYBAR += $x_bar_y_bar;
        $SXB += $x_sqr;
        $SYB += $y_sqr;
        
        echo "<tr>
                    <td style='width: 14.28%;'>" . $x . "</td>
                    <td style='width: 14.28%;'>" . $y . "</td>
                    <td style='width: 14.28%;'>" . $x_bar . "</td>
                    <td style='width: 14.28%;'>" . $y_bar . "</td>
                    <td style='width: 14.28%;'>" . $x_bar_y_bar . "</td>
                    <td style='width: 14.28%;'>" . $x_sqr . "</td>
                    <td style='width: 14.28%;'>" . $y_sqr . "</td>
                </tr>";
    }

    $Sx = sqrt($SXB / (count($x_arr) - 1) );
    $Sy = sqrt($SYB / (count($y_arr) - 1) );
    $r = ( ((1 / (count($x_arr) - 1)) * $SXYBAR) / ( $Sx * $Sy ) );

    echo "  <tr>
                <td colspan='4'></td>
                <td><i><b> " . $SXYBAR . "</b></i></td>
                <td><i><b> " . $SXB . "</b></i></td>
                <td><i><b> " . $SYB . "</b></i></td>
            </tr>
            
            <tr>
                <td colspan='9'></td>
            </tr>
            
            <tr>
                <td class='text-center' colspan='2' >
                    <i><b>S<sub>x</sub></b></i> = ".$Sx. "
                </td>
                <td class='text-center' colspan='2' >
                    <i><b>S<sub>y</sub></b></i> = ".$Sy."
                </td>
                <td class='text-center' colspan='3' >
                    Linear Correlation (<i><b>r</b></i>) = ".$r."
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
