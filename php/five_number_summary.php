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

    echo "  <thead>
                <tr>
                    <th scope='col text-center'>First Quartile (Q1)</th>
                    <th scope='col text-center'>Second Quartile (Q2)</th>
                    <th scope='col text-center'>Third Quartile (Q3)</th>
                    <th scope='col text-center'>Inter Quartile Range</th>
                    <th scope='col text-center'>Lower Limit</th>
                    <th scope='col text-center'>Upper Limit</th>
                    <th scope='col text-center'>Outliers</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td class='text-center' >".$Q1."</td>
                    <td class='text-center' >".$Q2."</td>
                    <td class='text-center' >".$Q3."</td>
                    <td class='text-center' >".$IQR."</td>
                    <td class='text-center' >".$min_len."</td>
                    <td class='text-center' >".$max_len."</td><td>";
                    if(count($outliers) == 0) {
                        echo "-";
                    } else {
                        for($i = 0; $i < count($outliers); $i++) {
                            echo $outliers[$i]." ";
                        }
                    }
    echo "          </td>
                </tr>
            </tbody>";

    array_push($datapoints, array("label" => "Boxplot", "y" => array( min($arr), $Q1, $Q2, $Q3, max($arr) )));

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