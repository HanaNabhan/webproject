<?php include("complementary/header.php");
$id = $_GET["id"];
// selecting data of one item in the courses list
$selectedData = $conn->query("SELECT * FROM courses join admins on courses.owner_id = admins.id WHERE courses.id = $id");
$selectedData->execute();
$itemData = $selectedData->fetch(PDO::FETCH_OBJ);
// selecting related topics ... 
$data = $itemData->category;
$selectRelatedData = $conn->query("select * from courses where category = '$data' ");
$selectRelatedData->execute();
$relatedData = $selectRelatedData->fetchAll(PDO::FETCH_OBJ);
// selecting course requirements and learning outcomes .... 
$selectedRequirements = $conn->query("select  courses.id as id , requirements.course_requirements as requirements , requirements.course_outcomes as outcome from courses join requirements on courses.id = requirements.course_id where id = '$id' ");
$selectedRequirements->execute();
$selectedReqData = $selectedRequirements->fetch(PDO::FETCH_ASSOC);
// what to learn section from string to array to be can be accessed
$outcomesArray = explode('.', $selectedReqData['outcome']);
// requirements section from string to array to can be accessed ... 
$reqArray = explode('.', $selectedReqData['requirements']);
// ----------------------------------
// checking if the person has purchased the course or not .... 
$user_id = $_SESSION['user_id'] ;  
$check = $conn->query("select * from courses join booking on courses.id = booking.course_id JOIN users on booking.user_id = users.id WHERE courses.id = '$id'  and users.id = '$user_id' ; ") ;  
$check->execute(); 
?>
<!DOCTYPE html>
<html>

<head>
    <title> Benha university | Online E-learning platform</title>
    <meta charset="utf-8">
    <meta name="keywords" content="E-learning">
    <meta name="description" content="E-learning platform">

    <!-- include library -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ephesis&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap">

    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- link to css  -->
    <link rel="stylesheet" href="page.css">

</head>

<body>

    <div class="pd-y">

        <div class="container">
            <div class="course-item">
                <div class="section-header">
                    <h2 class="section-title"> <?php echo $itemData->name_of_course; ?> </h2>
                    <span class="section-line"></span>
                    <p style="text-transform: capitalize;">created by: <?php echo $itemData->username; ?></p>
                </div>
                <p style="text-transform: capitalize;">
                    <!-- <?php echo $itemData->details; ?>. -->
                </p>
                <i class="fa fa-bell hover-opacity "></i>
                <i class="fa fa-globe hover-opacity "></i> <span style="font-size: 10px; color:#999;text-transform: capitalize;"> <?php echo $itemData->language; ?></span>
                <div class="rating">
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1"><i class="fa fa-star"></i></label>
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2"><i class="fa fa-star"></i></label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3"><i class="fa fa-star"></i></label>
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4"><i class="fa fa-star"></i></label>
                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5"><i class="fa fa-star"></i></label>




                </div>
                <div class="course-price">
                    <span class="original-price"><?php echo $itemData->price + 50; ?></span>
                    <span class="discounted-price"> <?php echo $itemData->price; ?></span>
                </div>
                <?php if (isset($_SESSION['username']) and $check->rowCount() > 0 ) :  ?>
                        <a href="coursePage.php?id=<?php $_SESSION['course_id'] = $id ;  echo $_SESSION['course_id'] ; ?>" style="text-decoration: none;color: #999;"><button class="btn hover-opacity ">Go To Course</button></a>
                <?php elseif (isset($_SESSION['username'])) : ?>
                        <a href="pay.php?id=<?php $_SESSION['pay'] = $id ; echo $_SESSION['pay']; ?>" style="text-decoration: none;color: #999;"><button class="btn hover-opacity ">Enroll Now</button></a>
                <?php else : ?>
                        <a href="login.php" style="text-decoration: none;color: #999;"><button class="btn hover-opacity ">Login To Enroll</button></a>
                <?php endif; ?>

            </div>
            <div class="course-item">
                <div class="course-item-img">
                    <img src="images/<?php echo $itemData->image; ?>" alt="course-pic">
                </div>
            </div>
            <div class="clear"></div>

        </div>

    </div>
    <div class="container">
        <div class="learn-section">
            <h2 class="hover-opacity">Description</h2>
            <hr>
            <ul>
                <li>- <?php echo $itemData->details;  ?></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="learn-section">
            <h2 class="hover-opacity">What Will You Learn?</h2>
            <hr>
            <ul>
                <?php foreach ($outcomesArray as $outcome) : ?>
                    <?php if ($outcome != '') : ?>
                        <li><i class="fa fa-check hover-opacity"></i><?php echo $outcome; ?></li>
                    <?php endif;  ?>
                <?php endforeach;  ?>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="learn-section">
            <h2 class="hover-opacity">Requirements</h2>
            <hr>
            <ul>
                <?php foreach ($reqArray as $element) : ?>
                    <li><?php echo $element; ?></li>
                <?php endforeach;  ?>
            </ul>
        </div>
    </div>

    <div class="pd-y">
        <div class="enroll-section">
            <h2>Try Free Courses or Enroll in Paid Courses</h2>
            <p>Explore thousands of courses available on Coursera.<br> Start learning for free, or enroll in a paid course to access graded assignments, certificates, and more.</p>
            <div class="container">
                <div class="item-courses">
                    <h3>Free courses</h3>
                    <ul>
                        <li><i class="fa fa-check"></i> Online video content</li>
                        <li><i class="fa fa-times"></i> Certificate of completion</li>
                        <li><i class="fa fa-times"></i> Instructor Q&A</li>
                        <li><i class="fa fa-times"></i> Instructor direct message</li>
                    </ul>
                </div>
                <div class="item-courses">
                    <h3>Paid courses</h3>
                    <ul>
                        <li><i class="fa fa-check"></i> Online video content</li>
                        <li><i class="fa fa-check"></i> Certificate of completion</li>
                        <li><i class="fa fa-check"></i> Instructor Q&A</li>
                        <li><i class="fa fa-check"></i> Instructor direct message</li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>

            <div class="container">
                <button class="btn hover-opacity">Try Free Courses</button>
                <button class="btn hover-opacity">Enroll in Paid Courses</button>
            </div>
        </div>
    </div>

    <?php if ($selectRelatedData->rowCount() > 0) : ?>
        <div class="about pd-y">
            <div class="section-header">
                <h2 class="section-title">related topics</h2>
                <span class="section-line"></span>
            </div> <!--close section-header div-->
            <div class="container">
                <div class="about-content">
                    <?php foreach ($relatedData as $data) : ?>
                        <div class="about-item ltr-effect">
                            <img src="images/<?php echo $data->image; ?>" class="about-img-item" alt="<?php echo $data->name; ?>">
                            <h3 class="about-item-title mg-d"><?php echo $data->name; ?> </h3>
                            <p class="about-item-description mg-d"><?php echo $data->price; ?>$</p>
                            <a href="#" class="about-item-link">Purchase Course</a>
                        </div>
                        <div class="clear"></div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>



    <?php include("complementary/footer.php"); ?>
</body>

</html>