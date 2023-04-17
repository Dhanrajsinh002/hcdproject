<?php

session_start();

if(isset($_POST['nh']) && isset($_POST['sl']) && isset($_POST['sm']) && isset($_POST['sd']) && isset($_POST['ss']) && isset($_POST['c']) && isset($_POST['ci_alpha'])) {
    
    $decision = "";
    $sign_prefix = "";
    $compare_prefix = "";
    $region = "";
    $z = round(($_POST['sm'] - $_POST['nh']) / ($_POST['sd'] / sqrt($_POST['ss'])), 2);
    $cv = $_POST['ci_alpha'];

    $final_cv = 0;

    if($_POST['c'] == "tow_tailed") {
        $sign_prefix = "±";
        if($z <= -($cv) || $z >= $cv) {
            $decision = "rejected";
            $compare_prefix = "outside of";
            $region = "rejection region";
        } else {
            $decision = "accepted";
            $compare_prefix = "inside of";
            $region = "acceptance region";
        }
    } else if($_POST['c'] == "right_tailed") {
        if($z > $cv) {
            $decision = "rejected";
            $compare_prefix = "right side of";
            $region = "rejection region";
        } else {
            $decision = "accepted";
            $compare_prefix = "left side of";
            $region = "acceptance region";
        }
    } else {
        $sign_prefix = "-";
        if ($z < -($cv)) {
            $decision = "rejected";
            $compare_prefix = "left side of";
            $region = "rejection region";
        } else {
            $decision = "accepted";
            $compare_prefix = "right side of";
            $region = "acceptance region";
        }
    }

    // echo $z." - ".$cv." - ".$decision;
    echo "  <thead class='thead-dark'>
                <tr>
                    <th>Results</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td> The value of the test statistic is <b><i>z</i></b> = ".$z. " </td>
                </tr>
                <tr>
                    <td> Here The value of the test statistic is " . $compare_prefix . " The Critical Value " . $sign_prefix . "" . $cv . " limits and appears in " . $region . "</td>
                </tr>
                <tr>
                    <td> Hence Null Hypothesis (<b><i>H<sub>0</sub></i></b>) is " . $decision . "</td>
                </tr>
            </tbody>";
}

?>