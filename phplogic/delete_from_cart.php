<?php
    session_start();
    include "../phplogic/dbcon.php";

    $game_id = $_POST['game_id'];
    $email = $_SESSION['email'];

    $sql = $_SESSION['conn']->prepare("DELETE FROM cart WHERE game_id = ? AND email = ?");
    $sql->bind_param("ss", $game_id, $email);

    if ($sql->execute()) {
        header("Location: ../Ramp/cart.php");
    } else {
        // Handle error, maybe redirect to an error page
        header("Location: ../Ramp/error.php");
    }
    exit();
