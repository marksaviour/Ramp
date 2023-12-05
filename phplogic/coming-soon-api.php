<?php
//
//$curl = curl_init();
//
//curl_setopt_array($curl, [
//    CURLOPT_URL => "https://video-game-calendar-release.p.rapidapi.com/?limit=10&skip=0",
//    CURLOPT_RETURNTRANSFER => true,
//    CURLOPT_ENCODING => "",
//    CURLOPT_MAXREDIRS => 10,
//    CURLOPT_TIMEOUT => 30,
//    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//    CURLOPT_CUSTOMREQUEST => "GET",
//    CURLOPT_HTTPHEADER => [
//        "X-RapidAPI-Host: video-game-calendar-release.p.rapidapi.com",
//        "X-RapidAPI-Key: be362aa391mshdfbb3211098ae75p17a474jsnc3e3e6e2ce43"
//        ],
//    ]);
//
//$response = curl_exec($curl);
//$err = curl_error($curl);
//
//curl_close($curl);
//
//if ($err) {
//    echo "cURL Error #:" . $err;
//} else {
//    echo $response;
//}
//?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>IGDB API Integration</title>
    </head>

    <body>
        <h1>Game Information</h1>
        <div id="game-info"></div>
        <script src="../js/db.js"></script>
    </body>
</html>