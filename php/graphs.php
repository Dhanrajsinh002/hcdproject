<?php
session_start();

// graph array

$datapoints = array();

// grpah plotting function


// for first method calculation
if (isset($_POST["m1_data"])) {
    $inp_arr = explode(",", $_POST["m1_data"]);
    // print_r($inp_arr);

    $m1frequencies = findResultOfMethod1($inp_arr);

    print_r($m1frequencies);
}

// for second method calculation
if (isset($_POST["m2_label"]) && isset($_POST["m2_data"])) {
    $labels = $_POST["m2_label"];
    $lbl_val = $_POST["m2_data"];

    $lbl_arr = explode(",", $labels);
    $val_arr = explode(",", $lbl_val);

    $m2frequencies = findResultOfMethod2($lbl_arr, $val_arr);
}

function findResultOfMethod1($arr)
{

    global $datapoints;

    // for finding frequencies

    $m1label = array();
    $m1freqs = array();
    $rel_arr = array();
    foreach ($arr as $value) {
        if (isset($rel_arr[$value])) {
            $rel_arr[$value] += 1;
        } else {
            $rel_arr[$value] = 1;
        }
    }

    $arr_lbl = array_keys($rel_arr);
    $arr_val = array_values($rel_arr);

    foreach ($arr_val as $i) {
        array_push($m1freqs, (int)$i);
    }

    foreach ($arr_lbl as $i) {
        array_push($m1label, $i);
    }

    // print_r($m1freqs);
    // print_r($m1label);
    // exit(0);
    // return $rel_arr;

    // for finding relative frequencies

    $m1rel_freqs = array();

    for ($i = 0; $i < count($m1freqs); $i++) {
        array_push($m1rel_freqs, $m1freqs[$i] / count($arr));
        // array_push( $m1rel_freqs, round($m1freqs[$i]/count($arr), 2) );
    }

    for ($i = 0; $i < count($m1rel_freqs); $i++) {
        array_push($datapoints, array("y" => $m1rel_freqs[$i], "label" => (string)$m1label[$i]));
    }

    // returning for frequency and relative frequency tables

    // return array($m1label, $m1freqs, $m1rel_freqs);

    echo "<thead class='thead-dark'>
                <tr>
                    <th scope='col text-center'>Labels</th>
                    <th scope='col text-center'>Frequency</th>
                    <th scope='col text-center'>Relative Frequency</th>
                </tr>
            </thead><tbody>";
    for ($i = 0; $i < count($m1label); $i++) {
        echo "<tr>
                    <td class='text-center' style='width: 25%;'>" . $m1label[$i] . "</td>
                    <td class='text-center' style='width: 25%;'>" . $m1freqs[$i] . "</td>
                    <td class='text-center' style='width: 50%;'>" . $m1rel_freqs[$i] . "</td>
                </tr>";
    }
    echo "</tbody>";

    // returning for graph creation

    echo plotBarGraph($datapoints);
    echo plotPieGraph($datapoints);
    echo plotScatterGraph($datapoints);
    // echo json_encode($datapoints, JSON_NUMERIC_CHECK);
}

function findResultOfMethod2($lbl, $val)
{
    global $datapoints;
    $sum = 0;
    for ($i = 0; $i < count($val); $i++) {
        $sum += $val[$i];
    }

    $m2rel_freqs = array();
    for ($i = 0; $i < count($val); $i++) {
        array_push($m2rel_freqs, $val[$i] / $sum);
    }

    for ($i = 0; $i < count($m2rel_freqs); $i++) {
        array_push($datapoints, array("y" => $m2rel_freqs[$i], "label" => (string)$lbl[$i]));
    }

    echo "<thead class='thead-dark'>
            <tr>
                <th scope='col text-center'>Labels</th>
                <th scope='col text-center'>Frequency</th>
                <th scope='col text-center'>Relative Frequency</th>
            </tr>
            </thead><tbody>";
    for ($i = 0; $i < count($lbl); $i++) {
        echo "<tr style='text-align: center;'>
                    <td class='text-center' style='width: 25%;'>" . $lbl[$i] . "</td>
                    <td class='text-center' style='width: 25%;'>" . $val[$i] . "</td>
                    <td class='text-center' style='width: 50%;'>" . $m2rel_freqs[$i] . "</td>
                </tr>";
    }

    echo "</tbody>";

    echo plotBarGraph($datapoints);
    echo plotPieGraph($datapoints);
    echo plotScatterGraph($datapoints);
}

function plotBarGraph($datapoints)
{
?>
    <script>
        var chart = new CanvasJS.Chart("barChart", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Bar Graph"
            },
            axisX: {
                title: "Labels"
            },
            axisY: {
                title: "Relative Frequency",
                minimum: 0,
                maximum: 1
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0.##%",
                dataPoints: <?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    </script>
<?php
}

function plotPieGraph($datapoints)
{
?>
    <script>
        var chart = new CanvasJS.Chart("pieChart", {
            theme: "light2",
            animationEnabled: true,
            title: {
                text: "Pie Graph"
            },
            data: [{
                type: "pie",
                indexLabel: "{y}",
                yValueFormatString: "#,##0.00\"%\"",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "#36454F",
                indexLabelFontSize: 18,
                indexLabelFontWeight: "bolder",
                showInLegend: true,
                legendText: "{label}",
                dataPoints: <?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    </script>
<?php
}

function plotScatterGraph($datapoints)
{
?>
    <script>
        var chart = new CanvasJS.Chart("dotPlot", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1",
            title: {
                text: "Dot Plot"
            },
            axisX: {
                title: "Weight",
                suffix: " kg"
            },
            axisY: {
                title: "Height",
                suffix: " inch"
            },
            data: [{
                type: "scatter",
                markerType: "circle",
                markerSize: 10,
                toolTipContent: "Height: {y} inch<br>Weight: {x} kg",
                dataPoints: <?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    </script>
<?php
}

?>

<!-- <script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("barChart", {
    animationEnabled: true,
    theme: "light2",
    title:{
        text: "Gold Reserves"
    },
    axisY: {
        title: "Gold Reserves (in tonnes)"
    },
    data: [{
        type: "column",
        yValueFormatString: "#,##0.## tonnes",
        dataPoints: 
        <?php // echo json_encode($datapoints, JSON_NUMERIC_CHECK); 
        ?>
    }]
});
chart.render();
 
}
</script> -->