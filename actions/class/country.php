<?php 

class Country
{
	function __construct()
	{
		
	}

	function insert_country($conn, $nombre, $zipostal){

        $sql = "";        

        if(!$this->search_user($email, $conn)){
            $rc = pg_query( $conn, $sql );
            if($rc){
                pg_free_result($rc);
                pg_close($conn);
                return true;
            }

        }            
        pg_free_result($rc);
        return false;
        
    }

     function search_country_all($conn){
		
		$sqlb = "SELECT id_city, city, zip_postal FROM city";
		$arrayName = array();
		if ($resultado = mysqli_query($conn, $sqlb)) {
		    
		    if(mysqli_num_rows($resultado) > 0){
		    	while($row = mysqli_fetch_row($resultado)){		    	 
                	$array = array('id_city' => $row[0], 'city' => $row[1]);
                	array_push($arrayName, $array);
            	}
            	mysqli_free_result($resultado);
                return $arrayName;
		    }		    
		    mysqli_free_result($resultado);
		}
        return true;


	}

    function search_zip($conn, $idcity){
        $sqlb = "SELECT id_city,  zip_postal FROM city WHERE id_city = $idcity";
        $arrayName = array();
        if ($resultado = mysqli_query($conn, $sqlb)) {
            
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_row($resultado)){              
                    $array = array('id_city' => $row[0], 'zip_postal' => $row[1]);
                    array_push($arrayName, $array);
                }
                mysqli_free_result($resultado);
                return $arrayName;
            }           
            mysqli_free_result($resultado);
        }
    }
	
}