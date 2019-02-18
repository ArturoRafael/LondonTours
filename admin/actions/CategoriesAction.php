<?php
require_once("var_flush.php");
include("connection.php");
if( isset($_GET['action']) && !empty($_GET['action']) ){


	if( $_GET['action'] == 'updateInfo' && isset($_GET['idcatg']) && !empty($_GET['idcatg']) ) {
          $id = base64_decode($_GET['idcatg']);
          $sql = "SELECT id_catgry, descrip FROM category_tour WHERE id_catgry = $id";
    	  $query = mysqli_query($db, $sql);
    	  $data = array();
    	 if($query){
        	if(mysqli_num_rows($query) > 0){
        		$obj = mysqli_fetch_assoc($query);
        		mysqli_close($db); 
	    		print_r(json_encode($obj)); 
        		
        	}
        }
        
	     
	}else if( $_GET['action'] == 'updateNameCatg' && isset($_GET['datos']) && !empty($_GET['id']) ){
        $id = $_GET['id'];
        $name = filter_var($_GET['datos'], FILTER_SANITIZE_STRING);
        $sql = "UPDATE category_tour SET descrip = '$name' WHERE id_catgry = $id";

        $query = mysqli_query($db, $sql);
        if($query){
            mysqli_close($db); 
            echo 'ok';
        }else{
            mysqli_close($db); 
            echo 'err';
        }

    }else if( $_GET['action'] == 'newNameCatg' && isset($_GET['datos']) ){
        
        $name = filter_var($_GET['datos'], FILTER_SANITIZE_STRING);
        $sql = "INSERT INTO category_tour(descrip) VALUES ('$name')";

        $query = mysqli_query($db, $sql);
        if($query){
            mysqli_close($db); 
            echo 'ok';
        }else{
            mysqli_close($db); 
            echo 'err';
        }

    }else{
        echo 'err';
    }

}else{
    echo 'err';
}


?>