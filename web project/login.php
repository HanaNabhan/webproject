<?php include_once("complementary/header.php"); ?>
<?php require_once("conn.php"); ?>
<?php
$error = "";
if (isset($_SESSION["username"])) {
    header("location:homepage.php");
    exit() ; 
}
if (isset($_POST["submit"])) {
    if (empty($_POST["email"]) or empty($_POST["password"])) {
        $error =  "Some Inputs Are Empty";
    } else {
        $email = $_POST["email"];
        $user_password = $_POST["password"];
        $login = $conn->query("SELECT * FROM users WHERE email='$email'");
        $login->execute();
        $data = $login->fetch(PDO::FETCH_ASSOC);
        if ($login->rowCount() > 0) {
            if (password_verify($user_password, $data["user_password"])) {
                $_SESSION['email'] = $data['email'];
                $email = $_SESSION['email'] ;
                $selection = $conn->query("select * from users where email =  '$email'");
                $selection->execute(); 
                $data = $selection->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $data['id'];
                $_SESSION['username'] = $data['username'] ; 
                header('location:homepage.php');
                exit();
            } else {
                $error =  "email or password is wrong";
            }
        } else {
            $error =  "email or password is wrong outside";
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
            left: 48%;
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
    </style>
</head>

<body>
    <div class="login container">
        <h1 style="text-align: center; ">Login</h1>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="form-f">
            <!-- <label for="username">UserName</label> -->
            <input id="username" class="login-input bord" name="email" type="text" placeholder="Enter your email">
            <!-- <label for="password">UserName</label> -->
            <!-- <input id="password" class="login-input bord" name="password" type="password" placeholder="Enter a password"> -->
            <!-- <input id="username" class="login-input bord" name="password" type="text" placeholder="Enter a username"> -->
            <input id="password" class="login-input bord" name="password" type="password" placeholder="Enter a password">
            <input class="login-input send" type="submit" value="LOGIN" name="submit">
            <?php echo $error; ?>
        </form>
    </div>
</body>
<?php include_once("complementary/footer.php");
