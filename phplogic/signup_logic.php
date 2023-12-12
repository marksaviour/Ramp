<?php
    session_start();
    include("dbcon.php");

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = $_SESSION['conn']->prepare("INSERT INTO users (username, email, password) VALUES (?,?,?)");
    $sql->bind_param("sss", $username, $email, $hashedPassword);

    if ($sql->execute()) {
        $success = "Account Created!";
        header("Location: ../login.php?success=" . urlencode($success));
        exit();
    } else {
        header("Location: ../error.php");
        exit();
    }
