<?php
    session_start();
    include("dbcon.php");

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

//    Keep un-hashed till you solve issue with login not reading the hash
//    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, password, username) VALUES ('$email' , '$password' , '$username')";

    if (mysqli_query($_SESSION['conn'], $sql)) {
        $success = "Account Created!";
        header("Location: ../login.php?success=" . urlencode($success));
        exit();
    } else {
        header("Location: ../error.php");
        exit();
    }