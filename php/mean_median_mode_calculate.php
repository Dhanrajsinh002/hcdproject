<?php
session_start();
if(isset($_POST["val_arr"])) {
    // $inp = $_POST["mmm_val"];
    // echo $_POST["val_arr"];
    $inp = $_POST["val_arr"];
    $inp_arr = explode(",",$inp);

    $mean = findMean($inp_arr);
    $median = findMedian($inp_arr);
    $mode = findMode($inp_arr);

    echo "  <thead>
            <tr> 
                <th scope='col text-center' id='meanResult'>Mean</td> 
                <th scope='col text-center' id='medianResult'>Median</td> 
                <th scope='col text-center' id='modeResult'>Mode</td> 
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class='text-center' id='meanResult'>".$mean."</td> 
                <td class='text-center' id='medianResult'>".$median."</td> 
                <td class='text-center' id='modeResult'>".$mode."</td> 
            </tr>
            </tbody>";
}

function findMean($arr) {
    $sum = 0;
    for($i = 0; $i < count($arr); $i++) {
        $sum += $arr[$i];
    }
    return ($sum/count($arr));
}

function findMedian($arr) {
    sort($arr);
    if(count($arr) % 2 == 0) {
        return (int) (($arr[ (int) ((count($arr) - 1) / 2) ] + $arr[ (int) (count($arr) / 2) ] ) / 2);
    } else {
        return ($arr[ (int) (count($arr) / 2) ]);
    }
}

function findMode($arr) {
    $mode = "";
    $rarr = array();
    foreach($arr as $value) {
        if(isset($rarr[$value])) {
            $rarr[$value] += 1;
        } else {
            $rarr[$value] = 0;
        }
    }
    // for ($i = 0; $i < count($arr); $i++) {
    //     echo $arr[$i].",";
    // }
    // foreach($rarr as $x => $y) {
    //     echo $x." => ".$y."<br>";
    // }

    // $mode = array_keys($rarr, max($rarr));
    // print_r(array_keys($rarr, max($rarr)));
    $ak = array_keys($rarr, max($rarr));
    foreach($ak as $i) {
        $mode .= (string)$i." ";
    }

    return $mode;

}

// echo "<br>Mean = ".$mean."<br>Median = ".$median."<br>Mode = ".$mode;
?>