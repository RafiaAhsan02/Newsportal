<?php
$realpath = realpath(dirname(__FILE__));
include $realpath . "/../database/db_connect.php";
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Register | The Newsline</title>
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
        if (isset($_POST['submit'])) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirmation = $_POST['password_confirmation'];
            $data['user_type'] = 'user';
            $agree = $_POST['agree'] ?? '';


            if (empty($name)) {
                $error['name'] = "Please enter a name.";
            } elseif (strlen($name) < 3) {
                $error['name'] = "Name must be at least 3 characters.";
            } else {
                $data['name'] = $name;
            }

            if (empty($email)) {
                $error['email'] = "Please enter a valid email address.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Invalid email format, please try again.";
            } else {
                $data['email'] = $email;
            }

            if (empty($password)) {
                $error['password'] = "Please enter a password.";
            } elseif (strlen($password) < 6) {
                $error['password'] = "Your password must be at least 6 characters.";
            } else {
                $data['password'] = $password;
            }

            if (empty($password_confirmation)) {
                $error['password_confirmation'] = "Please confirm your password.";
            } elseif ($password != $password_confirmation) {
                $error['password'] = "Password does not match, please try again.";
            } else {
                $data['password_confirmation'] = $password_confirmation;
            }

            if (empty($agree)) {
                $error['agree'] = "You must agree to the terms and conditions.";
            } else {
                $data['agree'] = $agree;
            }

            // insert into database

            if (empty($error)) {
                $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

                try {
                    $insert = "INSERT INTO users(name, email, password) VALUES(:name, :email, :password)";

                    if ($stmt = $conn->prepare($insert)) {
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                        $stmt->execute();

                        $_SESSION['success'] = "User has been created successfully.";
                        header("Location:index.php"); //login page
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        }
        ?>

        <!-- form fields -->
        <form id="register-form" action="" method="post">
            <h2 class="login-title">Sign Up</h2>

            <div class="form-group">
                <input class="form-control" type="text" name="name" placeholder="Name" value="<?php echo $data['name'] ?? ''; ?>">
                <span class='text-danger'> <?php echo $error['name'] ?? ''; ?></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Email" value="<?php echo $data['email'] ?? ''; ?>" autocomplete="off">
                <span class='text-danger'> <?php echo $error['email'] ?? ''; ?></span>
            </div>
            <div class="form-group">
                <input class="form-control" id="password" type="password" name="password" placeholder="Password">
                <span class='text-danger'> <?php echo $error['password'] ?? ''; ?></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password">
                <span class='text-danger'> <?php echo $error['password_confirmation'] ?? ''; ?></span>
            </div>

            <div class="form-group text-left">
                <label class="ui-checkbox ui-checkbox-info">
                    <input type="checkbox" name="agree">
                    <span class="input-span"></span>I agree to the terms and conditions.</label>
                <span class='text-danger'> <?php echo "<br>"; echo $error['agree'] ?? ''; ?></span>
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-block" name="submit" type="submit">Sign up</button>
            </div>
            <div class="text-center">Already a member?
                <a class="color-blue" href="index.php">Login here</a>
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
            $('#register-form').validate({
                errorClass: "help-block",
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        confirmed: true
                    },
                    password_confirmation: {
                        equalTo: password
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