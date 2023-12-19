<?php require_once("adminComp/header.php");
$id = $_GET['id'] ; 
$deleteAdmin = $conn->query("delete from admins where id = $id");
$deleteAdmin->execute();  
header("location:adminShow.php");
// exit();
?> 