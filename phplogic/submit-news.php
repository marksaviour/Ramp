<?php
    session_start();
    include("dbcon.php");

    if (isset($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST["email"];

        $sql = $_SESSION['conn']->prepare("INSERT INTO newsletter (email_address) VALUES (?)");

        $sql->bind_param('s', $email);

        if ($sql->execute()) {
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../error.php");
            exit();
        }
    }