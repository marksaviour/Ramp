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

                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!--Cart-->
        <section class="h-100 h-custom">
            <div class="container h-100 py-5">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col" class="h5">Shopping Bag</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Price</th>
                                    <th scope="col"><i class="fa-solid fa-xmark"></i></th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                session_start();
                                include "../Ramp/phplogic/dbcon.php";

                                if (!isset($_SESSION['email'])) {
                                    header("Location: ../Ramp/login.php");
                                    exit();
                                }

                                $sql = $_SESSION['conn']->prepare("SELECT game_id FROM cart WHERE email = ?");
                                $sql->bind_param("s", $_SESSION["email"]);
                                $sql->execute();
                                $result = $sql->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $game_id = $row['game_id'];

                                        // Start API Connection
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
                                            CURLOPT_POSTFIELDS => 'fields name,cover.url; where id = '.$game_id.';',
                                        ]);

                                        $response = curl_exec($curl);

                                        if ($response === false) {
                                            echo 'Request Error:' . curl_error($curl);
                                        } else {
                                            $games = json_decode($response, true);

                                            if (json_last_error() === JSON_ERROR_NONE) {
                                                foreach ($games as $game) {
                                                    $id = $game['id'];
                                                    $name = $game['name'];
                                                    $imageUrl = $game['cover']['url'];
                                                    $altText = "Cover image for {$name}";
                                                    $developer = $game['involved_companies'][0]['company']['name'];
                                                    $platform = $game['platforms'][0]['name'];


                                                    echo "<tr data-game-id='{$id}'>
                                                            <th scope='row'>
                                                                <div class='d-flex align-items-center'>
                                                                    <img src='{$imageUrl}' class='img-fluid rounded-3 cart-img' alt='{$altText}'>
                                                                    <div class='flex-column ms-4'>
                                                                        <p class='mb-2'>{$name}</p>
                                                                        <p class='mb-0'>{$developer}</p>
                                                                    </div>
                                                                </div>
                                                            </th>
                        
                                                            <td class='align-middle'>
                                                                <p class='mb-0'>{$platform}</p>
                                                            </td>
                        
                                                            <td class='align-middle'>
                                                                <p class='mb-0'>€15.00</p>
                                                            </td>
                        
                                                            <td class='align-middle'>
                                                                <form action='../Ramp/phplogic/delete_from_cart.php' method='post'>
                                                                    <input type='hidden' name='game_id' value='{$game_id}'>
                                                                    <button type='submit' class='btn btn-danger'>
                                                                        <i class='fa-solid fa-xmark'></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                          </tr>";
                                                }
                                            } else {
                                                echo "JSON Decode Error: " . json_last_error_msg();
                                            }
                                        }
                                    }
                                } else {
                                    header("Location: ../error.php");
                                    exit();
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="card shadow-2-strong mb-5 mb-lg-0" style="border-radius: 16px;">
                            <div class="card-body p-4">

                                <div class="row">
                                    <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mb-md-0">
                                        <form>
                                            <div class="d-flex flex-row pb-3">
                                                <div class="d-flex align-items-center pe-2">
                                                    <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel1v"
                                                           value="" aria-label="..." checked />
                                                </div>
                                                <div class="rounded border w-100 p-3">
                                                    <p class="d-flex align-items-center mb-0">
                                                        <i class="fab fa-cc-mastercard fa-2x text-dark pe-2"></i>Credit
                                                        Card
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row pb-3">
                                                <div class="d-flex align-items-center pe-2">
                                                    <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel2v"
                                                           value="" aria-label="..." />
                                                </div>
                                                <div class="rounded border w-100 p-3">
                                                    <p class="d-flex align-items-center mb-0">
                                                        <i class="fab fa-cc-visa fa-2x fa-lg text-dark pe-2"></i>Debit Card
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row">
                                                <div class="d-flex align-items-center pe-2">
                                                    <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel3v"
                                                           value="" aria-label="..." />
                                                </div>
                                                <div class="rounded border w-100 p-3">
                                                    <p class="d-flex align-items-center mb-0">
                                                        <i class="fab fa-cc-paypal fa-2x fa-lg text-dark pe-2"></i>PayPal
                                                    </p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-6">
                                        <div class="row">
                                            <div class="col-12 col-xl-6">
                                                <div class="form-outline mb-4 mb-xl-5">
                                                    <input type="text" id="typeName" class="form-control form-control-lg" size="17"
                                                           placeholder="John Smith" />
                                                    <label class="form-label" for="typeName">Name on card</label>
                                                </div>

                                                <div class="form-outline mb-4 mb-xl-5">
                                                    <input type="text" class="form-control form-control-lg" placeholder="MM/YY" size="7" id="exp" minlength="7" maxlength="7" />
                                                    <label class="form-label" for="typeExp">Expiration</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-xl-6">
                                                <div class="form-outline mb-4 mb-xl-5">
                                                    <input type="text" id="typeText" class="form-control form-control-lg" size="17" placeholder="1111 2222 3333 4444" minlength="19" maxlength="19" />
                                                    <label class="form-label" for="typeText">Card Number</label>
                                                </div>

                                                <div class="form-outline mb-4 mb-xl-5">
                                                    <input type="password" id="typeText" class="form-control form-control-lg" placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3" maxlength="3" />
                                                    <label class="form-label" for="typeText">Cvv</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-3">
                                        <div class="d-flex justify-content-between" style="font-weight: 500;">
                                            <p class="mb-2">Subtotal</p>
                                            <p class="mb-2">$23.49</p>
                                        </div>

                                        <div class="d-flex justify-content-between" style="font-weight: 500;">
                                            <p class="mb-0">Shipping</p>
                                            <p class="mb-0">$2.99</p>
                                        </div>

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                                            <p class="mb-2">Total (tax included)</p>
                                            <p class="mb-2">$26.48</p>
                                        </div>

                                        <button type="button" class="btn btn-primary btn-block btn-lg">
                                            <div class="d-flex justify-content-between">
                                                <span>Checkout</span>
                                                <span>$26.48</span>
                                            </div>
                                        </button>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
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
