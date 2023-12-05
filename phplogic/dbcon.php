<?php
    session_start();

    // Login Info
    $db_host = 'localhost';
    $db_user = 'RampUser';
    $db_pass = 'EQryHEspXZXj7E(D';
    $db_name = 'Ramp';

    // Connection Script
    $_SESSION["conn"] = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    // Connection Test
    if (!$_SESSION["conn"]){
        header("Location: ../error.php");
        exit();
    }