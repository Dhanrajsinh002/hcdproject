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

    $Q1 = findQ1($arr);
    $Q2 = findQ2($arr);
    $Q3 = findQ3($arr);
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

    array_push($datapoints, array("label" => "Boxplot", "y" => array( min($arr), $Q1, $Q3, max($arr), $Q2 )));

    return boxPlots($datapoints);
}

function findQ1($arr) {
    // Find the first quartile (Q1)
    $count = count($arr);
    $middle = floor(($count - 1) / 2);
    $lower_half = array_slice($arr, 0, $middle + 1);
    $count_lower_half = count($lower_half);
    $middle_lower_half = floor(($count_lower_half - 1) / 2);
    if ($count_lower_half % 2 == 0) {
        return ($lower_half[$middle_lower_half] + $lower_half[$middle_lower_half + 1]) / 2;
    } else {
        return $lower_half[$middle_lower_half];
    }
}

function findQ2($arr) {
    $count = count($arr);
    $middle = floor(($count - 1) / 2);
    if ($count % 2 == 0) {
        return ($arr[$middle] + $arr[$middle + 1]) / 2;
    } else {
        return $arr[$middle];
    }
}

function findQ3($arr) {
    $count = count($arr);
    $middle = floor(($count - 1) / 2);
    $upper_half = array_slice($arr, $middle + 1);
    $count_upper_half = count($upper_half);
    $middle_upper_half = floor(($count_upper_half - 1) / 2);
    if ($count_upper_half % 2 == 0) {
        return ($upper_half[$middle_upper_half] + $upper_half[$middle_upper_half + 1]) / 2;
    } else {
        return $upper_half[$middle_upper_half];
    }
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
        		title: "Y",
                interval: 5
        	},
        	data: [{
        		type: "boxAndWhisker",
        		color: "#3C4D2D",
        		upperBoxColor: "#AEF35A",
        		lowerBoxColor: "#B8B2FB",
        		yValueFormatString: "#.#####",
        		dataPoints: <?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>
        	}]
        });
        chart.render();
    </script>
    <?php
}
?>