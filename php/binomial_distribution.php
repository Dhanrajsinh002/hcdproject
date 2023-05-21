<?php

session_start();

$mainDataPoints = array();
$subDataPoints = array();

if( (isset($_POST["bd_n"])) && ($_POST["bd_p"]) && (isset($_POST["bd_x"])) && (isset($_POST["bd_o"]))) {
    
    $bd_n = $_POST["bd_n"];
    $bd_p = $_POST["bd_p"];
    $bd_x = $_POST["bd_x"];
    $bd_o = $_POST["bd_o"];

    for($i = 0; $i <= $bd_n; $i++) {
        array_push($mainDataPoints, array( "X" => $i, "Y" => binomial_pmf($bd_n, $bd_p, $i)) );
    }

    if($bd_o == "equal") {
        binomial_pmf($bd_n, $bd_p, $bd_x);
    } else if($bd_o == "less_equal") { // atleast
        binomial_at_most($bd_n, $bd_p, $bd_x);
        echo "  <thead class='thead-dark'>
                    <tr>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                    </tr>
                </tbody>";
    } else { // atmost
        binomial_at_least($bd_n, $bd_p, $bd_x);
        echo "  <thead class='thead-dark'>
                    <tr>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                    </tr>
                </tbody>";
    }
}

// Define the function to calculate the binomial coefficient
function binomialCoef($n, $k) {

  if ($k == 0 || $k == $n) {
    return 1;
  } else {
    $numerator = 1;
    for ($i = $n; $i >= $n - $k + 1; $i--) {
      $numerator *= $i;
    }
    $denominator = 1;
    for ($j = $k; $j >= 1; $j--) {
      $denominator *= $j;
    }
    return $numerator / $denominator;
  }
}

// Define the function to calculate the PMF of the binomial distribution
function binomial_pmf($n, $p, $k)
{
    $q = 1 - $p;
    $coefficient = binomialCoef($n, $k);
    $probability = pow($p, $k) * pow($q, $n - $k);
    return $coefficient * $probability;
}

// Define the function to calculate the probability of getting at least k successes
function binomial_at_least($n, $p, $k)
{
    // $probability = 0;
    $probability = array();
    for ($i = $k; $i <= $n; $i++) {
        // $probability += binomial_pmf($n, $p, $i);
        array_push($subDataPoints, array("X" => $i, "Y" => binomial_pmf($n, $p, $i)) );
        array_push($probability, binomial_pmf($n, $p, $i));
    }
    return $probability;
}

// Define the function to calculate the probability of getting at most k successes
function binomial_at_most($n, $p, $k)
{
    // $probability = 0;
    $probability = array();
    for ($i = 0; $i <= $k; $i++) {
        // $probability += binomial_pmf($n, $p, $i);
        array_push($subDataPoints, array("X" => $i, "Y" => binomial_pmf($n, $p, $i)) );
        array_push($probability, binomial_pmf($n, $p, $i));
    }
    return $probability;
}


?>