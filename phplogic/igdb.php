<?php
    session_start();
    include ('../phplogic/dbcon.php');

    $api_url = "https://api.igdb.com/v4/games/";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Client-ID: p28s8c005mhip2mq7e97o4fngl8075',
        'Authorization: Bearer k9jnsr4idy5c45j61zc8h3gc1ulawr'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $json_data = curl_exec($ch);
    curl_close($ch);

    $array = json_decode($json_data, true);

    if (!empty($array) && is_array($array)) {
        // Prepare SQL statement
        $stmt = $_SESSION['conn']->prepare("INSERT INTO games (name, id, artwork, release_date, platforms, summary) VALUES (?, ?, ?, ?, ?, ?)");

        foreach ($array as $game) {
            // Bind parameters and execute statement for each game
            $stmt->execute([
                $game['name'],
                $game['id'],
                json_encode($game['artworks']),
                $game['release_date'],
                implode(", ", $game['platforms']),
                $game['summary'],
            ]);
        }
    } else {
        echo "Error retrieving data from the API.";
    }