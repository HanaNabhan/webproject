<?php include_once("adminComp/header.php"); ?>
<?php
$error = "";
$err_username = "";
$err_pass =  "";
$err_email = "";
$success =  "";
$data = $conn->query("SELECT * FROM admins WHERE id = " . $_GET['id']);
$data->execute();
$adminData = $data->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    if ($adminData['username'] == $username and $adminData['email'] == $email and (password_verify(password_hash($password, PASSWORD_DEFAULT), $adminData['password']) or (empty($password) or empty($confirmPassword)))) {
        // if (empty($confirmPassword) ) {
        // $error = 'Please Fill the confirmation password';
        if ($password != $confirmPassword) {
            $error = 'Password Doesn\'t match';
        } else {
            $error = 'No items Updated';
        }
    } else {
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
        if ((!$upper or !$lower or !$specialCharacters) and !empty($password)) {
            if ($password != $confirmPassword) {
                $error = "Password doesn't match";
            } else if ($length < 8)
                $err_pass =  "Password must be at least than 8 letters ";
            else
                $err_pass = 'Write the password in the correct form';
        }
        if (empty($err_pass) and  empty($err_email) and empty($err_username) and empty($error)) {
            if (!empty($password)) {
                $inserted = $conn->prepare("UPDATE admins SET username = :username , email = :email , password = :password , updated_at =:updated_at WHERE id = " . $_GET['id']);
                $inserted->execute(
                    [
                        ":username" => $username,
                        ":email" => $email,
                        ":password" => password_hash($password, PASSWORD_DEFAULT),
                        ":updated_at" => date("Y-m-d H:i:s"),
                    ]
                );
            } else {
                $inserted = $conn->prepare("UPDATE admins SET username=:username , email=:email, updated_at = :updated_at WHERE id = " . $_GET['id']);
                $inserted->execute(
                    [
                        ':username' => $username,
                        ':email' => $email,
                        ':updated_at' => date('Y-m-d H:i:s'),
                    ]
                );
            }
            $_SESSION['username'] = $username;
            $id = $_GET['id'];
            header("location:adminUpdate.php?id=$id");
            exit();
        }
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Page</title>
    <style>
        .card {
            padding: 30px;
            width: 40%;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-left: 34vw;
            margin-top: 18vh;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login {
            height: 90vh;
            width: 100%;
            /* top: 50%; */
            /* position: relative; */
        }

        .login-input {
            text-align: center;
            display: block;
            margin-top: 15px;
            border: 1px grey solid;
            border-radius: 2px;
            width: 100%;
            height: 20%;
            margin-bottom: 10px;
            /* margin-left: 20px ; */
        }

        .bord:focus {
            /* border: 2px red solid; */
            /* background-color: #C0C0C0; */
            border-radius: 2px;
            color: gray;
            background-color: antiquewhite;
        }

        .heading1 {
            color: turquoise;
            margin-top: 3%;
            text-align: center;
        }

        .form-f {
            width: 90%;
        }

        .send {
            background-color: gray;
            /* border: none; */
            border-radius: 3px;
            width: 100%;
            margin-top: 3%;
            /* margin-left: 2px; */
            transition: 0.5s;
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
    <div class="card">
        <h1 class="heading1" style="text-align: center; ">Update</h1>
        <form action="adminUpdate.php?id=<?php echo $_GET['id']; ?>" method="post" class="form-f">
            <label for="username">User Name</label>
            <input class="login-input bord" name="username" type="text" placeholder="Update Your Username" value="<?php echo $adminData['username']; ?>">
            <div class="error"> <?php echo $err_username; ?></div>
            <label for="username">Email</label>
            <input class="login-input bord" name="email" type="email" placeholder="Enter a email" value="<?php echo $adminData['email']; ?>">
            <div class="error"> <?php echo $err_email; ?></div>
            <label for="username">Password</label>
            <input class="login-input bord" name="password" type="password" placeholder="Enter a password">
            <label for="username">Confirm Password</label>
            <input class="login-input bord" name="confirmPassword" type="password" placeholder="Enter Confirmation password">
            <div class="error"> <?php echo $err_pass; ?></div>
            <input class="login-input send" name="submit" type="submit" value="Update">
            <div class="error"> <?php echo $error ?></div>
        </form>
    </div>
    <?php include_once("adminComp/footer.php"); ?>
</body>

</html>