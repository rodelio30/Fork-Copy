<?php
if(!defined('Emember')){
    header('location: ../index.php');
    die();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blogging_website";
// $dbname = "everleas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>