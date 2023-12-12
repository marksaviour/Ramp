<?php
    session_start();
    include("dbcon.php");

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = $_SESSION['conn']->prepare("SELECT * FROM users WHERE email = ?");
    $sql->bind_param("s", $email);

    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['userLoggedIn'] = true;
            $_SESSION['email'] = $email;
            header("Location: ../index.php");
        } else {
            $error_message = "Invalid email or password";
            header("Location: ../login.php?error=" . urlencode($error_message));
        }
    } else {
        $error_message = "Invalid email or password";
        header("Location: ../login.php?error=" . urlencode($error_message));
    }
    exit();
