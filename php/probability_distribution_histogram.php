<?php

session_start();

$datapoints = array();

// if(isset($_POST["pdh_val"])) {
//     // echo $_POST["pdh_val"];

//     $inp_arr = explode(",",$_POST["pdh_val"]);
//     // print_r($inp_arr);

//     $m1frequencies = findResultOfPDHMethod1($inp_arr);
// }

if(isset($_POST["pdh_lbl"]) && isset($_POST["pdh_lbl_val"])) {
    // echo $_POST["pdh_lbl"]."<br>".$_POST["pdh_lbl_val"];

    $labels = $_POST["pdh_lbl"];
    $lbl_val = $_POST["pdh_lbl_val"];

    $lbl_arr = explode(",",$labels);
    $val_arr = explode(",",$lbl_val);

    $m2frequencies = findResultOfPDHMethod2($lbl_arr,$val_arr);
}

function findResultOfPDHMethod1($arr) {

}

function findResultOfPDHMethod2($lbl, $val) {
    global $datapoints;

    $sum = 0;
    for($i = 0; $i < count($val); $i++) {
        $sum += $val[$i];
    }

    $m2rel_freqs = array();
    for($i = 0; $i < count($val); $i++) {
        array_push( $m2rel_freqs, $val[$i]/$sum);
    }

    for($i = 0; $i < count($m2rel_freqs); $i++) {
        array_push($datapoints, array("x" => (string)$lbl[$i], "y" => $m2rel_freqs[$i]) );
    }

    echo "  <thead class='thead-dark'>
                <tr>
                    <th scope='col text-center'>Labels</th>
                    <th scope='col text-center'>Frequency</th>
                    <th scope='col text-center'>Probability <i><b>P(X = x)</b></i> </th>
                </tr>
            </thead><tbody>";
    for($i = 0; $i < count($lbl); $i++) {
        echo "<tr style='text-align: center;'>
                    <td class='text-center' style='width: 25%;'>".$lbl[$i]."</td>
                    <td class='text-center' style='width: 25%;'>".$val[$i]."</td>
                    <td class='text-center' style='width: 50%;'>".$m2rel_freqs[$i]."</td>
                </tr>";
    }

    echo "</tbody>";

    return plotHistogram($datapoints);
}


function plotHistogram($datapoints) {
    ?>
    <script>
        var chart = new CanvasJS.Chart("Histogram", {
            animationEnabled: true,
            title:{
                text: "Customer Satisfaction Based on Reviews"
            },
            axisY: {
                title: "Satisfied Customers",
                includeZero: true,
                suffix: "%"
            },
            axisX: {
                minimum: 0,
                interval: 1,
            },
            data: [{
                type: "stepArea",
                markerSize: 5,
                xValueFormatString: "Prbability",
                yValueFormatString: "#,##0.##\"%\"",
                dataPoints: <?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    </script>
    <?php
}
?>