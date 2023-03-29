<?php

$lbl_pool = array('A', 'B', 'C', 'D', 'E');
$val_pool = array(76 , 78 , 79 , 81 , 86 );
$groupSize = 2;

// Calculate the number of distinct combinations
$lbl_combinations = array();
$val_combinations = array();

for ($i = 0; $i < count($lbl_pool); $i++) {
    for ($j = $i + 1; $j < count($lbl_pool); $j++) {
        $lbl_combinations[] = array($lbl_pool[$i], $lbl_pool[$j]);
        $val_combinations[] = array($val_pool[$i], $val_pool[$j]);
    }
}

// Print the distinct combinations
foreach ($lbl_combinations as $combination) {
    echo implode(',', $combination) . " ";
}

echo "<br>";

foreach ($val_combinations as $combination) {
    echo implode(',', $combination) . " ";
}
?>