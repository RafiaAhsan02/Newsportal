<?php
$realpath = realpath(dirname(__FILE__));
include $realpath . "/../database/db_connect.php";

session_start();
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Login | The Newsline</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="assets/css/main.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="./assets/css/pages/auth-light.css" rel="stylesheet" />
</head>

<body class="bg-silver-300">
    <div class="content">
        <div class="brand">
            <a class="link" href="../index.php">The Newsline</a>
        </div>

        <?php
        $data = [];
        $error = [];

        if (isset($_POST['login'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            /*
            my email: Catattack@mailinator.com
            my pass: 123abc
            */

            if (empty($email)) {
                $error['email'] = "Please enter a valid email address.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Invalid email format, please try again.";
            } else {
                $data['email'] = $email;
            }

            if (empty($password)) {
                $error['password'] = "Please enter a password.";
            } else {
                $data['password'] = $password;
            }


            // insert into database
            if (empty($error)) {

                try {
                    $sql = "SELECT * FROM users WHERE email = :email";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(['email' => $data['email']]);
                    $user = $stmt->fetch(PDO::FETCH_OBJ);

                    if ($user) {
                        if (password_verify($data['password'], $user->password)) {
                            $_SESSION['user_id'] = $user->id;
                            $_SESSION['user_name'] = $user->name;
                            $_SESSION['role'] = $user->type;

                            header("Location:dashboard.php");
                        } else {
                            $error['password'] = "Incorrect password.";
                        }
                    } else {
                        $error['email'] = "This email is not associated with an existing user.";
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        }

        ?>

        <form id="login-form" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
            <h2 class="login-title">Login</h2>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-envelope"></i></div>
                    <input class="form-control" type="email" name="email" placeholder="Email" value="<?php echo $data['email'] ?? ''; ?>" autocomplete="off">
                    <span class='text-danger'> <?php echo $error['email'] ?? ''; ?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                    <input class="form-control" id="password" type="password" name="password" placeholder="Password">
                    <span class='text-danger'> <?php echo $error['password'] ?? ''; ?></span>
                </div>
            </div>
            <div class="form-group d-flex">
                <a href="javascript:void(0)">Forgot password?</a>
                <!-- nts replace void with forgot password page! -->
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-block" type="submit" name="login">Login</button>
            </div>
            <div class="text-center">Not a member?
                <a class="color-blue" href="register.php">Create account</a>
            </div>
        </form>
    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->
    <script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        $(function() {
            $('#login-form').validate({
                errorClass: "help-block",
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
            });
        });
    </script>
</body>

</html>