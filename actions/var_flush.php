<?php

function limpiarCadena($valor)
{
    $valor = str_ireplace("SELECT","",$valor);
    $valor = str_ireplace("COPY","",$valor);
    $valor = str_ireplace("DELETE","",$valor);
    $valor = str_ireplace("DROP","",$valor);
    $valor = str_ireplace("DUMP","",$valor);
     $valor = str_ireplace(" AND ","",$valor);
    $valor = str_ireplace(" OR ","",$valor);
    $valor = str_ireplace("%","",$valor);
    $valor = str_ireplace("LIKE","",$valor);
    $valor = str_ireplace("--","",$valor);
    $valor = str_ireplace("^","",$valor);
    $valor = str_ireplace("[","",$valor);
    $valor = str_ireplace("]","",$valor);
    $valor = str_ireplace("!","",$valor);
    $valor = str_ireplace("¡","",$valor);
    $valor = str_ireplace("?","",$valor);
    $valor = str_ireplace("=","",$valor);
    $valor = str_ireplace("&","",$valor);
    $valor = str_ireplace("\ ","",$valor);
    return $valor;
}

$input_arr = array(); 
foreach ($_GET as $key => $input_arr) 
{ 
    $_GET[$key] = addslashes(limpiarCadena($input_arr)); 
}

foreach ($_POST as $key => $input_arr) 
{ 
    $_POST[$key] = addslashes(limpiarCadena($input_arr)); 
}

if($_SERVER["SERVER_NAME"] == 'localhost'){
        $url_actual = "http://".$_SERVER["SERVER_NAME"]."/project_tours/";
}else{ 
        $url_actual = "https://".$_SERVER["SERVER_NAME"]."/";
}


session_start();


?>