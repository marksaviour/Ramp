<?php
    session_start();
    include("dbcon.php");

    $password = $_POST['password'];
    $reset_token = $_POST['reset_token'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = $_SESSION['conn']->prepare("UPDATE users SET password = ? WHERE reset_token = ?");
    $sql->bind_param("ss", $hashedPassword, $reset_token);

    if ($sql->execute()) {
        if ($sql->affected_rows > 0) {
            $success = "Password Updated";
            header("Location: ../login.php?success=" . urlencode($success));
            exit();
        } else {
            header("Location: ../error.php?error=" . urlencode("Invalid or expired reset token."));
            exit();
        }
    } else {
        header("Location: ../error.php");
        exit();
    }