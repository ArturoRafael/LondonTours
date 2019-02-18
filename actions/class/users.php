<?php 

class Users
{
	function __construct()
	{
		
	}  
                       
	function insert_user($nombre, $email, $country, $calle, $telf, $pass, $clas_user = 0, $conn){

        $sql = "INSERT INTO users(id_city, name, email, phone, road, clas_user, password) 
                VALUES ($country, '$nombre', '$email', '$telf', '$calle', $clas_user, '$pass')";        

        if(!$this->search_user(strtolower($email), $conn)){
            $rc = mysqli_query($conn, $sql);
            if($rc){
                mysqli_close($conn);
                return true;
            }

        }                    
        mysqli_close($conn);
        return false;
        
    }
    

      function update_user($email, $sql, $conn){
                
        if($this->search_user($email, $conn)){
            $rc = mysqli_query($conn, $sql);
            if($rc){
                mysqli_close($conn);
                return true;
            }

        }                    
        mysqli_close($conn);
        return false;
        

    }

    function search_user($email, $conn){
		
		$sqlb = "SELECT id_user FROM users WHERE email = '$email'";
		if ($resultado = mysqli_query($conn, $sqlb)) {            
            if(mysqli_num_rows($resultado) > 0){    			
				mysqli_free_result($resultado);
                return true;
    		}
    	}
    	mysqli_free_result($resultado);
        return false;

	}

    function login_user($email, $pass, $conn){

        $sql = "SELECT name, clas_user, id_user FROM users WHERE email = '$email' AND password = '$pass'";
        $arrayName = array();
        if($this->search_user($email, $conn)){
            $rc = mysqli_query($conn, $sql);
            if($rc){  
                if(mysqli_num_rows($rc) > 0){              
                    while($row = mysqli_fetch_row($rc)){              
                        $id_user = $row[2];
                        $name = $row[0];
                        $clas_user = $row[1];                    
                    }
                    mysqli_free_result($rc);
                    mysqli_close($conn);
                    $array = array('name' => $name, 'clasUser' => $clas_user, 'id_user' => $id_user);
                    array_push($arrayName, $array);
                    
                    return $arrayName;
                
                }else{
                    mysqli_close($conn);
                    return false;
                }
                
            }

        }                    
        mysqli_close($conn);
        return false;
    }
}