<?php

session_start();

$bd_n = 0;
$bd_p = 0;
$bd_x = 0;
$bd_o = "";

if( (isset($_POST["bd_n"])) && ($_POST["bd_p"]) && (isset($_POST["bd_x"])) && (isset($_POST["bd_o"]))) {
    
    $bd_n = $_POST["bd_n"];
    $bd_p = $_POST["bd_p"];
    $bd_x = $_POST["bd_x"];
    $bd_o = $_POST["bd_o"];

    if( ($_POST["bd_n"] - $_POST["bd_x"]) > $_POST["bd_x"]) {

        // echo ($_POST["bd_n"]."-". $_POST["bd_n"] - $_POST["bd_x"]);
        binomialCoef($_POST["bd_n"], $_POST["bd_n"] - $_POST["bd_x"], 1);
    
    } else if (($_POST["bd_n"] - $_POST["bd_x"]) == $_POST["bd_x"]) {
    
        // echo ($_POST["bd_n"]." ". $_POST["bd_x"]);
        binomialCoef($_POST["bd_n"], $_POST["bd_x"], 2);
        
    } else {
        
        // echo ($_POST["bd_n"]." ". $_POST["bd_x"]);
        binomialCoef($_POST["bd_n"], $_POST["bd_x"], 2);
        // echo $_POST["bd_x"];
    }
}

function binomialCoef($nume, $val, $flag) {
    global $bd_n, $bd_x;
    
    $nume_facto = 1;
    $deno_facto = 1;
    $deno_init = 0;
    
    for($i = $val+1; $i <= $nume; $i++) {
        $nume_facto *= $i;
    }

    // echo $nume_facto;

    if($flag == 1) {
        $deno_init = $bd_x;
    } else {
        $deno_init = $bd_n - $bd_x;
    }

    // echo $deno_init;

    for($i = $deno_init; $i > 0; $i--) {
        $deno_facto *= $i;
    }

    binomialProbability($nume_facto / $deno_facto);
}

function binomialProbability($n_x) {

    global $bd_n, $bd_p, $bd_x, $bd_o;

    if($bd_o == "equal") {
        echo "  <thead class='thead-dark'>
                    <tr scope='col text-center'>
                        <td class='text-center'>P(X = x) =</td>
                        <td class='text-center'>".$n_x * pow($bd_p, $bd_x) * pow( (1 - $bd_p), $bd_n - $bd_x)."</td>
                    </tr>
                </thead> ";
    } else if ($bd_o == "less_equal") {

    } else {}
}
?>