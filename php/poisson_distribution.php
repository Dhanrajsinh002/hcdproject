<?php

session_start();

if(isset($_POST['lmd']) && isset($_POST['X']) && isset($_POST['condition'])) {
    
    $facto = calculateFacto($_POST['X']);

    echo "  <tbody>
            <tr>
                    <td class='text-center'><i><b>Mean (μ) </b></i></td>
                    <td scope='col text-center' style='width: 25%;'> ".$_POST['lmd']."</td>
            </tr>
            <tr>
                    <td class='text-center'><i><b>Standard Deviation (σ) </b></i></td>
                    <td scope='col text-center' style='width: 25%;'> ".round(pow($_POST['lmd'], 0.5), 3). "</td>
            </tr>
            <tr>
                    <td class='text-center'><i><b>Varience (σ<sup>2</sup>) </b></i></td>
                    <td scope='col text-center' style='width: 25%;'> ".$_POST['lmd']."</td>
            </tr>
            <tr>
                    <td class='text-center'><i><b>P (X = x) = </b></i></td>
                    <td scope='col text-center' style='width: 25%;'> ".round( ( exp(-$_POST['lmd']) * (pow($_POST['lmd'], $_POST['X']) / $facto) ), 4)."</td>
            </tr>
            </tbody>";
    
    
    
            // <thead class='thead-dark'><tr>
            // </tr></thead>";
}

function calculateFacto($val) {
    $facto = 1;

    for($i = $val; $i > 0; $i--) {
        $facto *= $i;
    }

    return $facto;
}

?>