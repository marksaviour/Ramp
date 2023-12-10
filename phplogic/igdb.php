<?php
    session_start();
    include('../phplogic/dbcon.php');

    $clientId = 'p28s8c005mhip2mq7e97o4fngl8075';
    $authToken = 'Bearer k9jnsr4idy5c45j61zc8h3gc1ulawr';

    // Get data from the API
    $api_url = "https://api.igdb.com/v4/games/";
    $json_data = file_get_contents($api_url);
    $array = json_decode($json_data, true);

    if (!empty($array) && is_array($array)) {
        // Extract data from the API response
        $name = $array[0]['name'];
        $id = $array[0]['id'];
        $platforms = implode(", ", $array[0]['platforms']);
        $summary = $array[0]['summary'];
        $release_dates = implode(", ", $array[0]['release_dates']);
        $url = $array[0]['url'];
    }