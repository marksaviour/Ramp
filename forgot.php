<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RAMP - Login</title>
    <link rel="icon" type="image/x-icon" href="../Ramp/assets/images/logo/logo.svg"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/65953c8738.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

    <body>
        <div>
            <div class="container-fluid ps-md-0">
                <div class="row g-0">
                    <div class="d-none d-md-flex col-md-4 col-lg-6">
                        <img src="../Ramp/assets/images/login-img.png" alt="Descriptive Alt Text" class="img-fluid w-100">
                    </div>
                    <div class="col-md-8 col-lg-6">
                        <div class="login d-flex align-items-center py-5">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-9 col-lg-8 mx-auto">
                                        <h3 class="login-heading mb-4">Forgot Your Password?</h3>
                                        <!-- Sign In Form -->
                                        <form method="POST" action="../Ramp/phplogic/forgot_logic.php" >
                                            <?php if(isset($_GET['error'])) { ?>
                                                <div class="alert alert-danger" role="alert"> <?php echo htmlspecialchars($_GET['error']); ?></div>
                                            <?php } ?>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" type="email" id="email" name="email" placeholder="name@example.com">
                                                <label for="email">Email address</label>
                                            </div>
                                            <div class="d-grid">
                                                <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Send email!</button>
                                                <div class="text-center">
                                                    <a class="small" href="login.php">Login</a>
                                                    <a class="small" href="signup.php">Sign Up</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>