<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>RAMP - Coming Soon</title>
        <link rel="icon" type="image/x-icon" href="../Ramp/assets/images/logo/logo.svg"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/65953c8738.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../Ramp/css/style.css">
    </head>

    <body>
        <!--Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <!--Navbar Name-->
                <a class="navbar-brand" href="index.php">RAMP</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

                <!--Navbar Links List-->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Platforms</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="pc.php">PC</a></li>
                                <li><a class="dropdown-item" href="xbox.php">XBOX</a></li>
                                <li><a class="dropdown-item" href="nintendo.php">Nintendo</a></li>
                                <li><a class="dropdown-item" href="playstation.php">Playstation</a></li>
                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="#">Coming Soon</a></li>
                    </ul>

                    <div class="d-flex">
                        <?php
                            session_start();
                            if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
                                echo '<a href="../Ramp/phplogic/logout_logic.php" class="btn btn-outline-dark"><i class="fa-solid fa-user"></i> Logout</a>';
                            } else {
                                echo '<a href="login.php" class="btn btn-outline-dark"><i class="fa-solid fa-user"></i> Login</a>';
                            }
                        ?>
                    </div>

                    <div class="d-flex">
                        <?php
                            session_start();
                            if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
                                echo '<a href="cart.php" class="btn btn-outline-dark"><i class="fa-solid fa-cart-shopping"></i> Cart</a>';
                            } else {
                                echo '<a href="login.php" class="btn btn-outline-dark"><i class="fa-solid fa-cart-shopping"></i> Cart</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </nav>

        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">Coming Soon</h1>
                    <p class="lead mb-0">See what games are coming out in the next 7 days!</p>
                </div>
            </div>
        </header>


        <!-- Page content-->
        <div class="container">
            <div class='row'>
            <?php
                // Declare Variables for time
                $currentTime = time();
                $weekTime = strtotime("+7 days", $currentTime);

                // Declare API Key Variables
                $clientId = 'p28s8c005mhip2mq7e97o4fngl8075';
                $authToken = 'Bearer k9jnsr4idy5c45j61zc8h3gc1ulawr';

                //Start API Link
                function makeIGDBRequest($url, $postFields) {
                    global $clientId, $authToken;
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => [
                            "Client-ID: {$clientId}",
                            "Authorization: {$authToken}",
                            "Content-Type: application/json"
                        ],
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => $postFields,
                    ]);

                    $response = curl_exec($curl);
                    if(curl_errno($curl)){
                        echo 'Request Error:' . curl_error($curl);
                    }
                    curl_close($curl);
                    return json_decode($response, true);
                }

                // Fetch Release Dates
                $gamesReleaseDates = makeIGDBRequest("https://api.igdb.com/v4/release_dates/",
                                                     "fields game, date; where date > {$currentTime} & date < {$weekTime}; sort date asc; limit 500;");

                // Extract game IDs from the first response
                $gameIds = array_column($gamesReleaseDates, 'game');

                // Fetch Game Details
                $gameDetailsQuery = "fields name, cover.url, summary, involved_companies.company.name; where id = (" . implode(',', $gameIds) . "); limit 500; sort date asc;";
                $gamesDetails = makeIGDBRequest("https://api.igdb.com/v4/games/", $gameDetailsQuery);

                //Combine the Data
                $combinedData = [];

                // Array to keep track of outputted games
                $processedGames = [];

                foreach ($gamesDetails as $detail) {
                    // Check if the game has already been outputted
                    if (isset($processedGames[$detail['id']])) {
                        continue;
                    }

                    foreach ($gamesReleaseDates as $releaseDate) {
                        if ($releaseDate['game'] == $detail['id']) {
                            // Check if the game has a cover, developer, and summary
                            if (!empty($detail['cover']['url']) && !empty($detail['involved_companies'][0]['company']['name']) && !empty($detail['summary'])) {
                                $combinedData[] = array_merge($detail, ['release_date' => $releaseDate['date']]);
                                $processedGames[$detail['id']] = true;
                                break;
                            }
                        }
                    }
                }

                foreach ($gamesReleaseDates as $releaseDate) {
                    if ($releaseDate['game'] == $detail['id']) {
                        $combinedData[] = array_merge($detail, ['release_date' => $releaseDate['date']]);
                        $processedGames[$detail['id']] = true;
                        break;
                    }
                }

                // Function to compare release dates
                function compareReleaseDates($a, $b) {
                    return $a['release_date'] - $b['release_date'];
                }

                // Sort the combined data by release date
                usort($combinedData, 'compareReleaseDates');

                // Display the combined data
                foreach ($combinedData as $game) {
                    $releaseDate = date("Y-m-d", $game['release_date']);
                    $name = $game['name'];
                    $imageUrl = $game['cover']['url'];
                    $altText = "Cover image for {$name}";
                    $developer = $game['involved_companies'][0]['company']['name'];
                    $summary = $game['summary'];

                    echo "<div class='col-lg-6'>
                                <div class='card mb-4'>
                                    <a href='#'><img class='card-img-top' src='{$imageUrl}' alt='{$altText}' /></a>
                                    <div class='card-body'>
                                        <div class='small text-muted'>Release Date: {$releaseDate}</div>
                                        <h2 class='card-title'>{$name}</h2>
                                        <div class='small card-title'>Developer: {$developer}</div>
                                        <p class='card-text'>{$summary}</p>
                                    </div>
                                </div>
                          </div>";
                }
            ?>
            </div>
        </div>

        <!-- Footer-->
        <footer class="text-center text-lg-start bg-dark text-white">
            <div class="container p-4 pb-0">
                <section class="">
                    <form method="POST" action="phplogic/submit_news.php" >
                        <div class="row d-flex justify-content-center">
                            <div class="col-auto">
                                <p class="pt-2"><strong>Sign up for our newsletter:</strong></p>
                            </div>

                            <div class="col-md-5 col-12">
                                <div class="form-outline mb-4">
                                    <input class="form-control" type="email" id="email" name="email" placeholder="Email Address">
                                    <label for="email"></label>
                                </div>
                            </div>

                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-4">Subscribe</button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>

            <section>
                <div class="container text-center text-md-start mt-5">
                    <div class="row mt-3">
                        <!--Useful Links-->
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">Useful links</h6>
                            <p><a href="index.php" class="text-reset">Home</a></p>
                            <?php
                            session_start();
                            if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
                                echo '<p><a href="cart.php" class="text-reset">Cart</a></p>';
                                echo '<p><a href="../Ramp/phplogic/logout_logic.php" class="text-reset">Logout</a></p>';
                            } else {
                                echo '<p><a href="login.php" class="text-reset">Cart</a></p>';
                                echo '<p><a href="login.php" class="text-reset">Login</a></p>';
                            }
                            ?>
                            <p><a href="comingsoon.php" class="text-reset">Coming Soon</a></p>
                        </div>

                        <!--Where to find Us-->
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-4">
                            <h6 class="text-uppercase fw-bold mb-4"><i class="fas fa-location-dot me-3 text-secondary"></i>Where to Find us</h6>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d807.7135626720799!2d14.47561211078151!3d35.92606739828898!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x130e456163c656b5%3A0xabf0a9cf8e5d6724!2s42-40%20Triq%20Giorgio%20Mitrovich%2C%20Pembroke!5e0!3m2!1sen!2smt!4v1699348545531!5m2!1sen!2smt" width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <!--Contact-->
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                            <p><i class="fas fa-home me-3 text-secondary"></i>40 Triq Giorgio Mitrovich, Pembroke</p>
                            <p><i class="fas fa-envelope me-3 text-secondary"></i>info@ramp.com</p>
                            <p><i class="fas fa-phone me-3 text-secondary"></i>+ 356 1122334455</p>
                            <p><i class="fab fa-facebook-f me-3 text-secondary"></i>Facebook</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="p-4">
                <p class="blockquote-footer">&copy;2023 Copyright: RAMP</p>
            </div>
        </footer>


        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>