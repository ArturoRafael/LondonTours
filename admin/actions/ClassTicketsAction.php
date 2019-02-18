<?php
require_once("var_flush.php");
include("connection.php");
if( isset($_GET['action']) && !empty($_GET['action']) ){


	if( $_GET['action'] == 'updateInfo' && isset($_GET['idclass']) && !empty($_GET['idclass']) ) {
          $id = base64_decode($_GET['idclass']);
          $sql = "SELECT id_type, descrip FROM type_price WHERE id_type = $id";
    	  $query = mysqli_query($db, $sql);
    	  $data = array();
    	 if($query){
        	if(mysqli_num_rows($query) > 0){
        		$obj = mysqli_fetch_assoc($query);
        		mysqli_close($db); 
	    		print_r(json_encode($obj)); 
        		
        	}
        }
        
	     
	}else if( $_GET['action'] == 'updateNameClass' && isset($_GET['datos']) && !empty($_GET['id']) ){
        $id = $_GET['id'];
        $name = filter_var($_GET['datos'], FILTER_SANITIZE_STRING);
        $sql = "UPDATE type_price SET descrip = '$name' WHERE id_type = $id";

        $query = mysqli_query($db, $sql);
        if($query){
            mysqli_close($db); 
            echo 'ok';
        }else{
            mysqli_close($db); 
            echo 'err';
        }

    }else if( $_GET['action'] == 'newNameClass' && isset($_GET['datos']) ){
        
        $name = filter_var($_GET['datos'], FILTER_SANITIZE_STRING);
        $sql = "INSERT INTO type_price(descrip) VALUES ('$name')";

        $query = mysqli_query($db, $sql);
        if($query){
            mysqli_close($db); 
            echo 'ok';
        }else{
            mysqli_close($db); 
            echo 'err';
        }

    }else{
        echo 'err2';
    }

}else{
    echo 'err1';
}


?>