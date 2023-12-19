<?php require_once("complementary/header.php");
if(!isset($_SESSION['course_id']))
{
    header('location:homepage.php');
}
unset($_SESSION['course_id']);

?>





<?php require_once("complementary/footer.php"); ?>