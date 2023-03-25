<?php

session_start();

if(isset($_POST['n_val']) && isset($_POST['p_val'])) {
    $mean = calculateMean($_POST['n_val'], $_POST['p_val']);
    $sd = calculateSD($_POST['n_val'], $_POST['p_val']);

    echo "  <thead>
                <tr>
                    <td style='width: 50%;'> <i><b>Mean (μ)</b></i></td>
                    <td style='width: 50%;'> <i><b>Standard Deviation (σ)</b></i></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='width: 50%;'> ".$mean."</td>
                    <td style='width: 50%;'> ".$sd."</td>
                </tr>
            </tbody>";
}

function calculateMean($n, $p) {
    return $n*$p;
}

function calculateSD($n, $p) {
    return (sqrt($n * $p * (1 - $p)));
}

?>