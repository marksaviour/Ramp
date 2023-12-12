<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>RAMP - Game Rentals</title>
        <link rel="icon" type="image/x-icon" href="../Ramp/assets/images/logo/logo.svg"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
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
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Platforms</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="pc.php">PC</a></li>
                                <li><a class="dropdown-item" href="xbox.php">XBOX</a></li>
                                <li><a class="dropdown-item" href="nintendo.php">Nintendo</a></li>
                                <li><a class="dropdown-item" href="playstation.php">Playstation</a></li>
                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="comingsoon.php">Coming Soon</a></li>
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

        <!--Carousel-->
        <header>
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../Ramp/assets/images/carousel-1.png" alt="Slider image with logo RAMP">
                    </div>
                    <div class="carousel-item">
                        <img src="../Ramp/assets/images/carousel-2.png" alt="Slider image stating that all games are priced at €15/hr">
                    </div>
                    <div class="carousel-item">
                        <img src="../Ramp/assets/images/carousel-3.png" alt="Slider image stating Dont want to buy? Just rent!">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </header>


        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <h2>- Best Rated</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                        $clientId = 'p28s8c005mhip2mq7e97o4fngl8075';
                        $authToken = 'Bearer k9jnsr4idy5c45j61zc8h3gc1ulawr';

                        $curl = curl_init();

                        curl_setopt_array($curl, [
                            CURLOPT_URL => "https://api.igdb.com/v4/games/",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_HTTPHEADER => [
                                "Client-ID: {$clientId}",
                                "Authorization: {$authToken}",
                                "Content-Type: application/json"
                            ],
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => 'fields name,cover.url; limit 8; sort rating desc;',
                        ]);

                        $response = curl_exec($curl);

                        if(curl_errno($curl)){
                            echo 'Request Error:' . curl_error($curl);
                        } else {
                            $games = json_decode($response, true);
                            foreach ($games as $game) {
                                $id = $game['id'];
                                $name = $game['name'];
                                $imageUrl = $game['cover']['url'];
                                $altText = "Cover image for {$name}";

                                echo "<div class='col mb-5'>
                                            <div class='card h-100'>
                                                <img class='card-img-top' src='{$imageUrl}' alt='{$altText}'/>
                                                <div class='card-body p-4'>
                                                    <div class='text-center'>
                                                        <h5 class='fw-bolder'>{$name}</h5>
                                                    </div>
                                                </div>
                                                
                                                <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                                                    <div class='text-center'>";

                                if (!isset($_SESSION['userLoggedIn']) || $_SESSION['userLoggedIn'] != true) {
                                    echo "<a href='../Ramp/login.php' class='btn btn-outline-dark'><i class='fa-solid fa-user'></i> Add to Cart</a>";
                                } else {
                                    echo "<form action='../Ramp/phplogic/addToCart.php' method='post'>
                                                                <input type='hidden' name='game_id' value='{$id}'/>
                                                                <button type='submit' class='btn btn-outline-dark mt-auto'>Add to cart</button>
                                                              </form>";
                                }

                                echo "            </div>
                                                </div>
                                            </div>
                                          </div>";
                            }
                        }
                        curl_close($curl);
                    ?>
                </div>
            </div>
        </section>


        <!-- Footer-->
        <footer class="text-center text-lg-start bg-dark text-white">
            <div class="container p-4 pb-0">
                <section class="">
                    <form method="POST" action="../Ramp/phplogic/submit-news.php" >
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