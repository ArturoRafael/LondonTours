<?php
require_once("var_flush.php");
include_once('class/users.php');
include_once('connection.php');

if($_POST){

	if(isset($_POST["csrf"]) && isset($_POST["signup-username"]) && isset($_POST["signup-email"]) && isset($_POST["signup-telf"]) && isset($_POST["signup-password"]) && isset($_POST["accept-terms"]))
  {	
    
    if ($_POST["csrf"] != $_SESSION["token-registry"]) {
        echo "There was a problem with the entered values. Try again";
        exit(0);
    }


    if(!filter_var($_POST["accept-terms"], FILTER_VALIDATE_BOOLEAN) || filter_var($_POST["accept-terms"], FILTER_VALIDATE_BOOLEAN) == NULL){      
      echo "Accept the terms and conditions to continue...";
      exit(0);
    }

    $nombre = filter_var($_POST["signup-username"], FILTER_SANITIZE_STRING);
    
    $email = filter_var($_POST["signup-email"], FILTER_SANITIZE_EMAIL);
    $email = strtolower($email);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Enter a valid email.";
        exit(0);
    }

    $country = filter_var($_POST["signup-country"], FILTER_SANITIZE_NUMBER_INT);
    
    $calle = filter_var($_POST["signup-road"], FILTER_SANITIZE_STRING);
    
    $telf = filter_var($_POST["signup-telf"], FILTER_SANITIZE_STRING);    

    $pass2 = filter_var($_POST["signup-password-repeat"], FILTER_SANITIZE_STRING);
    $pass = filter_var($_POST["signup-password"], FILTER_SANITIZE_STRING);
    if(strlen($pass) && strlen($pass2) && $pass == $pass2)
        $pass = sha1($pass);
    else{
        echo "Check passwords, and try again.";
        exit(0);
    }

 
    $usuario = new Users();
    if($usuario->insert_user($nombre, $email, $country, $calle, $telf, $pass, 0, $db)){
      echo "ok";
    }else{
      echo "There was a problem with the entered values. Try again";
      exit(0);
    }

  }
  else if(isset($_POST["csrfl"]) && isset($_POST["signin-email"]) && isset($_POST["signin-password"]))
  {     
    
    if ($_POST["csrfl"] != $_SESSION["token-login"]) {
        echo "nokk";
        exit(0);
    }

    $email = filter_var($_POST["signin-email"], FILTER_SANITIZE_EMAIL);
    
    $email = strtolower($email);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "nokkk";
        exit(0);
    }


    $pass = filter_var($_POST["signin-password"], FILTER_SANITIZE_STRING);
    $pass = sha1($pass);
    $usuario = new Users();
    $userLog = $usuario->login_user($email, $pass, $db);    
    
    if($userLog) {
      $_SESSION['index'] = base64_encode($userLog[0]['id_user']);
      $_SESSION['name'] = base64_encode($userLog[0]['name']);
      $_SESSION['clasUser'] = base64_encode($userLog[0]['clasUser']);      
      echo 'ok';
    }else{
      echo 'nokk';
      exit(0);
    }    

  }
  else if(isset($_POST["reset-email"]))
  {     
    
    $email = filter_var($_POST["reset-email"], FILTER_SANITIZE_EMAIL);

    $usuario = new Users();
    $random = md5(uniqid(mt_rand(), true));
    $pass = sha1($random);
    $email = strtolower($email);
    $sql = "UPDATE users SET password = '$pass' WHERE email = '$email'";
    
    $userLog = $usuario->update_user($email, $sql, $db);    
    if($userLog) {
      echo $random;
    }else{
      echo 'nok';
      exit(0);
    }    

  }
  else if(isset($_POST["search_glob"])){
    $var_search = strtolower(filter_var($_POST["search_glob"], FILTER_SANITIZE_STRING));  
    echo 'tours/'.urlencode($var_search);
  }
  else{
    echo "nok";
    exit(0);
  }



}//final del post