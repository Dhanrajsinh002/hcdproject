<?php

session_start();

$Q1 = 0;
$Q2 = 0;
$Q3 = 0;
$IQR = 0;
$min_len = 0;
$max_len = 0;
$datapoints = array();

if(isset($_POST["fns_val"])) {
    $arr = explode(",",$_POST["fns_val"]);
    sort($arr);

    $Q2 = findMedian($arr);
    $quartiles = findQuartiles($arr);
    $IQR = $Q3 - $Q1;
    $min_len = $Q1 - 1.5 * $IQR;    
    $max_len = $Q3 + 1.5 * $IQR;
    
    $outliers = findOutliers($arr);
    
    // print_r($arr);
    // echo $arr[count($arr)-1];

    // echo "Q1-".$Q1;
    // echo "\nQ2-".$Q2;
    // echo "\nQ3-".$Q3;
    // echo "\nIQR".$IQR;
    // echo "\nMin Lim-".$min_len;
    // echo "\nMax Lim-".$max_len;
    // print_r($outliers);

    echo "  <tr>
                <th>First Quartile (Q1)</th>
                <th>Second Quartile (Q2)</th>
                <th>Third Quartile (Q3)</th>
                <th>Inter Quartile Range</th>
                <th>Lower Limit</th>
                <th>Upper Limit</th>
                <th>Outliers</th>
            </tr>
            
            <tr>
                <td style='width: 14.28%;'>".$Q1."</td>
                <td style='width: 14.28%;'>".$Q2."</td>
                <td style='width: 14.28%;'>".$Q3."</td>
                <td style='width: 14.28%;'>".$IQR."</td>
                <td style='width: 14.28%;'>".$min_len."</td>
                <td style='width: 14.28%;'>".$max_len."</td><td>";
            for($i = 0; $i < count($outliers); $i++) {
                echo $outliers[$i]." ";
            }
        echo "</td></tr>";

    array_push($datapoints, array("label" => "Boxplot", "y" => array(5,15,16,20,21,25,26,27,30,30,31,32,32,34,35,38,38,41,43,66)));
    // print_r($datapoints);
    // exit(0);
    // $dataPoints = array(
	// array("label" => "Oven", "y" => array(4, 6, 8, 9, 7)),
	// array("label" => "Microwawe", "y" => array(5, 6, 7, 8, 6.5)),
	// array("label" => "PC & Peripherals", "y" => array(6, 8, 10, 11, 9.5)),
	// array("label" => "Air Conditioner", "y" => array(8, 9, 13, 14, 10.5)),
	// array("label" => "Dishwasher", "y" => array(5, 7, 9, 12, 7.5)),
	// array("label" => "Electric Kettle", "y" => array(4, 6, 8, 9, 7)),
	// array("label" => "Fridge", "y" => array(8, 9, 12, 13, 11))
    // );
    return boxPlots($datapoints);
}

function findMedian($arr) {
    $len = count($arr);
    if($len % 2 == 0) {
        return (($arr[ (int) ((count($arr) - 1) / 2) ] + $arr[ (int) (count($arr) / 2) ] ) / 2);
    } else {
        return ($arr[ (int) ($len / 2) ]);
    }
}

function findQuartiles($arr) {
    global $Q1,$Q3;

    $bot_arr = array(); // Q1
    $top_arr = array(); // Q3
    $last_iter = 0;

    if(count($arr) %2 != 0) {
        $last_iter -= 1;
    }

    // for bottom median array Q1
    for($i = 0; $i < count($arr)/2; $i++) {
        array_push($bot_arr, $arr[$i]);
        $last_iter++;
    }
    // echo "Bot arr-".print_r($bot_arr);
    $Q1 = findMedian($bot_arr);
    
    // print_r($bot_arr);
    
    // for top median array Q3
    for($i = $last_iter; $i < count($arr); $i++) {
        array_push($top_arr, $arr[$i]);
    }
    
    // echo "top arr-".print_r($top_arr);
    $Q3 = findMedian($top_arr);

    // print_r($top_arr);
}

function findOutliers($arr) {
    global $min_len,$max_len;

    $outliers = array();

    for($i = 0; $i < count($arr); $i++) {
        if($arr[$i] < $min_len) {
            array_push($outliers, $arr[$i]);
        } else {
            break;
        }
    }

    for($j = count($arr)-1; $j > -1; $j--) {
        if($arr[$j] > $max_len) {
            array_push($outliers, $arr[$j]);
        } else {
            break;
        }
    }

    return $outliers;
}

function boxPlots($datapoints) {
    ?>
    <script>
        var chart = new CanvasJS.Chart("boxPlot", {
            animationEnabled: true,
        	theme: "light2",
        	title: {
        		text: "Boxplot",
        		fontColor: "#3C4D2D"
        	},
        	axisY: {
        		title: "Y"
        	},
        	data: [{
        		type: "boxAndWhisker",
        		color: "#3C4D2D",
        		upperBoxColor: "#AEF35A",
        		lowerBoxColor: "#B8B2FB",
        		yValueFormatString: "#,##0",
        		dataPoints: <?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>
        	}]
        });
        chart.render();
    </script>
    <?php
}
?>