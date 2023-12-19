<?php  include_once("conn.php");
session_unset();  
session_destroy();   
header("location:homepage.php") ; 
exit() ; 
?>