<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_project";

try {
    $conn= new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
    $conn-> exec("set names utf8");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: ". $e->getMessage();
}
?>