<?php
    session_start();
    include("dbcon.php");

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = $_SESSION['conn']->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $sql->bind_param("ss", $email, $password);

    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['userLoggedIn'] = true;
        $_SESSION['userEmail'] = $email;
        header("Location: ../index.php");
        exit();
    } else {
        $error_message = "Invalid email or password";
        header("Location: ../login.php?error=" . urlencode($error_message));
        exit();
    }
