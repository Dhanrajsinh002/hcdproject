<?php

session_start();

$dataPoints = array();

if( isset($_POST['Intercept']) && isset($_POST['Slop']) ) {
    
    // array_push($dataPoints, [$_POST['Intercept'], 0]);

    if($_POST['Slop'] > 0) {
        for($i = 0; $i <= 10; $i++) {
            // array_push($dataPoints, [ strval ($_POST['Intercept'] + ($_POST['Slop'] * $i) ), $i]);
            // $dataPoints[$_POST['Intercept'] + $_POST['Slop']] = $i;
            array_push($dataPoints, array("y" => $_POST['Intercept'] + ($_POST['Slop'] * $i), "label" => $i) );
        }
    } else if($_POST['Slop'] < 0) {
        for($i = 0; $i <= 10; $i++) {
            // array_push($dataPoints, [ strval ($_POST['Intercept'] - ($_POST['Slop'] * $i) ), $i]);
            // $dataPoints[$_POST['Intercept'] - abs($_POST['Slop'])] = $i;
            array_push($dataPoints, array("y" => $_POST['Intercept'] + ($_POST['Slop'] * $i), "label" => $i) );
        }
    } else {
        for($i = 0; $i <= 10; $i++) {
            // array_push($dataPoints, [ strval ($_POST['Intercept'] + $_POST['Slop'], $i) ]);
            // $dataPoints[$_POST['Intercept']] = $i;
            array_push($dataPoints, array("y" => $_POST['Intercept'] + $_POST['Slop'], "label" => $i) );
        }
    }

    // print_r($dataPoints);

    // $DataPoints = array();
    // array_push($DataPoints, array('Y','X'));
    // for($i = 0; $i < count($dataPoints); $i += 2) {
    //     // array_push($DataPoints, array((String) $small_x[$i], $prob_arr[$i]));
    //     array_push($DataPoints, array($dataPoints[$i], $dataPoints[$i+1]));
    // }

    // print_r($dataPoints);

    showGraph($dataPoints);
}

function showGraph($DataPoints) {
    ?>
    <script>
        var chart = new CanvasJS.Chart("lineChart", {
            	title: {
            		text: "Push-ups Over a Week"
            	},
                toolTip:{   
			        content: "x = {x}: y = {y}"      
		        },
                axisX: {
                    interval: 1,
                    minimum: 0,
                },
            	axisY: {
                    title: "Number of Push-ups",
            	},
            	data: [{
            		type: "line",
                    showInLegend: true,
            		dataPoints: <?php echo json_encode($DataPoints, JSON_NUMERIC_CHECK); ?>
            	}]
            });
            chart.render();



        // google.charts.load('current', {'packages':['corechart']});
        // google.charts.setOnLoadCallback(drawChart);
        // function drawChart() {
        //     var data = google.visualization.arrayToDataTable(<?php echo json_encode($DataPoints); ?>);
        //     var options = {
        //         title: 'Company Performance',
        //         curveType: 'function',
        //         legend: { position: 'bottom' }
        //     };
        //     var chart = new google.visualization.LineChart(document.getElementById('lineChart'));
        //     chart.draw(data, options);
        // }
    </script>
    <?php
}

?>