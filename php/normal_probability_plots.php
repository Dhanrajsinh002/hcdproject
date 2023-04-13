<?php

session_start();

require './db_config.php';

$datapoints = array();

if (isset($_POST['values'])) {

    $i = 0;

    $val_arr = explode(",", $_POST['values']);
    sort($val_arr);

    $sel = "SELECT * FROM normal_scores_table WHERE `n` = " . count($val_arr);
    $res = $conn->query($sel);

    if ($res->num_rows > 0) {
        echo "<thead class='thead-dark'>
                <tr>
                    <th scope='col text-center'>Label Values</th>
                    <th scope='col text-center'>Normal Score</th>
                </tr>
            </thead><tbody>";
        $row = $res->fetch_assoc();
        foreach ($row as $key => $value) {
            if ($i >= 1 && $i <= count($val_arr)) {
                echo "  <tr>
                            <td class='text-center' style='width: 50%;'>" . $val_arr[$i - 1] . "</td>
                            <td class='text-center' style='width: 50%;'>" . $value . "</td>
                        </tr>";

                array_push($datapoints, array("y" => $value, "x" => (string)$val_arr[$i - 1]));
                // echo $val_arr[$i-1] . " > " . $value . "\n";
                // echo "\n";
            }
            $i++;
        }
    }

    plotScatterGraph($datapoints);
}

function plotScatterGraph($datapoints)
{
?>
    <script>
        var chart = new CanvasJS.Chart("nppScatter", {
            animationEnabled: true,
            theme: "light1",
            title: {
                text: "Scatter Plot"
            },
            axisX: {
                title: "Values",
            },
            axisY: {
                title: "Normal Score",
            },
            data: [{
                type: "scatter",
                markerType: "circle",
                markerSize: 10,
                toolTipContent: "Normal Score: {y} <br>Value: {x} ",
                dataPoints: <?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    </script>
<?php
}

?>