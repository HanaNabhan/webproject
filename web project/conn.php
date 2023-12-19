<?php
try {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $host = "localhost";
    $dbname = "e-learning";
    $user = "root";
    $pass = "";
    $conn = new PDO("mysql:host=$host;dbname=$dbname;", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
