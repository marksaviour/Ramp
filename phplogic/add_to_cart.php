<?php
    session_start();
    include "dbcon.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $gameId = $_POST['game_id'];
        $email = $_SESSION['email'];

        $checkQuery = "SELECT COUNT(*) FROM cart WHERE email = ? AND game_id = ?";
        $checkStmt = $_SESSION['conn']->prepare($checkQuery);
        $checkStmt->bind_param("si", $email, $gameId);
        $checkStmt->execute();

        $result = $checkStmt->get_result();
        $count = $result->fetch_row()[0];
        $checkStmt->close();

        if ($count > 0) {
            $error_message = "Item is already in cart";
            header("Location: ../cart.php?error=" . urlencode($error_message));
            exit();
        } else {
            $query = "INSERT INTO cart (email, game_id) VALUES (?, ?)";

            $stmt = $_SESSION['conn']->prepare($query);
            $stmt->bind_param("si", $email, $gameId);
            $stmt->execute();
            $stmt->close();

            $success_message = "Item has been successfully added to the cart";
            header("Location: ../cart.php?success=" . urlencode($success_message));
            exit();
        }
    }