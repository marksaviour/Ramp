<?php
 session_start();
 require ("dbcon.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $_SESSION['conn']->query($query);

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $updateQuery = "UPDATE users SET reset_token = '$token', token_expiry = '$expires_at' WHERE email = '$email'";
        $_SESSION['conn']->query($updateQuery);

        $resetLink = "http://localhost:8888/Shop/passchange.php?token=$token";
        $subject = "Password Reset";
        $body = "Please click on the following link to reset your password: $resetLink";
        mail($email, $subject, $body);

        $success = "Email Sent! Please check your inbox";
        header("Location: ../login.php?success=" . urlencode($success));
        exit();
    } else {
        $error = "The email you submitted does not have an account";
        header("Location: ../forgot.php?error=" . urlencode($error));
        exit();
    }
} else {
    header("Location: ../error.php");
    exit();
}