<?php

session_start();

$datapoints = [];

if (isset($_POST["msdrv_val"])) {

    $inp_arr = explode(",", $_POST["msdrv_val"]);
    sort($inp_arr);
    $m1_mean = calculateMeanMethod1($inp_arr);
}

if (isset($_POST["m2_msdrv_lbl_val"]) && isset($_POST["m2_msdrv_val"])) {

    $inp_lbl = explode(",", $_POST["m2_msdrv_lbl_val"]);
    $inp_val = explode(",", $_POST["m2_msdrv_val"]);
    $m2_mean = calculateMeanMethod2($inp_lbl, $inp_val);
}

function calculateMeanMethod1($arr)
{

    global $datapoints;

    $mean = 0;
    $freq = array();         // holds extracted freq from rel_arr
    $rel_arr = array();     // holds [user's value] & [it's occurance]
    $prob_arr = array();   // holds final probability to observe
    $small_x = array();   // holds small x value to be in coefficient
    $small_xs = array(); // holds square of small x value to be in coefficient

    foreach ($arr as $value) {
        if (isset($rel_arr[$value])) {
            $rel_arr[$value] += 1;
        } else {
            $rel_arr[$value] = 1;
        }
    }

    $arr_val = array_values($rel_arr);
    $arr_key = array_keys($rel_arr);

    foreach ($arr_val as $i) {
        array_push($freq, (int)$i);
    }

    foreach ($arr_key as $i) {
        array_push($small_x, (int)$i);
    }

    for ($i = 0; $i < count($freq); $i++) {
        array_push($prob_arr, $freq[$i] / count($arr));
        // array_push( $m1rel_freqs, round($m1freqs[$i]/count($arr), 2) );
    }

    for ($i = 0; $i < count($freq); $i++) {
        $mean += ($small_x[$i] * $prob_arr[$i]);
    }

    // Standard Deviation

    for ($i = 0; $i < count($freq); $i++) {
        array_push($small_xs, pow($small_x[$i], 2) * $prob_arr[$i]);
    }

    $small_xs_sum = 0;

    for ($i = 0; $i < count($freq); $i++) {
        $small_xs_sum += $small_xs[$i];
    }

    echo "  <thead class='thead-dark'>
                <tr>
                    <th scope='col text-center fs-3'> <i>x</i></th>
                    <th scope='col text-center fs-3'> <i>P(X=x)</i></th>
                    <th scope='col text-center fs-3'> <i>x * P(X=x)</i></th>
                    <th scope='col text-center fs-3'> <i>x<sup>2</sup> * P(X=x)</i></th>
                </tr>
            </thead>
            
            <tbody>";

    for ($i = 0; $i < count($freq); $i++) {
        echo "<tr style='text-align: center;'>
                    <td class='text-center' style='width: 25%;'>" . $small_x[$i] . "</td>
                    <td class='text-center' style='width: 25%;'>" . $prob_arr[$i] . "</td>
                    <td class='text-center' style='width: 25%;'>" . $small_x[$i] * $prob_arr[$i] . "</td>
                    <td class='text-center' style='width: 25%;'>" . pow($small_x[$i], 2) * $prob_arr[$i] . "</td>
                </tr>";
    }

    echo "  <tr style='text-align: center;'>
                <td class='text-center' colspan = '2' style='width: 50%;'> <b><i>Mean (μ): </i></b> " . $mean . " </td>
                <td class='text-center' colspan = '2' style='width: 50%;'> <b><i>Standard Deviation (σ): </i></b>" . round(sqrt($small_xs_sum - pow($mean, 2)), 5) . "</td>
            </tr>
            </tbody>";

    for ($i = 0; $i < count($freq); $i++) {
        array_push($datapoints, array("x" => (string)$small_x[$i], "y" => $prob_arr[$i]));
        // array_push($datapoints, [(string)$small_x[$i], $prob_arr[$i]] );
    }

    // $DataPoints = array();
    // array_push($DataPoints, array('X','Y'));
    // for($i = 0; $i < count($freq); $i++) {
    //     // array_push($DataPoints, array((String) $small_x[$i], $prob_arr[$i]));
    //     array_push($DataPoints, array($small_x[$i], $prob_arr[$i]));
    // }

    // print_r($DataPoints);

    return Histogram($datapoints);
    // return Histogram($DataPoints);
}

function calculateMeanMethod2($lbl, $val)
{

    global $datapoints;

    $mean = 0;
    $small_xs = array();

    for ($i = 0; $i < count($lbl); $i++) {
        $mean += ($lbl[$i] * $val[$i]);
    }

    // Standard Deviation

    for ($i = 0; $i < count($lbl); $i++) {
        array_push($small_xs, pow($lbl[$i], 2) * $val[$i]);
    }

    $small_xs_sum = 0;

    for ($i = 0; $i < count($lbl); $i++) {
        $small_xs_sum += $small_xs[$i];
    }

    // echo round(sqrt($small_xs_sum - pow($mean,2)), 5);

    echo "  <thead class='thead-dark'>
                <tr>
                    <th scope='col text-center fs-3'><i>x</i></th>
                    <th scope='col text-center fs-3'><i>P(X=x)</i></th>
                    <th scope='col text-center fs-3'><i>x * P(X=x)</i></th>
                    <th scope='col text-center fs-3'><i>x<sup>2</sup> * P(X=x)</i></th>
                </tr>
            </thead>
            
            <tbody>";
    for ($i = 0; $i < count($lbl); $i++) {
        echo "<tr style='text-align: center;'>
                    <td class='text-center' style='width: 25%;'>" . $lbl[$i] . "</td>
                    <td class='text-center' style='width: 25%;'>" . $val[$i] . "</td>
                    <td class='text-center' style='width: 25%;'>" . $lbl[$i] * $val[$i] . "</td>
                    <td class='text-center' style='width: 25%;'>" . $small_xs[$i] . "</td>
                </tr>";
    }

    echo "<tr style='text-align: center;'>
            <td class='text-center' colspan = 2; style='width: 50%;'> <b><i>Mean (μ): </i></b> " . $mean . " </td>
            <td class='text-center' colspan = 2; style='width: 50%;'> <b><i>Standard Deviation (σ): </i></b>" . round(sqrt($small_xs_sum - pow($mean, 2)), 5) . "</td>
            </tr>
            </tbody>";

    for ($i = 0; $i < count($val); $i++) {
        array_push($datapoints, array("x" => (string)$lbl[$i], "y" => $val[$i]));
    }

    return Histogram($datapoints);
}

function Histogram($datapoints)
{
?>
    <script>
        var chart = new CanvasJS.Chart("Histogram", {
            animationEnabled: true,
            title: {
                text: "Histogram"
            },
            axisY: {
                includeZero: true,
                suffix: "%",
                maximum: 1,
            },
            axisX: {
                minimum: 0,
                interval: 1,
            },
            data: [{
                type: "stepArea",
                markerSize: 5,
                xValueFormatString: "Prbability",
                yValueFormatString: "#,##0.###\"%\"",
                dataPoints: <?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    </script>

    <!-- <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($datapoints); ?>);

        var options = {
          title: 'Lengths of dinosaurs, in meters',
          legend: { position: 'none' },
          backgroundColor: 'transparent',
          hAxis: {title: 'x', gridlines: {color: 'transparent'}},
          vAxis: {title: 'P(X=x)', gridlines: {count: 5, color: 'transparent'}},
          seriesType: "bars",
          isStacked: true
        };

        var chart = new google.visualization.Histogram(document.getElementById('Histogram'));
        chart.draw(data, options);
      }
    </script> -->
<?php
}

?>