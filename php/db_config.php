<?php

// Create connection

try {
    $conn = mysqli_connect("localhost", "root", "", "statistical_calculators_db");
} catch(Exception $e) {
    die("Erroer in Connectint to database: ". $e->getMessage());
}

?>