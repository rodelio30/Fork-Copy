<?php 
sleep(2);
session_start(); // Initialize the session

$_SESSION = [];
session_unset();
session_destroy();

header("Location: ../signin.php");
?>