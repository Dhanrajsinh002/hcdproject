<?php

session_start();

$N = 0;
$P = 0;
$X = 0;
$mean = 0;
$sd = 0;
$Condition = "";
$p_arr = array();

if( (isset($_POST["N"])) && ($_POST["P"]) && (isset($_POST["X"])) && (isset($_POST["Condition"]))) {
    
    $N = $_POST["N"];
    $P = $_POST["P"];
    $X = $_POST["X"];
    $Condition = $_POST["Condition"];
    $begin = 0;
    $end = 0;

    if($Condition == "less_equal") {
        $begin = 0;
        $end = $_POST['X'];
    } else if($Condition == "greter_equal") {
        $begin = $_POST['X'];
        $end = $_POST['N'];
    } else if($Condition == "all") {
        $begin = 0;
        $end = $_POST['N'];
    } else {
        $begin = $_POST['X'];
        $end = $_POST['X'];
    }

    echo "  <thead class='thead-dark'>
                <tr>
                    <td scope='col text-center'>Mean   <b><i>μ = np</i></b></td>
                    <td scope='col text-center'>".$N * $P. "</td>
                </tr>
                <tr>
                    <td scope='col text-center'>S.D.   <b><i>σ = √np(1 - p)</i></b></td>
                    <td scope='col text-center'>".round( sqrt( $N * $P * (1 - $P) ), 2)."</td>
                </tr>
                <tr>
                    <td  scope='col text-center'>Number Correct <br> <b><i>x</i></b></td>
                    <td  scope='col text-center'>Probability <br> <b><i>P(X = x)</i></b></td>
                </tr>
            </thead><tbody>";
    for($i = $begin; $i <= $end; $i++) {
        $NcR = fact($N) / (fact($i) * fact($N - $i));
        // array_push($p_arr, round( $NcR * pow($P, $X) * (pow((1 - $P), ($N - $X))), 4));
        echo "      <tr>
                        <td class='text-center'>" . $i . "</td>
                        <td class='text-center'>" . round($NcR * pow($P, $X) * (pow((1 - $P), ($N - $X))), 4) . "</td>
                    </tr>
                </tbody> ";
        // round( $NcR * pow($P, $X) * (pow((1 - $P), ($N - $X))), 4);
    }

    
}

function fact($num) {
    $f = 1;
    while ($num != 0) {
        $f *= $num;
        $num--;
    }
    return $f;
}