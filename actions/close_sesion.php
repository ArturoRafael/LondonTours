<?php 

session_start();

if ($_SERVER['HTTP_REFERER'] == ""){ 
    header("Location: ../index"); 
    exit(); 
}
 
unset($_SESSION['index']);
unset($_SESSION['name']);
unset($_SESSION['clasUser']);
unset($_SESSION["token-registry"]);
unset($_SESSION["token-login"]);
session_destroy();

header("Location: ../index");


?>