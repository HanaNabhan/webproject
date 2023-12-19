<?php include_once("adminComp/header.php"); ?>
<?php
$error = "";
if (isset($_SESSION["adminUserName"])) {
    header("location:adminHome.php");
    exit();
}
if (isset($_POST["submit"])) {
    if (empty($_POST["email"]) or empty($_POST["password"])) {
        $error =  "Please fill all the inputs";
    } else {
        $email = $_POST["email"];
        $user_password = $_POST["password"];
        $login = $conn->query("SELECT * FROM admins WHERE email='$email'");
        $login->execute();
        $data = $login->fetch(PDO::FETCH_ASSOC);
        if ($login->rowCount() > 0) {
            if (password_verify($user_password, $data["password"])) {
                $_SESSION['adminUserName'] =  $data['username'];
                header('location:adminHome.php');
                exit();
            } else {
                $error =  "Email or Password is wrong";
            }
        } else {
            $error =  "Email or Password is wrong outside";
        }
    }
}
?>

<head>
    <style>
        .login {
            height: 100vh;
            width: fit-content;
            /* top: 50%; */
            /* position: relative; */
        }

        .login-input {

            display: block;
            margin-top: 15px;
            /* width: fit-content ;  */
            /* height: fit-content; */
            left: 25%;
        }

        .bord:focus {
            /* border: 2px red solid; */
            /* background-color: #C0C0C0; */
            border-radius: 3px;
            color: gray;
        }

        h1 {
            /* position: absolute; */
            /* top: 20%;
            left: 48%; */
            text-align: center;
        }

        .form-f {
            /* position: absolute; */
            /* width: fit-content; */
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

        .card {
            background-color: aliceblue;
            width: 60%;
            /* height: 200%; */
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-left: 34vw;
            margin-top: 18vh;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="card">
        <h1 style="text-align: center; ">Admin Login</h1>
        <form action="adminLogin.php" method="post" class="form-f">
            <!-- <label for="username">UserName</label> -->
            <input id="username" class="login-input bord" name="email" type="email" placeholder="Enter your email">
            <!-- <label for="password">UserName</label> -->
            <!-- <input id="password" class="login-input bord" name="password" type="password" placeholder="Enter a password"> -->
            <!-- <input id="username" class="login-input bord" name="password" type="text" placeholder="Enter a username"> -->
            <input id="password" class="login-input bord" name="password" type="password" placeholder="Enter a password">
            <input class="login-input send" type="submit" value="LOGIN" name="submit">
            <div><?php echo $error; ?></div>
        </form>
    </div>
</body>
<?php include_once("adminComp/footer.php");
