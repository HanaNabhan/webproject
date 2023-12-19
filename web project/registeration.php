<?php include_once("complementary/header.php");
include_once("conn.php");
if(isset($_SESSION['username'])) {
    header('location:homepage.php');
    exit() ; 
}
$error = "";
$err_username = "";
$err_pass =  "";
$err_email = "";
if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirmPassword'])) {
        $error = 'Please Fill All The Inputs';
    } else {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $username_verification = preg_match('/[^a-zA-Z]/', $username);
        $length = strlen($password);
        $upper = preg_match('/[A-Z]/', $password);
        $lower = preg_match('/[a-z]/', $password);
        $specialCharacters = preg_match('/[^A-Za-z0-9]/', $password);
        if ($username_verification) {
            $err_username = 'Please Write The UserName In Correct form ';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err_email =  "Email is not a valid";
        }
        if (!$upper or !$upper or !$lower or !$specialCharacters) {
            if ($length < 8)
                $err_pass =  "Password must be more than 8 letters ";
            else
                $err_pass = 'Write The Password correctly';
        }
        if ($password != $confirmPassword) {
            $error_pass = "Password doesn't match";
        }
        if (empty($err_pass) and  empty($err_email) and empty($err_username) and empty($error)) {
            $email_verify = $conn->query("SELECT * FROM users WHERE email = '$email' ");
            $email_verify->execute();
            if ($email_verify->rowCount() > 0) {
                $error = "Email is Already Registered" ; 
            } else {
                $inserted = $conn->prepare("INSERT INTO users (username,email,user_password) VALUES (:username,:email,:user_password)");
                $inserted->execute(
                    [
                        ":username" => $username,
                        ":email" => $email,
                        ":user_password" => password_hash($password, PASSWORD_DEFAULT)
                    ]
                );
                $_SESSION['username'] = $username;  
                header('location:login.php');
                exit();
            }
        }
    }
}
?>

<head>
    <style>
        .login {
            height: 100vh;
            width: 100%;
            /* top: 50%; */
            position: relative;
            background-color: aliceblue;
        }

        .login-input {

            display: block;
            margin-top: 15px;
            width: 50%;
            height: 50px;
            left: 25%;
        }

        .bord:focus {
            /* border: 2px red solid; */
            /* background-color: #C0C0C0; */
            border-radius: 3px;
            color: gray;
        }

        h1 {
            position: absolute;
            top: 20%;
            left: 46%;
            text-align: center;
        }

        .form-f {
            position: absolute;
            width: 50%;
            top: 32%;
            left: 38%;

        }

        .send {
            background-color: gray;
            border: none;
            border-radius: 3px;
            /* transition: background-color  0.5ms; */
        }

        .send:hover {
            background-color: #C0C0C0;
            color: white;
            cursor: pointer;
        }
        /* define error class here ... */ 
    </style>
</head>

<body>
    <div class="login container">
        <h1 style="text-align: center; ">Register</h1>
        <form action="registeration.php" method="post" class="form-f">
            <!-- <label for="username">UserName</label> -->
            <input class="login-input bord" name="username" type="text" placeholder="Enter a username">
            <div class="error"> <?php echo $err_username; ?></div>
            <input class="login-input bord" name="email" type="email" placeholder="Enter a email">
            <div class="error"> <?php echo $err_email; ?></div>
            <input class="login-input bord" name="password" type="password" placeholder="Enter a password">
            <input class="login-input bord" name="confirmPassword" type="password" placeholder="Enter Confirmation password">
            <div class="error"> <?php echo $err_pass; ?></div>
            <input class="login-input send" name="submit" type="submit" value="LOGIN">
            <div class="error"> <?php echo $error; ?></div>
        </form>
    </div>
</body>
<?php include_once("complementary/footer.php"); ?>