<?php

$usuario = "root";
$contrasena = ""; 
$servidor = "localhost";
$basededatos = "tours_project";

$db = mysqli_connect($servidor, $usuario, $contrasena, $basededatos);


if (mysqli_connect_errno()) {
    printf("Conexión fallida: %s\n", mysqli_connect_error());
    exit();
}
mysqli_query($db,"SET NAMES 'utf8'");
?>