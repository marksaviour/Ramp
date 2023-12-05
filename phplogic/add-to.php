<?php
    session_start();
    include "dbcon.php";

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    function addItemToCart($_SESSION['conn'], $id) {
        // Query the database to get item details
        $stmt = $_SESSION['conn']->prepare("SELECT * FROM games WHERE id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch();

        if ($item) {
            if (isset($_SESSION['cart'][$itemId])) {
                $error_message = "Item is already in cart";
                header("Location: ../login.php?error=" . urlencode($error_message));
            } else {
                $_SESSION['cart'][$itemId] = array(
                    'name' => $item['name'],
                    'price' => $item['price'],
                );
                $success_message = "Item has been added to cart";
                header("Location: ../login.php?error=" . urlencode($success_message));
            }
        } else {
            echo "Item not found!"; //Keep in meantime to check if code is working
        }
    }

    // Example usage
    addItemToCart($_SESSION['conn'], 1, 2); // Adds 2 quantities of item with ID 1