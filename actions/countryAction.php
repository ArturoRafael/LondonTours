<?php

require_once("var_flush.php");
include_once 'class/country.php';
$country = new Country;
include("connection.php");

if( isset($_POST['actionC']) && !empty($_POST['actionC']) || isset($_POST['actionZ']) && !empty($_POST['actionZ']) ){
	if( isset($_POST['actionC']) && $_POST['actionC'] == 'addInputCountry' ) {
                        
            $countryAll = $country->search_country_all($db);
            echo ($countryAll) ? json_encode($countryAll) : 'err';
            die;
	}
	else if( isset($_POST['actionZ']) && $_POST['actionZ'] == 'addInputZip' && !empty($_POST['obj'])) {           
           	$idcity = $_POST['obj'];       
            $zip_postal = $country->search_zip($db, $idcity);
            echo ($zip_postal) ? json_encode($zip_postal) : 'err';
            die;
	}else{
        echo 'err';
    }
}

?>