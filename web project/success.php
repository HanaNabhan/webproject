<?php require_once("complementary/header.php");
if (!isset($_SESSION['paid']) or !isset($_SESSION['price'])){
    header('location:homepage.php');
} else {
    $course_id = $_SESSION['paid'];
    $price = $_SESSION['price'];
    $insertData = $conn->prepare('INSERT INTO booking (user_id ,course_id,price) VALUES (:user_id,:course_id,:price)');
    $insertData->execute(
        [
            ':user_id' => $_SESSION['user_id'],
            'course_id' => $course_id ,
            ':price' => $price 
        ]
    );
}
unset($_SESSION['paid'] , $_SESSION['price']); ?>
<html>

<head>
    <meta http-equiv="refresh" content="5;url=course_content.php?id=<?php echo $course_id; ?>">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5c5946fe44.js" crossorigin="anonymous"></script>
    <title>Pay Page</title>
</head>


<body>


    <div class="home">
        <div class="overlay">
            <div class="home-content">
                <h1 class="main-address">Thank for purchasing , Kepp Learning</h1>
                <p class="home-description">
                    <!-- content in the front page -->
                </p>
                <!-- <p style="color: white;"> <?php echo $data['name_of_course']; ?> , &dollar;<?php echo $data['price']; ?></p> -->
        </div> <!-- close overlay div -->
    </div> <!-- close home div -->

    <?php require_once("complementary/footer.php"); ?>
</body>

</html>