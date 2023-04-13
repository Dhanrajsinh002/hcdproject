<?php

session_start();

if( isset($_POST['SD']) && isset($_POST['N']) ) {
    
    $sam_sd = $_POST['SD'] / sqrt($_POST['N']);


}

?>