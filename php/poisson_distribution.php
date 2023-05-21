<?php

session_start();

$mainDataPoints = array();
$subDataPoints = array();

if(isset($_POST['lmd']) && isset($_POST['X']) && isset($_POST['condition'])) {

        $lim = 0;
        $i = 0;
        // for ($i = 0; $i <= ); $i++) {
        //         array_push($mainDataPoints, array("X" => $i, "Y" => poisson_pmf($_POST['lmd'], $i)));
        // }

        do{
                $lim += poisson_pmf($_POST['lmd'], $i);
                array_push($mainDataPoints, array("X" => $i, "Y" => $lim));
                $i++;
        } while($lim >= 0.1);

        // if ($_POST['condition'] == "equal") {
        //         poisson_pmf($_POST['lmd'], $bd_x);

        // } else if ($_POST['condition'] == "less_equal") { // atleast
        //         poisson_cdf_at_most($_POST['lmd'], $bd_x);
        //         echo "  <thead class='thead-dark'>
        //             <tr>
        //                 <th>Result</th>
        //             </tr>
        //         </thead>
        //         <tbody>
        //             <tr>
        //                 <td></td>
        //             </tr>
        //         </tbody>";

        // } else { // atmost
        //         poisson_cdf_at_least($_POST['lmd'], $bd_x);
        //         echo "  <thead class='thead-dark'>
        //             <tr>
        //                 <th>Result</th>
        //             </tr>
        //         </thead>
        //         <tbody>
        //             <tr>
        //                 <td></td>
        //             </tr>
        //         </tbody>";
        // }

        print_r($mainDataPoints);
//     echo "  <tbody>
//             <tr>
//                     <td class='text-center'><i><b>Mean (μ) </b></i></td>
//                     <td scope='col text-center' style='width: 25%;'> ".$_POST['lmd']."</td>
//             </tr>
//             <tr>
//                     <td class='text-center'><i><b>Standard Deviation (σ) </b></i></td>
//                     <td scope='col text-center' style='width: 25%;'> ".round(pow($_POST['lmd'], 0.5), 3). "</td>
//             </tr>
//             <tr>
//                     <td class='text-center'><i><b>Varience (σ<sup>2</sup>) </b></i></td>
//                     <td scope='col text-center' style='width: 25%;'> ".$_POST['lmd']."</td>
//             </tr>
//             <tr>
//                     <td class='text-center'><i><b>P (X = x) = </b></i></td>
//                     <td scope='col text-center' style='width: 25%;'> ".round( ( exp(-$_POST['lmd']) * (pow($_POST['lmd'], $_POST['X']) / $facto) ), 4)."</td>
//             </tr>
//             </tbody>";
}

// Define the Poisson probability mass function
function poisson_pmf($mu, $k) {
        $e = exp(1);
        $pmf = (pow($mu, $k) * pow($e, -$mu)) / factorial($k);
        return $pmf;
}

// Define the factorial function
function factorial($n) {
        if ($n <= 1) {
                return 1;
        } else {
                return $n * factorial($n - 1);
        }
}

// Define the Poisson cumulative distribution function for "at most" k events
function poisson_cdf_at_most($mu, $k)
{
        $cdf = 0;
        for ($i = 0; $i <= $k; $i++) {
                $cdf += poisson_pmf($mu, $i);
        }
        return $cdf;
}

// Define the Poisson cumulative distribution function for "at least" k events
function poisson_cdf_at_least($mu, $k) {
        $cdf = 0;
        $i = $k;
        do{
                $cdf += poisson_pmf($mu, $i);
                $i++;
        }
        while ($cdf >= 0.1);
        return $cdf;
}

?>