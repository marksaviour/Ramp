<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>RAMP - Sign Up</title>
        <link rel="icon" type="image/x-icon" href="../Ramp/assets/images/logo/logo.svg"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/65953c8738.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <!-- Close Button -->
        <div class="position-absolute top-0 end-0 mt-5 me-5">
            <a href="index.php" class="btn btn-large btn-close" aria-label="Close"></a>
        </div>

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
                                        <h3 class="login-heading mb-4">Welcome To RAMP</h3>

                                        <form method="POST" action="../Ramp/phplogic/signup_logic.php" onsubmit="return validateForm(event)">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" type="text" id="username" name="username" placeholder="username">
                                                <label for="username">Username</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" type="email" id="email" name="email" placeholder="name@example.com">
                                                <label for="email">Email address</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" type="password" id="password" name="password" placeholder="password" onkeyup="checkPassword()">
                                                <label for="password">Password</label>
                                                <small id="passwordHelp" class="form-text text-muted"></small>
                                            </div>

                                            <!-- Required Javascript for password checking-->
                                            <script>
                                                function checkPassword() {
                                                    var password = document.getElementById("password").value;
                                                    var message = document.getElementById("passwordHelp");
                                                    var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$");

                                                    if(strongRegex.test(password)) {
                                                        message.style.color = 'green';
                                                        message.innerHTML = "Password is strong.";
                                                        return true;
                                                    } else {
                                                        message.style.color = 'red';
                                                        message.innerHTML = "Password must be at least 8 characters long, contain a number and an uppercase letter.";
                                                        return false;
                                                    }
                                                }

                                                function validateForm(event) {
                                                    if (!checkPassword()) {
                                                        event.preventDefault();
                                                        return false;
                                                    }
                                                }
                                            </script>

                                            <div class="d-grid">
                                                <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Create Account</button>
                                                <div class="text-center">
                                                    <a class="small" href="login.php">Login</a>
                                                    <a class="small" href="forgot.php">Forgot password?</a>
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